<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Contracts\CitaServiceInterface;

class CitasControllerApi extends Controller
{
    private CitaServiceInterface $citaService;

    public function __construct(CitaServiceInterface $citaService)
    {
        $this->citaService = $citaService;
    }
    public function index(Request $request)
    {
        // Usamos el SP pa_ObtenerCitas() para traer todas las citas
        $citas = $this->citaService->all();
        return response()->json($citas);
    }

    public function indexHoy(Request $request)
    {
        $hoy = now()->toDateString();
        // 1) obtenemos todas las citas de hoy
        $raw = $this->citaService->allHoy($hoy);

        // 2) filtramos solo las del odontólogo autenticado
        $odontologoId = $request->user()->id_usuario;
        $mias = array_filter($raw, fn($c) => $c->id_odontologo == $odontologoId);

        // 3) dejamos solo los campos que la vista espera
        $payload = array_map(fn($c) => [
            'hora_cita' => $c->hora_cita,
            'nombre_completo_paciente' => $c->nombre_paciente,  // ¡aquí cambiamos el alias!
            'estado_cita' => $c->estado_cita,
        ], $mias);

        return response()->json(array_values($payload));
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

    /**
     * Busca un paciente por cédula exacta o por fragmento de nombre.
     */
    public function buscarPaciente(string $input)
    {
        $paciente = DB::table('pacientes')
            ->select(
                'cedula',
                DB::raw("CONCAT(nombres_paciente,' ',apellidos_paciente) AS nombre_completo_paciente"),
                'edad',
                'telefono_paciente',
                'correo_paciente'
            )
            ->where('cedula', $input)
            ->orWhere(function ($query) use ($input) {
                $query->where('nombres_paciente', 'LIKE', "{$input}%")
                    ->orWhere('apellidos_paciente', 'LIKE', "{$input}%")
                    ->orWhere('cedula', 'LIKE', "{$input}%");
            })
            ->first();

        if (!$paciente) {
            return response()->json(['message' => 'No se encontraron pacientes.'], 404);
        }

        return response()->json(['paciente' => $paciente]);
    }


    public function indexAregistro()
    {
        return view('asistente.aregistro');
    }

    public function storePaciente(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|digits:10|unique:pacientes,cedula',
                'nombres_paciente' => 'required|string|max:50',
                'apellidos_paciente' => 'required|string|max:50',
                'edad' => 'required|integer|min:0|max:120',
                'genero' => 'required|in:masculino,femenino',
                'telefono_paciente' => 'required|string|max:50',
                'direccion' => 'required|string|max:255',
                'correo_paciente' => 'required|string|max:100|unique:pacientes,correo_paciente',
                'tipo_sangre' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            ], [
                'cedula.unique' => 'Esta cédula ya se encuentra registrada',
                'correo_paciente.unique' => 'Este correo ya está en uso por otro paciente.'
            ]);

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
            return response()->json(['mensaje' => 'Paciente registrado correctamente'], 200);
        } catch (QueryException $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
                'motivo' => 'required|string|max:255',
                'total' => 'required|numeric|min:0',
                'cedula' => 'required|string|max:20',
                'odontologo' => 'required|integer',
            ]);

            $this->citaService->create([
                'fecha_cita' => $data['fecha'],
                'hora_cita' => $data['hora'],
                'estado_cita' => $data['estado'],
                'motivo_cita' => $data['motivo'],
                'total_cita' => $data['total'],
                'paciente_id' => $data['cedula'],
                'usuario_id' => $data['odontologo'],
            ]);

            return response()->json(['message' => 'Cita registrada'], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Error al crear la cita',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'fecha' => 'sometimes|date',
            'hora' => 'sometimes|date_format:H:i',
            'estado' => 'sometimes|in:pendiente,confirmada,cancelada,completada',
            'motivo' => 'sometimes|string|max:255',
            'total' => 'sometimes|numeric',
            'odontologo' => 'sometimes|integer',
        ]);

        $this->citaService->update($id, [
            'fecha_cita' => $data['fecha'] ?? null,
            'hora_cita' => $data['hora'] ?? null,
            'estado_cita' => $data['estado'] ?? null,
            'motivo_cita' => $data['motivo'] ?? null,
            'total_cita' => $data['total'] ?? null,
            'usuario_id' => $data['odontologo'] ?? null,
        ]);

        return response()->json(['message' => 'Cita actualizada']);
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

    public function show(int $id)
    {
        $cita = $this->citaService->find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita);
    }


    public function delete(int $id)
    {
        try {
            // Esto lanza excepción si no existe o el SP falla
            $this->citaService->delete($id);
            return response()->json(['message' => 'Cita eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'No se pudo eliminar la cita',
                'error' => $e->getMessage()
            ], 400);
        }
    }

}
