<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Insumos</title>
    <link rel="stylesheet" href="{{ asset('css/Sgestion.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="main-container">
        <header class="header">
            <h1><i class="fas fa-dolly"></i> Gestión de Insumos</h1>
        </header>

        <section class="card">
            <h2 class="section-title">📦 Insumos ordenados</h2>
            <div class="table-responsive rounded-4 shadow-sm">
                <div id="tabla-solicitudes"></div>
            </div>
        </section>

        <section class="final-section">
            <button id="regresarBtn" class="btn btn-regresar">
                Regresar a Inicio <i class="fas fa-arrow-left"></i>
            </button>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            cargarSolicitudes();
        });

        function cargarDatos(url, esJson = false) {
            fetch(url, {
                headers: esJson ? { 'Accept': 'application/json' } : {}
            })
                .then(res => res.json())
                .then(data => {
                    mostrarTabla(data);
                })
                .catch(() => {
                    document.getElementById('tabla-solicitudes').innerHTML = '<p>Error cargando datos.</p>';
                });
        }
        function cargarSolicitudes() {
            cargarDatos('/api/dueno/ordenar-insumos', true);
        }


        function mostrarTabla(data) {
            if (!data || !Array.isArray(data) || data.length === 0) {
                document.getElementById('tabla-solicitudes').innerHTML = '<p>No hay órdenes para mostrar.</p>';
                return;
            }

            let html = `<table class="styled-table">
            <thead>
                <tr>
                    <th>Insumos</th>
                    <th>Cantidad actual</th>
                    <th>Fecha de vencimiento</th>
                    <th>Cantidad ordenada</th>
                    <th>Costo</th>
                    <th>Estado de la orden</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>`;

            data.forEach(orden => {
                let nombres = '', cantidades = '', fechas = '', ordenadas = '', costos = '';
                orden.insumos.forEach(insumo => {
                    const color = insumo.cantidad_actual <= insumo.umbral_alerta ? 'bajo' : 'suficiente';
                    nombres += `<div>${insumo.nombre_insumo}</div>`;
                    cantidades += `<div class="${color}">${insumo.cantidad_actual}</div>`;
                    fechas += `<div>${insumo.fecha_vencimiento}</div>`;
                    ordenadas += `<div>${insumo.cantidad_ordenada}</div>`;
                    costos += `<div>$${parseFloat(insumo.total).toFixed(2)}</div>`;
                });

                html += `<tr>
                <td>${nombres}</td>
                <td>${cantidades}</td>
                <td>${fechas}</td>
                <td>${ordenadas}</td>
                <td>${costos}</td>
                <td><span class="badge badge-enviado">${orden.estado}</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-outline-success" title="Aceptar" onclick="aprobarOrden(${orden.id_orden})">
                            <i class="bi bi-check2"></i>
                        </button>
                    <button class="btn btn-outline-danger" title="Rechazar" onclick="rechazarOrden(${orden.id_orden})">
                        <i class="bi bi-x-circle"></i>
                    </button>
                    </div>
                </td>
            </tr>`;
            });

            html += `</tbody></table>`;
            document.getElementById('tabla-solicitudes').innerHTML = html;
        }
        function aprobarOrden(id) {
            fetch(`/api/dueno/ordenes/${id}/aprobar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json'
                }
            })
                .then(res => {
                    if (!res.ok) throw res;
                    return res.json();
                })
                .then(data => {
                    alert(data.mensaje);
                    cargarSolicitudes();
                })
                .catch(async (error) => {
                    let mensaje = 'Error al aprobar la orden.';
                    if (error.json) {
                        const errData = await error.json();
                        if (errData.mensaje) mensaje = errData.mensaje;
                    }
                    alert(mensaje);
                });
        }

        function rechazarOrden(id) {
            fetch(`/api/dueno/ordenes/${id}/rechazar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json'
                }
            })
                .then(res => {
                    if (!res.ok) throw res;
                    return res.json();
                })
                .then(data => {
                    alert(data.mensaje);
                    cargarSolicitudes();
                })

                .catch(async (error) => {
                    let mensaje = 'Error al rechazar la orden.';
                    if (error.json) {
                        const errData = await error.json();
                        if (errData.mensaje) mensaje = errData.mensaje;
                    }
                    alert(mensaje);
                });
        }

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

    </script>


    <script>
        document.getElementById("regresarBtn").addEventListener("click", function () {
            const rol = @json(Auth::user()->rol_id) || null;
            console.log(rol);
            if (rol === 5 || rol === 1) {
                window.location.href = "/dueno";
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Rol desconocido',
                    text: 'No se pudo determinar a dónde regresar.',
                    confirmButtonColor: '#e53935',
                });
            }
        });
    </script>

    <script>
        fetch('')
            .then(response => response.json())
            .then(data => {
                const resumenCitasContainer = document.getElementById('resumen-citas');
                let htmlContent = '<h5 class="text-muted">Citas Hoy</h5><h2 class="text-primary">';

                data.forEach(contar => {
                    const estado = contar.estado_cita;
                    const cantidad = contar.cantidad;
                    const clase = obtenerClasePorEstado(estado);

                    htmlContent += `
                <span class="${clase}">${estado}</span>
                <span class="${clase}">${cantidad}</span>
            `;
                });

                htmlContent += '</h2>';
                resumenCitasContainer.innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('Error al cargar las solicitudes:', error);
            });

        document.querySelectorAll('.update-status').forEach(button => {
            button.addEventListener('click', function () {
                const citaId = this.dataset.id;
                const nuevoEstado = this.dataset.status;
                const estadoActual = document.getElementById(`estado-cita-${citaId}`).textContent.trim().toLowerCase();

                fetch(`citas/${citaId}/actualizar-estado`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ estado: nuevoEstado })
                })
                    .then(response => response.json())
                    .then(data => {
                        const estadoTd = document.getElementById(`estado-cita-${citaId}`);
                        estadoTd.classList.remove('text-success', 'text-warning', 'text-danger', 'text-primary');
                        estadoTd.classList.add(obtenerClasePorEstado(nuevoEstado));
                        estadoTd.textContent = nuevoEstado;

                        Swal.fire({
                            title: 'Éxito',
                            text: data.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        fetch('resumen-citas')
                            .then(response => response.json())
                            .then(data => {
                                const resumenCitasContainer = document.getElementById('resumen-citas');
                                let htmlContent = '<h5 class="text-muted">Citas Hoy</h5><h2 class="text-primary">';

                                data.forEach(contar => {
                                    const estado = contar.estado_cita;
                                    const cantidad = contar.cantidad;
                                    const clase = obtenerClasePorEstado(estado);

                                    htmlContent += `
                                <span class="${clase}">${estado}</span>
                                <span class="${clase}">${cantidad}</span>
                            `;
                                });

                                htmlContent += '</h2>';
                                resumenCitasContainer.innerHTML = htmlContent;
                            })
                            .catch(error => {
                                console.error('Error al actualizar el resumen de citas:', error);
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

    </script>
</body>

</html>
