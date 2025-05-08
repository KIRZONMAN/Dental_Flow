<?php
namespace App\Services;

use App\Contracts\ProveedorServiceInterface;
use Illuminate\Support\Facades\DB;

class ProveedorService implements ProveedorServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerProveedores()');
    }

    public function find(string $nit): ?object
    {
        return DB::table('proveedores')->where('nit', $nit)->first();
    }

    public function create(array $datos): void
    {
        DB::statement(
            'CALL pa_InsertarProveedor(?, ?, ?, ?)',
            [
                $datos['nit'],
                $datos['nombre_proveedor'],
                $datos['telefono_proveedor'],
                $datos['correo_proveedor']
            ]
        );
    }

    public function update(string $nit, array $datos): void
    {
        DB::statement(
            'CALL pa_ActualizarProveedor(?, ?, ?, ?)',
            [
                $nit,
                $datos['nombre_proveedor'],
                $datos['telefono_proveedor'],
                $datos['correo_proveedor']
            ]
        );
    }

    public function delete(string $nit): void
    {
        DB::statement('CALL pa_EliminarProveedor(?)', [$nit]);
    }
}
