<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolLaboratoristaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('roles')->updateOrInsert(
            ['id_rol' => 4],
            ['nombre_rol' => 'Laboratorista', 'descripcion_rol' => 'Gestiona órdenes de laboratorio']
        );

        \DB::table('usuarios')->updateOrInsert(
            ['correo_usuario' => 'juan.laboratorista@example.com'],
            [
                'nombres_usuario' => 'Juan Armando',
                'apellidos_usuario' => 'Gomez Galindez',
                'contrasena_usuario' => bcrypt('secret123'),
                'telefono_usuario' => '3001234567',
                'direccion_usuario' => 'Calle Falsa 123',
                'estado_usuario' => 'activo',
                'especialidad_usuario' => null,
                'rol_id' => 4
            ]
        );
    }

}
