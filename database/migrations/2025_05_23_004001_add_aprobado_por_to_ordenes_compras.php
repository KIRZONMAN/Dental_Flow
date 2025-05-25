<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ordenes_compras', function (Blueprint $table) {
            // que sea entero SIGNED, para que coincida con usuarios.id_usuario
            $table->integer('aprobado_por')->nullable()->after('usuario_id');

            $table->foreign('aprobado_por')
                ->references('id_usuario')->on('usuarios')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ordenes_compras', function (Blueprint $table) {
            // nombre exacto como lo ves en SHOW CREATE TABLE
            $table->dropForeign('fk_ordenes_compras_aprobador');
            $table->dropColumn('aprobado_por');
        });
    }
};
