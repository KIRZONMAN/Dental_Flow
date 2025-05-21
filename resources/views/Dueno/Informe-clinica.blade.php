<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Contable | DentalFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Destadistico.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Encabezado -->
    <header class="headerContable">
        <h1 class="titulo">Informe de la clínica</h1>
        <a href="dueno" class="back-button">← Volver</a>
    </header>
    <div class="contable-wrapper container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11 contable-card shadow-lg rounded-4 p-4 bg-white">
                <!-- Resumen Financiero -->
                <section class="resumen-financiero mb-5 p-4 rounded-4">
                    <h2 class="mb-4">Resumen Financiero de los últimos 30 días</h2>
                    <div class="row text-center resumen-datos">
                        <div class="col-md-4">
                            <div class="resumen-box bg-light border shadow-sm rounded-3 p-3">
                                <h5>Ingresos Totales</h5>
                                <p class="fw-bold text-success">${{number_format($ingresos, 2)}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="resumen-box bg-light border shadow-sm rounded-3 p-3">
                                <h5>Egresos Totales</h5>
                                <p class="fw-bold text-danger">-${{ number_format($gastos, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="resumen-box bg-light border shadow-sm rounded-3 p-3">
                                <h5>Saldo Neto</h5>
                                <p class="fw-bold 
                                @if ($ingresos - $gastos < 0)
                                    text-danger 
                                @else ($ingresos - $gastos > 0)
                                    text-success
                                @endif
                                    "> ${{ number_format($ingresos - $gastos, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Historial de Movimientos -->
                <section class="historial mb-5">
                    <h2 class="mb-3">Historial de Movimientos</h2>
                    <div class="table-responsive rounded-4 shadow-sm">
                        <div id="tabla-transacciones"></div>
                        <div id="paginacion"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Encabezado del Sistema Estadístico -->
    <header class="headerEstadistico">
        <h1 class="titulo">📊 Sistema Estadístico</h1>
    </header>

    <!-- Contenido principal -->
    <main class="container-fluid seccion-principal">
        <section class="row g-4 justify-content-center">

            <!-- Tarjeta: Citas -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('citas')">
                    <h2>📅 Citas</h2>
                    <p>✅ Atendidas: <strong>{{$completadas}}</strong></p>
                    <p>❌ Canceladas: <strong>{{$canceladas}}</strong></p>
                </div>
            </div>

            <!-- Tarjeta: Facturación -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('facturacion')">
                    <h2>💸 Facturación</h2>
                    <p>💰 Ingresos: <strong>${{ number_format($ingresos, 2) }}</strong></p>
                    <p>📉 Pagos: <strong>-${{ number_format($gastos, 2) }}</strong></p>
                </div>
            </div>

            <!-- Tarjeta: Inventario -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('inventario')">
                    <h2>📦 Inventario</h2>
                    <p>🟢 Disponibles: <strong>{{ $total_insumos }}</strong></p>
                    <p>⚠️ Riesgo de agotarse: <strong>{{ $en_riesgo }}</strong></p>
                </div>
            </div>

            <!-- Tarjeta: Desempeño -->
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card-estadistica" onclick="generarGrafico('desempeno')">
                    <h2>👥 Desempeño</h2>
                    <p>👨‍⚕️ Procedimientos:</p>
                    <ul class="lista-odontologos">
                        @foreach ($conteo_procedimientos_odontologo as $procedimientos)
                            <li>{{ $procedimientos->nombre_completo_odontologo }}:
                                <strong>{{ $procedimientos->cantidad }}</strong>
                            </li>
                        @endforeach
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
        let globalActual = null;
        function generarGrafico(tipo) {
            const tipoGrafico = document.getElementById('tipoGrafico').value;
            globalActual = tipo;
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
                            data: [{{ $completadas }}, {{$canceladas}}],
                            backgroundColor: ["#4CAF50", "#FF3D00"]
                        }]
                    };
                    break;
                case 'facturacion':
                    titulo = "Facturación";
                    datos = {
                        labels: ["Ingresos", "Gastos"],
                        datasets: [{
                            label: "Monto ($)",
                            data: [{{$ingresos}}, {{$gastos}}],
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
                            data: [{{ $total_insumos }}, {{ $en_riesgo }}],
                            backgroundColor: ["#3F51B5", "#FFC107"]
                        }]
                    };
                    break;
                case 'desempeno':
                    titulo = "Desempeño del Personal";
                    datos = {
                        labels: [
                            @foreach ($conteo_procedimientos_odontologo as $procedimientos)
                                "Dr. {{ $procedimientos->nombre_completo_odontologo }}",
                            @endforeach
                            ],
                        datasets: [{
                            label: "Procedimientos",
                            data: [
                                @foreach ($conteo_procedimientos_odontologo as $p)
                                    {{ $p->cantidad }},
                                @endforeach
                                ],
                            backgroundColor: ["#8E24AA", "#D81B60", "#43A047", "#FF7043", "#039BE5", "#F57C00", "#8D6E63", "#7B1FA2", "#C2185B", "#388E3C", "#FFA000", "#546E7A"]
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
        document.getElementById('tipoGrafico').addEventListener('change', function () {
            generarGrafico(globalActual);
        });
    </script>

    <!-- Script para cargar datos historial de movimientos -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            cargarDatos('/api/historial-movimientos?limit=10&page=1');
        });

        function cargarDatos(url) {
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    mostrarTabla(data.data);
                    mostrarPaginacion(data);
                })

                .catch(() => {
                    document.getElementById('tabla-transacciones').innerHTML = '<p>Error cargando datos.</p>';
                    document.getElementById('paginacion').innerHTML = '';
                });
        }

        function mostrarTabla(datos) {
            if (!datos || !Array.isArray(datos) || datos.length === 0) {
                document.getElementById('tabla-transacciones').innerHTML = '<p>No hay datos para mostrar.</p>';
                return;
            }

            let html = `<table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-primary">
            <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>`;

            datos.forEach(item => {
                const total = parseFloat(item.total) || 0;
                const claseFila = item.tipo === 'Ingreso' ? 'table-success' : 'table-danger';
                const simbolo = item.tipo === 'Ingreso' ? '+' : '-';
                const badgeColor = item.tipo === 'Ingreso' ? 'bg-success' : 'bg-danger';

                html += `<tr class="${claseFila}">
            <td>${formatearFecha(item.fecha)}</td>
            <td>${item.descripcion}</td>
            <td>${simbolo}$${total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td><span class="badge ${badgeColor}">${item.tipo}</span></td>
        </tr>`;
            });

            html += `</tbody></table>`;
            document.getElementById('tabla-transacciones').innerHTML = html;
        }

        function mostrarPaginacion(data) {
            let html = '';

            if (data.prev_page_url) {
                html += `<button id="anterior" onclick="cargarDatos('${data.prev_page_url}')">Anterior</button>`;
            }

            html += ` Página ${data.current_page} de ${data.last_page} `;

            if (data.next_page_url) {
                html += `<button id="siguiente" onclick="cargarDatos('${data.next_page_url}')">Siguiente</button>`;
            }

            document.getElementById('paginacion').innerHTML = html;
        }

        function formatearFecha(fechaStr) {
            if (!fechaStr) return '';
            const partes = fechaStr.split('-');
            if (partes.length !== 3) return fechaStr;

            const fecha = new Date(partes[0], partes[1] - 1, partes[2]);
            return fecha.toLocaleDateString();
        }

    </script>

    <!-- Pie de página -->
    <footer class="text-center py-3 text-muted small">
        &copy; {{ date('Y') }} Dental Flow. Todos los derechos reservados.
    </footer>
</body>

</html>