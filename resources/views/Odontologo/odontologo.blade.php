<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Odontólogo - Dental Flow</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/Sodontologo.css') }}">
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <nav class="bg-white border-end sidebar shadow-sm" id="sidebar-wrapper">
            <div class="sidebar-heading px-4 py-3 d-flex align-items-center gap-2">
                <img src="{{ asset('imagen/logo.png') }}" width="40" alt="Logo">
                <span><strong>Dental Flow</strong></span>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('odontologo.dashboard') }}" class="list-group-item list-group-item-action"><i
                        class="fas fa-home me-2"></i>Inicio</a>
                <a href="{{ route('odontologo.agenda') }}" class="list-group-item list-group-item-action"><i
                        class="fas fa-calendar-alt me-2"></i>Agenda</a>
                <a href="{{ route('odontologo.ordenes') }}" class="list-group-item list-group-item-action"><i
                        class="fas fa-calendar-alt me-2"></i>Órdenes</a>
                <a href="{{ route('odontologo.solicitud.form') }}" class="list-group-item list-group-item-action"><i
                        class="fas fa-tooth me-2"></i>Solicitar Prótesis</a>
                <a href="/gestionInsumos" class="list-group-item list-group-item-action"><i
                        class="fas fa-box-open me-2"></i>Insumos</a>
                <a href="{{ route('odontologo.configuracion') }}" class="list-group-item list-group-item-action"><i
                        class="fas fa-cog me-2"></i>Configuración</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="page-content-wrapper" class="w-100">

            <header class="odont-header shadow-sm px-4 py-3 d-flex justify-content-between align-items-center bg-light">
                <h4 class="text-primary m-0">Bienvenido, Dr. {{ Auth::user()->nombres_usuario }}👨‍⚕️</h4>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-secondary"><i class="fas fa-user"></i> Perfil</a>
                    <a href="/login" class="btn btn-outline-danger"><i class="fas fa-sign-out-alt"></i> Cerrar
                        Sesión</a>
                </div>
            </header>

            <main class="container-fluid py-4">

                <!-- Widget Día -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card stat-card text-center shadow-sm">
                            <div class="card-body">
                                <h5 class="text-muted">Citas Hoy</h5>
                                <h2 class="text-primary">{{ $totalCitas }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Citas -->
                <section class="card shadow-sm p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-calendar-check text-primary"></i> Próximas Citas</h4>
                        <a href="{{ route('odontologo.agenda') }}" class="btn btn-outline-primary"><i
                                class="fas fa-calendar-alt"></i> Ver
                            Agenda</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="citas-body">
                                <!-- Las filas llegarán vía JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Solicitudes y Órdenes -->
                <div class="row">
                    <div class="col-lg-6">
                        <section class="card shadow-sm p-4 mb-4">
                            <h4><i class="fas fa-file-medical text-info"></i> Órdenes</h4>
                            <p>Administra las órdenes generadas para tus pacientes.</p>
                            <a href="{{ route('odontologo.ordenes') }}" class="btn btn-outline-info mt-2"><i
                                    class="fas fa-folder-open"></i> Ir a
                                Órdenes</a>
                        </section>
                    </div>

                    <div class="col-lg-6">
                        <section class="card shadow-sm p-4 mb-4">
                            <h4><i class="fas fa-envelope-open-text text-dark"></i> Solicitudes</h4>
                            <p>Gestiona recursos y solicitudes de tratamientos.</p>
                            <div class="d-flex flex-wrap gap-3 mt-3">
                                <a href="/gestionInsumos" class="btn btn-outline-dark">
                                    <i class="fas fa-box-open"></i> Insumos
                                </a>
                                <a href="{{ route('odontologo.pedidos') }}" class="btn btn-outline-dark">
                                    <i class="fas fa-clipboard-list"></i> Pedidos
                                </a>
                                <a href="{{ route('odontologo.solicitud.form') }}" class="btn btn-outline-dark">
                                    <i class="fas fa-tooth"></i> Prótesis
                                </a>
                            </div>
                        </section>
                    </div>
                </div>
            </main>

            <footer class="text-center py-3 text-muted small">
                &copy; {{ date('Y') }} Dental Flow. Todos los derechos reservados.
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // 1) CSRF
                await fetch('/sanctum/csrf-cookie', {
                    credentials: 'include'
                });

                // 2) Consume el endpoint corregido
                const res = await fetch('/api/citas/hoy', {
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!res.ok) throw new Error(res.statusText);

                // 3) Parse y render
                const citas = await res.json();
                console.log('citas recibidas:', citas);

                const tbody = document.getElementById('citas-body');
                citas.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
        <td>${c.hora_cita}</td>
        <td>${c.nombre_completo_paciente}</td>
        <td>
          <span class="badge ${c.estado_cita === 'confirmada' ? 'text-bg-success' :
                            c.estado_cita === 'pendiente' ? 'text-bg-warning' :
                                c.estado_cita === 'cancelada' ? 'text-bg-danger' :
                                    'text-bg-primary'
                        }">${c.estado_cita}</span>
        </td>
        <td>
          <div class="btn-group">
            <button class="btn btn-sm btn-outline-success"><i class="fas fa-play"></i></button>
            <button class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></button>
            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
          </div>
        </td>`;
                    tbody.appendChild(tr);
                });
            } catch (err) {
                console.error('Error al cargar citas:', err);
            }
        });
    </script>




</body>

</html>