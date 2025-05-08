<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Insumo</title>
</head>
<body>
    <h2>🦷 DentalFlow - Nueva Solicitud de Insumo</h2>
    <p>Hola {{ $datos['nombre_proveedor'] }},</p>
    <p>Has recibido una nueva solicitud de insumo por parte de la clínica.</p>

    <ul>
        <li><strong>Insumo:</strong> {{ $datos['insumo'] }}</li>
        <li><strong>Cantidad:</strong> {{ $datos['cantidad'] }}</li>
        <li><strong>Fecha de solicitud:</strong> {{ $datos['fecha'] }}</li>
    </ul>

    <p>Por favor gestiona esta solicitud lo antes posible. Para más detalles, puedes responder a este correo.</p>

    <p>Gracias por tu colaboración,<br>
    Equipo DentalFlow</p>
</body>
</html>
