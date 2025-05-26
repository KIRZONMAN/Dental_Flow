<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\pa_ActProveedorController;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\LaboratoristaController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\GeneralController;
// Añadido Fortify:
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

// ——— Rutas de Autenticación (Fortify) ———
//INVITADOS
// Mostrar formulario de login
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

// Procesar login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Logout vía Fortify
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout'); //

// Otras vistas generales
Route::view('/citas_asesoria', 'plantilla_asesoria');
Route::view('/plantilla', 'plantilla');
Route::view('/plantillaSubMenu', 'plantillaSubMenu');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/asistente');
    });

    // ADMINISTRADOR
    Route::middleware(['auth', 'role:1'])
        ->prefix('administrador')
        ->as('administrador.')
        ->group(function () {
            // Dashboard principal
            Route::get('/', fn() => view('administrador.administrador'))
                ->name('dashboard');
            // Gestión de usuarios (vista estática)
            Route::get('gestionUsuarios', fn() => view('administrador.gestionUsuarios'))
                ->name('usuarios');

            // Configuración Administrador
            Route::match(['get', 'post'], '/configuracion3', [AdministradorController::class, 'configuracion3'])
                ->name('configuracion3');

            // Gestión de proveedores (vista estática o blade)
            Route::get('gestionProveedores', fn() => view('gestionProveedores'))
                ->name('proveedores');

            // CRUD de Procedimientos
            Route::get('procedimientos', [ProcedimientoController::class, 'index'])
                ->name('procedimientos.index');
            Route::post('procedimientos', [ProcedimientoController::class, 'store'])
                ->name('procedimientos.store');
            Route::delete('procedimientos/{id}', [ProcedimientoController::class, 'destroy'])
                ->name('procedimientos.destroy');

            // Registro de usuario
            Route::get('usuarios', [AdministradorController::class, 'VistaAgregarUsuario'])->name('usuarios.create');
            Route::post('usuarios', [AdministradorController::class, 'agregarUsuario'])->name('usuarios.store');

            // Mostrar formulario de edición
            Route::get('usuarios/{id}/edit', [AdministradorController::class, 'edit'])
                ->name('usuarios.edit');
            // Procesar la actualización
            Route::put('usuarios/{id}', [AdministradorController::class, 'update'])
                ->name('usuarios.update');
            //Eliminar usuario
            Route::delete('usuarios/{id}', [AdministradorController::class, 'usuarios.destroy']);
        });

    // ODONTÓLOGO
    Route::middleware(['auth', 'role:1,2'])
        ->prefix('odontologo')
        ->group(function () {
            Route::get('/', [OdontologoController::class, 'index'])
                ->name('odontologo.dashboard');

            // Dashboard de Órdenes: usa una vista dedicada
            Route::view('/ordenes', 'odontologo.ordenes')
                ->name('odontologo.ordenes');

            // Solicitud de prótesis
            Route::get('/solicitud', [OdontologoController::class, 'showSolicitudForm'])
                ->name('odontologo.solicitud.form');
            Route::post('/solicitud', [OdontologoController::class, 'storeSolicitud'])
                ->name('odontologo.solicitud.store');

            // Agenda, historias y configuración
            Route::get('/agenda', [CitasController::class, 'indexAgendaBusqueda'])
                ->name('odontologo.agenda');
            Route::get('/historias/{cedula}', [CitasController::class, 'indexHistorias'])
                ->name('odontologo.historias');
            // Listado de historias clínicas de un paciente
            Route::get('/historias/{cedula}/list', [HistoriaClinicaController::class, 'index'])
                ->middleware(['auth', 'role:2'])->name('odontologo.historias.list');

            // Borrado de una historia concreta (dispara trigger 17)(PENDIENTE)
            Route::delete('/historias/{id}', [HistoriaClinicaController::class, 'destroy'])
                ->name('odontologo.historias.destroy');
            // Configuración Odontologo
            Route::match(['get', 'post'], '/configuracion', [OdontologoController::class, 'configuracion'])
                ->name('odontologo.configuracion');
            Route::get('/pedidos/{id}', [OdontologoController::class, 'showPedido']);
            Route::delete('/pedidos/{id}', [OdontologoController::class, 'destroyPedido']);

            // Gestión de Pedidos
            Route::view('/gestionPedidos', 'odontologo.GestionPedidos')
                ->name('odontologo.pedidos');
            Route::get('/pedidos', [OdontologoController::class, 'listarPedidos']);
        });

    // ASISTENTE
    Route::middleware(['auth','role:1,3'])->prefix('asistente')->group(function () {
        Route::get('/', [AsistenteController::class, 'index'])
            ->name('asistente');
        Route::get('citas', [CitasController::class, 'indexCitas'])
            ->name('asistente.citas.view');
        Route::get('citas/edit/{id}', [CitasController::class, 'edit'])
            ->name('asistente.citas.edit');
        Route::get('ahistorial', [CitasController::class, 'indexAhistorialPacientes'])
            ->name('asistente.ahistorial');
        Route::view('/aregistro', 'asistente.Aregistro')
            ->name('asistente.aregistro');
        Route::get('historial/{cedula}/pdf', [AsistenteController::class, 'descargarPDF'])
            ->name('asistente.historial.pdf');
        Route::match(['get', 'post'], 'configuracion2', [AsistenteController::class, 'configuracion2'])
            ->name('asistente.configuracion2');
    });

    // Rutas Laboratorista
    Route::prefix('laboratorista')
        ->middleware(['auth', 'role:1,4'])
        ->group(function () {
            Route::get('/', [LaboratoristaController::class, 'index'])
                ->name('laboratorista.dashboard');
            Route::get('/ordenes', [LaboratoristaController::class, 'ordenesHoy'])
                ->name('laboratorista.ordenes.hoy');
            Route::get('/orden/{id}', [LaboratoristaController::class, 'show'])
                ->name('laboratorista.orden.show');
            Route::post('/orden/{id}/estado', [LaboratoristaController::class, 'updateEstado'])
                ->name('laboratorista.orden.estado');
            Route::post('/orden/{id}/producto', [LaboratoristaController::class, 'addProducto'])
                ->name('laboratorista.orden.producto');
            Route::get('/ordenes/todos', [LaboratoristaController::class, 'all'])
                ->name('laboratorista.ordenes.todos');
            // Configuración Laboratorista
            Route::match(['get', 'post'], '/configuracion4', [LaboratoristaController::class, 'configuracion'])
                ->name('laboratorista.configuracion');
    });

    //Dueño
    // Configuración Dueño
    Route::middleware(['auth','role:5'])->match(['get', 'post'], 'api/dueno/configuracion', [DuenoController::class, 'configuracion'])
        ->name('dueno-configuracion');

    //RUTAS PROTEGIDAS GENERALES

    // Gestión de insumos(Administrador,odontologo y laboratorista)
    Route::get('/gestionInsumos',[GeneralController::class, 'insumos'])
        ->middleware(['auth', 'role:1,2,4'])
        ->name('gestion.insumos');
});
