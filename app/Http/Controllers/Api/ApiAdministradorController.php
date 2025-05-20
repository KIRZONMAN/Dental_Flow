<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ApiAdministradorController extends Controller
{

    public function index()
    {
        return view('administrador.gestionUsuarios');
    }

    public function indexUsuarios()
    {
        $usuarios = DB::table('v_gestion_usuarios')->get();

        return response()->json([
            'usuarios' => $usuarios
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombres_usuario' => 'required',
            'apellidos_usuario' => 'required',
            'correo_usuario' => 'required|email',
            'contrasena_usuario' => 'nullable|string|min:6',
            'telefono_usuario' => 'required',
            'direccion_usuario' => 'required',
            'estado_usuario' => 'required|in:activo,inactivo',
            'rol_id' => 'required|integer',
        ]);

        try {
            // Si no vino password, no lo incluimos en el array
            $update = [
                'nombres_usuario' => $data['nombres_usuario'],
                'apellidos_usuario' => $data['apellidos_usuario'],
                'correo_usuario' => $data['correo_usuario'],
                'telefono_usuario' => $data['telefono_usuario'],
                'direccion_usuario' => $data['direccion_usuario'],
                'estado_usuario' => $data['estado_usuario'],
                'rol_id' => $data['rol_id'],
            ];
            if (!empty($data['contrasena_usuario'])) {
                $update['contrasena_usuario'] = Hash::make($data['contrasena_usuario']);
            }

            DB::table('usuarios')->where('id_usuario', $id)->update($update);
            return redirect()->route('administrador.usuarios')
                ->with('success', 'Usuario actualizado');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function eliminarUsuario($id)
    {
        DB::table('usuarios')->where('id_usuario', $id)->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);
    }

    public function edit($id)
    {
        $usuario = DB::table('usuarios')->where('id_usuario', $id)->first();
        $roles = DB::table('roles')->select('id_rol', 'nombre_rol')->get();
        return view('administrador.usuarios_edit', compact('usuario', 'roles'));
    }


}
