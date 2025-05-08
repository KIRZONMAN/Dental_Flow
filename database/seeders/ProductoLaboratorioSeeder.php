<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductoLaboratorioSeeder extends Seeder
{
    public function run()
    {
        // Aquí defines manualmente alguna relación producto–orden de prueba
        DB::table('productos_laboratorio')->insert([
            [
              'orden_id'   => 1,
              'insumo_id'  => 1,
              'cantidad'   => 5,
              'detalles'   => 'Guantes quirúrgicos usados para prueba',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            // … más filas si quieres
        ]);
    }
}
