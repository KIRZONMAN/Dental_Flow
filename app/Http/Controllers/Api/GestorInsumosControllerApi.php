<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionProveedor;
use Carbon\Carbon;


class GestorInsumosControllerApi extends Controller
{
    // Listar proveedores
    public function index()
    {
        $proveedores = DB::select('SELECT * FROM proveedores');
        return response()->json($proveedores);
    }


    // Insertar proveedor
    public function store(Request $request)
    {
        $request->validate([
            'nit' => 'required|string',
            'nombre' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email'
        ]);

        DB::statement('CALL pa_InsertarProveedor(?, ?, ?, ?)', [
            $request->nit,
            $request->nombre,
            $request->telefono,
            $request->correo
        ]);

        return response()->json(['message' => 'Proveedor insertado con éxito']);
    }

    // Actualizar proveedor
    public function update(Request $request, $nit)
    {
        $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email'
        ]);

        DB::statement('CALL pa_ActualizarProveedor(?, ?, ?, ?)', [
            $nit,
            $request->nombre,
            $request->telefono,
            $request->correo
        ]);

        return response()->json(['message' => 'Proveedor actualizado con éxito']);
    }

    // Eliminar proveedor
    public function destroy($nit)
    {
        DB::statement('CALL pa_EliminarProveedor(?)', [$nit]);

        return response()->json(['message' => 'Proveedor eliminado con éxito']);
    }

    //Listaciones 2
    public function listarProveedores()
    {
        try {
            $proveedores = DB::select("CALL pa_ObtenerProveedores()");
            return response()->json($proveedores);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener proveedores: ' . $e->getMessage()], 500);
        }
    }

    //Correos Electronicos

    public function solicitarInsumo(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'tipo' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            'proveedor' => 'required|string',
        ]);

        $tipo = $request->tipo;
        $cantidad = $request->cantidad;
        $nit = $request->proveedor;

        try {
            $proveedor = DB::table('proveedores')->where('nit', $nit)->first();

            if (!$proveedor || !$proveedor->correo_proveedor) {
                return response()->json(['error' => 'Correo del proveedor no encontrado'], 404);
            }

            $datos = [
                'insumo' => $tipo,
                'cantidad' => $cantidad,
                'fecha' => Carbon::now()->format('d/m/Y'),
                'nombre_proveedor' => $proveedor->nombre_proveedor
            ];

            Mail::to($proveedor->correo_proveedor)->send(new NotificacionProveedor($datos));

            return response()->json(['message' => 'Solicitud registrada y correo enviado']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar solicitud', 'detalle' => $e->getMessage()], 500);
        }
    }

    // --------------------- PEDIDOS ------------------------

    // Listar pedidos
    public function listarPedidos()
    {
        try {
            $pedidos = DB::select("CALL pa_ObtenerPedidos()");
            return response()->json($pedidos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener pedidos: ' . $e->getMessage()], 500);
        }
    }

    // Insertar pedido
    public function insertarPedido(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'estado' => 'required|string',
            'id_proveedor' => 'required|integer'
        ]);

        try {
            DB::statement('CALL pa_InsertarPedido(?, ?, ?, ?)', [
                $request->descripcion,
                $request->fecha,
                $request->estado,
                $request->id_proveedor
            ]);

            return response()->json(['message' => 'Pedido insertado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al insertar pedido: ' . $e->getMessage()], 500);
        }
    }

    // Actualizar pedido
    public function actualizarPedido(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'estado' => 'required|string',
            'id_proveedor' => 'required|integer'
        ]);

        try {
            DB::statement('CALL pa_ActualizarPedido(?, ?, ?, ?, ?)', [
                $id,
                $request->descripcion,
                $request->fecha,
                $request->estado,
                $request->id_proveedor
            ]);

            return response()->json(['message' => 'Pedido actualizado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar pedido: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar pedido
    public function eliminarPedido($id)
    {
        try {
            DB::statement('CALL pa_EliminarPedido(?)', [$id]);
            return response()->json(['message' => 'Pedido eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar pedido: ' . $e->getMessage()], 500);
        }
    }

}
