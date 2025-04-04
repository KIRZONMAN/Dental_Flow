<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="stylesheet" href="{{ asset('css/Sgestion2.css') }}">

</head>
<body>
    <h2 class="titulo">Estado de pedidos</h2>

    <table class="tabla-pedidos">
        <tr>
            <th>🦷 Carillas</th>
            <td>📩 Ordenado</td>
        </tr>
        <tr>
            <th>🦷 Prótesis parcial (zirconio)</th>
            <td>🕒 En producción</td>
        </tr>
        <tr>
            <th>🦷 Retenedores</th>
            <td>🚐 Listo para entregar</td>
        </tr>
        <tr>
            <th>🦷 Moldes</th>
            <td>✅ Entregado</td>
        </tr>
    </table>

    <a href="/odontologo" class="btn-regresar">Regresar al menú</a>
</body>
</html>
