<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Solicitudes</title>
    <link rel="stylesheet" href="{{ asset('css/AdminSolicitudes.css') }}">

</head>
<body>
    <h2 class="titulo">Solicitudes</h2>
    <div class="filters">
        <label for="productFilter">Filtrar por producto:</label>
        <select id="productFilter">
            <option value="">Ninguno</option>
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
        </select>

        <label for="statusFilter">Filtrar por estado:</label>
        <select id="statusFilter">
            <option value="">Ninguno</option>
            <option value="asc">Orden Estado(ASC)</option>
            <option value="desc">Orden Estado(DES)</option>
        </select>
    </div>

    <table class="tabla-pedidos">
        <tbody>
            <tr>
                <th>🦷 Carillas</th>
                <td>📩 Ordenado</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Prótesis parcial (zirconio)</th>
                <td>🕒 En producción</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Retenedores</th>
                <td>🚐 Listo para entregar</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Moldes</th>
                <td>✅ Entregado</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Implantes dentales</th>
                <td>📩 Ordenado</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Coronas de porcelana</th>
                <td>🕒 En producción</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Gel de blanqueamiento dental</th>
                <td>🚐 Listo para entregar</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
            <tr>
                <th>🦷 Protesis total de porcelana</th>
                <td>✅ Entregado</td>
                <td><button class="menu-button">Menú</button></td>
            </tr>
        </tbody>
    </table>

    <div id="menu" class="menu">
        <button onclick="changeStatus('📩 Ordenado')">📩 Ordenado</button>
        <button onclick="changeStatus('🕒 En producción')">🕒 En producción</button>
        <button onclick="changeStatus('🚐 Listo para entregar')">🚐 Listo para entregar</button>
        <button onclick="changeStatus('✅ Entregado')">✅ Entregado</button>
    </div>

    <a href="/administrador" class="btn-regresar">Regresar al menú</a>

    <!-- Script de Menu y Filtros-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const menuButtons = document.querySelectorAll('.menu-button');
    const menu = document.getElementById('menu');
    const productFilter = document.getElementById('productFilter');
    const statusFilter = document.getElementById('statusFilter');
    let rows = Array.from(document.querySelectorAll('.tabla-pedidos tbody tr'));

    productFilter.addEventListener('change', handleFilterChange);
    statusFilter.addEventListener('change', handleFilterChange);

    menuButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            const row = event.target.parentNode.parentNode;
            const statusCell = row.querySelector('td:nth-child(2)');
            showMenu(event, statusCell);
        });
    });

    window.addEventListener('click', function(event) {
        if (!menu.contains(event.target) && !event.target.classList.contains('menu-button')) {
            menu.style.display = 'none';
        }
    });

    function handleFilterChange() {
        const productValue = productFilter.value;
        const statusValue = statusFilter.value;

        // Sort the rows based on the selected filters
        if (productValue === 'asc' || productValue === 'desc') {
            sortTable(productValue === 'asc' ? 'product-asc' : 'product-desc');
        }

        if (statusValue === 'asc' || statusValue === 'desc') {
            sortTable(statusValue === 'asc' ? 'status-asc' : 'status-desc');
        }

        // Filter the rows based on the selected filters
        filterTable(productValue, statusValue);
    }

    function filterTable(productValue, statusValue) {
        rows.forEach(row => {
            const productCell = row.querySelector('th').textContent.toLowerCase();
            const statusCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            let productMatch = true;
            let statusMatch = true;

            if (productValue !== 'asc' && productValue !== 'desc' && productValue) {
                productMatch = productCell.includes(productValue);
            }

            if (statusValue !== 'asc' && statusValue !== 'desc' && statusValue) {
                statusMatch = statusCell.includes(statusValue);
            }

            row.style.display = productMatch && statusMatch ? '' : 'none';
        });
    }

    function sortTable(criteria) {
        const order = {
            'product-asc': (a, b) => a.querySelector('th').textContent.localeCompare(b.querySelector('th').textContent),
            'product-desc': (a, b) => b.querySelector('th').textContent.localeCompare(a.querySelector('th').textContent),
            'status-asc': (a, b) => {
                const statusOrder = ['📩 Ordenado', '🕒 En producción', '🚐 Listo para entregar', '✅ Entregado'];
                return statusOrder.indexOf(a.querySelector('td:nth-child(2)').textContent) - statusOrder.indexOf(b.querySelector('td:nth-child(2)').textContent);
            },
            'status-desc': (a, b) => {
                const statusOrder = ['📩 Ordenado', '🕒 En producción', '🚐 Listo para entregar', '✅ Entregado'];
                return statusOrder.indexOf(b.querySelector('td:nth-child(2)').textContent) - statusOrder.indexOf(a.querySelector('td:nth-child(2)').textContent);
            }
        };

        rows.sort(order[criteria]);

        const tbody = document.querySelector('.tabla-pedidos tbody');
        tbody.innerHTML = ''; // Clear the current rows
        rows.forEach(row => tbody.appendChild(row)); // Append all sorted rows
    }

    function showMenu(event, statusCell) {
        const menu = document.getElementById('menu');
        menu.style.display = 'block';
        menu.style.top = `${event.pageY}px`;
        menu.style.left = `${event.pageX}px`;

        window.changeStatus = function(newStatus) {
            statusCell.textContent = newStatus;
            menu.style.display = 'none';
        };
    }
});

    </script>
</body>
</html>
