<!DOCTYPE html>
/**
 * Summary of conexion
 * @param mixed $servidor
 * @param mixed $usuario
 * @param mixed $contraseña
 * @param mixed $bd
 * @return bool|mysqli
 */

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Asistente</title>
    <link rel="stylesheet" href="styles.css">
</head>

<script>
    <div id="resultado">
        <?php if (!empty($datos)): ?>
        <?php    if (isset($datos['error'])): ?>
        <p><?php        echo $datos['error']; ?></p>
        <?php    else: ?>
        <h2>📋 Detalles de la Cita</h2>
        <p><strong>Fecha:</strong> <?php        echo $datos['fecha']; ?></p>
        <p><strong>Hora:</strong> <?php        echo $datos['hora']; ?></p>
        <p><strong>Estado:</strong> <?php        echo $datos['estado']; ?></p>
        <p><strong>Motivo:</strong> <?php        echo $datos['motivo']; ?></p>
        <p><strong>Total:</strong> <?php        echo $datos['total']; ?></p>
        <p><strong>ID Paciente:</strong> <?php        echo $datos['id_paciente']; ?></p>
        <p><strong>ID Usuario:</strong> <?php        echo $datos['id_usuario']; ?></p>
        <?php    endif; ?>
        <?php endif; ?>
    </div>

</script>



<body>
    <header>
        <div class="header-content">
            <div class="menu-icon" id="menu-icon">&#9776;</div>
            <h2>Asistente</h2>
            <div class="date">📅 Fecha: <?php echo date("d/m/Y"); ?></div>
        </div>
        <nav id="dropdown-menu" class="dropdown-menu">
            <a href="Citas.php"><button class="nav-button">📅 Citas</button></a>
            <a href="Ahistorial.php"><button class="nav-button">📋 Historial</button></a>
            <a href="ARegistro.php"><button class="nav-button">📝 Registrar Paciente</button></a>
            <a href="configuracion2.php"><button class="nav-button">⚙️ Configuración</button></a>

        </nav>
        <!-- Carrusel de citas -->
        <div class="citas-container">
            <div class="citas-wrapper">
                <button class="nav-button" onclick="cargarCita(13)">Cita 7AM-8AM</button>
                <button class="nav-button" onclick="loadInterface('cita2')">Cita 8AM-9AM</button>
                <button class="nav-button emergency" onclick="loadInterface('emergencia')">🚨 Emergencia
                    9AM-10AM</button>
                <button class="nav-button" onclick="loadInterface('cita3')">Cita 10AM-11AM</button>
                <button class="nav-button disabled">⏳ No disponible 11AM-12PM</button>
                <button class="nav-button" onclick="loadInterface('cita4')">Cita 1PM-2PM</button>
                <button class="nav-button" onclick="loadInterface('cita5')">Cita 2PM-3PM</button>
            </div>
        </div>
    </header>

    <form method="POST">
        <label>Nombre de la tabla:</label>
        <input type="text" name="tabla" required>
        <input type="hidden" name="accion" value="seleccionar">
        <button type="submit">Consultar</button>
    </form>

    <main>
        <div class="main-content" id="main-content">
            <div id="resultado_consulta_citas">
                <h2>Seleccione una cita para ver los detalles</h2>
            </div>
        </div>
    </main>





    <script>
        document.getElementById('menu-icon').addEventListener('click', function () {
            var dropdownMenu = document.getElementById('dropdown-menu');
            dropdownMenu.classList.toggle("show-menu");
        });


        function loadInterface(cita) {
            "cita2": { paciente: "Andrea Gómez", odontologo: "Dra. Sofía Ramírez", motivo: "Revisión de ortodoncia", estado: "En curso", notas: "Evaluar necesidad de ajustes en brackets." },
            "emergencia": { paciente: "Luis Fernández", odontologo: "Dr. José Herrera", motivo: "Dolor intenso en muela", estado: "Pendiente", notas: "Posible extracción urgente." },
            "cita3": { paciente: "Mariana López", odontologo: "Dra. Patricia Ríos", motivo: "Tratamiento de caries", estado: "Finalizada", notas: "Se colocó resina en el diente molar superior derecho." },
            "cita4": { paciente: "Fernando Torres", odontologo: "Dr. Esteban Muñoz", motivo: "Consulta general", estado: "Pendiente", notas: "Verificar estado general de encías y dientes." },
            "cita5": { paciente: "Laura Méndez", odontologo: "Dra. Valentina Soto", motivo: "Blanqueamiento dental", estado: "En curso", notas: "Aplicación de peróxido de hidrógeno." }
        };

        let content = document.getElementById('main-content');
        let citaInfo = citasDetalles[cita];

        content.style.opacity = "0";
        setTimeout(() => {
            content.innerHTML = `
                    <h2>📋 Detalles de la Cita</h2>
                    <p><strong>Paciente:</strong> ${citaInfo.paciente}</p>
                    <p><strong>Odontólogo:</strong> ${citaInfo.odontologo}</p>
                    <p><strong>Motivo:</strong> ${citaInfo.motivo}</p>
                    <p><strong>Estado:</strong> <span class="status ${citaInfo.estado.toLowerCase()}">${citaInfo.estado}</span></p>
                    <p><strong>Notas:</strong> ${citaInfo.notas}</p>
                `;
            content.style.opacity = "1";
        }, 300);
        }

        function loadPage(page) {
            let content = document.getElementById('main-content');
            content.style.opacity = "0";

            fetch(page)
                .then(response => response.text())
                .then(data => {
                    setTimeout(() => {
                        content.innerHTML = data;
                        content.style.opacity = "1";
                    }, 300);
                })
                .catch(error => console.error("Error cargando la página:", error));
        }


        // Carrusel de citas: avanza y vuelve
        let citasWrapper = document.querySelector(".citas-wrapper");
        let desplazamiento = 240; // Espaciado entre botones
        let moviendoDerecha = true;

        function moverCarrusel() {
            if (moviendoDerecha) {
                citasWrapper.style.transform = `translateX(-${desplazamiento}px)`;
            } else {
                citasWrapper.style.transform = `translateX(0px)`;
            }
            moviendoDerecha = !moviendoDerecha;
        }

        setInterval(moverCarrusel, 5000);
    </script>

</body>

</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dental_flow";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);


// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla = 'Citas';
    $tabla = $conn->real_escape_string($tabla); // Evitar inyección SQL

    // Consulta simple(Manejar otros tipos de consultas de esta manera, Limit 1(puede variar) para evitar cargar toda la tabla)
    $sql = "SELECT * FROM $tabla WHERE id_cita = 13";
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
            $sql_select = "SELECT * FROM citas";
            $result = $conn->query($sql_select);

            // Verificar si hay resultados
            if ($result && $result->num_rows > 0) {
                echo "Datos obtenidos de la tabla <strong>$tabla</strong>:<br><br>";

                // Mostrar datos en una tabla HTML
                echo "<table  border='1'>";

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
exit();
?>
