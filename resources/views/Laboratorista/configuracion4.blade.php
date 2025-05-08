<?php
session_start();

// Al enviar el formulario guardamos en sesión y redirigimos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["nombre"]     = $_POST["nombre"];
    $_SESSION["telefono"]   = $_POST["telefono"];
    $_SESSION["email"]      = $_POST["email"];
    header("Location: /configuracion4");
    exit();
}

// Valores por defecto o de sesión
$nombre        = $_SESSION["nombre"]   ?? "Dr. Laboratorista";
$telefono      = $_SESSION["telefono"] ?? "+12 34567890";
$email         = $_SESSION["email"]    ?? "lab@dominio.com";
$especialidad  = "Laboratorista";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Configuración Laboratorista</title>
  <!-- Estilos base -->
  <link rel="stylesheet" href="{{ asset('css/Config2.css') }}">
  <!-- Estilos específicos -->
  <link rel="stylesheet" href="{{ asset('css/Config4.css') }}">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Configuración del Laboratorista</h1>
    </div>

    <form method="POST">
      <div class="section">
        <div class="section-title">Perfil</div>

        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
        </div>

        <div class="form-group">
          <label for="especialidad">Especialidad</label>
          <input type="text" id="especialidad"
                 value="<?= htmlspecialchars($especialidad) ?>"
                 class="readonly-input" readonly>
        </div>

        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
        </div>
      </div>

      <button type="submit">Guardar configuración</button>
    </form>
  </div>
</body>
</html>
