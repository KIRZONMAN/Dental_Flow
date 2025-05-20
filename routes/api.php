<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\Api\CitasControllerApi;
use App\Http\Controllers\Api\ApiAdministradorController;
use App\Http\Controllers\Api\GestorInsumosControllerApi;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\InsumoController;


//Route::middleware('auth')->group(function () { //Sanctum

// Ruta para obtener al usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
});

// Rutas RESTful de Citas (API – JSON)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('citas')->group(function () {
        Route::get('/', [CitasControllerApi::class, 'index'])->name('api.citas.index');
        Route::get('/hoy', [CitasControllerApi::class, 'indexHoy'])->name('api.citas.hoy');
        Route::get('/{id}', [CitasControllerApi::class, 'show'])
            ->where('id', '[0-9]+')
            ->name('api.citas.show');
        Route::post('/', [CitasControllerApi::class, 'store'])->name('api.citas.store');
        Route::put('/{id}', [CitasControllerApi::class, 'update'])
            ->where('id', '[0-9]+')
            ->name('api.citas.update');
        Route::delete('/{id}', [CitasControllerApi::class, 'delete'])
            ->where('id', '[0-9]+')
            ->name('api.citas.delete');
    });
});

// Vista de Blade para asistente (HTML)
Route::get('/asistente/citas', [CitasControllerApi::class, 'indexCitas'])
    ->name('asistente.citas.view');


// Ruta de búsqueda de paciente (mantener si la usas desde JS)
Route::get('/buscar-paciente/{input}', [CitasControllerApi::class, 'buscarPaciente']);



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

/*Administrador*/
Route::get('/usuarios', [ApiAdministradorController::class, 'indexUsuarios']);
Route::get('/gestionUsuarios', [ApiAdministradorController::class, 'index']);
Route::delete('/gestionUsuarios/{id}', [ApiAdministradorController::class, 'eliminarUsuario']);


//});
