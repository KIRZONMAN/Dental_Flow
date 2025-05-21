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
        DB::unprepared(file_get_contents(database_path('triggers/citas_triggers.sql')));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Usa un bloque SQL que incluya todos los DROP TRIGGER
        $sql = <<<'SQL'
DROP TRIGGER IF EXISTS tg_bi_citas_slotvalid;
DROP TRIGGER IF EXISTS tg_ai_citas_create_ordenlab;
DROP TRIGGER IF EXISTS tg_ai_citas_notification;
DROP TRIGGER IF EXISTS tg_bu_citas_totalcalc;
DROP TRIGGER IF EXISTS tg_bd_citas_softdel;
DROP TRIGGER IF EXISTS tg_ad_citas_cleanup;
DROP TRIGGER IF EXISTS tg_ai_proc_cita_total;
DROP TRIGGER IF EXISTS tg_ad_proc_cita_remove;
DROP TRIGGER IF EXISTS tg_au_proc_cita_update;
DROP TRIGGER IF EXISTS tg_bd_roles_protect;
DROP TRIGGER IF EXISTS tg_bi_users_emailuniq;
DROP TRIGGER IF EXISTS tg_bu_users_hashpwd;
DROP TRIGGER IF EXISTS tg_bu_users_softdel;
DROP TRIGGER IF EXISTS tg_ad_users_cascade;
DROP TRIGGER IF EXISTS tg_au_users_lock;
DROP TRIGGER IF EXISTS tg_bi_pacientes_validate;
DROP TRIGGER IF EXISTS tg_ai_pacientes_hist;
DROP TRIGGER IF EXISTS tg_bd_pacientes_protect;
DROP TRIGGER IF EXISTS tg_bd_historia_protect;
DROP TRIGGER IF EXISTS tg_ai_proc_costvalidate;
DROP TRIGGER IF EXISTS tg_bd_proc_protect;
DROP TRIGGER IF EXISTS tg_bi_receta_datechk;
DROP TRIGGER IF EXISTS tg_bd_receta_protect;
SQL;
        DB::unprepared($sql);
    }
};

