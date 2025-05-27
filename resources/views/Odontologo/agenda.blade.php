<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agenda de Pacientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
  <link rel="stylesheet" href="{{ asset('css/agenda_hc.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="agenda-body">
  <div class="container py-5">

    <div class="mb-4">
      <a href="{{ route('odontologo.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
      </a>
    </div>

    <div class="text-center mb-5 animate__animated animate__fadeInDown">
      <h1 class="agenda-title">📅 Agenda de Pacientes</h1>
      <p class="agenda-subtitle">Consulta, organiza y accede a la historia clínica de tus pacientes</p>
    </div>

    <div class="card shadow-lg p-4 mb-4 animate__animated animate__fadeIn">
      <form method="GET" action="{{ route('odontologo.agenda') }}"
            class="row g-3 justify-content-center align-items-center">
        <div class="col-12 col-md-8">
          <input type="text"
                 name="buscar_paciente"
                 value="{{ request('buscar_paciente') }}"
                 placeholder="🔍 Buscar paciente por nombre"
                 class="form-control agenda-search-input w-100">
        </div>
        <div class="col-12 col-md-2 d-grid">
          <button type="submit" class="btn btn-primary agenda-search-button w-100">
            <i class="fas fa-search me-1"></i> Buscar
          </button>
        </div>
      </form>
    </div>

    <div class="table-responsive animate__animated animate__fadeInUp">
      <table class="table table-hover text-center align-middle shadow-sm rounded agenda-table mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col">Cédula</th>
            <th scope="col">Paciente</th>
            <th scope="col">Teléfono</th>
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
                <a href="{{ route('odontologo.historias.list', ['cedula' => $paciente->cedula]) }}"
                   class="btn btn-outline-info btn-sm">
                  <i class="fas fa-notes-medical me-1"></i> Ver Historia
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      @if($pacientes->isEmpty())
        <div class="text-center text-muted py-4">
          No se encontraron pacientes.
        </div>
      @endif
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
