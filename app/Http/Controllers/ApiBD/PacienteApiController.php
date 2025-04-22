<?php
// app/Http/Controllers/ApiBD/PacienteApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\PacienteServiceInterface;

class PacienteApiController extends Controller
{
    public function __construct(private PacienteServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(string $cedula): JsonResponse
    {
        $paciente = $this->service->find($cedula);
        return $paciente
            ? response()->json($paciente)
            : response()->json(['message' => 'Paciente no encontrado'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'cedula'              => 'required|string|max:20|unique:pacientes,cedula',
            'nombres_paciente'    => 'required|string|max:50',
            'apellidos_paciente'  => 'required|string|max:50',
            'edad'                => 'required|integer|min:0|max:120',
            'genero'              => 'required|in:masculino,femenino',
            'telefono_paciente'   => 'required|string|max:50',
            'direccion_paciente'  => 'required|string|max:100',
            'correo_paciente'     => 'nullable|email|max:100',
            'tipo_sangre'         => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Paciente creado'], 201);
    }

    public function update(Request $req, string $cedula): JsonResponse
    {
        $data = $req->validate([
            'nombres_paciente'    => 'sometimes|string|max:50',
            'apellidos_paciente'  => 'sometimes|string|max:50',
            'edad'                => 'sometimes|integer|min:0|max:120',
            'genero'              => 'sometimes|in:masculino,femenino',
            'telefono_paciente'   => 'sometimes|string|max:50',
            'direccion_paciente'  => 'sometimes|string|max:100',
            'correo_paciente'     => 'sometimes|nullable|email|max:100',
            'tipo_sangre'         => 'sometimes|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $ok = $this->service->update($cedula, $data);
        return $ok
            ? response()->json(['message' => 'Paciente actualizado'])
            : response()->json(['message' => 'Paciente no encontrado'], 404);
    }

    public function destroy(string $cedula): JsonResponse
    {
        $ok = $this->service->delete($cedula);
        return $ok
            ? response()->json(['message' => 'Paciente eliminado'])
            : response()->json(['message' => 'Paciente no encontrado'], 404);
    }
}
