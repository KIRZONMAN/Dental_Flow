<?php
namespace App\Services;

use App\Contracts\HistoriaClinicaServiceInterface;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaService implements HistoriaClinicaServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerHistoriaClinica()');
    }

    public function find(int $id): ?object
    {
        return DB::table('historias_clinicas')
            ->where('id_historia_clinica', $id)
            ->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_RegistrarHistoriaClinica(?, ?, ?)',
            [
                $datos['paciente_id'],
                $datos['antecedentes_medicos'],
                $datos['tratamiento_realizados'],
            ]
        );
    }

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarHistoriaClinica(?, ?, ?)',
            [
                $id,
                $datos['antecedentes_medicos'],
                $datos['tratamiento_realizados'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarHistoriaClinica(?)', [$id]);
    }
}
