<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OdontologoController;

use App\Http\Controllers\Api\CitasControllerApi;
use App\Http\Controllers\Api\GestorInsumosControllerApi;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\InsumoController;


//Route::middleware('auth')->group(function () { //Sanctum

// Ruta para obtener al usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
});

// Citas
Route::get('/odontologo', [CitasControllerApi::class, 'index']);
Route::get('/citas', [CitasControllerApi::class, 'indexCitas'])->name('asistente.volver');
Route::post('/registrarcita', [CitasControllerApi::class, 'store']);
Route::get('/citas/edit/{id}', [CitasControllerApi::class, 'edit'])->name('citas.edit');
Route::put('/citas/{id}', [CitasControllerApi::class, 'update'])->name('citas.update');
Route::delete('/citas/delete/{id}', [CitasControllerApi::class, 'delete'])->name('citas.delete');
Route::get('/buscar-paciente/{input}', [CitasControllerApi::class, 'show']);



// Proveedores
Route::get('/proveedores', [GestorInsumosControllerApi::class, 'index']);
Route::post('/proveedores', [GestorInsumosControllerApi::class, 'store']);
Route::put('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'update']);
Route::delete('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'destroy']);
Route::get('/proveedores/listar', [GestorInsumosControllerApi::class, 'listarProveedores']);
Route::post('/solicitar-insumo', [GestorInsumosControllerApi::class, 'solicitarInsumo']);

//ruta adicional de proveedores
Route::get('/proveedores/listar', [ProveedorController::class, 'index']);
/*Route::post(
    '/solicitar-insumo',[InsumoController::class, 'solicitarInsumo'])->middleware('auth:sanctum');*/

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
