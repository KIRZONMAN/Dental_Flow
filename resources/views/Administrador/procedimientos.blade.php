<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Procedimientos | Administrador</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('administrador.dashboard') }}">
        <i class="fas fa-tooth me-1"></i> DentalFlow Admin
      </a>
    </div>
  </nav>

  <main class="container py-4">

    <!-- Título y botón volver juntos en móvil y desktop -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
      <h1 class="h3 mb-3 mb-md-0">Procedimientos</h1>
      <a href="{{ route('administrador.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
      </a>
    </div>

    <!-- Mensajes de sesión -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif

    <div class="row g-4">
      <!-- Formulario creación -->
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Procedimiento
          </div>
          <div class="card-body">
            <form action="{{ route('administrador.procedimientos.store') }}" method="POST" class="row g-3">
              @csrf
              <div class="col-12 col-md-6">
                <label for="tipo_procedimiento" class="form-label">Tipo de procedimiento</label>
                <input id="tipo_procedimiento" name="tipo_procedimiento" type="text"
                       class="form-control" placeholder="Ej: Limpieza dental" required>
              </div>
              <div class="col-12 col-md-4">
                <label for="costo" class="form-label">Costo</label>
                <input id="costo" name="costo" type="number" step="0.01"
                       class="form-control" placeholder="0.00" required>
              </div>
              <div class="col-12 col-md-2 d-grid">
                <button type="submit" class="btn btn-primary mt-4">
                  <i class="fas fa-check me-1"></i> Guardar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Tabla de procedimientos -->
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <i class="fas fa-list me-1"></i> Listado de Procedimientos
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Procedimiento</th>
                    <th>Costo</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($procedimientos as $p)
                    <tr>
                      <td>{{ $p->id_procedimiento }}</td>
                      <td>{{ $p->tipo_procedimiento }}</td>
                      <td>$ {{ number_format($p->costo, 2) }}</td>
                      <td class="text-center">
                        <form action="{{ route('administrador.procedimientos.destroy', $p->id_procedimiento) }}"
                              method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este procedimiento?');"
                              class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  @if($procedimientos->isEmpty())
                    <tr>
                      <td colspan="4" class="text-center text-muted py-3">
                        No hay procedimientos registrados.
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
