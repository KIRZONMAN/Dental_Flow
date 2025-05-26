<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Configuración Dueño</title>
    <link rel="stylesheet" href="{{ asset('css/Config2.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Configuración del Dueño</h1>
        </div>

        <form method="POST" action="{{ route('dueno-configuracion') }}">
            @csrf
            <div class="section">
                <div class="section-title">Perfil</div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
                </div>

                <div class="form-group">
                    <label for="especialidad">Rol</label>
                    <input type="text" id="especialidad" value="<?= $especialidad ?>" class="readonly-input" readonly>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="<?= $telefono ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= $email ?>">
                </div>
            </div>

            <button type="submit">Guardar configuración</button>
        </form>
    </div>
</body>

</html>
