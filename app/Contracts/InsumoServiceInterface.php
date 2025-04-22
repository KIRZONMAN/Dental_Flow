<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface InsumoServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarInsumo(?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['nombre_insumo'],
                $datos['cantidad_insumo'],
                $datos['costo_insumo'],
                $datos['fecha_vencimiento'],
                $datos['umbral_alerta'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarInsumo(?)', [$id]);
    }
}
