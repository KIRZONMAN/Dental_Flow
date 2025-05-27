<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/gestionUsuarios.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="barra-superior">
            <a href="/administrador" class="btn-volver">Volver</a>
            <h1 class="titulo-centro">Buscar Usuarios</h1>
        </div>
        <div class="barra-acciones">
            <div class="busqueda">
                <input type="text" name="buscar_paciente" id="searchInput" placeholder="Buscar usuario"
                    class="search-input">
                <button type="submit" class="search-button" onclick="buscarUsuario()">Buscar</button>
            </div>
            <div id="btnAddUser">
                <a href="/administrador/usuarios" id="btn-addUser">Agregar Usuarios</a>
            </div>
        </div>
        <div id="tabla-usuarios" class="table-responsive"></div>
        <div id="paginacion-usuarios"></div>
    </div>

    <!--Construir tabla usuarios-->
    <script>
        let paginaActual = 1;
        const usuariosPorPagina = 10;

        document.addEventListener('DOMContentLoaded', function () {
            cargarTablaUsuarios(paginaActual);
        });

        function cargarTablaUsuarios(pagina) {
            fetch(`/api/administrador/tablaUsuarios?limit=${usuariosPorPagina}&page=${pagina}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabla-usuarios').innerHTML = construirTablaUsuarios(data.data);
                    mostrarPaginacion(data);
                    paginaActual = data.current_page;
                })
                .catch(() => {
                    document.getElementById('tabla-usuarios').innerHTML = '<p>Error cargando usuarios.</p>';
                    document.getElementById('paginacion-usuarios').innerHTML = '';
                });
        }

        function construirTablaUsuarios(usuarios) {
            if (!usuarios.length) return '<p>No hay usuarios disponibles.</p>';

            const filas = usuarios.map(usuario => `
        <tr>
            <td>${usuario.id_usuario}</td>
            <td>${usuario.nombre_completo}</td>
            <td>${usuario.correo}</td>
            <td>${usuario.estado}</td>
            <td>${usuario.rol}</td>
            <td>
                <a href="/administrador/usuarios/${usuario.id_usuario}/edit" class="history-button">Editar</a>
                <a href="#" class="history-button eliminar-usuario" data-id="${usuario.id_usuario}">Eliminar</a>
            </td>
        </tr>
    `).join('');

            return `
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                ${filas}
            </tbody>
        </table>
    `;
        }
        function mostrarPaginacion(data) {
            let html = '';

            if (data.prev_page_url) {
                html += `<button onclick="cargarTablaUsuarios(${data.current_page - 1})">Anterior</button>`;
            } else {
                html += `<button disabled>Anterior</button>`;
            }

            html += ` Página ${data.current_page} de ${data.last_page} `;

            if (data.next_page_url) {
                html += `<button onclick="cargarTablaUsuarios(${data.current_page + 1})">Siguiente</button>`;
            } else {
                html += `<button disabled>Siguiente</button>`;
            }

            document.getElementById('paginacion-usuarios').innerHTML = html;
        }

    </script>


    <!--Acciones-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.addEventListener('click', function (e) {
                if (e.target.classList.contains('eliminar-usuario')) {
                    e.preventDefault();
                    const id = e.target.getAttribute('data-id');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/api/administrador/usuarios/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                                .then(response => {
                                    if (response.ok) {
                                        Swal.fire({
                                            title: '¡Eliminado!',
                                            text: 'El usuario fue eliminado correctamente.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        return response.json().then(err => { throw err; });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error al eliminar:', error);
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ocurrió un error al eliminar el usuario.',
                                        icon: 'error'
                                    });
                                });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        function buscarUsuario(pagina = 1) {
            const input = document.getElementById('searchInput').value.trim().toLowerCase();

            if (!input) {
                cargarTablaUsuarios(1);
                return;
            }

            fetch(`/api/administrador/filtrarUsuario/${input}?page=${pagina}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabla-usuarios').innerHTML = construirTablaUsuarios(data.data);
                    mostrarPaginacionBusqueda(data, input);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('tabla-usuarios').innerHTML = '<p>Error buscando usuarios.</p>';
                    document.getElementById('paginacion-usuarios').innerHTML = '';
                });
        }

        /*Función para mostrar opciones de paginación*/
        function mostrarPaginacionBusqueda(data, input) {
            let html = '';

            if (data.prev_page_url) {
                html += `<button onclick="buscarUsuario(${data.current_page - 1})">Anterior</button>`;
            } else {
                html += `<button disabled>Anterior</button>`;
            }

            html += ` Página ${data.current_page} de ${data.last_page} `;

            if (data.next_page_url) {
                html += `<button onclick="buscarUsuario(${data.current_page + 1})">Siguiente</button>`;
            } else {
                html += `<button disabled>Siguiente</button>`;
            }

            document.getElementById('paginacion-usuarios').innerHTML = html;
        }

    </script>

</body>

</html>