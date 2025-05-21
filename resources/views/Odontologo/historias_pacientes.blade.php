<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial de Pacientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="p-5">
  <h1 class="mb-4">📋 Pacientes con Historias Clínicas</h1>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nombre</th><th>Cédula</th><th>Teléfono</th><th>Acción</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pacientes as $p)
        <tr>
          <td>{{ $p->nombre_completo_paciente }}</td>
          <td>{{ $p->cedula }}</td>
          <td>{{ $p->telefono_paciente }}</td>
          <td>
            <a href="{{ route('odontologo.historias.list', $p->cedula) }}" class="btn btn-sm btn-primary">
              Ver historias
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <a href="{{ route('odontologo.dashboard') }}" class="btn btn-outline-secondary">
    ← Volver al panel
  </a>
</body>
</html>
