<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CitasControllerApi extends Controller
{
    public function index()
    {
        $citas = DB::table('v_estado_citas_pacientes')->where('id_usuario', 2)->limit(5)->get(); /*2 Se puede cambiar por ID DINAMICO */
        return view('odontologo.odontologo', compact('citas'));
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

    public function indexAgendaBusqueda()
    {
        $pacientes = DB::table('pacientes')->
            select(
                'cedula',
                DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente) AS nombre_completo_paciente"),
                'telefono_paciente'
            )
            ->limit(10)->get();
        return view('odontologo.agenda', compact('pacientes'));
    }

    public function indexHistorias()
    {
        $pacientes = DB::table('pacientes')->
            select(
                'cedula',
                DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente) AS nombre_completo_paciente"),
                'telefono_paciente'
            )
            ->limit(10)->where('cedula', '1020304050')->get();
        return view('odontologo.historias', compact('pacientes'));
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

    public function indexAregistro()
    {
        return view('asistente.aregistro');
    }

    public function storePaciente(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|max:20|unique:pacientes,cedula',
            ]);

            //dd('Pasa validación de cedula');

            $request->validate([
                'nombres_paciente' => 'required|string|max:50',
            ]);

            //dd('Pasa validación de nombres_paciente');

            // Validación de 'apellidos_paciente'
            $request->validate([
                'apellidos_paciente' => 'required|string|max:50',
            ]);

            //dd('Pasa validación de apellidos_paciente');

            // Validación de 'edad'
            $request->validate([
                'edad' => 'required|numeric|max:100',
            ]);

            //dd('Pasa validación de edad');

            // Validación de 'genero'
            $request->validate([
                'genero' => 'required|in:masculino,femenino',
            ]);

            //dd('Pasa validación de genero');

            // Validación de 'telefono_paciente'
            $request->validate([
                'telefono_paciente' => 'required|string|max:50',
            ]);

            //dd('Pasa validación de telefono_paciente');

            // Validación de 'direccion'
            $request->validate([
                'direccion' => 'required|string|max:100',
            ]);

            //dd('Pasa validación de direccion');

            // Validación de 'correo_paciente'
            $request->validate([
                'correo_paciente' => 'required|string|max:100',
            ]);

            //dd('Pasa validación de correo_paciente');

            // Validación de 'tipo_sangre'
            $request->validate([
                'tipo_sangre' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            ]);

            //dd('Pasa validación de tipo_sangre');


            DB::table('pacientes')->insert([
                'cedula' => $request->input('cedula'),
                'nombres_paciente' => $request->input('nombres_paciente'),
                'apellidos_paciente' => $request->input('apellidos_paciente'),
                'edad' => $request->input('edad'),
                'genero' => $request->input('genero'),
                'telefono_paciente' => $request->input('telefono_paciente'),
                'direccion_paciente' => $request->input('direccion'),
                'correo_paciente' => $request->input('correo_paciente'),
                'tipo_sangre' => $request->input('tipo_sangre'),
            ]);
            return redirect()->back()->with('success', 'Paciente registrado correctamente 😀');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al registrar, recuerda que la cédula no se puede repetir');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date_format:Y-m-d',
            'hora' => 'required|date_format:H:i',
            'estado' => 'required|in:pendiente,cancelada,confirmada,completada',
            'motivo' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'cedula' => 'required|string|max:20',
            'odontologo' => 'required|integer|max:99999999999'

        ]);

        DB::table('citas')->insert([
            'fecha_cita' => $request->input('fecha'),
            'hora_cita' => $request->input('hora'),
            'motivo_cita' => $request->input('motivo'),
            'total_cita' => $request->input('total'),
            'paciente_id' => $request->input('cedula'),
            'estado_cita' => $request->input('estado'),
            'usuario_id' => $request->input('odontologo'),
        ]);

        return response()->json(['message' => 'Cita registrada correctamente'], 201);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'fecha' => 'sometimes|date',
            'hora' => 'sometimes|date_format:H:i',
            'estado' => 'sometimes|in:pendiente,cancelada,confirmada,completada',
            'motivo' => 'sometimes|string|max:255',
            'total' => 'sometimes|numeric|min:0',
            'odontologo' => 'sometimes|integer',
        ]);

        // 2) Trae la cita “vieja”
        $old = DB::table('citas')->where('id_cita', $id)->first();

        // 3) Para cada parámetro, usa el nuevo si llega, o el viejo si no:
        $fecha = $request->input('fecha', $old->fecha_cita);
        $hora = $request->input('hora', $old->hora_cita);
        $estado = $request->input('estado', $old->estado_cita);
        $motivo = $request->input('motivo', $old->motivo_cita);
        $total = $request->input('total', $old->total_cita);
        $odontologo = $request->input('odontologo', $old->usuario_id);

        // 4) Llama al SP con todos los valores definitivos
        DB::statement('CALL pa_ActualizarCita(?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $fecha,
            $hora,
            $estado,
            $motivo,
            $total,
            $odontologo
        ]);

        return redirect()->back()->with('success', 'Cita actualizada correctamente 😀');
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

    public function show($input)
    {
        // Buscar paciente por cédula o nombre completo
        $paciente = DB::table('pacientes')
            ->select(
                '*',
                DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente) AS nombre_completo_paciente") // Concatenación de nombre y apellido
            )
            ->where('cedula', 'like', "%$input%")
            ->orWhere(DB::raw("CONCAT(nombres_paciente, ' ', apellidos_paciente)"), 'like', "%$input%")
            ->first();

        // Si no se encuentra al paciente, devolver un mensaje de error
        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        // Si se encuentra al paciente, devolver los datos en formato JSON
        return response()->json([
            'paciente' => $paciente
        ]);
    }


    public function delete($id)
    {

        $cita = DB::table('citas')->where('id_cita', $id)->first();

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $deleted = DB::table('citas')->where('id_cita', $id)->delete();

        if ($deleted) {
            $citas = DB::table('citas')->join('usuarios', 'citas.usuario_id', '=', 'usuarios.id_usuario')
                ->select(
                    'citas.*',
                    DB::raw("CONCAT(usuarios.nombres_usuario, ' ', usuarios.apellidos_usuario) AS nombre_completo_odontologo")
                )->where('usuarios.rol_id', 2)
                ->limit(5)->get();
            $usuarios = DB::table('usuarios')->where('rol_id', 2)->
                select(
                    'id_usuario',
                    DB::raw("CONCAT(nombres_usuario, ' ', apellidos_usuario) AS nombre_completo_odontologo")
                )
                ->limit(5)->get();
            return view('asistente.citas', compact('citas', 'usuarios'))->with('success', 'Cita eliminada');
        } else {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

    }

}
