<?php
// app/Http/Controllers/ApiBD/OrdenCompraApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\OrdenCompraServiceInterface;

class OrdenCompraApiController extends Controller
{
    public function __construct(private OrdenCompraServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $orden = $this->service->find($id);
        return $orden
            ? response()->json($orden)
            : response()->json(['message' => 'Orden de compra no encontrada'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'fecha_expedicion' => 'required|date',
            'fecha_vencimiento'=> 'required|date',
            'usuario_id'       => 'required|integer',
            'estado'           => 'required|in:ordenado,en produccion,listo para entregar,entregado',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Orden de compra creada'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'fecha_expedicion' => 'sometimes|date',
            'fecha_vencimiento'=> 'sometimes|date',
            'usuario_id'       => 'sometimes|integer',
            'estado'           => 'sometimes|in:ordenado,en produccion,listo para entregar,entregado',
        ]);

        $ok = $this->service->update($id, $data);
        return $ok
            ? response()->json(['message' => 'Orden de compra actualizada'])
            : response()->json(['message' => 'Orden de compra no encontrada'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Orden de compra eliminada'])
            : response()->json(['message' => 'Orden de compra no encontrada'], 404);
    }
}
