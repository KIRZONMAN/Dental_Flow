<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdministradorController extends Controller
{

        public function edit($id)
    {
        $usuario = DB::table('usuarios')->where('id_usuario', $id)->first();
        $roles = DB::table('roles')->select('id_rol', 'nombre_rol')->get();
        return view('administrador.usuarios_edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombres_usuario' => 'required|string|max:255',
            'apellidos_usuario' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuarios,correo_usuario,' . $id . ',id_usuario',
            'contrasena_usuario' => 'nullable|string|min:8',
            'telefono_usuario' => 'required|string|max:50',
            'direccion_usuario' => 'required|string|max:255',
            'estado_usuario' => 'required|in:activo,inactivo',
            'rol_id' => 'required|exists:roles,id_rol',
        ], [
            'correo_usuario.unique' => 'Este correo ya está en uso por otro usuario.',
            'contrasena_usuario.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        try {
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
                $update['contrasena_usuario'] = bcrypt($data['contrasena_usuario']);
            }

            DB::table('usuarios')->where('id_usuario', $id)->update($update);

            return redirect()->route('administrador.usuarios')
                ->with('success', 'Usuario actualizado correctamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

        public function configuracion3(Request $request)
    {
        // Si es POST, guardamos en sesión de Laravel
        if ($request->isMethod('post')) {
            session([
                'administrador.nombre' => $request->input('nombre'),
                'administrador.telefono' => $request->input('telefono'),
                'administrador.email' => $request->input('email'),
            ]);
            return redirect('administrador');
        }

        // Valores por defecto
        $datos = [
            'nombre' => session('administrador.nombre', '(Nombre)'),
            'telefono' => session('administrador.telefono', '+57 34567890'),
            'email' => session('administrador.email', 'administrador@dominio.com'),
            'especialidad' => 'Administrador',
        ];

        return view('administrador.configuracion3', $datos);
    }

    //Vista formulario
    public function VistaAgregarUsuario()
    {
        $roles = DB::table('roles')->get();
        return view('administrador.agregarUsuario', compact('roles'));
    }

        public function agregarUsuario(Request $request)
    {
        $validated = $request->validate([
            'nombres_usuario' => 'required|string|max:255',
            'apellidos_usuario' => 'required|string|max:255',
            'correo_usuario' => 'required|email|unique:usuarios,correo_usuario',
            'contrasena_usuario' => 'required|string|min:8',
            'telefono_usuario' => 'required|string|max:50',
            'direccion_usuario' => 'required|string|max:255',
            'estado_usuario' => 'required|in:activo,inactivo',
            'rol_id' => 'required|exists:roles,id_rol',
            'especialidad_usuario' => 'nullable|string|max:255',
        ], [
            /* Mensajes personalizados */
            'contrasena_usuario.min' => 'El campo contraseña requiere al menos 8 caracteres.',
            'correo_usuario.unique' => 'El correo ya está registrado'
        ]);

        DB::table('usuarios')->insert([
            'nombres_usuario' => $validated['nombres_usuario'],
            'apellidos_usuario' => $validated['apellidos_usuario'],
            'correo_usuario' => $validated['correo_usuario'],
            'contrasena_usuario' => bcrypt($validated['contrasena_usuario']),
            'telefono_usuario' => $validated['telefono_usuario'],
            'direccion_usuario' => $validated['direccion_usuario'],
            'estado_usuario' => $validated['estado_usuario'],
            'especialidad_usuario' => $validated['especialidad_usuario'] ?? null,
            'rol_id' => $validated['rol_id'],
        ]);

        return redirect()->route('gestionUsuarios')->with('success', 'Usuario registrado correctamente');
    }

    //Borrar un usuario
        public function eliminarUsuario($id)
    {
        DB::table('usuarios')->where('id_usuario', $id)->delete();

        return redirect()->route('gestionUsuarios')->with('success', 'Usuario registrado correctamente');
    }
}
