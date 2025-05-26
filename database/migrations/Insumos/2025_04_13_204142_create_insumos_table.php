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
        Schema::create('insumos', function (Blueprint $table) {
            $table->id('id_insumo');
            $table->string('nombre_insumo',50);
            $table->unsignedInteger('cantidad_insumo');
            $table->decimal('costo_insumo',10,2);
            $table->date('fecha_vencimiento')->nullable();
            $table->unsignedInteger('umbral_alerta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
