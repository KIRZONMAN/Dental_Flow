{{-- resources/views/odontologo/solicitud.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solicitud de Prótesis</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/Ssolicitud.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
</head>

<body>
  <div class="container py-4 solicitud-container">

    <header class="solicitud-header d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
      <a href="{{ route('odontologo.dashboard') }}" class="btn btn-outline-secondary mb-2 mb-md-0">
        <i class="fas fa-arrow-left"></i> Volver
      </a>

      <div class="logo-title d-flex align-items-center mb-2 mb-md-0">
        <img src="{{ asset('imagen/logo.png') }}" alt="Dental Icon" class="dental-icon me-2">
        <h1 class="h5 m-0">Solicitud de Prótesis</h1>
      </div>

      <button class="print-button btn btn-primary mb-2 mb-md-0" onclick="window.print()" title="Imprimir">
        <img src="{{ asset('imagen/imprimir.png') }}" alt="Imprimir">
        <i class="fas fa-print"></i>
      </button>
    </header>

    @if (session('success'))
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: '{{ session('success') }}',
          confirmButtonColor: '#1E3A8A'
        });
      </script>
    @endif

    <form method="POST"
          action="{{ route('odontologo.solicitud.store') }}"
          enctype="multipart/form-data"
          id="formulario-solicitud"
          class="solicitud-form">
      @csrf

      {{-- 1) Selección de la cita confirmada --}}
      <section class="card-section mb-4">
        <h2>📌 Seleccione la Cita</h2>
        <div class="row">
          <div class="col-12">
            <label for="cita_id" class="form-label">Cita</label>
            <select name="cita_id" id="cita_id" class="form-select" required>
              <option value="">— Elige una cita —</option>
              @foreach ($citas as $c)
                <option value="{{ $c->id_cita }}">
                  {{ \Carbon\Carbon::parse($c->fecha_cita)->format('d/m/Y') }} •
                  {{ substr($c->hora_cita, 0, 5) }} •
                  {{ $c->paciente->nombre_completo_paciente }}
                </option>
              @endforeach
            </select>
            @error('cita_id')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </section>

      {{-- 2) Información del odontólogo --}}
      <section class="card-section mb-4">
        <h2>Información del Odontólogo</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label">Dirección Odontológica</label>
            <input type="text" class="form-control" value="{{ auth()->user()->direccion_usuario }}" disabled>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Teléfono Odontológico</label>
            <input type="text" class="form-control" value="{{ auth()->user()->telefono_usuario }}" disabled>
          </div>
        </div>
      </section>

      {{-- 3) Detalles de la solicitud --}}
      <section class="card-section mb-4">
        <h2>Detalles de la Solicitud</h2>
        <div class="row g-3">
          <div class="col-12 col-md-4">
            <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
            <input type="date" id="fecha_solicitud" name="fecha_solicitud" class="form-control"
                   value="{{ now()->toDateString() }}" readonly>
          </div>
          <div class="col-12 col-md-4">
            <label for="fecha_limite" class="form-label">Fecha Límite</label>
            <input type="date" id="fecha_limite" name="fecha_limite" class="form-control" required>
            @error('fecha_limite')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 col-md-4">
            <label for="horario" class="form-label">Horario</label>
            <select id="horario" name="horario" class="form-select" required>
              <option value="">— Seleccione —</option>
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
            </select>
            @error('horario')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </section>

      {{-- 4) Datos del Paciente --}}
      <section class="card-section mb-4">
        <h2>Datos del Paciente</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="nombre_paciente" class="form-label">Nombre del Paciente</label>
            <div id="nombre_paciente" class="form-control bg-light"></div>
          </div>
          <div class="col-12 col-md-6">
            <label for="revisiones" class="form-label">Revisiones</label>
            <input type="text" id="revisiones" name="otros_detalles" class="form-control"
                   placeholder="Describa detalles para el laboratorio" required>
            @error('otros_detalles')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </section>

      {{-- 5) Tipo de Pedido / Material --}}
      <section class="card-section mb-4">
        <h2>Tipo de Pedido / Material</h2>
        <div class="row g-2">
          @foreach (['Metal Porcelana','Zirconio','Prótesis Total','Prótesis Parcial','Ortodoncia','Superior','Inferior','Acrílico','Flexible'] as $tipo)
            <div class="col-6 col-md-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tipo_material[]" value="{{ $tipo }}"
                       id="mat_{{ Str::slug($tipo) }}">
                <label class="form-check-label" for="mat_{{ Str::slug($tipo) }}">
                  {{ $tipo }}
                </label>
              </div>
            </div>
          @endforeach
        </div>
        @error('tipo_material')
          <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
      </section>

      {{-- 6) Otros Detalles (Color, Firma) --}}
      <section class="card-section mb-4">
        <h2>Otros Detalles</h2>
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="color" class="form-label">Color</label>
            <input type="text" id="color" name="color" class="form-control" placeholder="Color deseado">
          </div>
          <div class="col-12 col-md-6">
            <label for="firma" class="form-label">Firma Autorizada</label>
            <input type="file" id="firma" name="firma" class="form-control" accept="image/*">
            <img id="firma_preview" class="firma-preview mt-2" style="display: none;">
          </div>
        </div>
      </section>

      {{-- 7) Botón de envío --}}
      <div class="d-flex justify-content-end">
        <button type="submit" class="submit-button btn btn-primary">Enviar Solicitud</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script>
    const citasData = @json(
      $citas->mapWithKeys(fn($c) => [ (string)$c->id_cita => $c->paciente->nombre_completo_paciente ])
    );
    document.getElementById('cita_id').addEventListener('change', function() {
      document.getElementById('nombre_paciente').textContent = citasData[this.value] ?? '';
    });
    document.addEventListener("DOMContentLoaded", () => {
      const hoy = new Date().toLocaleDateString('en-CA');
      document.getElementById("fecha_limite").setAttribute("min", hoy);
      document.getElementById("fecha_solicitud").value = hoy;
      document.getElementById("firma").addEventListener("change", function(e) {
        const reader = new FileReader();
        reader.onload = ev => {
          const img = document.getElementById('firma_preview');
          img.src = ev.target.result;
          img.style.display = 'block';
        };
        reader.readAsDataURL(e.target.files[0]);
      });
    });
  </script>
</body>

</html>
