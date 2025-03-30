<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/Sadmin.css') }}">

</head>

<body>
    <header class="d-flex justify-content-between align-items-center p-3 bg-light shadow-sm">
        <div class="d-flex align-items-center">
            <img src="imagen/logo.png" alt="Logo" width="50">
            <h4 class="ms-3">Panel Administrador</h4>
        </div>
        <div>
            <a href="/configuracion3" class="btn btn-outline-secondary me-2">
                <i class="fas fa-cog"></i> Configuración
            </a>
            <button class="btn btn-outline-primary"><i class="fas fa-user"></i> Perfil</button>
        </div>
    </header>

    <div class="d-flex align-items-center">
<a href="/gestionUsuarios">
<button id="boton_menu">Gestión de Usuarios</button>
</a>
<a href="/asistente">
<button id="boton_menu">Asistente</button>
</a>
<a href="/odontologo">
<button id="boton_menu">Odontólogo</button>
</a>
<a href="/cajero">
<button id="boton_menu">Cajero</button>
</a>
    </div>

    <main class="container mt-4">
        <h2 class="text-primary text-center">Hola Administrador [Nombre]👋</h2>

        <!-- Sección de Citas -->
        <section class="mt-4">
            <h3 class="text-secondary">Resumen del dia</h3>
    <div class="label-container">
        <div class="label success">
            <i>✅</i> Atendidas: 8
        </div>
        <div class="label danger">
            <i>❌</i> Canceladas: 2
        </div>
    </div>
    <div class="label-container">
        <div class="label warning">
            <i>🛑</i> Insumos Críticos: 3
        </div>
        <div class="label info">
            <i>📋</i> Órdenes Pendientes: 5
        </div>
    </div>
        </section>

        <!-- Sección de gestión -->
        <section class="ordenes mt-4 p-3 border rounded shadow-sm">
            <h3 class="text-secondary">Solicitudes Pendientes</h3>
            <a href="/gestionarSolicitudes" class="btn btn-outline-dark">
                <i class="fas fa-file-medical"></i> Ver solicitud
            </a>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</hmtl>
