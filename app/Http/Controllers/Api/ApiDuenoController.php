<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionProveedor;
use App\Models\OrdenCompra;
use App\Models\Proveedor;

class ApiDuenoController extends Controller
{
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

        $ordenes = DB::table('detalles_ordenes   as deto')
            ->join('insumos           as i', 'deto.insumo_id', '=', 'i.id_insumo')
            ->join('ordenes_compras   as oc', 'deto.orden_id', '=', 'oc.id_orden_compra')
            ->leftJoin('usuarios        as u', 'u.id_usuario', '=', 'oc.aprobado_por') // ← NUEVO
            ->whereIn('oc.estado', ['ordenado', 'aprobado'])
            ->select(
                'oc.id_orden_compra   as id_orden',
                'oc.estado',
                DB::raw("CONCAT(u.nombres_usuario,' ',u.apellidos_usuario) as aprobador"), // ← NUEVO
                'i.nombre_insumo',
                'i.cantidad_insumo   as cantidad_actual',
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
                'aprobador' => $items[0]->aprobador,  // ← NUEVO
                'insumos' => $items->map(fn($i) => [
                    'nombre_insumo' => $i->nombre_insumo,
                    'cantidad_actual' => $i->cantidad_actual,
                    'cantidad_ordenada' => $i->cantidad_ordenada,
                    'fecha_vencimiento' => $i->fecha_vencimiento,
                    'umbral_alerta' => $i->umbral_alerta,
                    'total' => $i->total,
                ])->values()
            ];
        })->values();


        return $request->wantsJson()
            ? response()->json($agrupado)
            : view('dueno.ordenar-insumos');
    }



    public function aprobar($id)
    {
        $orden = OrdenCompra::with('detalles')->findOrFail($id);

        if ($orden->estado !== 'ordenado') {
            return response()->json(['mensaje' => 'Ya fue procesada'], 422);
        }

        DB::transaction(function () use ($orden) {

            /* 1️⃣  Cambiamos estado + firmamos */
            $orden->update([
                'estado' => 'aprobado',
                'aprobado_por' => auth()->id(),
            ]);

            /* 2️⃣  Averiguamos a qué proveedor(es) hay que avisar   */
            $proveedores = DB::table('proveedores')
                ->join('proveedores_insumos', 'proveedores.nit', '=', 'proveedores_insumos.proveedor_id')
                ->whereIn('proveedores_insumos.insumo_id', $orden->detalles->pluck('insumo_id'))
                ->select('proveedores.*')
                ->distinct()
                ->get();

            /* 3️⃣  Enviamos correo a cada uno */
            foreach ($proveedores as $prov) {
                $datos = [
                    'insumo' => 'Detalle adjunto',
                    'cantidad' => $orden->detalles
                        ->whereIn('insumo_id', function ($q) use ($prov) {
                            $q->select('insumo_id')
                                ->from('proveedores_insumos')
                                ->where('proveedor_id', $prov->nit);
                        })
                        ->sum('cantidad_insumo'),
                    'fecha' => now()->format('d/m/Y'),
                    'nombre_proveedor' => $prov->nombre_proveedor,
                ];

                Mail::to($prov->correo_proveedor)
                    ->send(new NotificacionProveedor($datos));
            }
        });

        return response()->json(['mensaje' => 'Orden aprobada y correos enviados']);
    }


    public function rechazar($id)
    {
        DB::table('ordenes_compras')
            ->where('id_orden_compra', $id)
            ->update(['estado' => 'rechazado']);

        return response()->json(['mensaje' => 'Orden rechazada.']);
    }

    public function marcarEntregada(int $id)
    {
        $orden = OrdenCompra::with('detalles.insumo')->findOrFail($id);

        if ($orden->estado !== 'aprobado') {
            return response()->json(['mensaje' => 'Solo las órdenes aprobadas pueden cerrarse'], 422);
        }

        DB::transaction(function () use ($orden) {

            /*subimos stock */
            foreach ($orden->detalles as $det) {
                $det->insumo->aumentarStock($det->cantidad_insumo);
            }

            /* cerramos orden */
            $orden->update([
                'estado' => 'entregado',
                'entregada_at' => now(),            //  ← opcional (ver migración abajo)
            ]);
        });

        return response()->json(['mensaje' => 'Orden marcada como entregada']);
    }

    public function entregar($id)
    {
        $orden = OrdenCompra::findOrFail($id);

        if ($orden->estado !== 'aprobado') {
            return response()->json(['mensaje' => 'Sólo puede entregarse una orden aprobada'], 422);
        }

        $orden->update([
            'estado' => 'entregado',
            'entregada_at' => now(),
        ]);

        return response()->json(['mensaje' => 'Orden marcada como recibida']);
    }


}
