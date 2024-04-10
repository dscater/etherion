<?php

namespace App\Http\Controllers;

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

            "configuracion_pagos.index",
            "configuracion_pagos.create",
            "configuracion_pagos.edit",
            "configuracion_pagos.destroy",

            "productos.index",
            "productos.destroy",

            "reportes.usuarios",
        ],
        "OPERADOR" => [],
        "AFILIADO" => [
            "productos.index",
            "productos.create",
            "productos.edit",
            "productos.destroy",
        ],
        "CLIENTE" => [],
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
}
