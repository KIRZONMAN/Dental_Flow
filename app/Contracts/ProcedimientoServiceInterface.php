<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface ProcedimientoServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarProcedimiento(?, ?, ?)',
            [
                $id,
                $datos['tipo_procedimiento'] ?? null,
                $datos['costo']              ?? null,
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarProcedimiento(?)', [$id]);
    }
}
