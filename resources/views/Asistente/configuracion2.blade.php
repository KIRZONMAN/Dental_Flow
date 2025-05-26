<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Configuración Asistente</title>
    <link rel="stylesheet" href="{{ asset('css/Config2.css') }}">
</head>

<body>
    <div class="container">
        <h1>Configuración del Asistente</h1>

        <form method="POST" action="{{ route('asistente.configuracion2') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $nombre) }}">
            </div>

            <div class="form-group">
                <label for="especialidad">Especialidad</label>
                <input type="text" id="especialidad" value="<?= $especialidad ?>" class="readonly-input" readonly>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $telefono) }}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $email) }}">
            </div>

            <button type="submit">Guardar configuración</button>
        </form>
    </div>
</body>

</html>
