<?php
namespace App\Services;

use App\Contracts\InsumoServiceInterface;
use Illuminate\Support\Facades\DB;

class InsumoService implements InsumoServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerInsumos()');
    }

    public function find(int $id): ?object
    {
        return DB::table('insumos')->where('id_insumo', $id)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarInsumo(?, ?, ?, ?, ?)',
            [
                $datos['nombre_insumo'],
                $datos['cantidad_insumo'],
                $datos['costo_insumo'],
                $datos['fecha_vencimiento'],
                $datos['umbral_alerta']
            ]
        );
    }

    public function update(int $id, array $datos): void
    {
        DB::statement(
            'CALL pa_ActualizarInsumo(?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['nombre_insumo'],
                $datos['cantidad_insumo'],
                $datos['costo_insumo'],
                $datos['fecha_vencimiento'],
                $datos['umbral_alerta']
            ]
        );
    }

    public function delete(int $id): void
    {
        DB::statement('CALL pa_EliminarInsumo(?)', [$id]);
    }
}
