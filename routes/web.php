<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\pa_ActProveedorController;
use App\Http\Controllers\CitasControllerApi;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\LaboratoristaController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');


Route::post('/register-user', [CreateNewUser::class, 'create']);



Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');


// Otras vistas generales
Route::view('/citas_asesoria', 'plantilla_asesoria');
Route::view('/plantilla', 'plantilla');
Route::view('/plantillaSubMenu', 'plantillaSubMenu');
Route::view('/procesar_registro', 'procesar_registro');
Route::view('/registrar', 'registrar');

Route::view('/ejemplo', 'odontologo.configuracion');


//Las Protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/asistente'); // Redirige automáticamente a la ruta /configuracion
    });
// ADMINISTRADOR
Route::view('/administrador', 'administrador.administrador');
Route::view('/gestionUsuarios', 'administrador.gestionUsuarios');
Route::view('/configuracion3', 'administrador.configuracion3');
Route::view('/gestionProveedores', 'gestionProveedores')->name('gestionProveedores');


// ASISTENTE
Route::prefix('asistente')->group(function () {
    Route::get('/', [AsistenteController::class, 'index'])->name('asistente');
    Route::view('/citas', 'asistente.citas');
    Route::view('/ahistorial', 'asistente.Ahistorial');
    Route::view('/aregistro', 'asistente.Aregistro');
    Route::view('/configuracion2', 'asistente.configuracion2');
});

// ODONTÓLOGO
Route::view('/ordenes', 'odontologo.ordenes');
Route::view('/gestionpedidos', 'odontologo.gestionpedidos');
Route::view('/solicitud', 'odontologo.solicitud');
Route::view('/agenda', 'odontologo.agenda');
Route::view('/historias', 'odontologo.historias');
Route::view('/configuracion', 'odontologo.configuracion');

// CAJERO
Route::view('/cajero', 'cajero.cajero');
Route::view('/cajero/cformulario', 'cajero.cformulario');
Route::view('/cajero/cestadistico', 'cajero.cestadistico');
Route::view('/cajero/ccontable', 'cajero.ccontable');
});

Route::post('/postaregistro', [\App\Http\Controllers\Api\CitasControllerApi::class, 'storePaciente'])->name('postaregistro');
Route::get('/aregistro', [\App\Http\Controllers\Api\CitasControllerApi::class, 'indexAregistro']);

// Rutas Laboratorista
Route::prefix('laboratorista')->middleware(['auth', 'role:4'])->group(function () {
    Route::get('/', [LaboratoristaController::class, 'index'])->name('laboratorista.dashboard');
    Route::get('/ordenes', [LaboratoristaController::class, 'ordenesHoy'])->name('laboratorista.ordenes.hoy');
    Route::get('/orden/{id}', [LaboratoristaController::class, 'show'])->name('laboratorista.orden.show');
    Route::post('/orden/{id}/estado', [LaboratoristaController::class, 'updateEstado'])->name('laboratorista.orden.estado');
    Route::get('/insumos', [LaboratoristaController::class, 'insumos'])->name('laboratorista.insumos');
    Route::get('/config',  [LaboratoristaController::class, 'config'])->name('laboratorista.config');
    Route::post('/orden/{id}/producto', [LaboratoristaController::class, 'addProducto'])->name('laboratorista.orden.producto');
    Route::get('/laboratorista/todos', [LaboratoristaController::class,'all'])->name('laboratorista.ordenes.todos');

});

/*RUTITA PARA CONFIGURACION 4 LABORATORISTA*/
Route::match(['get', 'post'], '/configuracion4', function () {
    // Si necesitas middleware de sesión u otro, añádelo aquí
    return view('laboratorista.configuracion4');
})->name('laboratorista.configuracion4');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')->name('login');

//INSUMOS
Route::get('/gestionInsumos', [LaboratoristaController::class, 'insumos'])
    ->middleware(['auth','role:2,4'])
    ->name('gestion.insumos');

