<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\OrdenLaboratorio;
use Illuminate\Database\QueryException;
use App\Models\User;

class OdontologoController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Si tienes la vista SQL v_estado_citas_pacientes:
        $citas = DB::table('v_estado_citas_pacientes')
            ->where('id_usuario', $userId)
            ->limit(5)
            ->get();

        $totalCitas = DB::table('citas')
            ->join('usuarios', 'id_usuario', '=', 'citas.usuario_id')
            ->where('correo_usuario', $userId)
            ->whereDate('fecha_cita', Carbon::today())
            ->count();
        return view('odontologo.odontologo', compact('citas', 'totalCitas'));
    }

    public function showSolicitudForm()
    {
        // Traemos solo las citas del odontólogo autenticado que estén confirmadas
        $citas = Cita::with('paciente')
            ->join('usuarios', 'id_usuario', '=', 'citas.usuario_id')
            ->where('correo_usuario', Auth::id())
            ->where('estado_cita', 'completada')
            ->get();

        return view('odontologo.solicitud', compact('citas'));
    }



    public function storeSolicitud(Request $request)
    {
        // 1) Validamos los campos mínimos
        $data = $request->validate([
            'cita_id' => 'required|exists:citas,id_cita',
            'fecha_limite' => 'required|date|after_or_equal:today',
            'horario' => 'required|in:Mañana,Tarde',
            'tipo_material' => 'required|array|min:1',
            'tipo_material.*' => 'string|max:50',
            'otros_detalles' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'firma' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $material = implode(', ', $data['tipo_material']);

            // justo antes de crear la orden
            $firmaPath = null;
            if ($request->hasFile('firma')) {
                $firmaPath = $request->file('firma')
                    ->store('firmas', 'public');
            }

            // 2) Seleccionamos un laboratorista activo (rol_id = 4)
            $laboratorista = \App\Models\User::where('rol_id', 4)
                ->where('estado_usuario', 'activo')
                ->firstOrFail();

            // 3) Creamos la orden
            OrdenLaboratorio::create([
                'cita_id' => $data['cita_id'],
                'usuario_id' => $laboratorista->id_usuario,
                'fecha_solicitud' => now()->toDateString(),
                'fecha_limite' => $data['fecha_limite'],
                'horario' => $data['horario'],
                'tipo_material' => $material,
                'otros_detalles' => $data['otros_detalles'] ?? null,
                'color' => $data['color'] ?? null,
                'firma' => $firmaPath,
                'estado' => 'pendiente',
            ]);


            // 4) Redirigimos con feedback
            return redirect()
                ->route('odontologo.solicitud.form')
                ->with('success', 'Solicitud enviada correctamente.');
        } catch (QueryException $e) {
            return redirect()
                ->route('odontologo.solicitud.form')
                ->with('error', $e->getMessage());
        }
    }

    public function configuracion(Request $request)
    {
        // Si es POST, guardamos en sesión de Laravel
        if ($request->isMethod('post')) {
            session([
                'odontologo.nombre' => $request->input('nombre'),
                'odontologo.telefono' => $request->input('telefono'),
                'odontologo.email' => $request->input('email'),
            ]);
            return redirect('odontologo');
        }

        // Valores por defecto
        $datos = [
            'nombre' => session('odontologo.nombre', '(Nombre)'),
            'telefono' => session('odontologo.telefono', '+57 34567890'),
            'email' => session('odontologo.email', 'odontologo@dentalflow.com'),
            'especialidad' => 'Sin especialidad',
        ];

        return view('odontologo.configuracion', $datos);
    }

    public function listarPedidos()
    {
        $odontologoId = Auth::id();

        $ordenes = OrdenLaboratorio::with('cita.paciente')
            ->whereHas('cita', fn($q) => $q->where('usuario_id', $odontologoId))
            ->orderByDesc('fecha_solicitud')
            ->paginate(10);


        return view('odontologo.GestionPedidos', compact('ordenes'));
    }


    /** GET /odontologo/pedidos/{id} */
    public function showPedido($id)
    {
        $orden = OrdenLaboratorio::with(['cita.paciente', 'cita.odontologo', 'productos.insumo'])
            ->findOrFail($id);

        // Asegurarnos de que el odontólogo es el propietario
        if ($orden->cita->usuario_id !== Auth::id()) {
            abort(403);
        }

        return view('odontologo.orden_show', compact('orden'));
    }

    /** DELETE /odontologo/pedidos/{id} */
    public function destroyPedido($id)
    {
        $orden = OrdenLaboratorio::findOrFail($id);

        // Sólo permitir “archivar” si está entregada
        if ($orden->estado !== 'entregada' || $orden->cita->usuario_id !== Auth::id()) {
            return back()->with('error', 'No puedes archivar esta orden.');
        }

        $orden->delete();
        return redirect()->route('odontologo.pedidos.index')
            ->with('success', 'Orden archivada correctamente.');
    }

}
