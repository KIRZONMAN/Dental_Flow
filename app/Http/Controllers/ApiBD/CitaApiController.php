<?php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\Contracts\CitaServiceInterface;

class CitaApiController extends Controller
{
    public function __construct(private CitaServiceInterface $service) {}

    public function index(): JsonResponse
    {
        $hoy = Carbon::today()->toDateString();
        return response()->json($this->service->allHoy($hoy));
    }

    public function show(int $id): JsonResponse
    {
        $cita = $this->service->find($id);
        return $cita
            ? response()->json($cita)
            : response()->json(['message' => 'Cita no encontrada'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'fecha'       => 'required|date',
            'hora'        => 'required|date_format:H:i',
            'estado'      => 'required|in:pendiente,confirmada,cancelada,completada',
            'motivo'      => 'required|string|max:255',
            'total'       => 'required|numeric|min:0',
            'paciente_id' => 'required|string|max:20',
            'usuario_id'  => 'required|integer',
        ]);

        $this->service->create([
            'fecha_cita'  => $data['fecha'],
            'hora_cita'   => $data['hora'],
            'estado_cita' => $data['estado'],
            'motivo_cita' => $data['motivo'],
            'total_cita'  => $data['total'],
            'paciente_id' => $data['paciente_id'],
            'usuario_id'  => $data['usuario_id'],
        ]);

        return response()->json(['message' => 'Cita creada'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'fecha'       => 'sometimes|date',
            'hora'        => 'sometimes|date_format:H:i',
            'estado'      => 'sometimes|in:pendiente,confirmada,cancelada,completada',
            'motivo'      => 'sometimes|string|max:255',
            'total'       => 'sometimes|numeric|min:0',
            'paciente_id' => 'sometimes|string|max:20',
            'usuario_id'  => 'sometimes|integer',
        ]);

        $ok = $this->service->update($id, [
            'fecha_cita'  => $data['fecha'] ?? null,
            'hora_cita'   => $data['hora'] ?? null,
            'estado_cita' => $data['estado'] ?? null,
            'motivo_cita' => $data['motivo'] ?? null,
            'total_cita'  => $data['total'] ?? null,
            'paciente_id' => $data['paciente_id'] ?? null,
            'usuario_id'  => $data['usuario_id'] ?? null,
        ]);

        return $ok
            ? response()->json(['message' => 'Cita actualizada'])
            : response()->json(['message' => 'Cita no encontrada'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Cita eliminada'])
            : response()->json(['message' => 'Cita no encontrada'], 404);
    }
}
