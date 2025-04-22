<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Consulta - DentalFlow</title>

    <!-- Librerías -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script type="module">
        import { createIcons } from 'https://cdn.jsdelivr.net/npm/lucide@latest/+esm';
        createIcons();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/Cformulario.css') }}">
</head>

<body>

    <div class="form-container fadeIn" id="factura">
        <header class="form-header">
            <div class="logo-title">
                <img src="imagen/logo.png" alt="Logo" class="logo-icon">
                <h1>Factura de Consulta</h1>
            </div>
            <div class="header-actions">
                <button class="icon-button" onclick="window.print()" title="Imprimir">
                    <i data-feather="printer"></i>
                </button>
                <button class="icon-button" onclick="iniciarCapturaPDF()" title="Descargar PDF">
                    <i data-feather="download"></i>
                </button>
            </div>
        </header>

        <form id="facturaForm">
            <section class="form-section">
                <div class="form-group">
                    <label for="numDocumento">Número documento</label>
                    <input type="text" id="numDocumento" placeholder="Escribir">
                </div>

                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" placeholder="Escribir">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" placeholder="Escribir">
                </div>

                <div class="form-group">
                    <label for="fecha_factura">Fecha de Factura</label>
                    <input type="date" id="fecha_factura">
                </div>

                <div class="form-group">
                    <label for="medioPago">Medio de Pago</label>
                    <input type="text" id="medioPago" placeholder="Escribir">
                </div>

                <div class="form-group">
                    <label for="precio">Precio consulta</label>
                    <input type="text" id="precio" placeholder="$0.00">
                </div>

                <div class="form-group">
                    <label for="servicio">Servicio prestado</label>
                    <input type="text" id="servicio" placeholder="Escribir">
                </div>
            </section>

            <section class="checkbox-section">
                <h2>Gastos Adicionales</h2>
                <div class="checkbox-grid">
                    @php
                        $gastos = [
                            'Metal Porcelana',
                            'Zirconio',
                            'Prótesis Total',
                            'Prótesis Parcial',
                            'Ortodoncia',
                            'Superior',
                            'Inferior',
                            'Acrílico',
                            'Flexible',
                        ];
                    @endphp
                    @foreach ($gastos as $gasto)
                        <label>
                            <input type="checkbox" name="tipo_protesis" value="{{ $gasto }}">
                            {{ $gasto }}
                        </label>
                    @endforeach
                </div>
            </section>

            <div class="btn-area">
                <button type="button" onclick="guardarFactura()">Guardar Factura</button>
            </div>
        </form>
    </div>

    <script>
        feather.replace();

        function iniciarCapturaPDF() {
            const factura = document.getElementById('factura');

            // Evitar la animación solo para el renderizado del PDF
            factura.classList.remove('fadeIn');
            factura.style.opacity = '1';
            factura.style.transform = 'none';

            // Esperamos a que se apliquen los estilos inmediatamente
            requestAnimationFrame(() => {
                setTimeout(() => {
                    generarPDF(factura);
                }, 100); // Pequeño delay para asegurar renderizado final
            });
        }

        function generarPDF(factura) {
            html2canvas(factura, { scale: 2 }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save("Factura_Consulta_DentalFlow.pdf");

                // Restauramos animación si es necesario
                factura.classList.add('fadeIn');
            });
        }

        function guardarFactura() {
            const nombre = document.getElementById("nombres").value;
            if (!nombre) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, completa los campos obligatorios.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Factura guardada',
                text: 'Los datos han sido registrados correctamente.',
                confirmButtonColor: '#3085d6'
            });
        }
    </script>

</body>

</html>
