<?php
namespace App\Services;

use App\Contracts\UsuarioServiceInterface;
use Illuminate\Support\Facades\DB;

class UsuarioService implements UsuarioServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerUsuarios()');
    }

    public function find(int $id): ?object
    {
        return DB::table('usuarios')->where('id_usuario', $id)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $datos['nombres_usuario'],
                $datos['apellidos_usuario'],
                $datos['correo_usuario'],
                $datos['contrasena_usuario'],
                $datos['telefono_usuario'],
                $datos['direccion_usuario'],
                $datos['estado_usuario'],
                $datos['especialidad_usuario'],
                $datos['rol_id']
            ]
        );
    }

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['nombres_usuario']      ?? null,
                $datos['apellidos_usuario']    ?? null,
                $datos['correo_usuario']       ?? null,
                $datos['telefono_usuario']     ?? null,
                $datos['direccion_usuario']    ?? null,
                $datos['estado_usuario']       ?? null,
                $datos['especialidad_usuario'] ?? null,
                $datos['rol_id']               ?? null,
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarUsuario(?)', [$id]);
    }
}
