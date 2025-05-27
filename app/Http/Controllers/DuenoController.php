<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DuenoController extends Controller
{
    public function indexDueno(Request $request)
    {
        $fechaLimite = date('Y-m-d H:i:s', strtotime('-30 days'));
        $gastos = DB::table('detalles_ordenes')
            ->join('ordenes_compras', 'detalles_ordenes.orden_id', '=', 'ordenes_compras.id_orden_compra')
            ->select('detalles_ordenes.*', 'ordenes_compras.estado')
            ->where('ordenes_compras.estado', '=', 'aprobado')
            ->where('ordenes_compras.fecha_expedicion', '>=', $fechaLimite)
            ->sum('total');

        $ingresos = DB::table('citas')
            ->where('estado_cita', 'completada')
            ->where('fecha_cita', '>=', $fechaLimite)
            ->sum('total_cita');
        return view('dueno.dueno', compact('gastos', 'ingresos'));
    }

    public function editConfiguracion(Request $request)
    {
        $datos = [
            'nombre' => session('dueno.nombre', '(Nombre)'),
            'telefono' => session('dueno.telefono', '+57 34567890'),
            'email' => session('dueno.email', 'gerencia@dentalflow.com'),
            'especialidad' => 'Dueño',
        ];

        return view('dueno.dueno-configuracion', $datos);
    }

    public function updateConfiguracion(Request $request)
    {
        session([
            'dueno.nombre' => $request->input('nombre'),
            'dueno.telefono' => $request->input('telefono'),
            'dueno.email' => $request->input('email'),
        ]);
        return redirect('dueno');
    }
}
