<?php
// app/Http/Controllers/ApiBD/InsumoApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\InsumoServiceInterface;

class InsumoApiController extends Controller
{
    public function __construct(private InsumoServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $insumo = $this->service->find($id);
        return $insumo
            ? response()->json($insumo)
            : response()->json(['message' => 'Insumo no encontrado'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'nombre_insumo'    => 'required|string|max:50',
            'cantidad_insumo'  => 'required|integer|min:0',
            'costo_insumo'     => 'required|numeric|min:0',
            'fecha_vencimiento'=> 'required|date',
            'umbral_alerta'    => 'required|integer|min:0',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Insumo creado'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'nombre_insumo'    => 'sometimes|string|max:50',
            'cantidad_insumo'  => 'sometimes|integer|min:0',
            'costo_insumo'     => 'sometimes|numeric|min:0',
            'fecha_vencimiento'=> 'sometimes|date',
            'umbral_alerta'    => 'sometimes|integer|min:0',
        ]);

        $ok = $this->service->update($id, $data);
        return $ok
            ? response()->json(['message' => 'Insumo actualizado'])
            : response()->json(['message' => 'Insumo no encontrado'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Insumo eliminado'])
            : response()->json(['message' => 'Insumo no encontrado'], 404);
    }
}
