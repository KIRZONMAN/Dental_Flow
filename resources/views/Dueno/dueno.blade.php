<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Dueño - Dental Flow</title>
    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/Cdueno.css') }}">
</head>

<body>

    <!-- HEADER -->
    <div class="d-flex gap-2">
    </div>
    <header class="header d-flex justify-content-between align-items-center px-4">
        <button class="btn text-white p-0" id="menu-toggle"><i class="fas fa-bars fa-lg"></i></button>
        <h1 class="h5 text-white m-0">Bienvenido, {{ Auth::user()->nombres_usuario }} dueño de la clínica</h1>
        <div class="d-flex align-items-center">
            <!-- NOTIFICACIONES -->
            <div class="dropdown me-3">
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifToggle">
                    <li><span class="dropdown-item">Sin notificaciones</span></li>
                </ul>
            </div>
            <!-- PERFIL / LOGOUT -->
            <div class="dropdown">
                <a class="text-white" href="#" id="userMenu" data-bs-toggle="dropdown"><i
                        class="fas fa-user-circle fa-2x"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <!-- Apunta a configuracion4 -->
                    <li>
                        <a class="dropdown-item">
                            Mi perfil
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <nav id="sidebar" class="sidebar collapsed">
        <div id="div-logo" class="sidebar-heading px-4 py-3 d-flex align-items-center gap-2">
            <img src="{{ asset('imagen/logo.png') }}" width="40" alt="Logo">
            <span><strong>Dental Flow</strong></span>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dueno.dashboard') }}" class="nav-link {{ request()->routeIs('dueno.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i>Página
                    principal
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('informe-clinica') }}"
                    class="nav-link {{ request()->routeIs('informe-clinica') ? 'active' : '' }}">
                    <i class="fas fa-list me-2"></i>Informe de la clínica
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ordenar-insumos') }}"
                    class="nav-link {{ request()->routeIs('ordenar-insumos') ? 'active' : '' }}">
                    <i class="fas fa-boxes me-2"></i>Gestionar y ordenar insumos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dueno-configuracion') }}"
                    class="nav-link {{ request()->routeIs('dueno-configuracion') ? 'active' : '' }}">
                    <i class="fas fa-cog me-2"></i>Configuración
                </a>
            </li>
        </ul>
    </nav>
    <!-- Main Content -->
    <div id="content" class="content">
        <main class="container-fluid py-4">
            <!-- Widget Día -->
            <div class="row g-3 mb-4">

                <div class="col-md-12">
                    <div class="card stat-card text-center shadow-sm">
                        <div class="card-body">
                            <h4>Rendimiento del personal</h4>
                            <div class="table-responsive">
                                <select name="rango" id="rango">
                                    <option value="hoy">Hoy</option>
                                    <option value="semana">Última semana</option>
                                    <option value="mes">Último mes</option>
                                </select>
                                <div id="contenido-conteo"></div>
                                <div id="paginacion" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>

            <!-- Citas -->
            <section class="card shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4><i class="fas fa-calendar-check text-primary"></i> Insumos</h4>
                </div>


                <!-- Solicitudes y Órdenes -->
                <div class="row">
                    <div class="col-lg-6">
                        <section class="card shadow-sm p-4 mb-4">
                            <h4><i class="fas fa-envelope-open-text text-dark"></i> Solicitudes</h4>
                            <p>Gestiona tus solicitudes pendientes</p>
                            <a href="/api/ordenar-insumos" class="btn btn-outline-info mt-2"><i
                                    class="fas fa-clipboard-list"></i> Ir a
                                Solicitudes</a>
                        </section>
                    </div>

                    <div class="col-lg-6">
                        <section class="card shadow-sm p-4 mb-4">
                            <h4><i class="fas fa-envelope-open-text text-dark"></i> ¡Insumos críticos!</h4>
                            <div class="table-responsive" id="insumos-criticos"></div>
                    </div>
                </div>
            </section>

            <!-- Finanzas -->
            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                    <section class="card shadow-sm p-4 mb-4">
                        <h4><i class="fas fa-envelope-open-text text-dark"></i>Finanzas</h4>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="table-light">
                                    <tr>
                                        <td class="fw-bold text-danger">Gastos</td>
                                        <td class="fw-bold text-danger">
                                            ${{ number_format($gastos, 2) }}</td>
                                        <!--ROJOS-->
                                    </tr>
                                    <td class="fw-bold text-success">Ingresos</td>
                                    <td class="fw-bold text-success">
                                        ${{ number_format($ingresos, 2) }}</t>
                                        <!--VERDES-->
                                        </tr>
                                    <td class="fw-bold text-primary">Balance</td>
                                    <td class="fw-bold
                                        @if ($ingresos - $gastos < 0)
                                            text-danger
                                        @else ($ingresos - $gastos > 0)
                                            text-success
                                        @endif
                                        "> ${{number_format($ingresos - $gastos, 2) }}
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>


        </main>

        <footer class="footer text-center py-3">
            <div class="container">
                &copy; {{ date('Y') }} Dental Flow. Todos los derechos reservados.
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>


