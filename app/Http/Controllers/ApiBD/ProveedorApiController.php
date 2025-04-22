<?php
// app/Http/Controllers/ApiBD/ProveedorApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\ProveedorServiceInterface;

class ProveedorApiController extends Controller
{
    public function __construct(private ProveedorServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(string $nit): JsonResponse
    {
        $prov = $this->service->find($nit);
        return $prov
            ? response()->json($prov)
            : response()->json(['message' => 'Proveedor no encontrado'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'nit'      => 'required|string|max:20|unique:proveedores,nit',
            'nombre'   => 'required|string|max:50',
            'telefono' => 'required|string|max:50',
            'correo'   => 'required|email|max:50',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Proveedor creado'], 201);
    }

    public function update(Request $req, string $nit): JsonResponse
    {
        $data = $req->validate([
            'nombre'   => 'sometimes|string|max:50',
            'telefono' => 'sometimes|string|max:50',
            'correo'   => 'sometimes|email|max:50',
        ]);

        $ok = $this->service->update($nit, $data);
        return $ok
            ? response()->json(['message' => 'Proveedor actualizado'])
            : response()->json(['message' => 'Proveedor no encontrado'], 404);
    }

    public function destroy(string $nit): JsonResponse
    {
        $ok = $this->service->delete($nit);
        return $ok
            ? response()->json(['message' => 'Proveedor eliminado'])
            : response()->json(['message' => 'Proveedor no encontrado'], 404);
    }
}
