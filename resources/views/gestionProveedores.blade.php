<!-- resources/views/gestionProveedores.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="mb-4 text-primary">Gestión de Proveedores</h2>

    <!-- Formulario -->
    <form id="proveedorForm" class="card shadow-sm p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="NIT" id="nit" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Nombre" id="nombre" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Teléfono" id="telefono" required>
            </div>
            <div class="col-md-3">
                <input type="email" class="form-control" placeholder="Correo" id="correo" required>
            </div>
        </div>
        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
        </div>
    </form>

    <!-- Tabla -->
    <div class="card shadow-sm p-3">
        <h5>Lista de Proveedores</h5>
        <table class="table table-bordered table-hover mt-3 bg-white">
            <thead class="table-primary">
                <tr>
                    <th>NIT</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaProveedores">
                <!-- Datos cargados dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', obtenerProveedores);
    const form = document.getElementById('proveedorForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const proveedor = {
            nit: document.getElementById('nit').value,
            nombre: document.getElementById('nombre').value,
            telefono: document.getElementById('telefono').value,
            correo: document.getElementById('correo').value
        };

        fetch('/api/proveedores', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(proveedor)
        }).then(res => res.json())
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
                            <td>
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
            fetch('/api/proveedores/' + nit, {
                method: 'DELETE'
            }).then(res => res.json())
              .then(data => {
                  alert(data.message);
                  obtenerProveedores();
              });
        }
    }
</script>
</body>
</html>
