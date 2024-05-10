<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\OrdenVenta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OrdenVentaController extends Controller
{
    public $validacion = [
        "productos" => "required|array|min:1",
        "configuracion_pago_id" => "required",
        "comprobante" => "required",
    ];

    public $mensajes = [
        "productos.required" => "Este campo es obligatorio",
        "productos.min" => "Debes seleccionar al menos :min producto",
        "configuracion_pago_id.required" => "Este campo es obligatorio",
        "comprobante.required" => "Este campo es obligatorio",
    ];

    public function index()
    {
        if (Auth::user()->tipo == 'CLIENTE') {
            return Inertia::render("Admin/OrdenVentas/Cliente");
        }
        if (Auth::user()->tipo == 'AFILIADO') {
            return Inertia::render("Admin/OrdenVentas/Afiliado");
        }
        return Inertia::render("Admin/OrdenVentas/Index");
    }

    public function listado(Request $request)
    {
        $orden_ventas = OrdenVenta::select("orden_ventas.*");

        if ($request->sin_pago) {
            if ($request->id && $request->id != '') {
                $orden_ventas = $orden_ventas->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pago_afiliados')
                        ->whereRaw('pago_afiliados.orden_venta_id = orden_ventas.id');
                })->orWhere(function ($subquery) use ($request) {
                    $subquery->whereIn('orden_ventas.id', [$request->id]);
                });
            } else {
                $orden_ventas = $orden_ventas->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pago_afiliados')
                        ->whereRaw('pago_afiliados.orden_venta_id = orden_ventas.id');
                });
            }
        }

        if ($request->order && $request->order == "desc") {
            $orden_ventas->orderBy("orden_ventas.id", $request->order);
        }

        $orden_ventas = $orden_ventas->get();

        return response()->JSON([
            "orden_ventas" => $orden_ventas
        ]);
    }

    public function paginado(Request $request)
    {

        $search = $request->search;

        $orden_ventas = [];
        if (Auth::user()->tipo == 'AFILIADO') {
            $orden_ventas = OrdenVenta::select("orden_ventas.*", "orden_detalles.precio_total", "orden_detalles.precio_sc", "orden_detalles.cantidad", "productos.descripcion")
                ->join("orden_detalles", "orden_detalles.orden_venta_id", "=", "orden_ventas.id")
                ->join("productos", "productos.id", "=", "orden_detalles.producto_id");
            // $orden_ventas->where("orden_ventas.estado", "!=", "PENDIENTE");
            $orden_ventas->where("productos.user_id", Auth::user()->id);
            if (trim($search) != "") {
                $orden_ventas->where(function ($query) use ($search) {
                    $query->where('orden_ventas.codigo', 'LIKE', "%$search%")
                        ->orWhere('productos.descripcion', 'LIKE', "%$search%");
                });
            }
        } elseif (Auth::user()->tipo == 'CLIENTE') {
            $orden_ventas = OrdenVenta::with(["user"])->select("orden_ventas.*");
            $orden_ventas->where("user_id", Auth::user()->id);
            // $orden_ventas->where("estado", "!=", "PENDIENTE");
            if (trim($search) != "") {
                $orden_ventas->where("codigo", "LIKE", "%$search%");
            }
        } else {
            $orden_ventas = OrdenVenta::with(["user"])->select("orden_ventas.*");

            if (trim($search) != "") {
                $orden_ventas->where("codigo", "LIKE", "%$search%");
            }
        }

        $orden_ventas = $orden_ventas->orderBy("id", "desc");

        $orden_ventas = $orden_ventas->paginate($request->itemsPerPage);
        return response()->JSON([
            "orden_ventas" => $orden_ventas
        ]);
    }

    public function registraOrden(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear la OrdenVenta
            $array_codigo = OrdenVenta::getNuevoCodigo();
            $request["codigo"] = $array_codigo[0];
            $request["nro"] = $array_codigo[1];
            $request["user_id"] = Auth::user()->id;
            $nueva_orden_venta = OrdenVenta::create(array_map('mb_strtoupper', $request->except("productos", "cantidades", "precios", "precio_total")));
            $datos_original = HistorialAccion::getDetalleRegistro($nueva_orden_venta, "orden_ventas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->orden_venta . ' REGISTRO UNA ORDEN DE VENTA',
                'datos_original' => $datos_original,
                'modulo' => 'ORDEN DE VENTAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            $productos = $request->productos;
            $cantidades = $request->cantidades;
            $precios = $request->precios;
            $precio_total = $request->precio_total;

            $total_sc = 0;
            foreach ($productos as $key => $producto) {
                $o_producto = Producto::find($producto);
                $precio_sc = (float)$cantidades[$key] * (float)$o_producto->precio;
                $precio_sc = round($precio_sc, 2);
                $total_sc = (float)$total_sc + (float)$precio_sc;
                $nueva_orden_venta->orden_detalles()->create([
                    "producto_id" => $producto,
                    "cantidad" => $cantidades[$key],
                    "precio" => $precios[$key],
                    "precio_sc" => number_format($precio_sc, 2, ".", ""),
                    "precio_total" => $precio_total[$key],
                ]);
            }
            $nueva_orden_venta->total_sc = number_format($total_sc, 2, ".", "");

            if ($request->hasFile('comprobante')) {
                $file = $request->comprobante;
                $nom_comprobante = time() . '_' . $nueva_orden_venta->id . '.' . $file->getClientOriginalExtension();
                $nueva_orden_venta->comprobante = $nom_comprobante;
                $file->move(public_path() . '/imgs/comprobantes/', $nom_comprobante);
            }
            $nueva_orden_venta->save();

            DB::commit();

            return response()->JSON([
                "sw" => true,
                "message" => "Orden de Venta registrada con éxito",
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                "sw" => false,
                "message" => "Ocurrió un error: " . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $this->validacion["qr"] = "required";
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear la OrdenVenta
            $array_codigo = OrdenVenta::getNuevoCodigo();
            $request["codigo"] = $array_codigo[0];
            $request["nro"] = $array_codigo[1];
            $nueva_orden_venta = OrdenVenta::create(array_map('mb_strtoupper', $request->except("qr")));
            $datos_original = HistorialAccion::getDetalleRegistro($nueva_orden_venta, "orden_ventas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->orden_venta . ' REGISTRO UNA ORDEN DE VENTA',
                'datos_original' => $datos_original,
                'modulo' => 'ORDEN DE VENTAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            if ($request->hasFile('qr')) {
                $file = $request->qr;
                $nom_qr = time() . '_' . $nueva_orden_venta->id . '.' . $file->getClientOriginalExtension();
                $nueva_orden_venta->qr = $nom_qr;
                $file->move(public_path() . '/imgs/qr/', $nom_qr);
            }
            $nueva_orden_venta->save();

            DB::commit();
            return redirect()->route("orden_ventas.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(OrdenVenta $orden_venta)
    {
        $orden_venta  = $orden_venta->load(["user", "orden_detalles.producto", "configuracion_pago"]);
        return Inertia::render("Admin/OrdenVentas/Show", compact("orden_venta"));
    }

    public function actualiza_estado(OrdenVenta $orden_venta, Request $request)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($orden_venta, "orden_ventas");
            $orden_venta->estado = $request->estado;
            $orden_venta->save();
            $datos_nuevo = HistorialAccion::getDetalleRegistro($orden_venta, "orden_ventas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->orden_venta . ' MODIFICÓ UNA ORDEN DE VENTA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'ORDEN DE VENTAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return response()->JSON([
                "sw" => true,
                "orden_venta" => $orden_venta,
                "message" => "La orden se actualizó correctamente",
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->JSON([
                "sw" => false,
                "message" => "Ocurrió un error: " . $e->getMessage(),
            ], 500);
        }
    }

    public function update(OrdenVenta $orden_venta, Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($orden_venta, "orden_ventas");
            $orden_venta->update(array_map('mb_strtoupper', $request->except("qr")));
            if ($request->hasFile('qr')) {
                $antiguo = $orden_venta->qr;
                if ($antiguo != 'default.png') {
                    \File::delete(public_path() . '/imgs/qr/' . $antiguo);
                }
                $file = $request->qr;
                $nom_qr = time() . '_' . $orden_venta->id . '.' . $file->getClientOriginalExtension();
                $orden_venta->qr = $nom_qr;
                $file->move(public_path() . '/imgs/qr/', $nom_qr);
            }
            $orden_venta->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($orden_venta, "orden_ventas");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->orden_venta . ' MODIFICÓ UNA ORDEN DE VENTA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'ORDEN DE VENTAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("orden_ventas.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
    public function destroy(OrdenVenta $orden_venta)
    {
        DB::beginTransaction();
        try {
            $antiguo = $orden_venta->comprobante;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/comprobantes/' . $antiguo);
            }
            $orden_venta->orden_detalles()->delete();
            $datos_original = HistorialAccion::getDetalleRegistro($orden_venta, "orden_ventas");
            $orden_venta->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->orden_venta . ' ELIMINÓ UNA ORDEN DE VENTA',
                'datos_original' => $datos_original,
                'modulo' => 'ORDEN DE VENTAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'message' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
}
