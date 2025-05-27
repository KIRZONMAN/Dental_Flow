<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="{{ asset('css/Config1.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="config-container">
        <div class="config-header">
            <h1>Configuración de Perfil</h1>
        </div>

        <form method="POST" action="{{ route('odontologo.configuracion') }}">
            @csrf
            <div class="config-section">
                <h2 class="section-title">Perfil</h2>

                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
                </div>

                <div class="form-group">
                    <label for="especialidad">Especialidad</label>
                    <input type="text" id="especialidad" name="especialidad" value="<?= $especialidad ?>">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="<?= $telefono ?>">
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="<?= $email ?>">
                </div>
            </div>

            <button type="submit" class="btn-guardar">Guardar configuración</button>
        </form>
    </div>

</body>

</html>
