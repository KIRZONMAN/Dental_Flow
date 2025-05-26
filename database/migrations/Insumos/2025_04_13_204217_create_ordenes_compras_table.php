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
        Schema::create('ordenes_compras', function (Blueprint $table) {
            $table->id('id_orden_compra');
            $table->date('fecha_expedicion');
            $table->date('fecha_vencimiento');
            $table->unsignedInteger('usuario_id');
            $table->enum('estado', ['ordenado', 'aprobado', 'rechazado','en produccion','listo para entregar','entregado'])->default('ordenado');
            $table->timestamps();

            //Claves Foraneas
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_compras');
    }
};
