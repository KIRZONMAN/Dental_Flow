<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes',function (Blueprint $table){
            $table->string('cedula',20)->unique();
            $table->string('nombres_paciente',50);
            $table->string('apellidos_paciente',50);
            $table->tinyInteger('edad')->unsigned();
            $table->enum('genero', ['masculino', 'femenino']);
            $table->string('telefono_paciente',50);
            $table->string('direccion_paciente',50);
            $table->string('correo_paciente',50);
            $table->enum('tipo_sangre', ['A+', 'A-','B+','B-','AB+','AB-','O+','O-']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
