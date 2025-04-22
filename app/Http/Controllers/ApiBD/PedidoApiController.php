<?php
// app/Http/Controllers/ApiBD/PedidoApiController.php

namespace App\Http\Controllers\ApiBD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Contracts\PedidoServiceInterface;

class PedidoApiController extends Controller
{
    public function __construct(private PedidoServiceInterface $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->all());
    }

    public function show(int $id): JsonResponse
    {
        $pedido = $this->service->find($id);
        return $pedido
            ? response()->json($pedido)
            : response()->json(['message' => 'Pedido no encontrado'], 404);
    }

    public function store(Request $req): JsonResponse
    {
        $data = $req->validate([
            'descripcion'   => 'required|string',
            'fecha'         => 'required|date',
            'estado'        => 'required|string',
            'id_proveedor'  => 'required|string|max:20',
        ]);

        $this->service->create($data);
        return response()->json(['message' => 'Pedido creado'], 201);
    }

    public function update(Request $req, int $id): JsonResponse
    {
        $data = $req->validate([
            'descripcion'   => 'sometimes|string',
            'fecha'         => 'sometimes|date',
            'estado'        => 'sometimes|string',
            'id_proveedor'  => 'sometimes|string|max:20',
        ]);

        $ok = $this->service->update($id, $data);
        return $ok
            ? response()->json(['message' => 'Pedido actualizado'])
            : response()->json(['message' => 'Pedido no encontrado'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        $ok = $this->service->delete($id);
        return $ok
            ? response()->json(['message' => 'Pedido eliminado'])
            : response()->json(['message' => 'Pedido no encontrado'], 404);
    }
}
