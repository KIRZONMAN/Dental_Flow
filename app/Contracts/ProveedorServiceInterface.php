<?php
namespace App\Contracts;

use Illuminate\Support\Facades\DB;

interface ProveedorServiceInterface
{
    public function all(): array;
    public function find(string $nit): ?object;
    public function create(array $datos): void;

    public function update(string $nit, array $datos): bool
    {
        return DB::statement(
            'CALL pa_ActualizarProveedor(?, ?, ?, ?)',
            [
                $nit,
                $datos['nombre']   ?? null,
                $datos['telefono'] ?? null,
                $datos['correo']   ?? null,
            ]
        );
    }

    public function delete(string $nit): bool
    {
        return DB::statement('CALL pa_EliminarProveedor(?)', [$nit]);
    }
}
