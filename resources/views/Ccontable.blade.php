<?php

session_start();

// Variables de ejemplo (esto debería venir de una base de datos en una versión final)
$ingresos = [
    ["fecha" => "2025-03-01", "descripcion" => "Pago de consulta - Paciente A", "monto" => 50000],
    ["fecha" => "2025-03-05", "descripcion" => "Pago de tratamiento - Paciente B", "monto" => 120000]
];

$egresos = [
    ["fecha" => "2025-03-03", "descripcion" => "Compra de insumos dentales", "monto" => 30000],
    ["fecha" => "2025-03-07", "descripcion" => "Pago de nómina", "monto" => 200000]
];

// Cálculo del balance
$totalIngresos = array_sum(array_column($ingresos, "monto"));
$totalEgresos = array_sum(array_column($egresos, "monto"));
$saldoNeto = $totalIngresos - $totalEgresos;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Contable</title>
    <link rel="stylesheet" href="{{ asset('css/Ccontable.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="container">
        <h1>Sistema Contable</h1>

        <!-- Resumen Financiero -->
        <section class="resumen-financiero">
            <h2>Resumen Financiero</h2>
            <p><strong>Ingresos Totales:</strong> $<?php echo number_format($totalIngresos); ?></p>
            <p><strong>Egresos Totales:</strong> $<?php echo number_format($totalEgresos); ?></p>
            <p><strong>Saldo Neto:</strong> $<?php echo number_format($saldoNeto); ?></p>
        </section>

        <!-- Historial de Movimientos -->
        <section class="historial">
            <h2>Historial de Movimientos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ingresos as $mov) : ?>
                        <tr class="ingreso">
                            <td><?php echo $mov["fecha"]; ?></td>
                            <td><?php echo $mov["descripcion"]; ?></td>
                            <td>$<?php echo number_format($mov["monto"]); ?></td>
                            <td>Ingreso</td>
                        </tr>
                    <?php endforeach; ?>
                    <?php foreach ($egresos as $mov) : ?>
                        <tr class="egreso">
                            <td><?php echo $mov["fecha"]; ?></td>
                            <td><?php echo $mov["descripcion"]; ?></td>
                            <td>$<?php echo number_format($mov["monto"]); ?></td>
                            <td>Egreso</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Gráfica de Flujo de Dinero -->
        <section class="grafico">
            <h2>Flujo de Dinero</h2>
            <canvas id="graficoFlujo"></canvas>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
                            font: { size: 16 }
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>
