<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Citas</title>
    <link rel="stylesheet" href="{{ asset('css/Citas.css') }}">

</head>

<body>
    <h2>📅 Administrador de Citas</h2>
    <label for="fecha">Seleccionar fecha:</label>
    <input type="date" id="fecha" onchange="mostrarHorario()">

    <div id="horario-container" class="hidden">
        <h3>Horario disponible</h3>
        <div id="horario"></div>
    </div>

    <div id="detalle-cita" class="hidden">
        <h3>Detalles de la Cita</h3>
        <p><strong>Hora:</strong> <span id="detalle-hora"></span></p>
        <p><strong>Paciente:</strong> <span id="detalle-nombre"></span></p>
        <p><strong>Cédula:</strong> <span id="detalle-cedula"></span></p>
        <p><strong>Estado:</strong></p>
        <div id="estado-buttons">
            <button class="estado-btn" style="background-color: green;" onclick="asignarEstado('Confirmada', 'green', 'white')">✔️ Confirmada</button>
            <button class="estado-btn" style="background-color: yellow; color: black;" onclick="asignarEstado('Reprogramada', 'yellow', 'black')">🔄 Reprogramada</button>
            <button class="estado-btn" style="background-color: orange;" onclick="asignarEstado('Emergencia', 'orange', 'white')">⚠️ Emergencia</button>
            <button class="estado-btn" style="background-color: red;" onclick="asignarEstado('Cancelada', 'red', 'white')">❌ Cancelada</button>
        </div>
        <button id="editar-cita" class="editar-btn hidden" onclick="modificarCita()">✏️ Editar Cita</button>
    </div>

    <script>
        let citas = {};

        function mostrarHorario() {
            const horarioContainer = document.getElementById('horario-container');
            const horarioDiv = document.getElementById('horario');
            horarioContainer.classList.remove('hidden');
            horarioDiv.innerHTML = '';

            let horas = [
                "8:00 AM", "9:00 AM", "10:00 AM", "11:00 AM",
                "12:00 PM", "1:00 PM", "2:00 PM", "3:00 PM",
                "4:00 PM", "5:00 PM", "6:00 PM"
            ];

            horas.forEach(hora => {
                let btn = document.createElement("button");
                btn.innerText = hora;
                btn.classList.add("hora-btn");
                btn.onclick = () => gestionarCita(hora, btn);
                horarioDiv.appendChild(btn);
            });
        }

        function gestionarCita(hora, btn) {
            if (citas[hora]) {
                let opcion = confirm(`La cita de ${citas[hora].nombre} ya existe.\n¿Deseas Verla o Modificarla?`);
                if (!opcion) return;
                mostrarDetallesCita(hora);
            } else {
                solicitarDatosPaciente(hora, btn);
            }
        }

        function solicitarDatosPaciente(hora, btn) {
            let nombre = prompt("Ingrese el nombre del paciente:");
            let cedula = prompt("Ingrese la cédula del paciente:");

            if (nombre && cedula) {
                citas[hora] = { nombre, cedula, estado: "Pendiente", color: "gray", textColor: "white", boton: btn };
                mostrarDetallesCita(hora);
            } else {
                alert("Debe ingresar todos los datos.");
            }
        }

        function mostrarDetallesCita(hora) {
            document.getElementById('detalle-hora').innerText = hora;
            document.getElementById('detalle-nombre').innerText = citas[hora].nombre;
            document.getElementById('detalle-cedula').innerText = citas[hora].cedula;
            document.getElementById('detalle-cita').classList.remove('hidden');
            document.getElementById('editar-cita').classList.remove('hidden');
        }

        function asignarEstado(estado, color, textColor) {
            let hora = document.getElementById('detalle-hora').innerText;
            if (citas[hora]) {
                citas[hora].estado = estado;
                citas[hora].color = color;
                citas[hora].textColor = textColor;
                citas[hora].boton.style.backgroundColor = color;
                citas[hora].boton.style.color = textColor;
                alert(`Cita actualizada:\nPaciente: ${citas[hora].nombre}\nHora: ${hora}\nEstado: ${estado}`);
            }
        }

        function modificarCita() {
            let hora = document.getElementById('detalle-hora').innerText;
            if (citas[hora]) {
                let nuevoNombre = prompt("Editar nombre:", citas[hora].nombre);
                let nuevaCedula = prompt("Editar cédula:", citas[hora].cedula);
                if (nuevoNombre && nuevaCedula) {
                    citas[hora].nombre = nuevoNombre;
                    citas[hora].cedula = nuevaCedula;
                    mostrarDetallesCita(hora);
                }
            }
        }
    </script>
</body>
</html>