<script>
    const sidebar = document.getElementById('sidebar'),
        toggle = document.getElementById('menu-toggle');
    toggle.addEventListener('click', () => sidebar.classList.toggle('collapsed'));
</script>

<!--Script para div de Rendimiento del personal-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selector = document.getElementById('rango');

        // Cargar datos inicialmente
        cargarDatos(buildUrl(1));

        // Al cambiar el rango
        selector.addEventListener('change', function () {
            cargarDatos(buildUrl(1)); // reinicia a página 1
        });
    });

    function buildUrl(page) {
        const rango = document.getElementById('rango').value;
        return `/api/dueno/rendimiento?limit=5&page=${page}&rango=${rango}`;
    }

    function cargarDatos(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                mostrarTabla(data.data);
                mostrarPaginacion(data);
            })
            .catch(() => {
                document.getElementById('contenido-conteo').innerHTML = '<p>Error cargando datos.</p>';
                document.getElementById('paginacion').innerHTML = '';
            });
    }

    function mostrarTabla(datos) {
        if (!datos || !Array.isArray(datos) || datos.length === 0) {
            document.getElementById('contenido-conteo').innerHTML = '<p>No hay datos para mostrar.</p>';
            return;
        }

        let html = `<table class="table table-hover mb-0 align-middle" style="margin-top: 15px;">
            <thead class="table-primary">
                <tr>
                    <th>Fecha</th>
                    <th>Odontólogo</th>
                    <th>Cantidad</th>
                    <th>Estado de la cita</th>
                    <th>Total de la cita</th>
                </tr>
            </thead>
            <tbody>`;

        datos.forEach(item => {
            const total = parseFloat(item.total_cita) || 0;
            html += `<tr>
                <td>${formatoFecha(item.fecha_cita)}</td>
                <td>${item.nombre_completo_odontologo}</td>
                <td>${item.cantidad}</td>
                <td>${item.estado_cita}</td>
                <td>$${total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            </tr>`;
        });

        html += `</tbody></table>`;
        document.getElementById('contenido-conteo').innerHTML = html;
    }

    function mostrarPaginacion(data) {
        let html = '';
        const rango = document.getElementById('rango').value;

        if (data.prev_page_url) {
            html += `<button id="anterior"  onclick="cargarDatos(buildUrl(${data.current_page - 1}))">Anterior</button>`;
        }

        html += ` Página ${data.current_page} de ${data.last_page} `;

        if (data.next_page_url) {
            html += `<button  id="siguiente" onclick="cargarDatos(buildUrl(${data.current_page + 1}))">Siguiente</button>`;
        }

        document.getElementById('paginacion').innerHTML = html;
    }

    function formatoFecha(fechaISO) {
        if (!fechaISO) return '';
        const [year, month, day] = fechaISO.split('-');
        return `${day}/${month}/${year}`;
    }
</script>


<!--Script para div de Insumos criticos-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        cargarInsumosCriticos();
    });

    function cargarInsumosCriticos() {
        fetch('/api/dueno/insumos')
            .then(response => response.json())
            .then(data => {
                document.getElementById('insumos-criticos').innerHTML = construirTablaInsumos(data.insumos);
            })
            .catch(() => {
                document.getElementById('insumos-criticos').innerHTML = '<p>Error cargando datos.</p>';
            });
    }

    function construirTablaInsumos(insumos) {
        if (!insumos.length) return '<p>No hay insumos críticos.</p>';

        const filas = insumos.map(insumo => {
            const costo = insumo.costo_insumo !== null
                ? `$${parseFloat(insumo.costo_insumo).toLocaleString('es-ES', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}`
                : 'No disponible';
            return `
        <tr>
            <td>${insumo.nombre_insumo}</td>
            <td>${costo}</td>
            <td class="fw-bold text-danger">${insumo.cantidad_insumo}</td>
            <td class="fw-bold text-success">${insumo.cantidad_aprobada}</td> <!-- cantidad aprobada -->
        </tr>
        `;
        }).join('');

        return `
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-primary">
            <tr>
                <th>Nombre</th>
                <th>Costo</th>
                <th>Cantidad actual</th>
                <th>Cantidad aprobada</th>
            </tr>
        </thead>
        <tbody>
            ${filas}
        </tbody>
    </table>
    `;
    }

</script>



</html>
