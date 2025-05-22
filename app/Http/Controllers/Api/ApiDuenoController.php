<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiDuenoController extends Controller
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

    public function indexRendimiento(Request $request)
    {
        $limit = request('limit', 5);
        $page = request('page', 1);
        $rango = $request->query('rango', 'hoy');

        $hoy = now();
        $fechaInicio = match ($rango) {
            'hoy' => $hoy->copy()->startOfDay(),
            'mes' => $hoy->copy()->subDays(29),
            default => $hoy->copy()->subDays(6),
        };
        $fechaFin = $hoy->endOfDay();

        $datos = DB::table('v_citas_detalladas')
            ->whereBetween('fecha_cita', [$fechaInicio->toDateString(), $fechaFin->toDateString()])
            ->orderBy('fecha_cita', 'desc')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json($datos);

    }

    public function indexInsumos()
    {
        $insumos = DB::table('insumos')
            ->leftJoin('detalles_ordenes', 'insumos.id_insumo', '=', 'detalles_ordenes.insumo_id')
            ->leftJoin('ordenes_compras', 'detalles_ordenes.orden_id', '=', 'ordenes_compras.id_orden_compra')
            ->select(
                'insumos.id_insumo',
                'insumos.nombre_insumo',
                'insumos.cantidad_insumo',
                'insumos.umbral_alerta',
                'insumos.costo_insumo',
                DB::raw('IFNULL(SUM(CASE WHEN ordenes_compras.estado NOT IN ("ordenado", "rechazado") THEN detalles_ordenes.cantidad_insumo ELSE 0 END), 0) as cantidad_aprobada')
            )
            ->groupBy('insumos.id_insumo', 'insumos.nombre_insumo', 'insumos.cantidad_insumo', 'insumos.umbral_alerta', 'insumos.costo_insumo')
            ->havingRaw('(insumos.cantidad_insumo + cantidad_aprobada) <= insumos.umbral_alerta')
            ->limit(5)
            ->get();
        return response()->json([
            'insumos' => $insumos,
        ]);
    }


    public function indexInformeClinica()
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
        $completadas = DB::table('citas')->where('estado_cita', 'completada')
            ->count('id_cita');
        $canceladas = DB::table('citas')->where('estado_cita', 'cancelada')
            ->count('id_cita');
        $total_insumos = DB::table('insumos')->count('id_insumo');
        $en_riesgo = DB::table('insumos')
            ->leftJoin('detalles_ordenes', 'insumos.id_insumo', '=', 'detalles_ordenes.insumo_id')
            ->leftJoin('ordenes_compras', 'detalles_ordenes.orden_id', '=', 'ordenes_compras.id_orden_compra')
            ->select(
                'insumos.id_insumo',
                'insumos.umbral_alerta',
                'insumos.cantidad_insumo',
                DB::raw('IFNULL(SUM(CASE WHEN ordenes_compras.estado = "aprobado" THEN detalles_ordenes.cantidad_insumo ELSE 0 END), 0) as cantidad_aprobada')
            )
            ->groupBy('insumos.id_insumo', 'insumos.umbral_alerta', 'insumos.cantidad_insumo')
            ->havingRaw('(insumos.cantidad_insumo + cantidad_aprobada) <= insumos.umbral_alerta')
            ->count();

        $conteo_procedimientos_odontologo = DB::table('v_procedimientos_por_odontologo')->get();

        $citas = DB::table('citas')
            ->select(
                'citas.*',
                DB::raw("fecha_cita AS fecha")
            )
            ->get()
            ->map(function ($item) {
                return (object) [
                    'fecha' => $item->fecha,
                    'descripcion' => $item->motivo_cita,
                    'total' => $item->total_cita,
                    'tipo' => 'Ingreso'
                ];
            });

        $detalles_ordenes = DB::table('detalles_ordenes')->join
        ('ordenes_compras', 'detalles_ordenes.orden_id', '=', 'ordenes_compras.id_orden_compra')
            ->join('insumos', 'detalles_ordenes.insumo_id', '=', 'insumos.id_insumo')
            ->select(
                'detalles_ordenes.*',
                DB::raw("ordenes_compras.fecha_expedicion AS fecha"),
                'insumos.nombre_insumo'
            )
            ->get()
            ->map(function ($item) {
                return (object) [
                    'fecha' => $item->fecha,
                    'descripcion' => $item->nombre_insumo,
                    'total' => $item->total,
                    'tipo' => 'Egreso'
                ];
            });

        return view('dueno.informe-clinica', compact(
            'gastos',
            'ingresos',
            'completadas'
            ,
            'canceladas',
            'detalles_ordenes',
            'total_insumos',
            'en_riesgo',
            'conteo_procedimientos_odontologo'
        ));
    }


    public function indexHistorialTransacciones()
    {
        $limit = request('limit', 10);
        $page = request('page', 1);

        $queryIngresos = DB::table('citas')
            ->where('estado_cita', 'completada')
            ->select(
                'fecha_cita as fecha',
                'motivo_cita as descripcion',
                'total_cita as total',
                DB::raw("'Ingreso' as tipo")
            );


        $queryEgresos = DB::table('detalles_ordenes')
            ->join('ordenes_compras', 'detalles_ordenes.orden_id', '=', 'ordenes_compras.id_orden_compra')
            ->join('insumos', 'detalles_ordenes.insumo_id', '=', 'insumos.id_insumo')
            ->where('ordenes_compras.estado', '=', 'aprobado')
            ->select(
                'ordenes_compras.fecha_expedicion as fecha',
                'insumos.nombre_insumo as descripcion',
                'detalles_ordenes.total',
                DB::raw("'Egreso' as tipo")
            );

        $unionQuery = $queryIngresos->unionAll($queryEgresos);

        $transacciones = DB::table(DB::raw("({$unionQuery->toSql()}) as transacciones"))
            ->mergeBindings($unionQuery)
            ->orderBy('fecha', 'desc')
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json($transacciones);
    }


    public function indexOrdenarInsumos(Request $request)
    {
        $ordenes = DB::table('detalles_ordenes as deto')
            ->join('insumos as i', 'deto.insumo_id', '=', 'i.id_insumo')
            ->join('ordenes_compras as oc', 'deto.orden_id', '=', 'oc.id_orden_compra')
            ->where('oc.estado', 'ordenado')
            ->select(
                'oc.id_orden_compra as id_orden',
                'oc.estado',
                'i.nombre_insumo',
                'i.cantidad_insumo as cantidad_actual',
                'i.fecha_vencimiento',
                'i.umbral_alerta',
                'deto.cantidad_insumo as cantidad_ordenada',
                'deto.total'
            )
            ->get();

        $agrupado = $ordenes->groupBy('id_orden')->map(function ($items, $id_orden) {
            return [
                'id_orden' => $id_orden,
                'estado' => $items[0]->estado,
                'insumos' => $items->map(function ($item) {
                    return [
                        'nombre_insumo' => $item->nombre_insumo,
                        'cantidad_actual' => $item->cantidad_actual,
                        'cantidad_ordenada' => $item->cantidad_ordenada,
                        'fecha_vencimiento' => $item->fecha_vencimiento,
                        'umbral_alerta' => $item->umbral_alerta,
                        'total' => $item->total,
                    ];
                })->values()
            ];
        })->values();

        if ($request->wantsJson()) {
            return response()->json($agrupado);
        }

        return view('dueno.ordenar-insumos');
    }


    public function aprobar($id)
    {
        DB::table('ordenes_compras')
            ->where('id_orden_compra', $id)
            ->update(['estado' => 'aprobado']);

        return response()->json(['mensaje' => 'Orden aprobada.']);
    }

    public function rechazar($id)
    {
        DB::table('ordenes_compras')
            ->where('id_orden_compra', $id)
            ->update(['estado' => 'rechazado']);

        return response()->json(['mensaje' => 'Orden rechazada.']);
    }

    public function configuracion(Request $request)
    {
        // Si es POST, guardamos en sesión de Laravel
        if ($request->isMethod('post')) {
            session([
                'dueno.nombre' => $request->input('nombre'),
                'dueno.telefono' => $request->input('telefono'),
                'dueno.email' => $request->input('email'),
            ]);
            return redirect('api/dueno');
        }

        // Valores por defecto
        $datos = [
            'nombre' => session('dueno.nombre', '(Nombre)'),
            'telefono' => session('dueno.telefono', '+57 34567890'),
            'email' => session('dueno.email', 'gerencia@dentalflow.com'),
            'especialidad' => 'Dueño',
        ];

        return view('dueno.dueno-configuracion', $datos);
    }

}
