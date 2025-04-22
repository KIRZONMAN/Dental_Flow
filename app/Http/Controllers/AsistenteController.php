<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenteController extends Controller
{
    /**
     * Panel principal: muestra las citas del día.
     */
    public function index()
    {
        // 1) Fecha de hoy en formato YYYY-MM-DD
        $hoy = Carbon::today()->toDateString();

        // 2) Traer todas las citas de hoy con paciente y odontólogo
        $citasHoy = DB::table('citas as c')
            ->join('pacientes as p', 'c.paciente_id', '=', 'p.cedula')
            ->join('usuarios  as u', 'c.usuario_id', '=', 'u.id_usuario')
            ->whereDate('c.fecha_cita', $hoy)
            ->select([
                'c.id_cita',
                'c.hora_cita',
                'c.motivo_cita',
                'c.estado_cita',
                DB::raw("CONCAT(p.nombres_paciente,' ',p.apellidos_paciente) AS paciente_nombre"),
                DB::raw("CONCAT(u.nombres_usuario,' ',u.apellidos_usuario)   AS odontologo_nombre"),
            ])
            ->orderBy('c.hora_cita')
            ->get();

        // 3) Renderizar vista con el listado
        return view('asistente.asistente', compact('citasHoy'));
    }
}
