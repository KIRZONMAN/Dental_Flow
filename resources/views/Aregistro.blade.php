<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente</title>
    <link rel="stylesheet" href="{{ asset('css/ARegistro.css') }}">

</head>

<body>
    <div class="container">
        <h2>Registro de Paciente</h2>
        <form action="/procesar_registro" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </div>
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" min="0" required>
            </div>
            <div class="form-group">
                <label for="genero">Género:</label>
                <select id="genero" name="genero">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="barrio">Barrio:</label>
                <input type="text" id="barrio" name="barrio" required>
            </div>
            <div class="form-group">
                <label for="apartamento">Apartamento:</label>
                <input type="text" id="apartamento" name="apartamento">
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="tipo_sangre">Tipo de Sangre:</label>
                <input type="text" id="tipo_sangre" name="tipo_sangre" required>
            </div>
            <button type="submit" class="btn-registrar">Registrar</button>
        </form>
    </div>
</body>

</html>
