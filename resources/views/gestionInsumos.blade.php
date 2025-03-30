<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/Sgestion.css') }}">

    <title>Gestionar Insumos</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gestionar Insumos</h1>
        </div>

        <div class="section">
            <div class="section-title">Insumos Disponibles</div>
            <table class="insumos-table">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Guantes de látex</td>
                        <td>Bajo Stock (5 unidades)</td>
                        <td>Feb 5</td>
                    </tr>
                    <tr>
                        <td>Algodón</td>
                        <td>Suficiente (20 unidades)</td>
                        <td>05/03/27</td>
                    </tr>
                    <tr>
                        <td>Anestesia Local</td>
                        <td>Bajo Stock (3 unidades)</td>
                        <td>05/03/27</td>
                    </tr>
                    <tr>
                        <td>Gasas Estériles</td>
                        <td>Suficiente (30 unidades)</td>
                        <td>05/03/27</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Solicitar Nuevo Insumo</div>
            <div class="form-section">
                <form id="formInsumos">
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo">
                        <option value="guantes">Guantes de látex</option>
                        <option value="algodon">Algodón</option>
                        <option value="anestesia">Anestesia Local</option>
                        <option value="gasas">Gasas Estériles</option>
                    </select>

                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="1">

                    <label for="proveedor">Proveedor:</label>
                    <select id="proveedor" name="proveedor">
                        <option value="proveedor1">Proveedor 1</option>
                        <option value="proveedor2">Proveedor 2</option>
                    </select>

                    <button type="submit">Solicitar</button>
                    <button type="button" id="limpiarBtn">Limpiar</button>
                </form>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Estados</div>
            <table class="status-table">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Guantes de látex</td>
                        <td>Ordenado</td>
                    </tr>
                    <tr>
                        <td>Proteína parcial (zirconio)</td>
                        <td>En producción</td>
                    </tr>
                    <tr>
                        <td>Anestesia Local</td>
                        <td>Listo para entregar</td>
                    </tr>
                    <tr>
                        <td>Gasas Estériles</td>
                        <td>Entregado</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Botón "Regresar" al final de la página -->
        <div class="section">
            <button id="regresarBtn">Regresar</button>
        </div>
    </div>

    <script>
        // Funcionalidad del botón "Limpiar"
        document.getElementById("limpiarBtn").addEventListener("click", function() {
            document.getElementById("formInsumos").reset();
        });

        // Funcionalidad del botón "Regresar"
        document.getElementById("regresarBtn").addEventListener("click", function() {
            window.location.href = "/odontologo";
        });
    </script>
</body>

</html>
