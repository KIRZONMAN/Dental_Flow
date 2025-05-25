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
            $table->timestamp('entregada_at')->nullable()->after('estado');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes_compras', function (Blueprint $table) {
            $table->dropColumn('entregada_at');
        });
    }

};
