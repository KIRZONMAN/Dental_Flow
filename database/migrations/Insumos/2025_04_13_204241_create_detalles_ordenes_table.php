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
        Schema::create('detalles_ordenes', function (Blueprint $table) {
            $table->id('id_detalle_orden');
            $table->unsignedInteger('cantidad_insumo');
            $table->decimal('total',10,2);
            $table->unsignedInteger('orden_id');
            $table->unsignedInteger('insumo_id');
            $table->timestamps();

            //Claves Foraneas
            $table->foreign('orden_id')->references('id_orden_compra')->on('ordenes_compras')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id_insumo')->on('insumos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_ordenes');
    }
};
