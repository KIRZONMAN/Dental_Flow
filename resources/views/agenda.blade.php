<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agenda de Búsqueda</title>
    <link rel="stylesheet" href="{{ asset('css/agenda_hc.css') }}">

</head>

<body>

    <div class="container">
        <h1>Agenda de búsqueda</h1>
        <form method="POST" action="">
            <input type="text" name="buscar_paciente" placeholder="Buscar paciente" class="search-input">
            <button type="submit" class="search-button">Buscar</button>
        </form>

        <?php
        /*
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "clinica";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $buscar_paciente = $_POST['buscar_paciente'];
                    $sql = "SELECT * FROM pacientes WHERE nombre LIKE '%$buscar_paciente%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='appointment-table'>
                                <tr>
                                    <th>Hora</th>
                                    <th>Día</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['hora'] . "</td>
                                    <td>" . $row['dia'] . "</td>
                                    <td>" . $row['mes'] . "</td>
                                    <td>" . $row['anio'] . "</td>
                                    <td>" . $row['nombre'] . "</td>
                                    <td>
                                        <a href='/historia?id=" . $row['id'] . "' class='history-button'>Ver Historia</a>
                                    </td>
                                  </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No se encontraron resultados.</p>";
                    }
                }

                */ ?>
        <table class="appointment-table">
            <tr>
                <th>Hora</th>
                <th>Día</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td>3:00 PM</td>
                <td>22</td>
                <td>Agosto</td>
                <td>2025</td>
                <td>Juan Pérez</td>
                <td><a href="/historias" class="history-button">Ver Historia</a></td>
            </tr>

            <tr>
                <td>3:00 PM</td>
                <td>28</td>
                <td>Octubre</td>
                <td>2025</td>
                <td>Zenitsu Agatsuma</td>
                <td><a href="/historias" class="history-button">Ver Historia</a></td>
            </tr>
            <!-- Agrega más filas según sea necesario -->
        </table>
    </div>
</body>

</html>
