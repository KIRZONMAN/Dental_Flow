<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/gestionUsuarios.css') }}">

</head>

<body>

    <div class="container">
        <h1>Buscar Usuarios</h1>
        <form method="POST" action="">
            <input type="text" name="buscar_paciente" placeholder="Buscar usuario" class="search-input">
            <button type="submit" class="search-button">Buscar</button>
        </form>

        <?php
        /*// Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "clinica";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Manejo de acciones (Editar, Eliminar, etc.)
        if (isset($_GET['accion']) && isset($_GET['id'])) {
            $accion = $_GET['accion'];
            $id = intval($_GET['id']);

            if ($accion == 'editar') {
                echo "<p>Editar usuario con ID: $id</p>";
                // Aquí puedes agregar la lógica para editar un usuario
            } elseif ($accion == 'eliminar') {
                echo "<p>Usuario con ID $id eliminado (simulado)</p>";
                // Aquí puedes agregar la lógica para eliminar un usuario
            } elseif ($accion == 'asignar_rol') {
                echo "<p>Asignar rol al usuario con ID: $id</p>";
            } elseif ($accion == 'modificar_permisos') {
                echo "<p>Modificar permisos del usuario con ID: $id</p>";
            }
        }
*/
        ?>

        <table class="appointment-table">
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td>Juan Pérez</td>
                <td>Odontologo</td>
                <td>En línea</td>
                <td>
                    <a href="/gestionUsuarios?accion=editar&id=1" class="history-button">Editar</a>
                    <a href="/gestionUsuarios?accion=eliminar&id=1" class="history-button">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Mario Fernandez</td>
                <td>Cajero</td>
                <td>Inactivo</td>
                <td>
                    <a href="/gestionUsuarios?accion=editar&id=2" class="history-button">Editar</a>
                    <a href="/gestionUsuarios?accion=eliminar&id=2" class="history-button">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Abigail Florez</td>
                <td>Asistente</td>
                <td>En línea</td>
                <td>
                    <a href="/gestionUsuarios?accion=editar&id=3" class="history-button">Editar</a>
                    <a href="/gestionUsuarios?accion=eliminar&id=3" class="history-button">Eliminar</a>
                </td>
            </tr>
            <tr>
                <td>Marco Gomez</td>
                <td>Odontologo</td>
                <td>En línea</td>
                <td>
                    <a href="/gestionUsuarios?accion=editar&id=4" class="history-button">Editar</a>
                    <a href="/gestionUsuarios?accion=eliminar&id=4" class="history-button">Eliminar</a>
                </td>
            </tr>
        </table>

        <div id="btnAddUser">
            <a href="/gestionUsuarios?accion=agregar" class="history-button">Agregar Usuarios</a>
        </div>

        <h2>Roles y Permisos</h2>
        <a href="/gestionUsuarios?accion=asignar_rol&id=1" class="history-button">👤Asignar rol</a>
        <a href="/gestionUsuarios?accion=modificar_permisos&id=1" class="history-button">⚙️Modificar Permisos</a>
    </div>

</body>

</html>
