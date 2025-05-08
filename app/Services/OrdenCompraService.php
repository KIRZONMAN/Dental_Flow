<?php
namespace App\Services;

use App\Contracts\OrdenCompraServiceInterface;
use Illuminate\Support\Facades\DB;

class OrdenCompraService implements OrdenCompraServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerOrdenesCompras()');
    }

    public function find(int $id): ?object
    {
        return DB::table('ordenes_compras')->where('id_orden_compra', $id)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarOrdenCompra(?, ?, ?, ?)',
            [
                $datos['fecha_expedicion'],
                $datos['fecha_vencimiento'],
                $datos['usuario_id'],
                $datos['estado']
            ]
        );
    }

    public function update(int $id, array $datos): void
    {
        DB::statement(
            'CALL pa_ActualizarOrdenCompra(?, ?, ?, ?, ?)',
            [
                $id,
                $datos['fecha_expedicion'],
                $datos['fecha_vencimiento'],
                $datos['usuario_id'],
                $datos['estado']
            ]
        );
    }

    public function delete(int $id): void
    {
        DB::statement('CALL pa_EliminarOrdenCompra(?)', [$id]);
    }
}
