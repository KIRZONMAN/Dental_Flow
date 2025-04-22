<?php
namespace App\Services;

use App\Contracts\CitaServiceInterface;
use Illuminate\Support\Facades\DB;

class CitaService implements CitaServiceInterface
{
    public function allHoy(string $fecha): array
    {
        return DB::select('CALL pa_ObtenerCitasHoy(?)', [$fecha]);
    }

    public function find(int $id): ?object
    {
        $rows = DB::select('CALL pa_ObtenerCita(?)', [$id]);
        return $rows[0] ?? null;
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarCita(?, ?, ?, ?, ?, ?, ?)',
            [
                $datos['fecha_cita'],
                $datos['hora_cita'],
                $datos['estado_cita'],
                $datos['motivo_cita'],
                $datos['total_cita'],
                $datos['paciente_id'],
                $datos['usuario_id'],
            ]
        );
    }

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarCita(?, ?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['fecha_cita'],
                $datos['hora_cita'],
                $datos['estado_cita'],
                $datos['motivo_cita'],
                $datos['total_cita'],
                $datos['usuario_id'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarCita(?)', [$id]);
    }
}
