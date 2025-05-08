<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pacientes</title>

    <!-- Bootstrap & Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/SAhistorial.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <!-- ENCABEZADO -->
    <header class="bg-primary text-white py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/asistente" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i> Volver</a>
            <h2 class="mb-0"><i class="fas fa-notes-medical"></i> Historial de Pacientes</h2>
        </div>
    </header>

    <!-- BÚSQUEDA -->
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 col-lg-6">
                    <div class="input-group shadow-sm">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="🔍 Buscar por nombre o cédula">
                        <button id="toggleTablaBtn" class="btn btn-info text-white" onclick="buscarPaciente()">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-responsive" id="tablaPacientes">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Paciente</th>
                            <th>Cédula</th>
                            <th>Edad</th>
                            <th>Telefono</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($pacientes as $paciente)
                                    <td>{{ $paciente->nombre_completo_paciente }}</td>
                                    <td>{{ $paciente->cedula }}</td>
                                    <td>{{ $paciente->edad }}</td>
                                    <td>{{ $paciente->telefono_paciente }}</td>
                                    <td>{{ $paciente->correo_paciente }}</td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RESULTADOS -->
            <div id="resultados" class="row gy-4 justify-content-center">

            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lógica JS -->
    <script>
        let tablaVisible = true;

        const toggleTablaBtn = document.getElementById("toggleTablaBtn");
        const resultados = document.getElementById("resultados");
        const tablaPacientes = document.getElementById("tablaPacientes");

        toggleTablaBtn.addEventListener("click", function () {
            tablaVisible = !tablaVisible;
            tablaPacientes.classList.toggle("d-none", !tablaVisible);
            resultados.classList.toggle("d-none", tablaVisible);
            toggleTablaBtn.innerHTML = tablaVisible
                ? '<i class="fas fa-search"></i> Buscar'
                : '<i class="fas fa-eye"></i> Mostrar';
        });
    </script>

<script>
        function buscarPaciente() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const resultadosDiv = document.getElementById('resultados');
            resultadosDiv.innerHTML = "";

            fetch(`/api/buscar-paciente/${input}`)
                .then(response => response.json())
                .then(data => {
                    if (data.paciente) {
                        // Si encontramos el paciente, mostramos la información
                        resultadosDiv.innerHTML = `
                    <div class="col-md-6 col-lg-5 col-xl-4">
                        <div class="card shadow paciente-card border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><i class="fas fa-user-circle"></i> ${data.paciente.nombre_completo_paciente}</h5>
                                <p class="card-text"><strong>🧬 Edad:</strong> ${data.paciente.edad} años</p>
                                <p class="card-text"><strong>📞 Teléfono:</strong> ${data.paciente.telefono_paciente}</p>
                                <p class="card-text"><strong>✉️ Correo:</strong> ${data.paciente.correo_paciente}</p>
                                <button class="btn btn-primary w-100 mt-3" onclick="descargarPDF('${data.paciente.nombre_completo_paciente}')">
                                    <i class="fas fa-file-pdf"></i> Descargar Historia Clínica
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    } else {
                        // Si no encontramos al paciente, mostramos un mensaje de error
                        resultadosDiv.innerHTML = `
                    <div class="col-12 text-center text-danger">
                        <i class="fas fa-user-times fa-2x mb-2"></i>
                        <p>No se encontraron pacientes.</p>
                    </div>
                `;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

    </script>
    <script>
    function descargarPDF(nombrePaciente) {
        alert(`Descargando historia clínica de ${nombrePaciente}`);
    }
</script>

</body>

</html>
