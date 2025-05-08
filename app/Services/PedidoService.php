<?php
namespace App\Services;

use App\Contracts\PedidoServiceInterface;
use Illuminate\Support\Facades\DB;

class PedidoService implements PedidoServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerPedidos()');
    }

    public function find(int $id): ?object
    {
        return DB::table('pedidos')->where('id_pedido', $id)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarPedido(?, ?, ?, ?)',
            [
                $datos['descripcion'],
                $datos['fecha'],
                $datos['estado'],
                $datos['id_proveedor']
            ]
        );
    }

    public function update(int $id, array $datos): void
    {
        DB::statement(
            'CALL pa_ActualizarPedido(?, ?, ?, ?, ?)',
            [
                $id,
                $datos['descripcion'],
                $datos['fecha'],
                $datos['estado'],
                $datos['id_proveedor']
            ]
        );
    }

    public function delete(int $id): void
    {
        DB::statement('CALL pa_EliminarPedido(?)', [$id]);
    }
}
