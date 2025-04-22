<?php
// app/Http/Controllers/ApiBD/ProcedimientoApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\ProcedimientoServiceInterface;

class ProcedimientoApiController extends Controller
{
    public function __construct(private ProcedimientoServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $proc = $this->service->find($id);
        return $proc
            ? response()->json($proc)
            : response()->json(['message' => 'Procedimiento no encontrado'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'tipo_procedimiento' => 'required|string|max:30',
            'costo'              => 'required|numeric|min:0',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Procedimiento creado'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'tipo_procedimiento' => 'sometimes|string|max:30',
            'costo'              => 'sometimes|numeric|min:0',
        ]);

        $ok = $this->service->update($id, $data);
        return $ok
            ? response()->json(['message' => 'Procedimiento actualizado'])
            : response()->json(['message' => 'Procedimiento no encontrado'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Procedimiento eliminado'])
            : response()->json(['message' => 'Procedimiento no encontrado'], 404);
    }
}
