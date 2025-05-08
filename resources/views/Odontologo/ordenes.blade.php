<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Órdenes</title>
    <link rel="stylesheet" href="{{ asset('css/Sordenes.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="ordenes-body">
    <div class="ordenes-container">

        <header class="ordenes-header">
            <img src="imagen/logo.png" alt="Dental Icon" class="dental-icon animated-icon">
            <h1 class="ordenes-title">Órdenes del Paciente</h1>
            <p class="ordenes-subtitle">Gestiona y crea nuevas órdenes o recetas fácilmente</p>
        </header>

        <main class="ordenes-main">

            <section class="order-section fade-in">
                <h2><i class="fas fa-clipboard-list"></i> Nueva Orden</h2>
                <form id="form-orden">
                    <div class="form-group">
                        <label for="paciente">Paciente:</label>
                        <input type="text" id="paciente" placeholder="Ej. Juan Pérez" class="form-control fancy-input">
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo de Orden:</label>
                        <input type="text" id="tipo" placeholder="Ej. Examen, Rayos X..." class="form-control fancy-input">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" class="form-control fancy-input" rows="4" placeholder="Detalle la orden médica..."></textarea>
                    </div>
                </form>
            </section>

            <section class="prescription-section fade-in">
                <h2><i class="fas fa-pills"></i> Nueva Receta Médica</h2>
                <form id="form-receta">
                    <div class="form-group">
                        <label for="paciente-receta">Paciente:</label>
                        <input type="text" id="paciente-receta" placeholder="Ej. Ana Martínez" class="form-control fancy-input">
                    </div>

                    <div class="form-group">
                        <label for="medicamento">Medicamento:</label>
                        <input type="text" id="medicamento" placeholder="Nombre del medicamento" class="form-control fancy-input">
                    </div>

                    <div class="form-group">
                        <label for="dosis">Dosis:</label>
                        <input type="text" id="dosis" placeholder="Cantidad (mg)" class="form-control fancy-input">
                    </div>

                    <div class="form-group">
                        <label for="frecuencia">Frecuencia:</label>
                        <input type="text" id="frecuencia" placeholder="Ej. 2 veces al día" class="form-control fancy-input">
                    </div>
                </form>
            </section>

            <footer class="ordenes-footer fade-in">
                <button class="btn btn-success btn-lg shadow-sm" onclick="guardarHistoria()"><i class="fas fa-save"></i> Guardar en Historia</button>
                <button class="btn btn-primary btn-lg shadow-sm" onclick="imprimirReceta()"><i class="fas fa-print"></i> Imprimir Receta</button>
                <button class="btn btn-secondary btn-lg shadow-sm" onclick="enviarDatos()"><i class="fas fa-paper-plane"></i> Enviar</button>
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
