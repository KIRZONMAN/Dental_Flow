<!-- cajero.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cajero</title>
    <link rel="stylesheet" href="{{ asset('css/Scajero.css') }}">
</head>

<body>

    <!-- Header -->
    <header>
        <div class="menu-container">
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">≣</label>
            <ul class="dropdown-menu">
                <li><a href="/cajero/cformulario">🧾 Generación de Facturas</a></li>
                <li><a href="/gestionInsumos">📦 Gestión de Insumos</a></li>
                <li><a href="/cajero/cestadistico">📊 Sistema Estadístico</a></li>
                <li><a href="/cajero/ccontable">💰 Sistema Contable</a></li>
            </ul>

        </div>
        <h1 class="titulo-principal">Cajero</h1>
    </header>

    <!-- Contenedor Principal -->
    <main>
        <section class="container">
            <h2 class="subtitulo">Resumen del día</h2>
            <p class="descripcion">Consulta información relevante como facturación reciente, insumos críticos y
                estadísticas clave del sistema.</p>

            <!-- Tarjetas con información clave -->
            <div class="summary-cards">
                <div class="card">
                    <h3>🧾 Facturas generadas</h3>
                    <p>15 hoy</p>
                </div>
                <div class="card">
                    <h3>📦 Insumos bajos</h3>
                    <p>3 artículos</p>
                </div>
                <div class="card">
                    <h3>💰 Ingresos del día</h3>
                    <p>$1,250,000</p>
                </div>
            </div>
        </section>
    </main>

</body>

</html>
