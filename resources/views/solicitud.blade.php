<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitud de Prótesis</title>
    <link rel="stylesheet" href="{{ asset('css/Ssolicitud.css') }}">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Establecer la fecha actual en el campo de fecha de solicitud
            let hoy = new Date().toISOString().split('T')[0];
            document.getElementById("fecha_solicitud").value = hoy;
            document.getElementById("fecha_limite").setAttribute("min", hoy);

            // Bloquear la escritura en "Otros" hasta que se active el checkbox
            let otrosCheckbox = document.querySelector("input[value='Otros']");
            let otrosInput = document.getElementById("otros");
            otrosInput.disabled = !otrosCheckbox.checked;

            otrosCheckbox.addEventListener("change", function () {
                otrosInput.disabled = !this.checked;
                if (this.checked) otrosInput.focus();
            });

            // Prevenir fechas anteriores en "Fecha límite"
            document.getElementById("fecha_limite").addEventListener("input", function () {
                if (this.value < hoy) {
                    this.value = hoy;
                }
            });

            // Manejar la carga y visualización de la firma
            document.getElementById("firma").addEventListener("change", function (event) {
                let file = event.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("firma_preview").src = e.target.result;
                        document.getElementById("firma_preview").style.display = "block";
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <header>
            <img src="imagen/logo.png" alt="Dental Icon" class="dental-icon">
            <h1>Solicitud de prótesis</h1>
            <button class="print-button" onclick="window.print()" title="Imprimir">
                <img src="imagen/imprimir.png" alt="Print Icon">
            </button>
        </header>

        <form>
            <div class="form-section">
                <label for="direccion">Dirección Odontológica:</label>
                <input type="text" id="direccion" placeholder="Escribir" class="input-field">

                <label for="telefono">Teléfono Odontológico:</label>
                <input type="text" id="telefono" placeholder="Escribir" class="input-field">
            </div>

            <div class="form-section">
                <label for="fecha_solicitud">Fecha de solicitud:</label>
                <input type="date" id="fecha_solicitud" class="input-field" readonly>

                <label for="fecha_limite">Fecha límite:</label>
                <input type="date" id="fecha_limite" class="input-field">

                <label for="horario">Horario:</label>
                <select id="horario" class="input-field">
                    <option value="mañana">Mañana</option>
                    <option value="tarde">Tarde</option>
                </select>
            </div>

            <div class="form-section">
                <label for="paciente">Paciente:</label>
                <input type="text" id="paciente" class="input-field">

                <label for="revisiones">Revisiones:</label>
                <input type="text" id="revisiones" class="input-field">
            </div>

            <div class="form-section checkboxes">
                <p><strong>Tipo de pedido / material:</strong></p>
                <label><input type="checkbox" name="tipo_protesis" value="Metal Porcelana"> Metal Porcelana</label>
                <label><input type="checkbox" name="tipo_protesis" value="Zirconio"> Zirconio</label>
                <label><input type="checkbox" name="tipo_protesis" value="Prótesis Total"> Prótesis Total</label>
                <label><input type="checkbox" name="tipo_protesis" value="Prótesis Parcial"> Prótesis Parcial</label>
                <label><input type="checkbox" name="tipo_protesis" value="Ortodoncia"> Ortodoncia</label>
                <label><input type="checkbox" name="tipo_protesis" value="Superior"> Superior</label>
                <label><input type="checkbox" name="tipo_protesis" value="Inferior"> Inferior</label>
                <label><input type="checkbox" name="tipo_protesis" value="Acrílico"> Acrílico</label>
                <label><input type="checkbox" name="tipo_protesis" value="Flexible"> Flexible</label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Otros"> Otros:
                </label>
                <input type="text" id="otros" class="input-field" style="width: 100px;" disabled>
            </div>

            <div class="form-section">
                <label for="color">Color:</label>
                <input type="text" id="color" class="input-field">
            </div>

            <div class="form-section">
                <label for="firma">Firma Autorizada (sube una imagen de tu firma tomada en foto):</label>
                <input type="file" id="firma" class="input-field" accept="image/*">
                <img id="firma_preview" style="display:none; max-width:100%; margin-top:10px;">
            </div>
        </form>
    </div>

</body>

</html>
