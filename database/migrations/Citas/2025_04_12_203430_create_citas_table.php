<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('odontologo_id');
            $table->dateTime('fecha');
            $table->string('servicio');
            $table->timestamps();

            // Puedes comentar estas claves si las tablas aún no existen
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('odontologo_id')->references('id')->on('odontologos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
