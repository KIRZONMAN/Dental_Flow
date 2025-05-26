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

// Rutas RESTful de Citas (API – JSON)
Route::middleware(['auth:sanctum'])->group(function () {
    // Ruta para obtener al usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //Citas
    Route::prefix('citas')->group(function () {
        Route::apiResource('citas', CitasControllerApi::class)->names('api.citas');
        Route::get('/hoy', [CitasControllerApi::class, 'indexHoy'])->name('api.citas.hoy');
        Route::get('/{id}', [CitasControllerApi::class, 'show'])
            ->where('id', '[0-9]+')
            ->name('api.citas.show');
        //Route::post('/', [CitasControllerApi::class, 'store'])->name('api.citas.store');
        //Route::delete('/{id}', [CitasControllerApi::class, 'delete'])->where('id', '[0-9]+')->name('api.citas.delete');
    });
    //Registrar Paciente
    Route::post('/postaregistro', [CitasControllerApi::class, 'storePaciente'])->name('postaregistro');
    // Ruta de búsqueda de paciente (mantener)
    Route::get('/buscar-paciente/{input}', [CitasControllerApi::class, 'buscarPaciente']);

    // Proveedores
    Route::get('/proveedores', [GestorInsumosControllerApi::class, 'index']);
    Route::post('/proveedores', [GestorInsumosControllerApi::class, 'store']);
    Route::put('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'update']);
    Route::get('/proveedores/listar', [ProveedorController::class, 'index']);
    Route::delete('/proveedores/{nit}', [GestorInsumosControllerApi::class, 'destroy']);
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

    /*Dueño*/
    Route::get('/dueno', [ApiDuenoController::class, 'indexDueno'])->name('dueno.dashboard');
    Route::get('/dueno/rendimiento', [ApiDuenoController::class, 'indexRendimiento'])->name('dueno.rendimiento');
    Route::get('/dueno/insumos', [ApiDuenoController::class, 'indexInsumos'])->name('dueno.insumos');
    Route::get('/dueno-conteo', [ApiDuenoController::class, 'conteoCitas'])->name('dueno.conteo');
    Route::get('/informe-clinica', [ApiDuenoController::class, 'indexInformeClinica'])->name('informe-clinica');
    Route::get('/historial-movimientos', [ApiDuenoController::class, 'indexHistorialTransacciones'])->name('historial-movimientos');
    Route::get('/ordenar-insumos', [ApiDuenoController::class, 'indexOrdenarInsumos'])->name('ordenar-insumos');
    // Configuración Dueño
    Route::match(['get', 'post'], '/apiDueno/configuracion', [ApiDuenoController::class, 'configuracion'])
        ->name('dueno-configuracion');

    Route::get('/insumos-solicitados', [ApiDuenoController::class, 'indexInsumosSolicitados'])->name('insumos-solicitados');
    Route::post('/ordenes/{id}/aprobar', [ApiDuenoController::class, 'aprobar']);
    Route::post('/ordenes/{id}/rechazar', [ApiDuenoController::class, 'rechazar']);
    // Justo después de aprobar/rechazar:
    Route::post('/ordenes/{id}/entregar', [ApiDuenoController::class, 'entregar'])
        ->name('api.ordenes.entregar');

    /*Administrador*/
    Route::get('/usuarios', [ApiAdministradorController::class, 'indexUsuarios']);
    Route::get('/gestionUsuarios', [ApiAdministradorController::class, 'index'])->name('gestionUsuarios');
    Route::delete('/gestionUsuarios/{id}', [ApiAdministradorController::class, 'eliminarUsuario']);
    Route::get('/agregarUsuario', [ApiAdministradorController::class, 'VistaAgregarUsuario']);
    Route::post('/agregarUsuario', [ApiAdministradorController::class, 'agregarUsuario'])->name('usuarios.store');
    Route::get('/tablaUsuarios', [ApiAdministradorController::class, 'indexTablaUsuarios']);
    Route::get('/filtrarUsuario/{input}', [ApiAdministradorController::class, 'filtrarUsuario']);

    /*Ruta prueba */
    Route::post('/testeoContra', [ApiAdministradorController::class, 'login'])->name('login.post');
    Route::post('/citas/{id}/procedimiento', [CitasControllerApi::class, 'addProcedure'])->name('api.citas.addProcedure');
    Route::delete('/citas/{id}/procedimiento/{pcId}', [CitasControllerApi::class, 'removeProcedure'])->name('api.citas.removeProcedure');
});
