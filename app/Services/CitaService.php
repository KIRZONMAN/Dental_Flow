<?php
namespace App\Services;

use App\Contracts\CitaServiceInterface;
use Illuminate\Support\Facades\DB;

class CitaService implements CitaServiceInterface
{
    /**
     * Devuelve todas las citas del día.
     */
    public function allHoy(string $fecha): array
    {
        // Asume que has creado un SP pa_ObtenerCitasHoy(fecha)
        return DB::select('CALL pa_ObtenerCitasHoy(?)', [$fecha]);
    }

    /**
     * Recupera una sola cita.
     */
    public function find(int $id): ?object
    {
        $rows = DB::select('CALL pa_ObtenerCita(?)', [$id]);
        return $rows[0] ?? null;
    }

    /**
     * Inserta una nueva cita.
     */
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

    /**
     * Actualiza una cita existente.
     */
    public function update(int $id, array $datos): void
    {
        DB::statement(
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

    /**
     * Elimina una cita.
     */
    public function delete(int $id): void
    {
        DB::statement('CALL pa_EliminarCita(?)', [$id]);
    }
}
