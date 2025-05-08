<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["nombre"] = $_POST["nombre"];
    $_SESSION["telefono"] = $_POST["telefono"];
    $_SESSION["email"] = $_POST["email"];
    header("Location: /configuracion2");
    exit();
}

$nombre = $_SESSION["nombre"] ?? "Dr. (Nombre)";
$telefono = $_SESSION["telefono"] ?? "+12 34567890";
$email = $_SESSION["email"] ?? "doctor@dominio.com";
$especialidad = "Asistente";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Asistente</title>
    <link rel="stylesheet" href="{{ asset('css/Config2.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Configuración del Asistente</h1>
        </div>

        <form method="POST">
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
