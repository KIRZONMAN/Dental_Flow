<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Íconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/Sgestion2.css') }}">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="titulo display-6 fw-bold text-primary">Estado de Pedidos</h2>
            <p class="text-muted">Consulta aquí el estado actual de cada uno de tus pedidos 🧾</p>
        </div>

        <div class="table-responsive rounded shadow-sm bg-white p-3">
            <table class="table table-hover text-center align-middle tabla-pedidos mb-0">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>🦷 Carillas</td>
                        <td><span class="badge badge-enviado">Ordenado</span></td>
                    </tr>
                    <tr>
                        <td>🦷 Prótesis parcial (zirconio)</td>
                        <td><span class="badge badge-produccion">En producción</span></td>
                    </tr>
                    <tr>
                        <td>🦷 Retenedores</td>
                        <td><span class="badge badge-listo">Listo para entregar</span></td>
                    </tr>
                    <tr>
                        <td>🦷 Moldes</td>
                        <td><span class="badge badge-entregado">Entregado</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-5">
            <a href="/odontologo" class="btn btn-regresar">
                <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
            </a>
        </div>
    </div>

</body>
</html>
