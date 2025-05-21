<?php
namespace App\Http\Controllers\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ApiAdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

    //Vista formulario
    public function VistaAgregarUsuario()
    {
        $roles = DB::table('roles')->get();
        return view('administrador.agregarUsuario', compact('roles'));
    }


    //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminarUsuario($id)
    {
        DB::table('usuarios')->where('id_usuario', $id)->delete();

        return response()->json(['mensaje' => 'Usuario eliminado correctamente'], 200);
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'correo_usuario' => 'required|email',
            'contrasena_usuario' => 'required|string',
        ]);

        $usuario = DB::table('usuarios')
            ->where('correo_usuario', $validated['correo_usuario'])
            ->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if (Hash::check($validated['contrasena_usuario'], $usuario->contrasena_usuario)) {
            // Aquí podrías crear un token o sesión API
            return response()->json(['success' => 'Has iniciado sesión correctamente'], 200);
        } else {
            return response()->json(['error' => 'Contraseña incorrecta'], 401);
        }
    }

    public function indexTablaUsuarios(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page = $request->query('page', 1);

        $data = DB::table('usuarios')
            ->join('roles', 'usuarios.rol_id', '=', 'roles.id_rol')
            ->select(
                'usuarios.id_usuario',
                DB::raw("CONCAT(usuarios.nombres_usuario, ' ', usuarios.apellidos_usuario) AS nombre_completo"),
                'usuarios.correo_usuario as correo',
                'usuarios.estado_usuario as estado',
                'roles.nombre_rol as rol'
            )
            ->orderBy('usuarios.id_usuario', 'asc')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json($data);
    }

    public function filtrarUsuario($input)
    {
        $usuarios = DB::table('usuarios')
            ->join('roles', 'usuarios.rol_id', '=', 'roles.id_rol')
            ->select(
                'usuarios.id_usuario as id_usuario',
                DB::raw("CONCAT(usuarios.nombres_usuario, ' ', usuarios.apellidos_usuario) AS nombre_completo"),
                'usuarios.correo_usuario as correo',
                'usuarios.estado_usuario as estado',
                'roles.nombre_rol as rol'
            )
            ->where(function ($query) use ($input) {
                $query->where('usuarios.nombres_usuario', 'like', "$input%")
                    ->orWhere('usuarios.apellidos_usuario', 'like', "$input%")
                    ->orWhere('usuarios.correo_usuario', 'like', "$input%");
            })
            ->orderBy('usuarios.id_usuario', 'asc')
            ->paginate(10);

        return response()->json($usuarios);
    }

}
