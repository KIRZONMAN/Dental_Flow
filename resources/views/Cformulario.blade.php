<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla Cajero - Clínica Dental</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/Cformulario.css') }}">

    <script>
        function generarPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            let n_documento = document.getElementById("n_documento").value;
            let nombres = document.getElementById("nombres").value;
            let apellidos = document.getElementById("apellidos").value;
            let telefono = document.getElementById("telefono").value;
            let precio = document.getElementById("precio").value;

            doc.text("Recibo de Consulta", 10, 10);
            doc.text(`Documento: ${n_documento}`, 10, 20);
            doc.text(`Nombre: ${nombres} ${apellidos}`, 10, 30);
            doc.text(`Teléfono: ${telefono}`, 10, 40);
            doc.text(`Precio Consulta: ${precio}`, 10, 50);

            doc.save("recibo_consulta.pdf");
        }
    </script>
</head>

<body>

    <div class="container">
        <header>
            <img src="imagen/logo.png" alt="Dental Icon" class="dental-icon">
            <h1>Factura</h1>
            <button class="print-button" onclick="window.print()" title="Imprimir">
                <img src="imagen/imprimir.png" alt="Print Icon">
            </button>
        </header>

        <form>
            <div class="form-section">
                <label for="numDocumento">Número documento:</label>
                <input type="text" id="numDocumento" placeholder="Escribir" class="input-field">

                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" placeholder="Escribir" class="input-field">
                <label for="telefono">Telefono:</label>
                <input type="text" id="telefono" placeholder="Escribir" class="input-field">
                <label for="fecha_factura">Fecha_Factura</label>
                <input type="date" id="fecha_factura" class="input-field">

                <label for="medioPago">Medio de Pago:</label>
                <input type="text" id="medioPago" placeholder="Escribir" class="input-field">
            </div>

            <div class="form-section">
                <label for="precio">Precio consulta:</label>
                <input type="text" id="precio" class="input-field">

                <label for="servicio">Servicio prestado:</label>
                <input type="text" id="servicio" class="input-field">
            </div>

            <div class="form-section checkboxes">
                <h2>Introducir Gastos</h2>
                <br>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Metal Porcelana"> Metal Porcelana
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Zirconio"> Zirconio
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Prótesis Total"> Prótesis Total
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Prótesis Parcial"> Prótesis Parcial
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Ortodoncia"> Ortodoncia
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Superior"> Superior
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Inferior"> Inferior
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Acrílico"> Acrílico
                </label>
                <label>
                    <input type="checkbox" name="tipo_protesis" value="Flexible"> Flexible
                </label>
            </div>
        </form>
    </div>
    </form>
</body>

</html>
