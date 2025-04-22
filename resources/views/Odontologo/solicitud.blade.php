<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Prótesis</title>
    <link rel="stylesheet" href="{{ asset('css/Ssolicitud.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
</head>
<body>
    <div class="solicitud-container">
        <header class="solicitud-header">
            <div class="logo-title">
                <img src="imagen/logo.png" alt="Dental Icon" class="dental-icon">
                <h1>Solicitud de Prótesis</h1>
            </div>
            <button class="print-button" onclick="window.print()" title="Imprimir">
                <img src="imagen/imprimir.png" alt="Imprimir">
            </button>
        </header>

        <form id="formulario-solicitud" class="solicitud-form">

            <div class="card-section">
                <h2>Información del Odontólogo</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label for="direccion">Dirección Odontológica</label>
                        <input type="text" id="direccion" class="input-field" placeholder="Escribe la dirección">
                    </div>
                    <div class="form-field">
                        <label for="telefono">Teléfono Odontológico</label>
                        <input type="text" id="telefono" class="input-field" placeholder="Escribe el teléfono">
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h2>Detalles de la Solicitud</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label for="fecha_solicitud">Fecha de Solicitud</label>
                        <input type="date" id="fecha_solicitud" class="input-field" readonly>
                    </div>
                    <div class="form-field">
                        <label for="fecha_limite">Fecha Límite</label>
                        <input type="date" id="fecha_limite" class="input-field">
                    </div>
                    <div class="form-field">
                        <label for="horario">Horario</label>
                        <select id="horario" class="input-field">
                            <option value="mañana">Mañana</option>
                            <option value="tarde">Tarde</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h2>Datos del Paciente</h2>
                <div class="form-row">
                    <div class="form-field">
                        <label for="paciente">Nombre del Paciente</label>
                        <input type="text" id="paciente" class="input-field">
                    </div>
                    <div class="form-field">
                        <label for="revisiones">Revisiones</label>
                        <input type="text" id="revisiones" class="input-field">
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h2>Tipo de Pedido / Material</h2>
                <div class="checkboxes">
                    @foreach(['Metal Porcelana', 'Zirconio', 'Prótesis Total', 'Prótesis Parcial', 'Ortodoncia', 'Superior', 'Inferior', 'Acrílico', 'Flexible'] as $tipo)
                        <label><input type="checkbox" name="tipo_protesis" value="{{ $tipo }}"> {{ $tipo }}</label>
                    @endforeach
                    <label>
                        <input type="checkbox" name="tipo_protesis" value="Otros"> Otros:
                    </label>
                    <input type="text" id="otros" class="input-field disabled-input" placeholder="Especificar" disabled>
                </div>
            </div>

            <div class="card-section">
                <h2>Otros Detalles</h2>
                <div class="form-row">
                    <div class="form-field full-width">
                        <label for="color">Color</label>
                        <input type="text" id="color" class="input-field" placeholder="Color deseado">
                    </div>
                    <div class="form-field full-width">
                        <label for="firma">Firma Autorizada</label>
                        <input type="file" id="firma" class="input-field" accept="image/*">
                        <img id="firma_preview" class="firma-preview" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="submit-button">Enviar Solicitud</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let hoy = new Date().toISOString().split('T')[0];
            document.getElementById("fecha_solicitud").value = hoy;
            document.getElementById("fecha_limite").setAttribute("min", hoy);

            const otrosCheckbox = document.querySelector("input[value='Otros']");
            const otrosInput = document.getElementById("otros");

            otrosCheckbox.addEventListener("change", () => {
                otrosInput.disabled = !otrosCheckbox.checked;
                otrosInput.classList.toggle("disabled-input", !otrosCheckbox.checked);
                if (otrosCheckbox.checked) otrosInput.focus();
            });

            document.getElementById("fecha_limite").addEventListener("input", function () {
                if (this.value < hoy) {
                    this.value = hoy;
                }
            });

            document.getElementById("firma").addEventListener("change", function (event) {
                let file = event.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        document.getElementById("firma_preview").src = e.target.result;
                        document.getElementById("firma_preview").style.display = "block";
                    };
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById("formulario-solicitud").addEventListener("submit", function (e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'success',
                    title: '¡Solicitud enviada!',
                    text: 'Tu solicitud ha sido registrada correctamente.',
                    confirmButtonColor: '#1E3A8A'
                });
            });
        });
    </script>
</body>
</html>
