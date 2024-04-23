<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\OrdenVenta;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public static $permisos = [
        "ADMINISTRADOR" => [
            "usuarios.index",
            "usuarios.create",
            "usuarios.edit",
            "usuarios.destroy",

            "institucions.index",
            "institucions.create",
            "institucions.edit",
            "institucions.destroy",

            "afiliados.index",
            "afiliados.create",
            "afiliados.edit",
            "afiliados.destroy",

            "clientes.index",
            "clientes.create",
            "clientes.edit",
            "clientes.destroy",

            "categorias.index",
            "categorias.create",
            "categorias.edit",
            "categorias.destroy",

            "producto_tamanos.index",
            "producto_tamanos.create",
            "producto_tamanos.edit",
            "producto_tamanos.destroy",

            "orden_ventas.index",
            "orden_ventas.show",
            "orden_ventas.update_estado",
            "orden_ventas.destroy",

            "pago_afiliados.index",
            "pago_afiliados.create",
            "pago_afiliados.edit",
            "pago_afiliados.destroy",

            "configuracion_pagos.index",
            "configuracion_pagos.create",
            "configuracion_pagos.edit",
            "configuracion_pagos.destroy",

            "productos.index",
            "productos.destroy",

            "reportes.productos",
            "reportes.orden_ventas",
            "reportes.ingresos_comision",
            "reportes.afiliados",
            "reportes.clientes",
            "reportes.g_orden_ventas",
            "reportes.g_ingresos_comision",
            "reportes.e_orden_ventas",
        ],
        "OPERADOR" => [
            "institucions.index",
            "institucions.create",
            "institucions.edit",
            "institucions.destroy",

            "afiliados.index",
            "afiliados.create",
            "afiliados.edit",
            "afiliados.destroy",

            "clientes.index",
            "clientes.create",
            "clientes.edit",
            "clientes.destroy",

            "categorias.index",
            "categorias.create",
            "categorias.edit",
            "categorias.destroy",

            "producto_tamanos.index",
            "producto_tamanos.create",
            "producto_tamanos.edit",
            "producto_tamanos.destroy",

            "orden_ventas.index",
            "orden_ventas.show",
            "orden_ventas.update_estado",
            "orden_ventas.destroy",

            "pago_afiliados.index",
            "pago_afiliados.create",
            "pago_afiliados.edit",
            "pago_afiliados.destroy",

            "configuracion_pagos.index",
            "configuracion_pagos.create",
            "configuracion_pagos.edit",
            "configuracion_pagos.destroy",

            "productos.index",
            "productos.destroy",

            "reportes.productos",
            "reportes.orden_ventas",
            "reportes.ingresos_comision",
            "reportes.afiliados",
            "reportes.clientes",
            "reportes.g_orden_ventas",
            "reportes.g_ingresos_comision",
            "reportes.e_orden_ventas",
        ],
        "AFILIADO" => [
            "productos.index",
            "productos.create",
            "productos.edit",
            "productos.destroy",

            "orden_ventas.index",
            "orden_ventas.show",
        ],
        "CLIENTE" => [
            "orden_ventas.index",
            "orden_ventas.show",
        ],
    ];

    public static function getPermisosUser()
    {
        $array_permisos = self::$permisos;
        if ($array_permisos[Auth::user()->tipo]) {
            return $array_permisos[Auth::user()->tipo];
        }
        return [];
    }


    public static function verificaPermiso($permiso)
    {
        if (in_array($permiso, self::$permisos[Auth::user()->tipo])) {
            return true;
        }
        return false;
    }

    public function permisos(Request $request)
    {
        return response()->JSON([
            "permisos" => $this->permisos[Auth::user()->tipo]
        ]);
    }

    public function getUser()
    {
        return response()->JSON([
            "user" => Auth::user()
        ]);
    }

    public static function getInfoBoxUser()
    {
        $tipo = Auth::user()->tipo;
        $array_infos = [];
        if (in_array('productos.index', self::$permisos[$tipo])) {
            $productos = Producto::all();
            if (Auth::user()->tipo == 'AFILIADO') {
                $productos = Producto::where("user_id", Auth::user()->id)->get();
            }
            $array_infos[] = [
                'label' => 'Productos',
                'cantidad' => count($productos),
                'color' => 'bg-blue-darken-2',
                'icon' => asset("imgs/icon_producto.png"),
                "url" => "productos.index"
            ];
        }
        if (in_array('orden_ventas.index', self::$permisos[$tipo])) {
            $orden_ventas = OrdenVenta::all();
            if (Auth::user()->tipo == 'AFILIADO') {
                $orden_ventas = OrdenVenta::select("orden_ventas.*")
                    ->join("orden_detalles", "orden_detalles.orden_venta_id", "=", "orden_ventas.id")
                    ->join("productos", "productos.id", "=", "orden_detalles.producto_id")
                    ->where("productos.user_id", Auth::user()->id)
                    ->get();
            }
            if (Auth::user()->tipo == 'CLIENTE') {
                $orden_ventas = OrdenVenta::where("user_id", Auth::user()->id)
                    ->where("estado", "!=", "PENDIENTE")
                    ->get();
            }
            $array_infos[] = [
                'label' => 'Ordenes de Ventas',
                'cantidad' => count($orden_ventas),
                'color' => 'bg-success',
                'icon' => asset("imgs/checklist.png"),
                "url" => "orden_ventas.index"
            ];
        }
        if (in_array('categorias.index', self::$permisos[$tipo])) {
            $categorias = Categoria::all();
            $array_infos[] = [
                'label' => 'Categorías',
                'cantidad' => count($categorias),
                'color' => 'bg-info',
                'icon' => asset("imgs/productdevelopment.png"),
                "url" => "categorias.index"
            ];
        }
        if (in_array('producto_tamanos.index', self::$permisos[$tipo])) {
            $producto_tamanos = Categoria::all();
            $array_infos[] = [
                'label' => 'Tamaño de Productos',
                'cantidad' => count($producto_tamanos),
                'color' => 'bg-warning',
                'icon' => asset("imgs/ruler.png"),
                "url" => "producto_tamanos.index"
            ];
        }
        if (in_array('clientes.index', self::$permisos[$tipo])) {
            $clientes = User::where("tipo", "CLIENTE")->get();
            $array_infos[] = [
                'label' => 'Clientes',
                'cantidad' => count($clientes),
                'color' => 'bg-indigo',
                'icon' => asset("imgs/people.png"),
                "url" => "clientes.index"
            ];
        }
        if (in_array('afiliados.index', self::$permisos[$tipo])) {
            $afiliados = User::where("tipo", "AFILIADO")->get();
            $array_infos[] = [
                'label' => 'Afiliados',
                'cantidad' => count($afiliados),
                'color' => 'bg-cyan-darken-2',
                'icon' => asset("imgs/people.png"),
                "url" => "afiliados.index"
            ];
        }
        if (in_array('usuarios.index', self::$permisos[$tipo])) {
            $usuarios = User::where("id", "!=", 1)->whereIn("tipo", ["ADMINISTRADOR", "OPERADOR"])->get();
            $array_infos[] = [
                'label' => 'Usuarios',
                'cantidad' => count($usuarios),
                'color' => 'bg-cyan-darken-2',
                'icon' => asset("imgs/icon_users.png"),
                "url" => "usuarios.index"
            ];
        }
        return $array_infos;
    }
}
