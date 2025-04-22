<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OdontologoController;

use App\Http\Controllers\Api\CitasControllerApi;
use App\Http\Controllers\Api\GestorInsumosControllerApi;

use App\Http\Controllers\ApiBD\{
    PacienteApiController, CitaApiController, HistoriaClinicaApiController,
    RecetaMedicaApiController, ProveedorApiController, InsumoApiController,
    OrdenCompraApiController, PedidoApiController, RolApiController,
    ProcedimientoApiController, UsuarioApiController
};

//Route::middleware('auth')->group(function () { //Sanctum

    // Ruta para obtener al usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });





    // Proveedores
    Route::get('/proveedores', [GestorInsumosControllerApi::class, 'index']);
    Route::post('/proveedores', [GestorInsumosControllerApi::class, 'store']);
    Route::put('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'update']);
    Route::delete('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'destroy']);
    Route::get('/proveedores/listar', [GestorInsumosControllerApi::class, 'listarProveedores']);
    Route::post('/solicitar-insumo', [GestorInsumosControllerApi::class, 'solicitarInsumo']);

    // Pedidos
    Route::get('/pedidos', [GestorInsumosControllerApi::class, 'listarPedidos']);
    Route::post('/pedidos', [GestorInsumosControllerApi::class, 'insertarPedido']);
    Route::put('/pedidos/{id}', [GestorInsumosControllerApi::class, 'actualizarPedido']);
    Route::delete('/pedidos/{id}', [GestorInsumosControllerApi::class, 'eliminarPedido']);

    // Agenda e Historias
    Route::get('/agenda', [CitasControllerApi::class, 'indexAgendaBusqueda']);
    Route::get('/historias', [CitasControllerApi::class, 'indexHistorias']);
    Route::get('/ahistorial', [CitasControllerApi::class, 'indexAhistorialPacientes']);
//});

//Servicios
Route::prefix('apibd')->group(function(){
    Route::apiResource('pacientes',   PacienteApiController::class);
    Route::apiResource('citas',       CitaApiController::class);
    Route::apiResource('historias',   HistoriaClinicaApiController::class);
    Route::apiResource('recetas',     RecetaMedicaApiController::class);
    Route::apiResource('proveedores', ProveedorApiController::class);
    Route::apiResource('insumos',     InsumoApiController::class);
    Route::apiResource('ordenes',     OrdenCompraApiController::class);
    Route::apiResource('pedidos',     PedidoApiController::class);
    Route::apiResource('roles',       RolApiController::class)->only(['index']);
    Route::apiResource('procedimientos', ProcedimientoApiController::class);
    Route::apiResource('usuarios',    UsuarioApiController::class);
});

//Controllers2

Route::prefix('citas')->group(function () {
    Route::get('/',        [CitaApiController::class, 'index']);   // GET    /api/citas
    Route::get('/{id}',    [CitaApiController::class, 'show']);    // GET    /api/citas/{id}
    Route::post('/',       [CitaApiController::class, 'store']);   // POST   /api/citas
    Route::put('/{id}',    [CitaApiController::class, 'update']);  // PUT    /api/citas/{id}
    Route::delete('/{id}', [CitaApiController::class, 'destroy']); // DELETE /api/citas/{id}
});
