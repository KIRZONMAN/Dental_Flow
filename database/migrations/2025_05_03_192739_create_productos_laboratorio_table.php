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
        Schema::create('productos_laboratorio', function (Blueprint $table) {
            $table->increments('id_producto_lab');
            $table->unsignedInteger('orden_id');
            $table->unsignedInteger('insumo_id');
            $table->integer('cantidad');
            $table->text('detalles')->nullable();
            $table->timestamps();

            $table->foreign('orden_id')->references('id_orden_lab')->on('ordenes_laboratorio');
            $table->foreign('insumo_id')->references('id_insumo')->on('insumos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_laboratorio');
    }
};
