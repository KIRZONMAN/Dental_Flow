<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Paciente;
use Barryvdh\DomPDF\Facade\Pdf;


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

    public function descargarPDF(string $cedula)
    {
        $paciente = Paciente::findOrFail($cedula);
        // Aquí indicamos la carpeta 'Asistente':
        $pdf = Pdf::loadView('Asistente.pdf_historia', compact('paciente'));
        return $pdf->download("historia_{$cedula}.pdf");
    }

    public function configuracion2(Request $request)
    {
        // Si es POST, guardamos en sesión de Laravel
        if ($request->isMethod('post')) {
            session([
                'asistente.nombre' => $request->input('nombre'),
                'asistente.telefono' => $request->input('telefono'),
                'asistente.email' => $request->input('email'),
            ]);
            return redirect()->route('asistente');
        }

        // Valores por defecto
        $datos = [
            'nombre' => session('asistente.nombre', '(Nombre)'),
            'telefono' => session('asistente.telefono', '+12 34567890'),
            'email' => session('asistente.email', 'asistente@dentalflow.com'),
            'especialidad' => 'Asistente',
        ];

        return view('asistente.configuracion2', $datos);
    }


}
