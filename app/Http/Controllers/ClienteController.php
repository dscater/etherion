<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ClienteController extends Controller
{
    public $validacion = [
        "nombre" => "required|min:1",
        "paterno" => "required|min:1",
        "ci" => "required|min:1",
        "ci_exp" => "required",
        "dir" => "required|min:1",
        "fono" => "required|min:1",
        "tipo" => "required",
        "acepto" => "required|boolean|accepted",
        'password' => 'required|confirmed|min:8',
    ];

    public $mensajes = [
        "nombre.required" => "Este campo es obligatorio",
        "nombre.min" => "Debes ingresar al menos :min caracteres",
        "paterno.required" => "Este campo es obligatorio",
        "paterno.min" => "Debes ingresar al menos :min caracteres",
        "ci.required" => "Este campo es obligatorio",
        "ci.unique" => "Este C.I. ya fue registrado",
        "ci.min" => "Debes ingresar al menos :min caracteres",
        "ci_exp.required" => "Este campo es obligatorio",
        "email.unique" => "El correo electrónico ya fue registrado",
        "dir.required" => "Este campo es obligatorio",
        "dir.min" => "Debes ingresar al menos :min caracteres",
        "fono.required" => "Este campo es obligatorio",
        "fono.min" => "Debes ingresar al menos :min caracteres",
        "tipo.required" => "Este campo es obligatorio",
        "acepto.accepted" => "Este campo es obligatorio",
        "password.required" => "Este campo es obligatorio",
        "password.confirmed" => "La contaseña no coincide",
        "password.min" => "Debes ingresar al menos :min caracteres",
    ];

    public function index()
    {
        return Inertia::render("Admin/Clientes/Index");
    }

    public function listado()
    {
        $usuarios = User::where("id", "!=", 1)->where("tipo", "CLIENTE")->get();
        return response()->JSON([
            "usuarios" => $usuarios
        ]);
    }

    public function paginado(Request $request)
    {
        $search = $request->search;
        $usuarios = User::where("id", "!=", 1)->where("tipo", "CLIENTE");

        if (trim($search) != "") {
            $usuarios->where("nombre", "LIKE", "%$search%");
            $usuarios->orWhere("paterno", "LIKE", "%$search%");
            $usuarios->orWhere("materno", "LIKE", "%$search%");
            $usuarios->orWhere("ci", "LIKE", "%$search%");
        }

        $usuarios = $usuarios->paginate($request->itemsPerPage);
        return response()->JSON([
            "usuarios" => $usuarios
        ]);
    }

    public function registro(Request $request)
    {
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci';
        $this->validacion['email'] = 'required|unique:users,ci';
        $request->validate($this->validacion, $this->mensajes);
        $request['fecha_registro'] = date('Y-m-d');
        $request['usuario'] = $request->email;
        $pass_aux = $request->password;
        DB::beginTransaction();
        try {
            // crear el Usuario
            $nuevo_usuario = User::create(array_map('mb_strtoupper', $request->except('foto')));
            $nuevo_usuario->password = Hash::make($pass_aux);
            $nuevo_usuario->usuario = mb_strtolower($request->usuario);
            $nuevo_usuario->email = mb_strtolower($request->email);
            $nuevo_usuario->cliente()->create([
                "acepto_contrato" => $request->acepto,
            ]);
            $nuevo_usuario->save();
            DB::commit();

            Auth::login($nuevo_usuario);

            return redirect()->route("inicio")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci';
        $this->validacion['email'] = 'required|unique:users,ci';
        $request->validate($this->validacion, $this->mensajes);
        $request['password'] = Hash::make($request->password);
        $request['fecha_registro'] = date('Y-m-d');
        DB::beginTransaction();
        try {
            // crear el Usuario
            $nuevo_usuario = User::create(array_map('mb_strtoupper', $request->except('foto')));
            // $nuevo_usuario->cliente()->create([
            //     "acepto_contrato" => $request->acepto_contrato,
            // ]);
            DB::commit();
            return redirect()->route("usuarios.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(User $user)
    {
    }

    public function update(User $user, Request $request)
    {
        $this->validacion['ci'] = 'required|min:4|numeric|unique:users,ci,' . $user->id;
        $this->validacion['email'] = 'required|unique:users,ci,' . $user->id;
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $datos_original = HistorialAccion::getDetalleRegistro($user, "users");
            $user->update(array_map('mb_strtoupper', $request->except('foto')));

            $datos_nuevo = HistorialAccion::getDetalleRegistro($user, "users");
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'MODIFICACIÓN',
                'descripcion' => 'EL CLIENTE ' . Auth::user()->usuario . ' MODIFICÓ UN CLIENTE',
                'datos_original' => $datos_original,
                'datos_nuevo' => $datos_nuevo,
                'modulo' => 'CLIENTES',
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s')
            ]);


            DB::commit();
            return redirect()->route("usuarios.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $antiguo = $user->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/users/' . $antiguo);
            }
            $datos_original = HistorialAccion::getDetalleRegistro($user, "users");

            $user->delete();
            HistorialAccion::create([
                'user_id' => Auth::user()->id,
                'accion' => 'ELIMINACIÓN',
                'descripcion' => 'EL CLIENTE ' . Auth::user()->usuario . ' ELIMINÓ UN CLIENTE',
                'datos_original' => $datos_original,
                'modulo' => 'CLIENTES',
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
