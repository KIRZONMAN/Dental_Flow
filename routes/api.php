<?php

use App\Http\Controllers\Api\ApiDuenoController;
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
    // Ruta para obtener al usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //Citas
    Route::apiResource('citas', CitasControllerApi::class)->names('api.citas');
    Route::prefix('citas')->group(function () {
        Route::get('/hoy', [CitasControllerApi::class, 'indexHoy'])->name('api.citas.hoy');
        Route::get('/{id}', [CitasControllerApi::class, 'show'])->where('id', '[0-9]+')->name('api.citas.show');
    });
    Route::controller(CitasControllerApi::class)->group(function () {
        //Pacientes
        Route::prefix('pacientes')->group(function () {
            Route::get('/', 'indexPacientes')->name('api.pacientes.index');
            Route::post('/', 'storePaciente')->name('post.pacientes');
            Route::get('/{input}', 'showPaciente')->name('api.pacientes.show'); //indexPaciente
        });
        // Agenda e Historias
        Route::get('/agenda', 'indexAgendaBusqueda');
        Route::get('/historias', 'indexHistorias');
        Route::get('/ahistorial', 'indexAhistorialPacientes');

    });
    // Proveedores
    Route::apiResource('/proveedores', GestorInsumosControllerApi::class)
        ->parameters(['proveedores' => 'nit'])
        ->names('api.proveedores');
    //Route::get('/proveedores', [GestorInsumosControllerApi::class, 'index']);
    //Route::post('/proveedores', [GestorInsumosControllerApi::class, 'store']);
    //Route::put('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'update']);
    //Route::delete('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'destroy']);
    //Route::get('/proveedores/listar', [ProveedorController::class, 'index']);
    Route::post('/solicitar-insumo', [GestorInsumosControllerApi::class, 'solicitarInsumo']);

    //ruta adicional de proveedores
    Route::get('/proveedores/listar', [ProveedorController::class, 'index']);
    /*Route::post(
        '/solicitar-insumo',[InsumoController::class, 'solicitarInsumo'])->middleware('auth:sanctum');*/

    // Pedidos
    Route::apiResource('/pedidos', GestorInsumosControllerApi::class)->names('api.pedidos');
    //Route::get('/pedidos', [GestorInsumosControllerApi::class, 'listarPedidos']);
    //Route::post('/pedidos', [GestorInsumosControllerApi::class, 'insertarPedido']);
    //Route::put('/pedidos/{id}', [GestorInsumosControllerApi::class, 'actualizarPedido']);
    //Route::delete('/pedidos/{id}', [GestorInsumosControllerApi::class, 'eliminarPedido']);


    /*Dueño*/
    Route::middleware(['auth', 'role:1,5'])->prefix('dueno')->group(function () {
        Route::controller(ApiDuenoController::class)->group(function () {
            Route::get('/rendimiento', 'indexRendimiento')->name('dueno.rendimiento');
            Route::get('/insumos', 'indexInsumos')->name('dueno.insumos');
            Route::get('/conteo', 'indexCitas')->name('dueno.conteo');
            Route::get('/informe-clinica', 'indexInformeClinica')->name('dueno.informe-clinica');
            Route::get('/historial-movimientos', 'indexHistorialTransacciones')->name('dueno.historial-movimientos');
            Route::get('/ordenar-insumos', 'indexOrdenarInsumos')->name('dueno.ordenar-insumos');
            Route::get('/insumos-solicitados', 'indexInsumosSolicitados')->name('dueno.insumos-solicitados');
        });
    });
    // Rutas SOLO para el Dueño
    Route::middleware(['auth', 'role:5'])->prefix('dueno')->group(function () {
        Route::prefix('ordenes/{id}')->controller(ApiDuenoController::class)->group(function () {
            Route::post('/aprobar', 'aprobar')->name('dueno.ordenes.aprobar');
            Route::post('/rechazar', 'rechazar')->name('dueno.ordenes.rechazar');
            Route::post('/entregar', 'entregar')->name('dueno.ordenes.entregar');
        });
    });


    /*Administrador*/
    Route::middleware(['auth', 'role:1'])->prefix('administrador')->group(function () {
        Route::controller(ApiAdministradorController::class)->group(function () {
            Route::get('/usuarios', 'indexUsuarios')->name('administrador.usuarios');
            Route::get('/gestionUsuarios', 'index')->name('administrador.gestionUsuarios');
            Route::delete('/usuarios/{id}', 'destroyUsuario');
            Route::post('/agregarUsuario', 'agregarUsuario')->name('usuarios.store');
            Route::get('/tablaUsuarios', 'indexTablaUsuarios');
            Route::get('/filtrarUsuario/{input}', 'filtrarUsuario');
        });
    });

    /*Ruta prueba */
    Route::post('/testeoContra', [ApiAdministradorController::class, 'login'])->name('login.post');
    Route::post('/citas/{id}/procedimiento', [CitasControllerApi::class, 'addProcedure'])->name('api.citas.addProcedure');
    Route::delete('/citas/{id}/procedimiento/{pcId}', [CitasControllerApi::class, 'removeProcedure'])->name('api.citas.removeProcedure');

});
