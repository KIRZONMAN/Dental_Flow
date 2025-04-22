<?php
// app/Http/Controllers/ApiBD/HistoriaClinicaApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\HistoriaClinicaServiceInterface;

class HistoriaClinicaApiController extends Controller
{
    public function __construct(private HistoriaClinicaServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $hc = $this->service->find($id);
        return $hc
            ? response()->json($hc)
            : response()->json(['message' => 'Historia clínica no encontrada'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'paciente_id' => 'required|string|max:20',
            'antecedentes'=> 'required|string|max:255',
            'tratamientos'=> 'required|string|max:255',
        ]);

        $this->service->create([
            'paciente_id'          => $data['paciente_id'],
            'antecedentes_medicos' => $data['antecedentes'],
            'tratamiento_realizados'=> $data['tratamientos'],
        ]);

        return response()->json(['message' => 'Historia clínica creada'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'antecedentes'=> 'sometimes|string|max:255',
            'tratamientos'=> 'sometimes|string|max:255',
        ]);

        $ok = $this->service->update($id, [
            'antecedentes_medicos'  => $data['antecedentes'] ?? null,
            'tratamiento_realizados'=> $data['tratamientos'] ?? null,
        ]);

        return $ok
            ? response()->json(['message' => 'Historia clínica actualizada'])
            : response()->json(['message' => 'Historia clínica no encontrada'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Historia clínica eliminada'])
            : response()->json(['message' => 'Historia clínica no encontrada'], 404);
    }
}
