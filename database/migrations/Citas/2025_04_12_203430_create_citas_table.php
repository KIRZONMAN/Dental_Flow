<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id_cita');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->enum('estado_cita', ['pendiente', 'confirmada', 'cancelada', 'completada'])
                  ->default('pendiente');
            $table->string('motivo_cita', 255);
            $table->decimal('total_cita', 10, 2)->default(0);
            $table->string('paciente_id', 20);
            $table->unsignedInteger('usuario_id'); // aquí va tu odontólogo
            $table->timestamps();

            $table->foreign('paciente_id')
                  ->references('cedula')->on('pacientes')
                  ->onDelete('cascade');
            $table->foreign('usuario_id')
                  ->references('id_usuario')->on('usuarios')
                  ->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
