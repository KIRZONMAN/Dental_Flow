<?php
// Conectar a la base de datos
$host = "localhost";
$user = "root"; // Cambia si usas otro usuario
$password = ""; // Cambia si tienes una contraseña
$database = "mi_base_de_datos"; // Cambia al nombre correcto de tu BD

$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar que los campos están llenos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Verificar que no estén vacíos
    if (empty($nombre) || empty($email) || empty($password)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $password_hash);

    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='/ARegistro'>Volver</a>";
    } else {
        echo "Error al registrar: " . $conn->error;
    }

    // Cerrar la conexión
    $stmt->close();
}

$conn->close();
?>
