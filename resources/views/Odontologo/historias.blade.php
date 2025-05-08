<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historia del Paciente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/agenda_hc.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="agenda-body">

    <div class="container py-5 animate__animated animate__fadeIn">
        <div class="card shadow-lg p-4 rounded-4">
            <div class="text-center mb-4">
                <h1 class="agenda-title">📝 Historia Clínica</h1>
                <p class="agenda-subtitle">Detalles del historial médico del paciente</p>
            </div>

            <div class="mb-4">
                @foreach ($pacientes as $paciente)
                <p class="fs-5"><strong><i class="fas fa-user"></i> Nombre del Paciente:</strong> {{ $paciente->nombre_completo_paciente }}</p>
                <p class="fs-5"><strong><i class="fas fa-calendar-day"></i> Cedula:</strong> {{ $paciente->cedula }}</p>
                <p class="fs-5"><strong><i class="fas fa-notes-medical"></i> Notas(MAL):</strong>{{ $paciente->telefono_paciente }}</p>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                <a href="agenda" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                    <i class="fas fa-arrow-left"></i> Volver a la Agenda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
