<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/Config3.css') }}">
</head>

<body>
    <div class="container">
        <div class="header text-center mb-4">
            <h1>Configuración</h1>
        </div>

        <form method="POST" class="mx-auto" style="max-width: 600px;">
            @csrf

            <div class="section mb-4">
                <div class="section-title mb-3">Perfil</div>

                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text"
                           id="nombre"
                           name="nombre"
                           value="<?= $nombre ?>"
                           class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input type="text"
                           id="especialidad"
                           value="<?= $especialidad ?>"
                           class="form-control readonly-input"
                           readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text"
                           id="telefono"
                           name="telefono"
                           value="{{ old('telefono', $telefono) }}"
                           class="form-control"
                           oninput="validateNumberInput(this)">
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="<?= $email ?>"
                           class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Guardar configuración</button>
        </form>
    </div>

    <!-- Validar Teléfono -->
    <script>
        function validateNumberInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    </script>

    <!-- Bootstrap JS (opcional, solo si usas componentes interactivos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
