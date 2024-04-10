<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionPago;
use App\Models\HistorialAccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ConfiguracionPagoController extends Controller
{
    public $validacion = [
        "banco" => "required|min:1",
        "nro_cuenta" => "required|min:1",
    ];

    public $mensajes = [
        "banco.required" => "Este campo es obligatorio",
        "banco.min" => "Debes ingresar al menos :min caracteres",
        "nro_cuenta.required" => "Este campo es obligatorio",
        "nro_cuenta.min" => "Debes ingresar al menos :min caracteres",
        "qr.required" => "Este campo es obligatorio",
    ];

    public function index()
    {
        return Inertia::render("Admin/ConfiguracionPagos/Index");
    }

    public function listado(Request $request)
    {
        $configuracion_pagos = ConfiguracionPago::select("configuracion_pagos.*");

        if ($request->order && $request->order == "desc") {
            $configuracion_pagos->orderBy("configuracion_pagos.id", $request->order);
        }

        $configuracion_pagos = $configuracion_pagos->get();

        return response()->JSON([
            "configuracion_pagos" => $configuracion_pagos
        ]);
    }

    public function paginado(Request $request)
    {

        $search = $request->search;

        $configuracion_pagos = ConfiguracionPago::select("configuracion_pagos.*");

        if (trim($search) != "") {
            $configuracion_pagos->where("nombre", "LIKE", "%$search%");
        }

        $configuracion_pagos = $configuracion_pagos->paginate($request->itemsPerPage);
        return response()->JSON([
            "configuracion_pagos" => $configuracion_pagos
        ]);
    }

    public function store(Request $request)
    {
        $this->validacion["qr"] = "required";
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear la ConfiguracionPago
            $nueva_configuracion_pago = ConfiguracionPago::create(array_map('mb_strtoupper', $request->except("qr")));
            $datos_original = HistorialAccion::getDetalleRegistro($nueva_configuracion_pago, "configuracion_pagos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'CREACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->configuracion_pago . ' REGISTRO UNA CONFIGURACIÓN DE PAGO',
                'datos_original' => $datos_original,
                'modulo' => 'CONFIGURACIÓN DE PAGOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            if ($request->hasFile('qr')) {
                $file = $request->qr;
                $nom_qr = time() . '_' . $nueva_configuracion_pago->id . '.' . $file->getClientOriginalExtension();
                $nueva_configuracion_pago->qr = $nom_qr;
                $file->move(public_path() . '/imgs/qr/', $nom_qr);
            }
            $nueva_configuracion_pago->save();

            DB::commit();
            return redirect()->route("configuracion_pagos.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(ConfiguracionPago $configuracion_pago)
    {
    }

    public function update(ConfiguracionPago $configuracion_pago, Request $request)
    {
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($configuracion_pago, "configuracion_pagos");
            $configuracion_pago->update(array_map('mb_strtoupper', $request->except("qr")));
            if ($request->hasFile('qr')) {
                $antiguo = $configuracion_pago->qr;
                if ($antiguo != 'default.png') {
                    \File::delete(public_path() . '/imgs/qr/' . $antiguo);
                }
                $file = $request->qr;
                $nom_qr = time() . '_' . $configuracion_pago->id . '.' . $file->getClientOriginalExtension();
                $configuracion_pago->qr = $nom_qr;
                $file->move(public_path() . '/imgs/qr/', $nom_qr);
            }
            $configuracion_pago->save();

            $datos_nuevo = HistorialAccion::getDetalleRegistro($configuracion_pago, "configuracion_pagos");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->configuracion_pago . ' MODIFICÓ UNA CONFIGURACIÓN DE PAGO',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'CONFIGURACIÓN DE PAGOS',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);

            DB::commit();
            return redirect()->route("configuracion_pagos.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
    public function destroy(ConfiguracionPago $configuracion_pago)
    {
        DB::beginTransaction();
        try {

            $antiguo = $configuracion_pago->qr;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/qr/' . $antiguo);
            }

            $datos_original = HistorialAccion::getDetalleRegistro($configuracion_pago, "configuracion_pagos");
            $configuracion_pago->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL USUARIO ' . Auth::user()->configuracion_pago . ' ELIMINÓ UNA CONFIGURACIÓN DE PAGO',
                'datos_original' => $datos_original,
                'modulo' => 'CONFIGURACIÓN DE PAGOS',
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
