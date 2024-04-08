<?php

namespace App\Http\Controllers;

use App\Models\FotoProducto;
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
        "descripcion" => "required|min:1",
        "categoria_id" => "required",
        "producto_tamano_id" => "required",
        "precio" => "required|numeric|min:0|max:1000000",
        "foto_productos" => "required|array|min:1|max:3",
    ];

    public $mensajes = [
        "descripcion.required" => "Este campo es obligatorio",
        "descripcion.min" => "Debes ingresar al menos :min caracteres",
        "categoria_id.required" => "Este campo es obligatorio",
        "producto_tamano_id.required" => "Este campo es obligatorio",
        "precio.required" => "Este campo es obligatorio",
        "precio.min" => "El precio no puede ser menor que :min",
        "precio.max" => "El precio no puede ser mayor que :max",
        "foto_productos.required" => "Debes cargar al menos una imagen",
        "foto_productos.min" => "Debes cargar al menos :min imagen",
        "foto_productos.max" => "No puedes cargar mas de :max imagenes",
    ];

    public function index()
    {
        return Inertia::render("Admin/Productos/Index");
    }

    public function listado(Request $request)
    {
        $productos = Producto::with(["categoria", "producto_tamano", "user", "foto_productos"]);

        if (Auth::user()->tipo == 'AFILIADO') {
            $productos = $productos->where("user_id", Auth::user()->id);
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

        $productos = Producto::with(["categoria", "producto_tamano", "user", "foto_productos"])->select("productos.*");

        if (trim($search) != "") {
            $productos->where("productos.descripcion", "LIKE", "%$search%");
        }

        if (Auth::user()->tipo == 'AFILIADO') {
            $productos = $productos->where("user_id", Auth::user()->id);
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
        $request['user_id'] = Auth::user()->id;
        DB::beginTransaction();
        try {
            // crear el Producto
            $nuevo_producto = Producto::create(array_map('mb_strtoupper', $request->except("eliminados", "foto_productos", "categoria", "producto_tamano", "user")));
            $datos_original = HistorialAccion::getDetalleRegistro($nuevo_producto, "productos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto . ' REGISTRO UN PRODUCTO',
                'datos_original' => $datos_original,
                'modulo' => 'PRODUCTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);


            if ($request->file("foto_productos")) {
                $foto_productos = $request->file('foto_productos');
                foreach ($foto_productos as $key => $file) {
                    $nom_archivo = "imagen" . $nuevo_producto->id . time() . "_" . $key . "." . $file->getClientOriginalExtension();
                    $nuevo_producto->foto_productos()->create([
                        "foto" => $nom_archivo,
                    ]);
                    $file->move(public_path() . '/imgs/productos/', $nom_archivo);
                }
            }

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
            $producto->update(array_map('mb_strtoupper', $request->except("eliminados", "foto_productos", "categoria", "producto_tamano", "user")));

            $datos_nuevo = HistorialAccion::getDetalleRegistro($producto, "productos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto . ' MODIFICÓ UN PRODUCTO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'PRODUCTOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);


            if (isset($request->eliminados)) {
                foreach ($request->eliminados as $e) {
                    $foto_producto = FotoProducto::find($e);
                    if (file_exists(public_path("imgs/productos/" . $foto_producto->foto))) {
                        \File::delete(public_path("imgs/productos/" . $foto_producto->foto));
                    }
                    $foto_producto->delete();
                }
            }

            $foto_productos = [];
            if ($request->file("foto_productos")) {
                $foto_productos = $request->file('foto_productos');
                foreach ($foto_productos as $key => $file) {
                    $nom_archivo = "imagen" . $producto->id . time() . "_" . $key . "." . $file->getClientOriginalExtension();
                    $producto->foto_productos()->create([
                        "foto" => $nom_archivo,
                    ]);
                    $file->move(public_path() . '/imgs/productos/', $nom_archivo);
                }
            }

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
            foreach ($producto->foto_productos as $item) {
                if (file_exists(public_path("imgs/productos/" . $item->imagen))) {
                    \File::delete(public_path("imgs/productos/" . $item->imagen));
                }
                $item->delete();
            }

            $datos_original = HistorialAccion::getDetalleRegistro($producto, "productos");
            $producto->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->producto . ' ELIMINÓ UN PRODUCTO',
                'datos_original' => $datos_original,
                'modulo' => 'PRODUCTOS',
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
