<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agenda de Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/agenda_hc.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="agenda-body">

    <div class="container py-5">
        <div class="text-center mb-5 animate__animated animate__fadeInDown">
            <h1 class="agenda-title">📅 Agenda de Pacientes</h1>
            <p class="agenda-subtitle">Consulta, organiza y accede a la historia clínica de tus pacientes</p>
        </div>

        <div class="card shadow-lg p-4 mb-4 animate__animated animate__fadeIn">
            <form method="POST" action="" class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
                <input type="text" name="buscar_paciente" placeholder="🔍 Buscar paciente por nombre" class="form-control agenda-search-input w-75">
                <button type="submit" class="btn btn-primary agenda-search-button">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </form>
        </div>

        <div class="table-responsive animate__animated animate__fadeInUp">
            <table class="table table-hover text-center align-middle shadow-sm rounded agenda-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Paciente</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">📄 Historia</th>
                    </tr>
                </thead>
                <tbody class="agenda-table-body">
                    @foreach ($pacientes as $paciente)
                                    <tr>
                                        <td>{{ $paciente->cedula }}</td>
                                        <td>{{ $paciente->nombre_completo_paciente }}</td>
                                        <td>{{ $paciente->telefono_paciente }}</td>
                                        <td>
                                            <div class="btn-group">
                                            <a href="/api/historias" class="btn btn-outline-info">
                                                <i class="fas fa-notes-medical"></i> Ver Historia
                                                <button class="btn btn-sm btn-outline-success"><i
                                                        class="fas fa-play"></i></button>
                                                        </a>
                                            </div>
                                        </td>
                                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
