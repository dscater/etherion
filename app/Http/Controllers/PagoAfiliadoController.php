<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\PagoAfiliado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PagoAfiliadoController extends Controller
{
    public $validacion = [
        "orden_venta_id" => "required",
        "descripcion" => "required|min:2",
        "estado" => "required",
    ];

    public $mensajes = [
        "orden_venta_id.required" => "Este campo es obligatorio",
        "descripcion.required" => "Este campo es obligatorio",
        "descripcion.min" => "Debes ingresar al menos :min caracteres",
        "estado.required" => "Este campo es obligatorio",
    ];

    public function index()
    {
        return Inertia::render("Admin/PagoAfiliados/Index");
    }

    public function listado(Request $request)
    {
        $pago_afiliados = PagoAfiliado::select("pago_afiliados.*");

        if ($request->order && $request->order == "desc") {
            $pago_afiliados->orderBy("pago_afiliados.id", $request->order);
        }

        $pago_afiliados = $pago_afiliados->get();

        return response()->JSON([
            "pago_afiliados" => $pago_afiliados
        ]);
    }

    public function paginado(Request $request)
    {
        $search = $request->search;

        $pago_afiliados = PagoAfiliado::with(["orden_venta"])->select("pago_afiliados.*")
            ->join("orden_ventas", "orden_ventas.id", "=", "pago_afiliados.orden_venta_id");

        if (trim($search) != "") {
            $pago_afiliados->where("orden_ventas.codigo", "LIKE", "%$search%");
        }

        $pago_afiliados = $pago_afiliados->paginate($request->itemsPerPage);
        return response()->JSON([
            "pago_afiliados" => $pago_afiliados
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el PagoAfiliado
            $nuevo_pago_afiliado = PagoAfiliado::create(array_map('mb_strtoupper', $request->all()));
            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_pago_afiliado, "pago_afiliados");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->pago_afiliado . ' REGISTRO UN PAGO DE AFILIADO',
                'datos_original' => $datos_original,
                'modulo' => 'PAGO A AFILIADOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);
            $nuevo_pago_afiliado->orden_venta->estado = $nuevo_pago_afiliado->estado;
            $nuevo_pago_afiliado->orden_venta->save();
            DB::commit();
            return redirect()->route("pago_afiliados.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(PagoAfiliado $pago_afiliado)
    {
    }

    public function update(PagoAfiliado $pago_afiliado, Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($pago_afiliado, "pago_afiliados");
            $pago_afiliado->update(array_map('mb_strtoupper', $request->all()));

            $datos_nuevo = HistorialAccion::getDetalleRegistro($pago_afiliado, "pago_afiliados");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->pago_afiliado . ' MODIFICÓ UN PAGO DE AFILIADO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'PAGO A AFILIADOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);


            $pago_afiliado->orden_venta->estado = $pago_afiliado->estado;
            $pago_afiliado->orden_venta->save();
            DB::commit();
            return redirect()->route("pago_afiliados.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
    public function destroy(PagoAfiliado $pago_afiliado)
    {
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($pago_afiliado, "pago_afiliados");
            $pago_afiliado->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->pago_afiliado . ' ELIMINÓ UN PAGO DE AFILIADO',
                'datos_original' => $datos_original,
                'modulo' => 'PAGO A AFILIADOS',
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
