<?php
namespace App\Services;

use App\Contracts\RolServiceInterface;
use Illuminate\Support\Facades\DB;

class RolService implements RolServiceInterface
{
    public function all(): array
    {
        return DB::select('CALL pa_ObtenerRoles()');
    }

    public function find(int $id): ?object
    {
        return DB::table('roles')->where('id_rol', $id)->first();
    }
}
