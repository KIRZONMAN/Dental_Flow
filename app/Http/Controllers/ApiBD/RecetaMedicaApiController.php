<?php
// app/Http/Controllers/ApiBD/RecetaMedicaApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\RecetaMedicaServiceInterface;

class RecetaMedicaApiController extends Controller
{
    public function __construct(private RecetaMedicaServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $rec = $this->service->find($id);
        return $rec
            ? response()->json($rec)
            : response()->json(['message' => 'Receta médica no encontrada'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'historia_clinica_id'=> 'required|integer',
            'tipo_orden'         => 'required|string|max:50',
            'descripcion_receta' => 'required|string|max:255',
            'medicamento_recetado'=> 'required|string|max:255',
            'fecha_receta'       => 'required|date',
        ]);

        $this->service->create([
            'historia_clinica_id'=> $data['historia_clinica_id'],
            'tipo_orden'         => $data['tipo_orden'],
            'descripcion_receta' => $data['descripcion_receta'],
            'medicamento_recetado'=> $data['medicamento_recetado'],
            'fecha_receta'       => $data['fecha_receta'],
        ]);

        return response()->json(['message' => 'Receta médica creada'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'historia_clinica_id'=> 'sometimes|integer',
            'tipo_orden'         => 'sometimes|string|max:50',
            'descripcion_receta' => 'sometimes|string|max:255',
            'medicamento_recetado'=> 'sometimes|string|max:255',
            'fecha_receta'       => 'sometimes|date',
        ]);

        $ok = $this->service->update($id, $data);
        return $ok
            ? response()->json(['message' => 'Receta médica actualizada'])
            : response()->json(['message' => 'Receta médica no encontrada'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Receta médica eliminada'])
            : response()->json(['message' => 'Receta médica no encontrada'], 404);
    }
}
