<?php

use App\Http\Controllers\CitaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
Route::get('/citas_asesoria', function () {
    return view('plantilla_asesoria');
});

// Definir rutas correctamente estructuradas
Route::get('/administrador', function () {
    return view('administrador', ['title' => 'Administrador']);
});

Route::get('/agenda', function () {
    return view('agenda', ['title' => 'Agenda']);
});

Route::get('/ahistorial', function () {
    return view('Ahistorial', ['title' => 'Historial']);
});

Route::get('/aregistro', function () {
    return view('Aregistro', ['title' => 'Registro']);
});

Route::get('/asistente', function () {
    return view('asistente', ['title' => 'Asistente']);
});

Route::get('/cajero', function () {
    return view('cajero', ['title' => 'Cajero']);
});

Route::get('/ccontable', function () {
    return view('Ccontable', ['title' => 'Contable']);
});

Route::get('/cestadistico', function () {
    return view('Cestadistico', ['title' => 'Estadístico']);
});

Route::get('/cformulario', function () {
    return view('Cformulario', ['title' => 'Formulario']);
});

Route::get('/citas', function () {
    return view('Citas', ['title' => 'Citas']);
});

Route::get('/configuracion', function () {
    return view('configuracion', ['title' => 'Configuración']);
});

Route::get('/configuracion2', function () {
    return view('configuracion2', ['title' => 'Configuración 2']);
});

Route::get('/configuracion3', function () {
    return view('configuracion3', ['title' => 'Configuración 3']);
});

Route::get('/gestionarSolicitudes', function () {
    return view('gestionarSolicitudes', ['title' => 'Gestionar Solicitudes']);
});

Route::get('/solicitud', function () {
    return view('solicitud', ['title' => 'solicitud']);
});

Route::get('/gestionInsumos', function () {
    return view('gestionInsumos', ['title' => 'Gestión de Insumos']);
});

Route::get('/gestionPedidos', function () {
    return view('GestionPedidos', ['title' => 'Gestión de Pedidos']);
});

Route::get('/gestionUsuarios', function () {
    return view('gestionUsuarios', ['title' => 'Gestión de Usuarios']);
});

Route::get('/historias', function () {
    return view('historias', ['title' => 'Historias']);
});

Route::get('/login', function () {
    return view('login', ['title' => 'Login']);
});

Route::get('/odontologo', function () {
    return view('odontologo', ['title' => 'Odontólogo']);
});

Route::get('/ordenes', function () {
    return view('ordenes', ['title' => 'Órdenes']);
});

Route::get('/plantilla', function () {
    return view('plantilla', ['title' => 'Plantilla']);
});

Route::get('/plantillaSubMenu', function () {
    return view('plantillaSubMenu', ['title' => 'Plantilla Submenú']);
});

Route::get('/procesar_registro', function () {
    return view('procesar_registro', ['title' => 'Procesar Registro']);
});

Route::get('/registrar', function () {
    return view('registrar', ['title' => 'Registrar']);
});