<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\OrdenCompra;
use App\Models\DetalleOrden;
use App\Models\Insumo;

class InsumoController extends Controller
{
    public function solicitarInsumo(Request $request)
    {
        $data = $request->validate([
            'tipo' => [
                'required',
                'string',
                // valida que ese nombre exista en insumos.nombre_insumo
                Rule::exists('insumos', 'nombre_insumo'),
            ],
            'cantidad' => 'required|integer|min:1',
            'proveedor' => [
                'required',
                'string',
                Rule::exists('proveedores', 'nit'),
            ],
        ]);

        try {
            // 1) Obtenemos el modelo Insumo
            $insumo = Insumo::where('nombre_insumo', $data['tipo'])->first();

            // 2) Creamos la orden de compra
            $orden = OrdenCompra::create([
                'fecha_expedicion'  => now(),
                'fecha_vencimiento' => now()->addDays(7),
                'usuario_id'        => auth()->id(), // o null si no hay auth
                'estado'            => 'ordenado',
            ]);

            // 3) Creamos el detalle con el total calculado
            $detalle = DetalleOrden::create([
                'orden_id'        => $orden->id_orden_compra,
                'insumo_id'       => $insumo->id_insumo,
                'cantidad_insumo' => $data['cantidad'],
                'total'           => $insumo->costo_insumo * $data['cantidad'],
            ]);

            return response()->json([
                'success'      => true,
                'orden_id'     => $orden->id_orden_compra,
                'detalle_id'   => $detalle->id_detalle_orden,
            ], 201);
        } catch (\Exception $e) {
            // Devuelve el error real para facilitar depuración
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
