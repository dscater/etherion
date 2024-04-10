<?php

use App\Http\Controllers\AfiliadoController;
use App\Http\Controllers\AvanceObraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracionPagoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\OperarioController;
use App\Http\Controllers\OrdenVentaController;
use App\Http\Controllers\PagoAfiliadoController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoTamanoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



Route::get('/', [PortalController::class, 'index'])->name("portal.inicio");

// CARRITO
Route::get('/carrito', [PortalController::class, 'carrito'])->name("portal.carrito");

Route::get('/registro', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return Inertia::render('Auth/Register');
})->name("registro");


Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return Inertia::render('Auth/Login');
})->name("login");


Route::post("afiliados/registro", [AfiliadoController::class, 'registro'])->name("afiliados.registro");
Route::post("clientes/registro", [ClienteController::class, 'registro'])->name("clientes.registro");

Route::get("institucions/getInstitucion", [InstitucionController::class, 'getInstitucion'])->name("institucions.getInstitucion");

// LISTAS PORTAL
Route::get("productos", [ProductoController::class, 'portal'])->name("productos.portal");
Route::get("categorias", [CategoriaController::class, 'listado'])->name("categorias.portal");
Route::get("configuracion_pagos", [ConfiguracionPagoController::class, 'listado'])->name("configuracion_pagos.portal");

// POST PORTAL

