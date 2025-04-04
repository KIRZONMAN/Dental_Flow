<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dental_flow";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

$tabla = 'Citas';
$sql = "SELECT * FROM $tabla WHERE id_cita = 13";
$datos = [];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener una sola fila
    $datos[] = [
        "id_cita" => $row["id_cita"],
        "fecha" => $row["fecha"],
        "hora" => $row["hora"],
        "estado" => $row["estado"],
        "motivo" => $row["motivo"],
        "total" => $row["total"],
        "id_paciente" => $row["id_paciente"],
        "id_usuario" => $row["id_usuario"]
    ];
} else {
    $datos = ["mensaje" => "No se encontró la cita."];
}
$jsonDatos = json_encode($datos, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Asistente</title>
    <link rel="stylesheet" href="Sasistente.css">
</head>

<script>
    <div id="resultado">
        <?php if (!empty($datos)): ?>
            <?php if (isset($datos['error'])): ?>
                <p><?php echo $datos['error']; ?></p>
            <?php else: ?>
                <h2>📋 Detalles de la Cita</h2>
                <p><strong>Fecha:</strong> <?php echo $datos['fecha']; ?></p>
                <p><strong>Hora:</strong> <?php echo $datos['hora']; ?></p>
                <p><strong>Estado:</strong> <?php echo $datos['estado']; ?></p>
                <p><strong>Motivo:</strong> <?php echo $datos['motivo']; ?></p>
                <p><strong>Total:</strong> <?php echo $datos['total']; ?></p>
                <p><strong>ID Paciente:</strong> <?php echo $datos['id_paciente']; ?></p>
                <p><strong>ID Usuario:</strong> <?php echo $datos['id_usuario']; ?></p>
            <?php endif; ?>
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
    <!--TEST-->
    <button type="submit">Borrar</button>

    <main>
        <div class="main-content" id="main-content">
            <div id="resultado">
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