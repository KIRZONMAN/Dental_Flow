<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Estadístico</title>
    <link rel="stylesheet" href="{{ asset('css/Cestadistico.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Encabezado -->
    <header class="header">
        <a href="/cajero" class="back-button">← Volver</a>
        <h1 class="titulo">📊 Sistema Estadístico</h1>
    </header>

    <!-- Contenido principal -->
    <main class="container-fluid seccion-principal">
        <section class="row g-4 justify-content-center">

            <!-- Tarjeta: Citas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('citas')">
                    <h2>📅 Citas</h2>
                    <p>✅ Atendidas: <strong>120</strong></p>
                    <p>❌ Canceladas: <strong>15</strong></p>
                </div>
            </div>

            <!-- Tarjeta: Facturación -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('facturacion')">
                    <h2>💸 Facturación</h2>
                    <p>💰 Ingresos: <strong>$3,200,000</strong></p>
                    <p>📉 Pagos: <strong>$1,100,000</strong></p>
                </div>
            </div>

            <!-- Tarjeta: Inventario -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('inventario')">
                    <h2>📦 Inventario</h2>
                    <p>🟢 Disponibles: <strong>85</strong></p>
                    <p>⚠️ Riesgo de agotarse: <strong>5</strong></p>
                </div>
            </div>

            <!-- Tarjeta: Desempeño -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('desempeno')">
                    <h2>👥 Desempeño</h2>
                    <p>👨‍⚕️ Procedimientos:</p>
                    <ul class="lista-odontologos">
                        <li>Dr. Pérez: <strong>45</strong></li>
                        <li>Dr. Gómez: <strong>38</strong></li>
                        <li>Dra. López: <strong>52</strong></li>
                    </ul>
                </div>
            </div>

        </section>

        <!-- Selector de tipo de gráfico -->
        <div class="tipo-grafico-container">
            <label for="tipoGrafico">📈 Tipo de gráfico:</label>
            <select id="tipoGrafico" class="form-select w-auto d-inline-block ms-2">
                <option value="bar">Barras</option>
                <option value="pie">Pastel</option>
                <option value="doughnut">Dona</option>
            </select>
        </div>

        <!-- Contenedor para gráfico -->
        <section class="chart-section">
            <div class="chart-container">
                <canvas id="grafico"></canvas>
            </div>
        </section>
    </main>

    <script>
        let chart = null;

        function generarGrafico(tipo) {
            const tipoGrafico = document.getElementById('tipoGrafico').value;
            const canvas = document.getElementById('grafico');
            const ctx = canvas.getContext('2d');
            const chartContainer = document.querySelector('.chart-container');
            chartContainer.style.display = 'block';

            if (!ctx) {
                console.error("Error al obtener el contexto del canvas.");
                return;
            }

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
                            label: "Procedimientos",
                            data: [45, 38, 52],
                            backgroundColor: ["#8E24AA", "#D81B60", "#43A047"]
                        }]
                    };
                    break;
            }

            chart = new Chart(ctx, {
                type: tipoGrafico,
                data: datos,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutBounce'
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: titulo,
                            font: { size: 22 }
                        },
                        legend: {
                            display: tipoGrafico !== 'bar',
                            position: 'bottom'
                        }
                    },
                    scales: tipoGrafico === 'bar' ? {
                        y: { beginAtZero: true }
                    } : {}
                }
            });
        }
    </script>
</body>
</html>
