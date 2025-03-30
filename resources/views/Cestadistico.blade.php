<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Estadístico</title>
    <link rel="stylesheet" href="{{ asset('css/Cestadistico.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Header -->
    <header>
        <a href="/cajero" class="back-button">← Volver</a>
        <h1>Sistema Estadístico</h1>
    </header>

    <!-- Contenedor Principal -->
    <main>
        <div class="dashboard">

            <!-- Citas -->
            <div class="card" onclick="generarGrafico('citas')">
                <h2>Citas</h2>
                <p>✅ Atendidas: <strong>120</strong></p>
                <p>❌ Canceladas: <strong>15</strong></p>
            </div>

            <!-- Facturación -->
            <div class="card" onclick="generarGrafico('facturacion')">
                <h2>Facturación</h2>
                <p>💰 Ingresos: <strong>$3,200,000</strong></p>
                <p>📉 Pagos: <strong>$1,100,000</strong></p>
            </div>

            <!-- Inventario -->
            <div class="card" onclick="generarGrafico('inventario')">
                <h2>Inventario</h2>
                <p>📦 Productos disponibles: <strong>85</strong></p>
                <p>⚠️ En riesgo de agotarse: <strong>5</strong></p>
            </div>

            <!-- Desempeño del Personal -->
            <div class="card" onclick="generarGrafico('desempeno')">
                <h2>Desempeño del Personal</h2>
                <p>👨‍⚕️ Procedimientos realizados por odontólogos:</p>
                <ul>
                    <li>Dr. Pérez: <strong>45</strong></li>
                    <li>Dr. Gómez: <strong>38</strong></li>
                    <li>Dra. López: <strong>52</strong></li>
                </ul>
            </div>

        </div>

        <!-- Contenedor del gráfico -->
        <div class="chart-container">
            <canvas id="grafico"></canvas>
        </div>

    </main>

    <script>
        let chart = null;

        function generarGrafico(tipo) {
    const canvas = document.getElementById('grafico');
    const ctx = canvas.getContext('2d');
    const chartContainer = document.querySelector('.chart-container');

    // Mostrar el contenedor del gráfico
    chartContainer.style.display = 'block';

    // Verificar que el canvas tenga un contexto válido
    if (!ctx) {
        console.error("Error: No se pudo obtener el contexto del canvas.");
        return;
    }

    // Destruir gráfico previo si existe
    if (chart) {
        chart.destroy();
    }

    let datos = {};
    let titulo = "";

    switch (tipo) {
        case 'citas':
            titulo = "Estado de las Citas";
            datos = {
                labels: ["Atendidas", "Canceladas"],
                datasets: [{
                    label: "Cantidad",
                    data: [120, 15],
                    backgroundColor: ["#4CAF50", "#FF3D00"]
                }]
            };
            break;

        case 'facturacion':
            titulo = "Facturación";
            datos = {
                labels: ["Ingresos", "Pagos"],
                datasets: [{
                    label: "Monto ($)",
                    data: [3200000, 1100000],
                    backgroundColor: ["#2196F3", "#FF9800"]
                }]
            };
            break;

        case 'inventario':
            titulo = "Inventario";
            datos = {
                labels: ["Disponibles", "En riesgo de agotarse"],
                datasets: [{
                    label: "Cantidad",
                    data: [85, 5],
                    backgroundColor: ["#3F51B5", "#FFC107"]
                }]
            };
            break;

        case 'desempeno':
            titulo = "Desempeño del Personal";
            datos = {
                labels: ["Dr. Pérez", "Dr. Gómez", "Dra. López"],
                datasets: [{
                    label: "Procedimientos Realizados",
                    data: [45, 38, 52],
                    backgroundColor: ["#8E24AA", "#D81B60", "#43A047"]
                }]
            };
            break;
    }

    // Crear el gráfico
    chart = new Chart(ctx, {
        type: 'bar',
        data: datos,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: titulo,
                    font: {
                        size: 18
                    }
                }
            }
        }
    });
}

    </script>

</body>
</html>
