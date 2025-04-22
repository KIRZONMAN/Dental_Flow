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
        Schema::create('recetas_medicas',function (Blueprint $table){
            $table->id('id_receta');
            $table->unsignedBigInteger('historia_id');
            $table->string('tipo_orden', 50);
            $table->string('descripcion_receta');
            $table->string('medicamento_recetado');
            $table->date('fecha');
            $table->foreign('historia_id')->references('id_historia')->on('historias_clinicas');
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
