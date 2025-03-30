<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="{{ asset('css/Sregistrar.css') }}">

    <div class="profile-card">
        <div class="profile-icon"></div>
        <div class="profile-info">
            <label for="patient-id">Cédula del paciente:</label>
            <input type="text" id="patient-id" name="patient-id" value="1234567890">

            <label for="first-name">Nombres:</label>
            <input type="text" id="first-name" name="first-name" value="José Manuel">

            <label for="last-name">Apellidos:</label>
            <input type="text" id="last-name" name="last-name" value="Gómez Valencia">

            <label for="age">Edad:</label>
            <input type="text" id="age" name="age" value="56 años">

            <label for="gender">Género:</label>
            <input type="text" id="gender" name="gender" value="Masculino">

            <label for="phone">Teléfono:</label>
            <input type="text" id="phone" name="phone" value="312 4567890">

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="13C #12-4B">

            <label for="neighborhood">Barrio:</label>
            <input type="text" id="neighborhood" name="neighborhood" value="Pandiguando">

            <label for="apartment">Apartamento:</label>
            <input type="text" id="apartment" name="apartment" value="No aplica">

            <label for="email">Correo:</label>
            <input type="text" id="email" name="email" value="persona@dominio.com">

            <label for="blood-type">Tipo de sangre:</label>
            <input type="text" id="blood-type" name="blood-type" value="A+">
        </div>
        <button class="update-button">Actualizar datos</button>
    </div>
    </body>

</html>
