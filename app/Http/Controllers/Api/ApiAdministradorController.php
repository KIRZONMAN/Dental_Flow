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
    /**
     * Remove the specified resource from storage.
     */

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
