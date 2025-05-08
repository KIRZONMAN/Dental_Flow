<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Citas</title>
    <link rel="stylesheet" href="{{ asset('css/Citas.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
<a href="{{ route('asistente') }}" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i> Volver</a>
    <h2>📅 Administrador de Citas</h2>

    <form id="form-cita">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" required>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="cancelada">Cancelada</option>
            <option value="confirmada">Confirmada</option>
            <option value="completada">Completada</option>
        </select>
        <label for="motivo">Motivo:</label>
        <input type="text" name="motivo" required>

        <label for="motivo">Coste Total:</label>
        <input type="number" name="total" step="any" required>

        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" required>

        <label for="odontologo">Odontólogo:</label>
        <select name="odontologo" id="odontologo" required>
            <option value="">Seleccionar odontólogo</option>
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}">{{ $usuario->nombre_completo_odontologo }}</option>
            @endforeach
        </select>

        <button type="submit">Registrar Cita</button>

        </a>

    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Motivo</th>
                    <th>Total</th>
                    <th>Cédula</th>
                    <th>Odontólogo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($citas as $cita)
                            <td>{{ $cita->fecha_cita }}</td>
                            <td>{{ $cita->hora_cita }}</td>
                            <td>{{ $cita->estado_cita }}</td>
                            <td>{{ $cita->motivo_cita }}</td>
                            <td>{{ $cita->total_cita }}</td>
                            <td>{{ $cita->paciente_id }}</td>
                            <td>{{ $cita->nombre_completo_odontologo }}</td>
                            <td>
                                <a href="{{ route('citas.edit', $cita->id_cita) }}">
                                    <button type="submit" class="btn btn-success">✍🏿</button>
                            </td>
                            <td>
                                <form action="{{ route('citas.delete', $cita->id_cita) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta Cita?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div id="mensaje"></div>

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

    <script>
        document.getElementById('form-cita').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = e.target;
            const data = {
                fecha: form.fecha.value,
                hora: form.hora.value,
                estado: form.estado.value,
                motivo: form.motivo.value,
                total: parseFloat(form.total.value),
                cedula: form.cedula.value,
                odontologo: form.odontologo.value,
            };

            try {
                const response = await fetch('/api/registrarcita', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    document.getElementById('mensaje').innerText = result.message;
                    form.reset();
                } else {
                    document.getElementById('mensaje').innerText = result.message || 'Error al registrar cita';
                }

            } catch (error) {
                console.error('Error:', error);
                document.getElementById('mensaje').innerText = 'Error en la conexión';
            }
        });
    </script>

</body>

</html>
