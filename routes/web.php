<?php

use App\Http\Controllers\Api\ApiDuenoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\pa_ActProveedorController;
use App\Http\Controllers\Api\CitasControllerApi;
use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\LaboratoristaController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\Api\ApiAdministradorController;
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
            Route::match(['get', 'post'], '/configuracion3', [ApiAdministradorController::class, 'configuracion3'])
                ->name('administrador.configuracion3');

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
            Route::get('usuarios/create', [ApiAdministradorController::class, 'VistaAgregarUsuario']);
            Route::post('usuarios', [ApiAdministradorController::class, 'agregarUsuario']);

            // Mostrar formulario de edición
            Route::get('usuarios/{id}/edit', [ApiAdministradorController::class, 'edit'])
                ->name('usuarios.edit');
            // Procesar la actualización
            Route::put('usuarios/{id}', [ApiAdministradorController::class, 'update'])
                ->name('usuarios.update');

            //Eliminar usuario
            Route::delete('gestionUsuarios/{id}', [ApiAdministradorController::class, 'eliminarUsuario']);
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

            // Agenda, historias y configuración, que ya tenías
            Route::get('/agenda', [CitasControllerApi::class, 'indexAgendaBusqueda'])
                ->name('odontologo.agenda');
            Route::get('/odontologo/historias/{cedula}', [CitasControllerApi::class, 'indexHistorias'])
                ->name('odontologo.historias');
            // Listado de historias clínicas de un paciente
            Route::get('/odontologo/historias/{cedula}/list', [HistoriaClinicaController::class, 'index'])
                ->middleware(['auth', 'role:2'])->name('odontologo.historias.list');

            // Borrado de una historia concreta (dispara trigger 17)
            Route::delete('/historias/{id}', [HistoriaClinicaController::class, 'destroy'])
                ->name('odontologo.historias.destroy');
            // Configuración Odontologo
            Route::match(['get', 'post'], '/configuracion', [OdontologoController::class, 'configuracion'])
                ->name('odontologo.configuracion');

            // Gestión de Pedidos
            Route::view('/gestionPedidos', 'odontologo.GestionPedidos')
                ->name('odontologo.pedidos');
        });

    // ASISTENTE
    Route::middleware(['auth','role:3'])->prefix('asistente')->group(function () {
        Route::get('/', [AsistenteController::class, 'index'])
            ->name('asistente');
        Route::get('citas', [CitasControllerApi::class, 'indexCitas'])
            ->name('asistente.citas.view');
        Route::get('citas/edit/{id}', [CitasControllerApi::class, 'edit'])
            ->name('asistente.citas.edit');
        // Aquí llamamos al controlador que prepara $pacientes:
        Route::get('ahistorial', [CitasControllerApi::class, 'indexAhistorialPacientes'])
            ->name('asistente.ahistorial');
        Route::view('aregistro', 'asistente.Aregistro')
            ->name('asistente.aregistro');
        // descarga la historia clínica en PDF
        Route::get('historial/{cedula}/pdf', [AsistenteController::class, 'descargarPDF'])
            ->name('asistente.historial.pdf');
        Route::match(['get', 'post'], 'configuracion2', [AsistenteController::class, 'configuracion2'])
            ->name('asistente.configuracion2');
    });


    // Configuración Dueño
    Route::middleware(['auth','role:5'])->match(['get', 'post'], 'api/dueno/configuracion', [ApiDuenoController::class, 'configuracion'])
        ->name('dueno-configuracion');
});




// Registro / Historial pacientes (API → web)
Route::post('/postaregistro', [CitasControllerApi::class, 'storePaciente'])->name('postaregistro');
Route::get(
    '/aregistro',
    [\App\Http\Controllers\Api\CitasControllerApi::class, 'indexAregistro']
);


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
        Route::get('/insumos', [LaboratoristaController::class, 'insumos'])
            ->name('laboratorista.insumos');
        Route::post('/orden/{id}/producto', [LaboratoristaController::class, 'addProducto'])
            ->name('laboratorista.orden.producto');
        Route::get('/ordenes/todos', [LaboratoristaController::class, 'all'])
            ->name('laboratorista.ordenes.todos');
        // Mostrar formulario de edición
        Route::get('usuarios/{id}/edit', [ApiAdministradorController::class, 'edit'])
            ->name('usuarios.edit');
        // Procesar la actualización
        Route::put('usuarios/{id}', [ApiAdministradorController::class, 'update'])
            ->name('usuarios.update');
        // Configuración Laboratorista
        Route::match(['get', 'post'], '/configuracion4', [LaboratoristaController::class, 'configuracion'])
            ->name('laboratorista.configuracion');
    });

// Gestión de insumos(Administrador,odontologo y laboratorista)
Route::get('/gestionInsumos',[LaboratoristaController::class, 'insumos'])
    ->middleware(['auth', 'role:1,2,4'])
    ->name('gestion.insumos');

//Falta catalogar
Route::get('pedidos', [OdontologoController::class, 'listarPedidos']);
Route::get('pedidos/{id}', [OdontologoController::class, 'showPedido']);
Route::delete('pedidos/{id}', [OdontologoController::class, 'destroyPedido']);
