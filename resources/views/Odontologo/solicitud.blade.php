<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitud de Prótesis</title>
    <link rel="stylesheet" href="{{ asset('css/Ssolicitud.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="solicitud-container">
        <header class="solicitud-header">
            <a href="{{ route('odontologo.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <div class="logo-title">
                <img src="{{ asset('imagen/logo.png') }}" alt="Dental Icon" class="dental-icon">
                <h1>Solicitud de Prótesis</h1>
            </div>
            <button class="print-button" onclick="window.print()" title="Imprimir">
                <img src="{{ asset('imagen/imprimir.png') }}" alt="Imprimir">
            </button>
        </header>

        {{-- Alerta de éxito --}}
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

        <form method="POST" action="{{ route('odontologo.solicitud.store') }}" enctype="multipart/form-data"
            id="formulario-solicitud" class="solicitud-form">
            @csrf

            {{-- 1) Selección de la cita confirmada --}}
            <div class="card-section">
                <h2>📌 Seleccione la Cita</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label for="cita_id">Cita</label>
                        <select name="cita_id" id="cita_id" class="input-field" required>
                            <option value="">— Elige una cita —</option>
                            @foreach ($citas as $c)
                                <option value="{{ $c->id_cita }}">
                                    {{ \Carbon\Carbon::parse($c->fecha_cita)->format('d/m/Y') }} •
                                    {{ substr($c->hora_cita, 0, 5) }}
                                    – {{ $c->paciente->nombre_completo_paciente }}
                                </option>
                            @endforeach
                        </select>
                        @error('cita_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 2) Información del odontólogo --}}
            <div class="card-section">
                <h2>Información del Odontólogo</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label>Dirección Odontológica</label>
                        <input type="text" class="input-field" value="{{ auth()->user()->direccion_usuario }}" disabled>
                    </div>
                    <div class="form-field">
                        <label>Teléfono Odontológico</label>
                        <input type="text" class="input-field" value="{{ auth()->user()->telefono_usuario }}" disabled>
                    </div>
                </div>
            </div>

            {{-- 3) Detalles de la solicitud --}}
            <div class="card-section">
                <h2>Detalles de la Solicitud</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label for="fecha_solicitud">Fecha de Solicitud</label>
                        <input type="date" id="fecha_solicitud" name="fecha_solicitud" class="input-field"
                            value="{{ now()->toDateString() }}" readonly>
                    </div>
                    <div class="form-field">
                        <label for="fecha_limite">Fecha Límite</label>
                        <input type="date" id="fecha_limite" name="fecha_limite" class="input-field" required>
                        @error('fecha_limite')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="horario">Horario</label>
                        <select id="horario" name="horario" class="input-field" required>
                            <option value="">— Seleccione —</option>
                            <option value="Mañana">Mañana</option>
                            <option value="Tarde">Tarde</option>
                        </select>
                        @error('horario')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 4) Datos del Paciente --}}
            <div class="card-section">
                <h2>Datos del Paciente</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label for="paciente">Nombre del Paciente</label>
                        <input type="text" id="paciente" class="input-field" disabled>
                    </div>
                    <div class="form-field">
                        <label for="revisiones">Revisiones</label>
                        <input type="text" id="revisiones" name="otros_detalles" class="input-field"
                            placeholder="Describa detalles para el laboratorio" required>
                        @error('otros_detalles')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- 5) Tipo de Pedido / Material --}}
            <div class="card-section">
                <h2>Tipo de Pedido / Material</h2>
                <div class="checkboxes">
                    @foreach (['Metal Porcelana', 'Zirconio', 'Prótesis Total', 'Prótesis Parcial', 'Ortodoncia', 'Superior', 'Inferior', 'Acrílico', 'Flexible'] as $tipo)
                        <label>
                            <input type="checkbox" name="tipo_material[]" value="{{ $tipo }}">
                            {{ $tipo }}
                        </label>
                    @endforeach
                    @error('tipo_material')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- 6) Otros Detalles (Color, Firma) --}}
            <div class="card-section">
                <h2>Otros Detalles</h2>
                <div class="form-row">
                    <div class="form-field full-width">
                        <label for="color">Color</label>
                        <input type="text" id="color" name="color" class="input-field" placeholder="Color deseado">
                    </div>
                    <div class="form-field full-width">
                        <label for="firma">Firma Autorizada</label>
                        <input type="file" id="firma" name="firma" class="input-field" accept="image/*">
                        <img id="firma_preview" class="firma-preview" style="display: none;">
                    </div>
                </div>
            </div>

            {{-- 7) Botón de envío --}}
            <div class="button-group">
                <button type="submit" class="submit-button">Enviar Solicitud</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        // Generamos un objeto { id_cita: nombre_completo_paciente, ... }
        // Después
        const citasData = @json($citas->pluck('paciente.nombre_completo_paciente', 'id_cita'));


        // Al cambiar la cita, ponemos el nombre
        document.getElementById('cita_id').addEventListener('change', function () {
            document.getElementById('paciente').value =
                citasData[this.value] ?? '';
        });

        document.addEventListener("DOMContentLoaded", () => {
            const hoy = new Date().toLocaleDateString('en-CA');
            document.getElementById("fecha_limite").setAttribute("min", hoy);
            document.getElementById("fecha_solicitud").value = hoy;

            // Vista previa de firma
            document.getElementById("firma").addEventListener("change", function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = ev => {
                        const img = document.getElementById('firma_preview');
                        img.src = ev.target.result;
                        img.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

</body>

</html>