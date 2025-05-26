<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CitasController extends Controller
{
    public function index()
    {
        $citas = Cita::all();
        return view('citas.index', compact('citas'));
    }

    public function indexAgendaBusqueda(Request $request)
    {
        $q = $request->input('buscar_paciente');

        $query = DB::table('pacientes')
            ->select(
                'cedula',
                DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente) AS nombre_completo_paciente"),
                'telefono_paciente'
            );

        if ($q) {
            $query->whereRaw("CONCAT(nombres_paciente,' ',apellidos_paciente) LIKE ?", ["%{$q}%"])
                ->orWhere('cedula', 'like', "%{$q}%");
        }

        $pacientes = $query->limit(10)->get();

        return view('odontologo.agenda', compact('pacientes'));
    }

        public function indexHistorias(string $cedula)
    {
        $pacientes = DB::table('pacientes')
            ->select(
                'cedula',
                DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente) AS nombre_completo_paciente"),
                'telefono_paciente'
            )
            ->where('cedula', $cedula)
            ->get();


        return view('odontologo.historias_pacientes', compact('pacientes'));
    }

        public function indexCitas()
    {
        $citas = DB::table('citas')->join('usuarios', 'citas.usuario_id', '=', 'usuarios.id_usuario')
            ->where('usuarios.rol_id', 2)
            ->select(
                'citas.*',
                DB::raw("CONCAT(usuarios.nombres_usuario, ' ', usuarios.apellidos_usuario) AS nombre_completo_odontologo")
            )
            ->limit(15)->get(); //Limite de 5 citas por página
        $usuarios = DB::table('usuarios')->where('rol_id', 2)->
            select(
                'id_usuario',
                DB::raw("CONCAT(nombres_usuario, ' ', apellidos_usuario) AS nombre_completo_odontologo")
            )
            ->get();
        return view('asistente.citas', compact('citas', 'usuarios'));
    }

        public function edit($id)
    {
        $cita = DB::table('citas')->where('id_cita', $id)->first();
        $usuarios = DB::table('usuarios')
            ->select('id_usuario', DB::raw("CONCAT(nombres_usuario, ' ', apellidos_usuario) AS nombre_completo_odontologo"))
            ->where('rol_id', 2)
            ->get();

        return view('Asistente.Citas_edit', compact('cita', 'usuarios'));
    }

        public function indexAhistorialPacientes()
    {
        $pacientes = DB::table('pacientes')
            ->select(
                '*',
                DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente) AS nombre_completo_paciente")
            )
            ->limit(10)
            ->get();

        return view('asistente.ahistorial', compact('pacientes'));
    }


}
