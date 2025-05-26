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
        Schema::create('proveedores_insumos', function (Blueprint $table) {
            $table->id('id_proveedor_insumo');
            $table->string('proveedor_id',20);
            $table->unsignedBigInteger('insumo_id');
            $table->timestamps();

            //Claves Foraneas
            $table->foreign('proveedor_id')->references('nit')->on('proveedores')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id_insumo')->on('insumos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores_insumos');
    }
};
