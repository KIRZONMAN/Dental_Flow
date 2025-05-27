<!-- resources/views/gestionProveedores.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Proveedores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">

        <!-- Volver -->
        <div class="mb-4">
            <a href="{{ route('administrador.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>

        <!-- Título -->
        <h2 class="mb-4 text-primary">Gestión de Proveedores</h2>

        <!-- Formulario -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="proveedorForm" class="row g-3">
                    <div class="col-12 col-md-3">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nit" placeholder="NIT" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" placeholder="Correo" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="reset" class="btn btn-secondary me-2">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Lista de Proveedores</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>NIT</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProveedores">
                            <!-- Datos cargados dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <!-- Tu lógica de fetch -->
    <script>
        document.addEventListener('DOMContentLoaded', obtenerProveedores);
        const form = document.getElementById('proveedorForm');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const proveedor = {
                nit: document.getElementById('nit').value,
                nombre: document.getElementById('nombre').value,
                telefono: document.getElementById('telefono').value,
                correo: document.getElementById('correo').value
            };
            fetch('/api/proveedores', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(proveedor)
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                form.reset();
                obtenerProveedores();
            });
        });

        function obtenerProveedores() {
            fetch('/api/proveedores')
                .then(res => res.json())
                .then(data => {
                    const tabla = document.getElementById('tablaProveedores');
                    tabla.innerHTML = '';
                    data.forEach(p => {
                        tabla.innerHTML += `
                        <tr>
                            <td>${p.nit}</td>
                            <td>${p.nombre_proveedor}</td>
                            <td>${p.telefono_proveedor}</td>
                            <td>${p.correo_proveedor}</td>
                            <td class="text-center">
                                <button onclick="eliminarProveedor('${p.nit}')" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`;
                    });
                });
        }

        function eliminarProveedor(nit) {
            if (confirm('¿Estás seguro de eliminar este proveedor?')) {
                fetch('/api/proveedores/' + nit, { method: 'DELETE' })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        obtenerProveedores();
                    });
            }
        }
    </script>
</body>
</html>
