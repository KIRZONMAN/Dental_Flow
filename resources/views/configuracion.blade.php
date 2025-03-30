<?php
session_start();

// Si se envían datos, los guardamos en la sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["nombre"] = $_POST["nombre"];
    $_SESSION["especialidad"] = $_POST["especialidad"];
    $_SESSION["telefono"] = $_POST["telefono"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["recordatorios"] = isset($_POST["recordatorios"]) ? "checked" : "";

    // Redirigir a sí misma para evitar reenvío del formulario
    header("Location: /configuracion");
    exit();
}

// Cargar los valores almacenados en la sesión o valores por defecto
$nombre = isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "Dr. (Nombre)";
$especialidad = isset($_SESSION["especialidad"]) ? $_SESSION["especialidad"] : "Especialidad";
$telefono = isset($_SESSION["telefono"]) ? $_SESSION["telefono"] : "+12 34567890";
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "doctor@dominio.com";
$recordatorios = isset($_SESSION["recordatorios"]) ? $_SESSION["recordatorios"] : "";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #13538a;
            margin: 0;
            padding: 0;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 50%;
            background-color: #4682b4;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            background-color: #5a9bd6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 1.2em;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        button {
            width: 100%;
            background-color: #2e6da4;
            color: white;
            padding: 10px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #1b4f72;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>Configuración</h1>
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
                    <input type="text" id="especialidad" name="especialidad" value="<?= $especialidad ?>">
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

            <div class="section">
                <div class="section-title">Notificaciones</div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="recordatorios" name="recordatorios" <?= $recordatorios ?>>
                    <label for="recordatorios">Recordatorios de citas</label>
                </div>
            </div>

            <button type="submit">Guardar configuración</button>
        </form>
    </div>

</body>

</html>
