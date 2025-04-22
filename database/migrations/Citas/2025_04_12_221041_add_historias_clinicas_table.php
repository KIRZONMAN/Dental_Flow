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
        Schema::create('historias_clinicas',function (Blueprint $table){
            $table->id('id_historia');
            $table->string('antecedentes_medicos',50);
            $table->string('tratamientos_realizados',50);
            $table->string('paciente_id');
            $table->foreign('paciente_id')->references('cedula')->on('pacientes');
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
