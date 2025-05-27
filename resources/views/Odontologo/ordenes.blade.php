{{-- resources/views/odontologo/ordenes.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Órdenes</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/Sordenes.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="ordenes-body">
  <div class="container py-4 ordenes-container">

    <div class="mb-3">
      <a href="{{ route('odontologo.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
      </a>
    </div>

    <header class="ordenes-header text-center mb-4">
      <h1 class="ordenes-title">Órdenes del Paciente</h1>
      <p class="ordenes-subtitle">Gestiona y crea nuevas órdenes o recetas fácilmente</p>
    </header>

    <main class="ordenes-main">
      <div class="row g-4">
        <!-- Nueva Orden -->
        <div class="col-12 col-lg-6">
          <section class="order-section fade-in h-100">
            <h2><i class="fas fa-clipboard-list me-2"></i>Nueva Orden</h2>
            <form id="form-orden">
              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <label for="paciente" class="form-label">Paciente:</label>
                  <input type="text" id="paciente" placeholder="Ej. Juan Pérez" class="form-control fancy-input">
                </div>
                <div class="col-12 col-md-6">
                  <label for="tipo" class="form-label">Tipo de Orden:</label>
                  <input type="text" id="tipo" placeholder="Ej. Examen, Rayos X..." class="form-control fancy-input">
                </div>
                <div class="col-12">
                  <label for="descripcion" class="form-label">Descripción:</label>
                  <textarea id="descripcion" class="form-control fancy-input" rows="4"
                    placeholder="Detalle la orden médica..."></textarea>
                </div>
              </div>
            </form>
          </section>
        </div>

        <!-- Nueva Receta Médica -->
        <div class="col-12 col-lg-6">
          <section class="prescription-section fade-in h-100">
            <h2><i class="fas fa-pills me-2"></i>Nueva Receta Médica</h2>
            <form id="form-receta">
              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <label for="paciente-receta" class="form-label">Paciente:</label>
                  <input type="text" id="paciente-receta" placeholder="Ej. Ana Martínez" class="form-control fancy-input">
                </div>
                <div class="col-12 col-md-6">
                  <label for="medicamento" class="form-label">Medicamento:</label>
                  <input type="text" id="medicamento" placeholder="Nombre del medicamento" class="form-control fancy-input">
                </div>
                <div class="col-12 col-md-6">
                  <label for="dosis" class="form-label">Dosis:</label>
                  <input type="text" id="dosis" placeholder="Cantidad (mg)" class="form-control fancy-input">
                </div>
                <div class="col-12 col-md-6">
                  <label for="frecuencia" class="form-label">Frecuencia:</label>
                  <input type="text" id="frecuencia" placeholder="Ej. 2 veces al día" class="form-control fancy-input">
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>

      <footer class="ordenes-footer fade-in d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
        <button class="btn btn-success btn-lg shadow-sm" onclick="guardarHistoria()">
          <i class="fas fa-save me-1"></i> Guardar en Historia
        </button>
        <button class="btn btn-primary btn-lg shadow-sm" onclick="imprimirReceta()">
          <i class="fas fa-print me-1"></i> Imprimir Receta
        </button>
        <button class="btn btn-secondary btn-lg shadow-sm" onclick="enviarDatos()">
          <i class="fas fa-paper-plane me-1"></i> Enviar
        </button>
      </footer>
    </main>
  </div>

  <script>
    function guardarHistoria() {
      Swal.fire({
        icon: 'success',
        title: 'Orden guardada',
        text: 'La orden ha sido guardada exitosamente en la historia clínica.',
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Entendido'
      });
    }

    function imprimirReceta() {
      Swal.fire({
        icon: 'info',
        title: 'Preparando Receta',
        text: 'La receta está siendo preparada para impresión.',
        confirmButtonColor: '#007bff',
        confirmButtonText: 'Aceptar'
      });
    }

    function enviarDatos() {
      Swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        text: 'Estás a punto de enviar esta información.',
        showCancelButton: true,
        confirmButtonColor: '#6c757d',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            icon: 'success',
            title: 'Enviado',
            text: 'La información fue enviada correctamente.',
            confirmButtonColor: '#6c757d'
          });
        }
      });
    }
  </script>
</body>

</html>
