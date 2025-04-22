<?php
namespace App\Services;

use App\Contracts\RecetaMedicaServiceInterface;
use Illuminate\Support\Facades\DB;

class RecetaMedicaService implements RecetaMedicaServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerRecetasMedicas()');
    }

    public function find(int $id): ?object
    {
        return DB::table('recetas_medicas')->where('id_receta', $id)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarRecetaMedica(?, ?, ?, ?, ?)',
            [
                $datos['historia_clinica_id'],
                $datos['tipo_orden'],
                $datos['descripcion_receta'],
                $datos['medicamento_recetado'],
                $datos['fecha_receta'],
            ]
        );
    }

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarRecetaMedica(?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['historia_clinica_id'],
                $datos['tipo_orden'],
                $datos['descripcion_receta'],
                $datos['medicamento_recetado'],
                $datos['fecha_receta'],
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarRecetaMedica(?)', [$id]);
    }
}
