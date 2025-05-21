<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Procedimientos | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h1>Procedimientos</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Formulario creación --}}
  <form action="{{ route('administrador.procedimientos.store') }}" method="POST" class="row g-2 mb-4">
    @csrf
    <div class="col-md-5">
      <input name="tipo_procedimiento" type="text" class="form-control" placeholder="Tipo de procedimiento" required>
    </div>
    <div class="col-md-3">
      <input name="costo" type="number" step="0.01" class="form-control" placeholder="Costo" required>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100"><i class="fas fa-plus"></i> Nuevo</button>
    </div>
  </form>

  {{-- Tabla --}}
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Procedimiento</th>
        <th>Costo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($procedimientos as $p)
      <tr>
        <td>{{ $p->id_procedimiento }}</td>
        <td>{{ $p->tipo_procedimiento }}</td>
        <td>{{ number_format($p->costo,2) }}</td>
        <td>
          <form action="{{ route('administrador.procedimientos.destroy', $p->id_procedimiento) }}"
                method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar?')">
              🗑
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <a href="{{ route('administrador.dashboard') }}" class="btn btn-outline-secondary">
    ← Volver al Dashboard
  </a>
</body>
</html>
