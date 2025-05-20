<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="{{ asset('css/gestionUsuarios.css') }}">

</head>

<body>
    <div class="container">
        <h1>Buscar Usuarios</h1>
        <form method="POST" action="">
            <input type="text" name="buscar_paciente" placeholder="Buscar usuario" class="search-input">
            <button type="submit" class="search-button">Buscar</button>
        </form>
        <div id="tabla-usuarios"></div>

        <div id="btnAddUser">
            <a href="/gestionUsuarios?accion=agregar" class="history-button">Agregar Usuarios</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            cargarTablaUsuarios();
        });

        function cargarTablaUsuarios() {
            fetch('/api/usuarios')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tabla-usuarios').innerHTML = construirTablaUsuarios(data.usuarios);
                })
                .catch(() => {
                    document.getElementById('tabla-usuarios').innerHTML = '<p>Error cargando usuarios.</p>';
                });
        }

        function construirTablaUsuarios(usuarios) {
            if (!usuarios.length) return '<p>No hay usuarios disponibles.</p>';

            const filas = usuarios.map(usuario => `
            <tr>
                <td>${usuario.id}</td>
                <td>${usuario.nombre_completo}</td>
                <td>${usuario.correo}</td>
                <td>${usuario.estado}</td>
                <td>${usuario.rol}</td>
                <td>
                    <a href="/administrador/usuarios/${usuario.id}/edit" class="history-button">Editar</a>
                    <a href="#" class="history-button eliminar-usuario" data-id="${usuario.id}">Eliminar</a>
                </td>
            </tr>
        `).join('');

            return `
            <table class="appointment-table">
                <thead>
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
                            fetch(`/api/gestionUsuarios/${id}`, {
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
</body>

</html>
