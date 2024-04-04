<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\Producto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public $validacion = [
        "nombre" => "required|min:1",
        "gerente_regional_id" => "required",
        "encargado_producto_id" => "required",
        "fecha_pent" => "required",
        "fecha_peje" => "required",
        "categoria_id" => "required",
    ];

    public $mensajes = [
        "nombre.required" => "Este campo es obligatorio",
        "nombre.min" => "Debes ingresar al menos :min caracteres",
        "gerente_regional_id.required" => "Este campo es obligatorio",
        "encargado_producto_id.required" => "Este campo es obligatorio",
        "fecha_pent.required" => "Este campo es obligatorio",
        "fecha_peje.required" => "Este campo es obligatorio",
        "categoria_id.required" => "Este campo es obligatorio",
    ];

    public function index()
    {
        return Inertia::render("Admin/Productos/Index");
    }

    public function listado(Request $request)
    {
        $productos = Producto::with(["gerente_regional", "encargado_producto", "categoria"]);

        if ($request->sin_presupuesto) {
            if ($request->id && $request->id != '') {
                $productos = $productos->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('presupuestos')
                        ->whereRaw('presupuestos.producto_id = productos.id');
                })->orWhere(function ($subquery) use ($request) {
                    $subquery->whereIn('productos.id', [$request->id]);
                });
            } else {
                $productos = $productos->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('presupuestos')
                        ->whereRaw('presupuestos.producto_id = productos.id');
                });
            }
        }

        if (Auth::user()->tipo == 'GERENTE REGIONAL') {
            $productos = $productos->where("gerente_regional_id", Auth::user()->id);
        }

        if (Auth::user()->tipo == 'ENCARGADO DE OBRA') {
            $productos = $productos->where("encargado_producto_id", Auth::user()->id);
        }

        if (isset($request->order)) {
            $productos = $productos->orderBy("id", $request->order);
        }

        $productos = $productos->get();
        return response()->JSON([
            "productos" => $productos
        ]);
    }

    public function getProducto(Producto $producto)
    {
        return response()->JSON([
            "producto" => $producto
        ]);
    }

    public function paginado(Request $request)
    {

        $search = $request->search;

        $productos = Producto::with(["gerente_regional", "encargado_producto", "categoria"])->select("productos.*");

        if (trim($search) != "") {
            $productos->where("productos.nombre", "LIKE", "%$search%");
        }

        if (Auth::user()->tipo == 'GERENTE REGIONAL') {
            $productos = $productos->where("gerente_regional_id", Auth::user()->id);
        }

        if (Auth::user()->tipo == 'ENCARGADO DE OBRA') {
            $productos = $productos->where("encargado_producto_id", Auth::user()->id);
        }

        $productos = $productos->paginate($request->itemsPerPage);
        return response()->JSON([
            "productos" => $productos
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el Producto
            $nuevo_producto = Producto::create(array_map('mb_strtoupper', $request->all()));
            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_producto, "productos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto . ' REGISTRO UNA CATEGORIA',
                'datos_original' => $datos_original,
                'modulo' => 'CATEGORIAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("productos.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(Producto $producto)
    {
    }

    public function update(Producto $producto, Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($producto, "productos");
            $producto->update(array_map('mb_strtoupper', $request->all()));

            $datos_nuevo = HistorialAccion::getDetalleRegistro($producto, "productos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto . ' MODIFICÓ UNA CATEGORIA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'CATEGORIAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);


            DB::commit();
            return redirect()->route("productos.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
    public function destroy(Producto $producto)
    {
        DB::beginTransaction();
        try {
            $usos = Presupuesto::where("producto_id", $producto->id)->get();
            if (count($usos) > 0) {
                throw ValidationException::withMessages([
                    'error' =>  "No es posible eliminar este registro porque esta siendo utilizado por otros registros",
                ]);
            }

            $datos_original = HistorialAccion::getDetalleRegistro($producto, "productos");
            $producto->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto . ' ELIMINÓ UNA CATEGORIA',
                'datos_original' => $datos_original,
                'modulo' => 'CATEGORIAS',
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
