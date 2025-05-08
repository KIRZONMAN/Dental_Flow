<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ordenes_laboratorio', function (Blueprint $table) {
            $table->increments('id_orden_lab');
            $table->unsignedInteger('cita_id');
            $table->unsignedInteger('usuario_id');
            $table->date('fecha_solicitud');
            $table->date('fecha_limite');
            $table->enum('horario', ['Mañana', 'Tarde']);
            $table->string('tipo_material', 50);
            $table->text('otros_detalles')->nullable();
            $table->enum('estado', ['pendiente', 'en producción', 'listo para enviar', 'entregada', 'rechazada'])
                ->default('pendiente');
            $table->timestamps();

            // Si quieres claves foráneas:
            $table->foreign('cita_id')->references('id_cita')->on('citas');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_laboratorio');
    }
};
