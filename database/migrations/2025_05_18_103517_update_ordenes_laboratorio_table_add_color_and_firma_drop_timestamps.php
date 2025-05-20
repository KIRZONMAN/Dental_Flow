<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdenesLaboratorioTableAddColorAndFirmaDropTimestamps extends Migration
{
    public function up()
    {
        Schema::table('ordenes_laboratorio', function (Blueprint $table) {
            // Añadimos color y firma
            $table->string('color', 50)->nullable()->after('otros_detalles');
            $table->string('firma', 150)->nullable()->after('color');
            // Eliminamos created_at y updated_at
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }

    public function down()
    {
        Schema::table('ordenes_laboratorio', function (Blueprint $table) {
            // Revertimos: volvemos a timestamps, y eliminamos color/firma
            $table->timestamps();
            $table->dropColumn(['color', 'firma']);
        });
    }
}
