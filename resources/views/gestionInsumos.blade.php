<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Insumos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/Sgestion.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<bfody>
    <div class="main-container">
        <header class="header">
            <h1><i class="fas fa-dolly"></i> Gestión de Insumos</h1>
        </header>

        <section class="card">
            <h2 class="section-title">📦 Insumos Disponibles</h2>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Estado</th>
                        <th>Vence</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($insumos as $insumo)
                        <tr>
                            <td>{{ $insumo->nombre_insumo }}</td>
                            <td>
                                @if ($insumo->cantidad_insumo <= $insumo->umbral_alerta)
                                    <span class="badge badge-bajo">
                                        Bajo ({{ $insumo->cantidad_insumo }})
                                    </span>
                                @else
                                    <span class="badge badge-suficiente">
                                        Suficiente ({{ $insumo->cantidad_insumo }})
                                    </span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($insumo->fecha_vencimiento)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="card">
            <h2 class="section-title">📝 Solicitar Nuevo Insumo</h2>
            <form id="formInsumos" class="form">
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Seleccione un insumo</option>
                        <option value="Guantes de látex">Guantes de látex</option>
                        <option value="Algodón">Algodón</option>
                        <option value="Anestesia Local">Anestesia Local</option>
                        <option value="Gasas Estériles">Gasas Estériles</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" required placeholder="Ej: 10">
                </div>

                <div class="form-group">
                    <label for="proveedor">Proveedor:</label>
                    <select id="proveedor" name="proveedor" required>
                        <option value="">Seleccione un proveedor</option>
                    </select>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-solicitar"><i class="fas fa-paper-plane"></i>
                        Solicitar</button>
                    <button type="button" id="limpiarBtn" class="btn btn-limpiar"><i class="fas fa-eraser"></i>
                        Limpiar</button>
                </div>
            </form>
        </section>

        <section class="card">
            <h2 class="section-title">📋 Estados de Solicitudes</h2>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Guantes de látex</td>
                        <td><span class="badge badge-enviado">Ordenado</span></td>
                    </tr>
                    <tr>
                        <td>Proteína parcial (zirconio)</td>
                        <td><span class="badge badge-produccion">En producción</span></td>
                    </tr>
                    <tr>
                        <td>Anestesia Local</td>
                        <td><span class="badge badge-listo">Listo para entregar</span></td>
                    </tr>
                    <tr>
                        <td>Gasas Estériles</td>
                        <td><span class="badge badge-entregado">Entregado</span></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="final-section">
            <button id="regresarBtn" class="btn btn-regresar">
                Regresar a Inicio <i class="fas fa-arrow-left"></i>
            </button>
        </section>
    </div>

    <script>
        document.getElementById("limpiarBtn").addEventListener("click", function () {
            Swal.fire({
                icon: 'warning',
                title: '¿Deseas limpiar el formulario?',
                showCancelButton: true,
                confirmButtonColor: '#00c3a5',
                cancelButtonColor: '#ff6b6b',
                confirmButtonText: 'Sí, limpiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formInsumos").reset();
                }
            });
        });

        document.getElementById("regresarBtn").addEventListener("click", function () {
            const rol = @json(Auth::user()->rol_id) || null;
            console.log(rol);
            if (rol === 2) {
                window.location.href = "/odontologo";
            } else if (rol === 1) {
                window.location.href = "/administrador";
            } else if (rol === 4) {
                window.location.href = "/laboratorista";
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Rol desconocido',
                    text: 'No se pudo determinar a dónde regresar.',
                    confirmButtonColor: '#e53935',
                });
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            fetch("/api/proveedores/listar")
                .then(response => response.json())
                .then(data => {
                    const proveedorSelect = document.getElementById("proveedor");
                    proveedorSelect.innerHTML = `<option value="">Seleccione un proveedor</option>`;
                    data.forEach(proveedor => {
                        proveedorSelect.innerHTML += `
                            <option value="${proveedor.nit}">
                                ${proveedor.nombre_proveedor} (${proveedor.correo_proveedor})
                            </option>`;
                    });
                })
                .catch(error => {
                    console.error("Error al cargar proveedores:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los proveedores disponibles.',
                        confirmButtonColor: '#e53935',
                    });
                });
        });

        document.getElementById("formInsumos").addEventListener("submit", function (e) {
            e.preventDefault();

            const tipo = document.getElementById("tipo").value;
            const cantidad = document.getElementById("cantidad").value;
            const proveedor = document.getElementById("proveedor").value;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("/api/solicitar-insumo", {
                method: "POST",
                credentials: 'include', // <— para enviar la cookie de sesión/Sanctum
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken // <— el token que Laravel espera
                },
                body: JSON.stringify({
                    tipo,
                    cantidad,
                    proveedor
                })
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error || "Error al enviar la solicitud.");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Solicitud enviada!',
                        text: data.message,
                        confirmButtonColor: '#00c3a5',
                    });
                    document.getElementById("formInsumos").reset();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                        confirmButtonColor: '#e53935',
                    });
                });
        });
    </script>

    </body>

</html>