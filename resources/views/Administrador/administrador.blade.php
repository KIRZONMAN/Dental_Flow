<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador | DentalFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Sadmin.css') }}">
</head>

<body>
    <header class="admin-header d-flex justify-content-between align-items-center flex-wrap p-3 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <img src="imagen/logo.png" alt="Logo DentalFlow" class="logo">
            <h1 class="titulo">Panel del Administrador</h1>
        </div>
        <div class="d-flex gap-2">
            <a href="/configuracion3" class="btn btn-outline-light rounded-pill">
                <i class="fas fa-cog me-1"></i> Configuración
            </a>
            <button class="btn btn-outline-light rounded-pill">
                <i class="fas fa-user me-1"></i> Perfil
            </button>
        </div>
    </header>

    <nav class="menu-admin container my-4">
        <section class="bienvenida text-center mb-5">
            <h2>Hola Administrador 👋</h2>
            <p>¡Bienvenido al panel de control de DentalFlow!</p>
        </section>
        <div class="row g-4 justify-content-center text-center">
            <div class="col-6 col-md-3">
                <a href="/api/gestionUsuarios" class="card-menu">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <div>Gestión de Usuarios</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/asistente" class="card-menu">
                    <i class="fas fa-user-nurse fa-2x mb-2"></i>
                    <div>Asistente</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/api/odontologo" class="card-menu">
                    <i class="fas fa-user-md fa-2x mb-2"></i>
                    <div>Odontólogo</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/api/dueno" class="card-menu">
                    <i class="fas fa-briefcase fa-2x mb-2"></i>
                    <div>Dueño</div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="/gestionProveedores" class="card-menu">
                    <i class="fas fa-boxes fa-2x mb-2"></i>
                    <div>Gestión de Proveedores</div>
                </a>
            </div>
        </div>
    </nav>

    <main class="container">
        <section class="seccion mt-5 text-center">
            <h3 class="titulo-seccion"><i class="fas fa-file-medical me-2"></i>Tabla usuarios activos</h3>
            <a href="/gestionarSolicitudes" class="btn btn-primary mt-3 rounded-pill px-4">
                Ver solicitudes
            </a>
        </section>
    </main>
</body>

</html>