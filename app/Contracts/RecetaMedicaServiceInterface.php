<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface RecetaMedicaServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarRecetaMedica(?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['historia_clinica_id']   ?? null,
                $datos['tipo_orden']            ?? null,
                $datos['descripcion_receta']    ?? null,
                $datos['medicamento_recetado']  ?? null,
                $datos['fecha_receta']          ?? null,
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarRecetaMedica(?)', [$id]);
    }
}
