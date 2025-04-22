<?php
// app/Http/Controllers/ApiBD/UsuarioApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\UsuarioServiceInterface;

class UsuarioApiController extends Controller
{
    public function __construct(private UsuarioServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $u = $this->service->find($id);
        return $u
            ? response()->json($u)
            : response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'nombres_usuario'     => 'required|string|max:50',
            'apellidos_usuario'   => 'required|string|max:50',
            'correo_usuario'      => 'required|email|max:100|unique:usuarios,correo_usuario',
            'contrasena_usuario'  => 'required|string|min:6',
            'telefono_usuario'    => 'required|string|max:50',
            'direccion_usuario'   => 'required|string|max:100',
            'estado_usuario'      => 'required|in:activo,inactivo',
            'especialidad_usuario'=> 'nullable|string|max:50',
            'rol_id'              => 'required|integer',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Usuario creado'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'nombres_usuario'     => 'sometimes|string|max:50',
            'apellidos_usuario'   => 'sometimes|string|max:50',
            'correo_usuario'      => 'sometimes|email|max:100',
            'contrasena_usuario'  => 'sometimes|string|min:6',
            'telefono_usuario'    => 'sometimes|string|max:50',
            'direccion_usuario'   => 'sometimes|string|max:100',
            'estado_usuario'      => 'sometimes|in:activo,inactivo',
            'especialidad_usuario'=> 'sometimes|nullable|string|max:50',
            'rol_id'              => 'sometimes|integer',
        ]);

        $ok = $this->service->update($id, $data);
        return $ok
            ? response()->json(['message' => 'Usuario actualizado'])
            : response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Usuario eliminado'])
            : response()->json(['message' => 'Usuario no encontrado'], 404);
    }
}
