<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ordenes_laboratorio', function (Blueprint $table) {
            // Cambiamos fecha_limite para que acepte NULL
            $table->date('fecha_limite')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ordenes_laboratorio', function (Blueprint $table) {
            // Revertimos a NOT NULL
            $table->date('fecha_limite')->nullable(false)->change();
        });
    }
};
