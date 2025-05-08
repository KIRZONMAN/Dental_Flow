<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LabPedidosSeeder extends Seeder
{
    public function run()
    {
        $hoy    = Carbon::today();
        $semana = $hoy->copy()->addWeek();
        $dia13  = $hoy->copy()->addDays(13);
        $dia14  = $hoy->copy()->addDays(14);

        // 1) Inserta cada orden y captura su ID
        $orden1 = DB::table('ordenes_laboratorio')->insertGetId([
            'cita_id'        => 1,
            'usuario_id'     => 8,
            'fecha_solicitud'=> $hoy->toDateString(),
            'fecha_limite'   => $semana->toDateString(),
            'horario'        => 'Mañana',
            'tipo_material'  => 'Zirconio',
            'otros_detalles' => 'Coronas superiores',
            'estado'         => 'pendiente',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        $orden2 = DB::table('ordenes_laboratorio')->insertGetId([
            'cita_id'        => 2,
            'usuario_id'     => 8,
            'fecha_solicitud'=> $hoy->toDateString(),
            'fecha_limite'   => $semana->toDateString(),
            'horario'        => 'Tarde',
            'tipo_material'  => 'Resina',
            'otros_detalles' => 'Incrustación',
            'estado'         => 'en producción',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        $orden3 = DB::table('ordenes_laboratorio')->insertGetId([
            'cita_id'        => 3,
            'usuario_id'     => 8,
            'fecha_solicitud'=> $dia13->toDateString(),
            'fecha_limite'   => $dia13->copy()->addWeek()->toDateString(),
            'horario'        => 'Mañana',
            'tipo_material'  => 'Metal',
            'otros_detalles' => 'Puente',
            'estado'         => 'listo para enviar',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        $orden4 = DB::table('ordenes_laboratorio')->insertGetId([
            'cita_id'        => 4,
            'usuario_id'     => 8,
            'fecha_solicitud'=> $dia14->toDateString(),
            'fecha_limite'   => $dia14->copy()->addWeek()->toDateString(),
            'horario'        => 'Tarde',
            'tipo_material'  => 'Cerámica',
            'otros_detalles' => 'Corona',
            'estado'         => 'entregada',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // 2) Ahora inserta los productos relacionados
        DB::table('productos_laboratorio')->insert([
            [
              'orden_id'   => $orden1,
              'insumo_id'  => 1,
              'cantidad'   => 5,
              'detalles'   => 'Guantes quirúrgicos usados para prueba',
              'created_at' => now(),
              'updated_at' => now(),
            ],
            // si quieres más productos, añádelos aquí usando $orden2, $orden3, etc.
        ]);
    }
}