Route::middleware('auth')->prefix("admin")->group(function () {
    // INICIO
    Route::get('/inicio', [InicioController::class, 'inicio'])->name('inicio');

    // INSTITUCION
    Route::resource("institucions", InstitucionController::class)->only(
        ["index", "show", "update"]
    );

    // USUARIO
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/update_foto', [ProfileController::class, 'update_foto'])->name('profile.update_foto');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("getUser", [UserController::class, 'getUser'])->name('users.getUser');
    Route::get("permisos", [UserController::class, 'permisos']);
    Route::get("menu_user", [UserController::class, 'permisos']);

    // USUARIOS
    Route::patch("usuarios/actualizaAcceso/{user}", [UsuarioController::class, 'actualizaAcceso'])->name("usuarios.actualizaAcceso");
    Route::put("usuarios/password/{user}", [UsuarioController::class, 'actualizaPassword'])->name("usuarios.password");
    Route::get("usuarios/paginado", [UsuarioController::class, 'paginado'])->name("usuarios.paginado");
    Route::get("usuarios/listado", [UsuarioController::class, 'listado'])->name("usuarios.listado");
    Route::get("usuarios/listado/byTipo", [UsuarioController::class, 'byTipo'])->name("usuarios.byTipo");
    Route::get("usuarios/show/{user}", [UsuarioController::class, 'show'])->name("usuarios.show");
    Route::put("usuarios/update/{user}", [UsuarioController::class, 'update'])->name("usuarios.update");
    Route::delete("usuarios/{user}", [UsuarioController::class, 'destroy'])->name("usuarios.destroy");
    Route::resource("usuarios", UsuarioController::class)->only(
        ["index", "store"]
    );

    // AFILIADOS
    Route::get("afiliados/paginado", [AfiliadoController::class, 'paginado'])->name("afiliados.paginado");
    Route::get("afiliados/listado", [AfiliadoController::class, 'listado'])->name("afiliados.listado");
    Route::get("afiliados/show/{user}", [AfiliadoController::class, 'show'])->name("afiliados.show");
    Route::put("afiliados/update/{user}", [AfiliadoController::class, 'update'])->name("afiliados.update");
    Route::delete("afiliados/{user}", [AfiliadoController::class, 'destroy'])->name("afiliados.destroy");
    Route::resource("afiliados", AfiliadoController::class)->only(
        ["index", "store"]
    );

    // CLIENTES
    Route::get("clientes/paginado", [ClienteController::class, 'paginado'])->name("clientes.paginado");
    Route::get("clientes/listado", [ClienteController::class, 'listado'])->name("clientes.listado");
    Route::get("clientes/show/{user}", [ClienteController::class, 'show'])->name("clientes.show");
    Route::put("clientes/update/{user}", [ClienteController::class, 'update'])->name("clientes.update");
    Route::delete("clientes/{user}", [ClienteController::class, 'destroy'])->name("clientes.destroy");
    Route::resource("clientes", ClienteController::class)->only(
        ["index", "store"]
    );

    // CATEGORIAS
    Route::get("categorias/paginado", [CategoriaController::class, 'paginado'])->name("categorias.paginado");
    Route::get("categorias/listado", [CategoriaController::class, 'listado'])->name("categorias.listado");
    Route::resource("categorias", CategoriaController::class)->only(
        ["index", "store", "update", "show", "destroy"]
    );

    // PRODUCTO TAMAÑOS
    Route::get("producto_tamanos/paginado", [ProductoTamanoController::class, 'paginado'])->name("producto_tamanos.paginado");
    Route::get("producto_tamanos/listado", [ProductoTamanoController::class, 'listado'])->name("producto_tamanos.listado");
    Route::resource("producto_tamanos", ProductoTamanoController::class)->only(
        ["index", "store", "update", "show", "destroy"]
    );

    // CONFIGURACION PAGOS
    Route::get("configuracion_pagos/paginado", [ConfiguracionPagoController::class, 'paginado'])->name("configuracion_pagos.paginado");
    Route::get("configuracion_pagos/listado", [ConfiguracionPagoController::class, 'listado'])->name("configuracion_pagos.listado");
    Route::resource("configuracion_pagos", ConfiguracionPagoController::class)->only(
        ["index", "store", "update", "show", "destroy"]
    );

    // PRODUCTOS
    Route::get("productos/getProducto/{producto}", [ProductoController::class, 'getProducto'])->name("productos.getProducto");
    Route::get("productos/paginado", [ProductoController::class, 'paginado'])->name("productos.paginado");
    Route::get("productos/listado", [ProductoController::class, 'listado'])->name("productos.listado");
    Route::get("productos/geolocalizacion", [ProductoController::class, 'geolocalizacion'])->name("productos.geolocalizacion");
    Route::resource("productos", ProductoController::class)->only(
        ["index", "store", "update", "show", "destroy"]
    );

    // ORDEN DE VENTAS
    Route::post("registraOrden", [OrdenVentaController::class, 'registraOrden'])->name("orden_ventas.registraOrden");
    Route::patch("orden_ventas/actualiza_estado/{orden_venta}", [OrdenVentaController::class, 'actualiza_estado'])->name("orden_ventas.actualiza_estado");
    Route::get("orden_ventas/paginado", [OrdenVentaController::class, 'paginado'])->name("orden_ventas.paginado");
    Route::get("orden_ventas/listado", [OrdenVentaController::class, 'listado'])->name("orden_ventas.listado");
    Route::resource("orden_ventas", OrdenVentaController::class)->only(
        ["index", "store", "update", "show", "destroy"]
    );

    // PAGO DE AFILIADOS
    Route::get("pago_afiliados/paginado", [PagoAfiliadoController::class, 'paginado'])->name("pago_afiliados.paginado");
    Route::get("pago_afiliados/listado", [PagoAfiliadoController::class, 'listado'])->name("pago_afiliados.listado");
    Route::resource("pago_afiliados", PagoAfiliadoController::class)->only(
        ["index", "store", "update", "show", "destroy"]
    );

    // REPORTES
    Route::get('reportes/productos', [ReporteController::class, 'productos'])->name("reportes.productos");
    Route::get('reportes/r_productos', [ReporteController::class, 'r_productos'])->name("reportes.r_productos");
    
    Route::get('reportes/orden_ventas', [ReporteController::class, 'orden_ventas'])->name("reportes.orden_ventas");
    Route::get('reportes/r_orden_ventas', [ReporteController::class, 'r_orden_ventas'])->name("reportes.r_orden_ventas");
    
    Route::get('reportes/ingresos_comision', [ReporteController::class, 'ingresos_comision'])->name("reportes.ingresos_comision");
    Route::get('reportes/r_ingresos_comision', [ReporteController::class, 'r_ingresos_comision'])->name("reportes.r_ingresos_comision");

    Route::get('reportes/afiliados', [ReporteController::class, 'afiliados'])->name("reportes.afiliados");
    Route::get('reportes/r_afiliados', [ReporteController::class, 'r_afiliados'])->name("reportes.r_afiliados");
    
    Route::get('reportes/clientes', [ReporteController::class, 'clientes'])->name("reportes.clientes");
    Route::get('reportes/r_clientes', [ReporteController::class, 'r_clientes'])->name("reportes.r_clientes");
    
    Route::get('reportes/g_orden_ventas', [ReporteController::class, 'g_orden_ventas'])->name("reportes.g_orden_ventas");
    Route::get('reportes/r_g_orden_ventas', [ReporteController::class, 'r_g_orden_ventas'])->name("reportes.r_g_orden_ventas");
    
    Route::get('reportes/g_ingresos_comision', [ReporteController::class, 'g_ingresos_comision'])->name("reportes.g_ingresos_comision");
    Route::get('reportes/r_g_ingresos_comision', [ReporteController::class, 'r_g_ingresos_comision'])->name("reportes.r_g_ingresos_comision");
    
    Route::get('reportes/e_orden_ventas', [ReporteController::class, 'e_orden_ventas'])->name("reportes.e_orden_ventas");
    Route::get('reportes/r_e_orden_ventas', [ReporteController::class, 'r_e_orden_ventas'])->name("reportes.r_e_orden_ventas");
});

require __DIR__ . '/auth.php';
