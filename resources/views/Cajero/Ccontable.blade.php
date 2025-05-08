<?php
session_start();

$ingresos = [['fecha' => '2025-03-01', 'descripcion' => 'Pago de consulta - Paciente A', 'monto' => 50000], ['fecha' => '2025-03-05', 'descripcion' => 'Pago de tratamiento - Paciente B', 'monto' => 120000]];
$egresos = [['fecha' => '2025-03-03', 'descripcion' => 'Compra de insumos dentales', 'monto' => 30000], ['fecha' => '2025-03-07', 'descripcion' => 'Pago de nómina', 'monto' => 200000]];

$totalIngresos = array_sum(array_column($ingresos, 'monto'));
$totalEgresos = array_sum(array_column($egresos, 'monto'));
$saldoNeto = $totalIngresos - $totalEgresos;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Contable | DentalFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Ccontable.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="contable-wrapper container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11 contable-card shadow-lg rounded-4 p-4 bg-white">

                <h1 class="text-center mb-4 text-primary">Sistema Contable</h1>

                <!-- Resumen Financiero -->
                <section class="resumen-financiero mb-5 p-4 rounded-4">
                    <h2 class="mb-4">Resumen Financiero</h2>
                    <div class="row text-center resumen-datos">
                        <div class="col-md-4">
                            <div class="resumen-box bg-light border shadow-sm rounded-3 p-3">
                                <h5>Ingresos Totales</h5>
                                <p class="fw-bold text-success">$<?php echo number_format($totalIngresos); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="resumen-box bg-light border shadow-sm rounded-3 p-3">
                                <h5>Egresos Totales</h5>
                                <p class="fw-bold text-danger">-$<?php echo number_format($totalEgresos); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="resumen-box bg-light border shadow-sm rounded-3 p-3">
                                <h5>Saldo Neto</h5>
                                <p class="fw-bold <?php echo $saldoNeto >= 0 ? 'text-success' : 'text-danger'; ?>">
                                    $<?php echo number_format($saldoNeto); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Historial de Movimientos -->
                <section class="historial mb-5">
                    <h2 class="mb-3">Historial de Movimientos</h2>
                    <div class="table-responsive rounded-4 shadow-sm">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Monto</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ingresos as $mov) : ?>
                                <tr class="table-success">
                                    <td><?php echo $mov['fecha']; ?></td>
                                    <td><?php echo $mov['descripcion']; ?></td>
                                    <td>$<?php echo number_format($mov['monto']); ?></td>
                                    <td><span class="badge bg-success">Ingreso</span></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach ($egresos as $mov) : ?>
                                <tr class="table-danger">
                                    <td><?php echo $mov['fecha']; ?></td>
                                    <td><?php echo $mov['descripcion']; ?></td>
                                    <td>-$<?php echo number_format($mov['monto']); ?></td>
                                    <td><span class="badge bg-danger">Egreso</span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Tarjeta Flotante para Mostrar/Ocultar Gráfica -->
                <div class="floating-graph-card shadow-lg rounded-4 p-3">
                    <button id="toggleGraph" class="btn btn-primary w-100 fw-bold">
                        <span id="toggleText">Mostrar Gráfica</span>
                    </button>
                </div>

                <!-- Gráfico de Flujo de Dinero -->
                <section id="graficoSection" class="grafico mb-4 d-none">
                    <h2 class="mb-4">Flujo de Dinero</h2>
                    <div id="graficoWrapper" class="grafico-wrapper d-flex justify-content-center">
                        <canvas id="graficoFlujo" class="grafico-canvas"></canvas>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- Scripts JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const graficoSection = document.getElementById("graficoSection");
            const toggleBtn = document.getElementById("toggleGraph");
            const toggleText = document.getElementById("toggleText");

            let chartVisible = false;

            toggleBtn.addEventListener("click", function () {
                chartVisible = !chartVisible;
                graficoSection.classList.toggle("d-none", !chartVisible);
                toggleText.textContent = chartVisible ? "Ocultar Gráfica" : "Mostrar Gráfica";
            });

            const ctx = document.getElementById('graficoFlujo').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Ingresos", "Egresos"],
                    datasets: [{
                        data: [<?php echo $totalIngresos; ?>, <?php echo $totalEgresos; ?>],
                        backgroundColor: ["#4CAF50", "#FF3D00"]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: "Distribución de Ingresos y Egresos",
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
