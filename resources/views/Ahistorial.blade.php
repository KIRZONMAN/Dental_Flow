<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pacientes</title>
    <link rel="stylesheet" href="{{ asset('css/SAhistorial.css') }}">

</head>
<body>

<header>
    <div class="header-content">
        <a href="/asistente" class="back-button">⬅ Volver</a>
        <h2>📋 Historial de Pacientes</h2>
    </div>
</header>

<main>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="🔍 Buscar por nombre o cédula">
        <button onclick="buscarPaciente()">Buscar</button>
    </div>

    <div id="resultados" class="resultados-container"></div>
</main>

<script>
function buscarPaciente() {
    let input = document.getElementById('searchInput').value.toLowerCase();
    let resultadosDiv = document.getElementById('resultados');
    resultadosDiv.innerHTML = "";

    let pacientes = [
        { nombre: "Carlos Pérez", cedula: "12345678", edad: "32", telefono: "3123456789", correo: "carlos@mail.com" },
        { nombre: "Andrea Gómez", cedula: "87654321", edad: "29", telefono: "3216549870", correo: "andrea@mail.com" }
    ];

    let encontrados = pacientes.filter(p => p.nombre.toLowerCase().includes(input) || p.cedula.includes(input));

    if (encontrados.length > 0) {
        encontrados.forEach(paciente => {
            resultadosDiv.innerHTML += `
                <div class="paciente-card">
                    <h3>${paciente.nombre}</h3>
                    <p><strong>Edad:</strong> ${paciente.edad} años</p>
                    <p><strong>Teléfono:</strong> ${paciente.telefono}</p>
                    <p><strong>Correo:</strong> ${paciente.correo}</p>
                    <button onclick="descargarPDF('${paciente.nombre}')">📄 Descargar Historia Clínica</button>
                </div>
            `;
        });
    } else {
        resultadosDiv.innerHTML = "<p>No se encontraron pacientes.</p>";
    }
}

function descargarPDF(nombre) {
    alert("Generando PDF de " + nombre);
}
</script>

</body>
</html>
