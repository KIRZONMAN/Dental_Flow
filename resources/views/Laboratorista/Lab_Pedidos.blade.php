<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos de Laboratorio – DentalFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/CLab_Pedidos.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- HEADER -->
    <header class="header d-flex justify-content-between align-items-center px-4">
        <button class="btn text-white p-0" id="menu-toggle"><i class="fas fa-bars fa-lg"></i></button>
        <h1 class="h5 text-white m-0">Pedidos de Laboratorio</h1>
        <div class="d-flex align-items-center">
            <!-- NOTIFICACIONES -->
            <div class="dropdown me-3">
                <button class="btn btn-link position-relative p-0 text-white" id="notifToggle"
                    data-bs-toggle="dropdown">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="notification-count">3</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifToggle">
                    <li><span class="dropdown-item">Sin notificaciones</span></li>
                </ul>
            </div>
            <!-- PERFIL / LOGOUT -->
            <div class="dropdown">
                <a class="text-white" href="#" id="userMenu" data-bs-toggle="dropdown"><i
                        class="fas fa-user-circle fa-2x"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li>
                        <a class="dropdown-item" href="{{ route('laboratorista.configuracion4') }}">
                            Mi perfil
                        </a>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <nav id="sidebar" class="sidebar collapsed">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('laboratorista.dashboard') }}"
                    class="nav-link {{ request()->routeIs('laboratorista.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i>Regresar a Inicio
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laboratorista.ordenes.hoy') }}"
                    class="nav-link {{ request()->routeIs('laboratorista.ordenes.hoy') ? 'active' : '' }}">
                    <i class="fas fa-list me-2"></i>Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('gestion.insumos') }}"
                    class="nav-link {{ request()->routeIs('gestion.insumos') ? 'active' : '' }}">
                    <i class="fas fa-boxes me-2"></i>Insumos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('laboratorista.config') }}"
                    class="nav-link {{ request()->routeIs('laboratorista.config') ? 'active' : '' }}">
                    <i class="fas fa-cog me-2"></i>Configuración
                </a>
            </li>
        </ul>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main id="content" class="content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h2 class="h5 m-0">Todos los Pedidos</h2>
                <input type="search" id="search" class="form-control form-control-sm w-auto"
                    placeholder="Buscar...">
            </div>
            <div class="table-responsive bg-white shadow-sm rounded">
                <table class="table table-hover lab-pedidos-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cita</th>
                            <th>Paciente</th>
                            <th>Odontólogo</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordenes as $pedido)
                            <tr>
                                <td>{{ $pedido->id_orden_lab }}</td>
                                <td>{{ \Carbon\Carbon::parse($pedido->cita->fecha_cita . ' ' . $pedido->cita->hora_cita)->format('d/m/Y H:i') }}</td>
                                <td>{{ $pedido->cita->paciente->nombres_paciente }}</td>
                                <td>{{ $pedido->cita->odontologo->nombres_usuario }}</td>
                                <td>
                                    <span class="badge badge-estado-{{ Str::slug($pedido->estado) }}">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('laboratorista.orden.show', $pedido->id_orden_lab) }}"
                                        class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $ordenes->links() }}
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar'),
            toggle = document.getElementById('menu-toggle');
        toggle.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
    </script>
</body>

</html>
