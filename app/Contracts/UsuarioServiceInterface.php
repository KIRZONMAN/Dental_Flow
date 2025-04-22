<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface UsuarioServiceInterface
{
    public function all(): array;
    public function find(int $id): ?object;
    public function create(array $datos): void;

    public function update(int $id, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $id,
                $datos['nombres_usuario']       ?? null,
                $datos['apellidos_usuario']     ?? null,
                $datos['correo_usuario']        ?? null,
                $datos['telefono_usuario']      ?? null,
                $datos['direccion_usuario']     ?? null,
                $datos['estado_usuario']        ?? null,
                $datos['especialidad_usuario']  ?? null,
                $datos['rol_id']                ?? null,
            ]
        );
    }

    public function delete(int $id): bool
    {
        return DB::statement('CALL pa_EliminarUsuario(?)', [$id]);
    }
}
