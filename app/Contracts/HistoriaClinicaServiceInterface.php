<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface HistoriaClinicaServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

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
