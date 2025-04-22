<?php
namespace App\Services;

use App\Contracts\ProcedimientoServiceInterface;
use Illuminate\Support\Facades\DB;

class ProcedimientoService implements ProcedimientoServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerProcedimientos()');
    }

    public function find(int $id): ?object
    {
        return DB::table('procedimientos')->where('id_procedimiento', $id)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarProcedimiento(?, ?)',
            [
                $datos['tipo_procedimiento'],
                $datos['costo'],
            ]
        );
    }

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarProcedimiento(?, ?, ?)',
            [
                $id,
                $datos['tipo_procedimiento'],
                $datos['costo'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarProcedimiento(?)', [$id]);
    }
}
