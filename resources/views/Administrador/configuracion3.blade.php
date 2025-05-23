<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="{{ asset('css/Config3.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Configuración</h1>
        </div>

        <form method="POST">
            @csrf
            <div class="section">
                <div class="section-title">Perfil</div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
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
                    <input type="email" id="email" name="email" value="<?= $email ?>">
                </div>
            </div>

            <button type="submit">Guardar configuración</button>
        </form>
    </div>

    <!--Validar Telefono-->
    <script>
        function validateNumberInput(input) {
            // Elimina cualquier carácter no numérico
            input.value = input.value.replace(/[^0-9]/g, '');

        }
    </script>
</body>

</html>