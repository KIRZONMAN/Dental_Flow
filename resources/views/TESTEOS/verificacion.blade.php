<!-- Formulario para ingresar el nombre de la tabla (OPCIONAL)-->
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="{{ asset('css/ejemplo.css') }}">
</head>
<form method="POST">
    <label>Nombre de la tabla:</label>
    <input type="text" name="tabla" required>
    <input type="hidden" name="accion" value="seleccionar">
    <button type="submit">Consultar</button>
</form>
<form method="POST">
    <label>Nombre de la tabla:</label>
    <input type="text" name="tabla" required>
    <input type="hidden" name="accion" value="insertar">
    <button type="submit">Insertar</button>
</form>
<form method="POST">
    <label>Nombre de la tabla:</label>
    <input type="text" name="tabla" required>
    <input type="hidden" name="accion" value="actualizar">
    <button type="submit">Actualizar</button>
</form>
<form method="POST">
    <label>Nombre de la tabla:</label>
    <input type="text" name="tabla" required>
    <input type="hidden" name="accion" value="borrar">
    <button type="submit">Borrar</button>
</form>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dental_flow";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["tabla"])) {
    $tabla = $_POST["tabla"]; // Obtener la tabla
    $tabla = $conn->real_escape_string($tabla); // Evitar inyección SQL

    // Consulta simple(Manejar otros tipos de consultas de esta manera, Limit 1(puede variar) para evitar cargar toda la tabla)
    $sql = "SELECT * FROM $tabla LIMIT 10";
    $result = $conn->query($sql);

    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];

        // Opción 1: INSERTAR
        if ($accion == "insertar") {
            $sql_insert = "INSERT INTO $tabla (fecha, hora, estado, motivo, total, id_paciente, id_usuario) 
                       VALUES ('2025-03-30', '10:00:00', 'Confirmada', 'Dolor de muela', 100.00, 1, 1)";
            $accion = "seleccionar";
            if ($conn->query($sql_insert) === TRUE) {
                echo "Registro insertado correctamente.";

            } else {
                echo "Error al insertar: " . $conn->error;
            }
        }

        //Opción 2: ACTUALIZAR
        if ($accion == "actualizar") {
            $sql_update = "UPDATE $tabla SET estado = 'Cancelada' WHERE id_cita = 1";
            $accion = "seleccionar";
            if ($conn->query($sql_update) === TRUE) {
                echo "Registro actualizado correctamente.";
            } else {
                echo "Error al actualizar: " . $conn->error;
            }
        }
        // Opción 3: BORRAR
        if ($accion == "borrar") {
            $sql_delete = "DELETE FROM $tabla WHERE id_cita = 1";
            $accion = "seleccionar";
            if ($conn->query($sql_delete) === TRUE) {
                echo "Registro eliminado correctamente.";
            } else {
                echo "Error al eliminar: " . $conn->error;
            }
        }


        // Opción 4: SELECCIONAR
        if ($accion == "seleccionar") {
            $sql_select = "SELECT * FROM $tabla";
            $result = $conn->query($sql_select);

            // Verificar si hay resultados
            if ($result && $result->num_rows > 0) {
                echo "Datos obtenidos de la tabla <strong>$tabla</strong>:<br><br>";

                // Mostrar datos en una tabla HTML
                echo "<table border='1'>";

                // Obtener y mostrar los nombres de las columnas
                echo "<tr>";
                while ($campo = $result->fetch_field()) {
                    echo "<th>" . htmlspecialchars($campo->name) . "</th>";
                }
                echo "</tr>";

                // Mostrar los datos de la tabla
                while ($fila = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($fila as $valor) {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No se pudo obtener información de la base de datos o no existen registros"; //Mensaje de error o sin registros
            }
        }
    }
}


// Cerrar conexión
$conn->close();
?>