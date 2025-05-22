<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel Asistente - DentalFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Sasistente.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Menú superior -->
    <header class="header shadow-sm d-flex justify-content-between align-items-center px-4 py-3">
        <div class="menu-toggle" id="menu-toggle">&#9776;</div>
        <h1 class="text-white fs-4 fw-semibold m-0">Panel Asistente</h1>
        <div class="text-white fs-6">{{ date('d/m/Y') }}</div>
    </header>

    <!-- Menú lateral -->
    <nav id="sidebar" class="sidebar">
        <a href="{{ route('asistente') }}" class="sidebar-link">🏠 Panel Principal</a>
        <a href="{{ route('asistente.citas.view') }}" class="sidebar-link">📅 Ver Citas</a>
        <a href="{{ route('asistente.ahistorial') }}" class="sidebar-link">📋 Historial</a>
        <a href="{{ route('asistente.aregistro') }}" class="sidebar-link">📝 Registrar Paciente</a>
        <a href="/asistente/configuracion2" class="sidebar-link">⚙️ Configuración</a>
        <div class="form-container">
            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <div id="content" class="content transition-all">
        <!-- 1) Carrusel dinámico -->
        <section class="carousel-container">
            @php
                $rolTexto = match (Auth::user()->rol_id) {
                    1 => 'Administrador',
                    3 => 'Asistente',
                    default => 'Usuario',
                };
            @endphp
            <h5 id="mensaje">Bienvenido, {{ $rolTexto }} {{ Auth::user()->nombres_usuario }} 👋</h5>
            <h2 class="section-title">Citas del Día</h2>
            <div class="carousel-wrapper">
                <button class="carousel-control left" onclick="scrollCarousel(-1)">&#8592;</button>
                <div class="carousel-scroll" id="carousel">
                    @foreach ($citasHoy as $cita)
                        <button class="btn-cita" onclick="loadInterface({{ $cita->id_cita }})">
                            🕐 {{ \Carbon\Carbon::parse($cita->hora_cita)->format('H:i') }}
                        </button>
                    @endforeach
                </div>
                <button class="carousel-control right" onclick="scrollCarousel(1)">&#8594;</button>
            </div>
        </section>

        <!-- 2) Detalles -->
        <main class="main-section container my-4">
            <div id="main-content" class="card shadow p-4">
                <h5 class="text-center text-muted">Selecciona una cita para ver los detalles</h5>
            </div>
        </main>
    </div>

    <!-- 3) Preparamos los datos en PHP para inyectar JSON limpio -->
    @php
        $citasData = $citasHoy->mapWithKeys(function ($c) {
            return [
                $c->id_cita => [
                    'paciente' => $c->paciente_nombre,
                    'odontologo' => $c->odontologo_nombre,
                    'motivo' => $c->motivo_cita,
                    'estado' => ucfirst($c->estado_cita),
                    'notas' => 'Sin notas',
                ],
            ];
        });
    @endphp

    <!-- 4) Scripts dinámicos -->
    <script>
        // Ahora esto inyecta un objeto JS válido sin confundir a Blade
        const citasDetalles = @json($citasData);

        function loadInterface(id) {
            const data = citasDetalles[id];
            const box = document.getElementById('main-content');
            box.style.opacity = 0;
            setTimeout(() => {
                box.innerHTML = `
          <h4 class="mb-3 text-primary">📋 Detalles de la Cita</h4>
          <p><strong>Paciente:</strong>   ${data.paciente}</p>
          <p><strong>Odontólogo:</strong> ${data.odontologo}</p>
          <p><strong>Motivo:</strong>     ${data.motivo}</p>
          <p><strong>Estado:</strong>     <span class="estado">${data.estado}</span></p>
          <p><strong>Notas:</strong>      ${data.notas}</p>
        `;
                box.style.opacity = 1;
            }, 200);
        }

        function scrollCarousel(dir) {
            document.getElementById('carousel').scrollBy({
                left: dir * 200,
                behavior: 'smooth'
            });
        }
        // Toggle del sidebar (sin cambios)
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('shrink');
        });
    </script>
</body>

</html>