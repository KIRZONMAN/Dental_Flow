<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface OrdenCompraServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarOrdenCompra(?, ?, ?, ?, ?)',
            [
                $id,
                $datos['fecha_expedicion'],
                $datos['fecha_vencimiento'],
                $datos['usuario_id'],
                $datos['estado'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarOrdenCompra(?)', [$id]);
    }
}
