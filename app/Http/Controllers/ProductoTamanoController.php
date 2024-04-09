<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\Producto;
use App\Models\ProductoTamano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProductoTamanoController extends Controller
{
    public $validacion = [
        "nombre" => "required|min:1",
        "p_comision" => "required|numeric|min:0|max:100|regex:/^\d+(\.\d{1,2})?$/",
    ];

    public $mensajes = [
        "nombre.required" => "Este campo es obligatorio",
        "nombre.min" => "Debes ingresar al menos :min caracteres",
        "p_comision.required" => "Este campo es obligatorio",
        "p_comision.numeric" => "Debes ingresar un valor númerico",
        "p_comision.min" => "El valor no puede ser menor a :min",
        "p_comision.max" => "El valor no puede ser mayor a :max",
        "p_comision.regex" => "Solo se permiten valores con 0 o 2 decimales",
    ];

    public function index()
    {
        return Inertia::render("Admin/ProductoTamanos/Index");
    }

    public function listado(Request $request)
    {
        $producto_tamanos = ProductoTamano::select("producto_tamanos.*");

        if ($request->order && $request->order == "desc") {
            $producto_tamanos->orderBy("producto_tamanos.id", $request->order);
        }

        $producto_tamanos = $producto_tamanos->get();

        return response()->JSON([
            "producto_tamanos" => $producto_tamanos
        ]);
    }

    public function paginado(Request $request)
    {

        $search = $request->search;

        $producto_tamanos = ProductoTamano::select("producto_tamanos.*");

        if (trim($search) != "") {
            $producto_tamanos->where("nombre", "LIKE", "%$search%");
        }

        $producto_tamanos = $producto_tamanos->paginate($request->itemsPerPage);
        return response()->JSON([
            "producto_tamanos" => $producto_tamanos
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el ProductoTamano
            $nuevo_producto_tamano = ProductoTamano::create(array_map('mb_strtoupper', $request->all()));
            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_producto_tamano, "producto_tamanos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto_tamano . ' REGISTRO UNA CATEGORIA',
                'datos_original' => $datos_original,
                'modulo' => 'CATEGORIAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("producto_tamanos.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(ProductoTamano $producto_tamano)
    {
    }

    public function update(ProductoTamano $producto_tamano, Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($producto_tamano, "producto_tamanos");
            $producto_tamano->update(array_map('mb_strtoupper', $request->all()));

            $datos_nuevo = HistorialAccion::getDetalleRegistro($producto_tamano, "producto_tamanos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto_tamano . ' MODIFICÓ UNA CATEGORIA',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'CATEGORIAS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            ProductoController::actualizaPrecioTotalByTamanoProducto($producto_tamano->id);

            DB::commit();
            return redirect()->route("producto_tamanos.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
    public function destroy(ProductoTamano $producto_tamano)
    {
        DB::beginTransaction();
        try {
            $usos = Producto::where("producto_tamano_id", $producto_tamano->id)->get();
            if (count($usos) > 0) {
                throw ValidationException::withMessages([
                    'error' =>  "No es posible eliminar esta categoría porque esta siendo utilizada por otros registros",
                ]);
            }

            $datos_original = HistorialAccion::getDetalleRegistro($producto_tamano, "producto_tamanos");
            $producto_tamano->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto_tamano . ' ELIMINÓ UNA CATEGORIA',
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
