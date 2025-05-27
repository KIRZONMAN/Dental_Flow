<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/AdAgregarUsuario.css') }}">
    <title>Registrar Usuario</title>
</head>

<body>
    <div class="registro-wrapper">
        <div class="form-card">
            <div class="barra-superior">
                <a href="/administrador/gestionUsuarios" class="btn-volver">Volver</a>
                <h2>Registrar Nuevo Usuario</h2>
            </div>
            <form id="form-registro-usuario" action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombres_usuario">Nombres:</label>
                        <input type="text" maxlength="50" name="nombres_usuario" id="nombres_usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidos_usuario">Apellidos:</label>
                        <input type="text" maxlength="50" name="apellidos_usuario" id="apellidos_usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="correo_usuario">Correo electrónico:</label>
                        <input type="email" maxlength="50" name="correo_usuario" id="correo_usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="contrasena_usuario">Contraseña:</label>
                        <input type="password" maxlength="255" name="contrasena_usuario" id="contrasena_usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono_usuario">Teléfono:</label>
                        <input type="text" maxlength="50" name="telefono_usuario" id="telefono_usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="direccion_usuario">Dirección:</label>
                        <input type="text" maxlength="100" name="direccion_usuario" id="direccion_usuario" required>
                    </div>

                    <div class="form-group">
                        <label for="estado_usuario">Estado:</label>
                        <select name="estado_usuario" id="estado_usuario" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="especialidad_usuario">Especialidad (opcional):</label>
                        <input type="text" maxlength="50" name="especialidad_usuario" id="especialidad_usuario">
                    </div>

                    <div class="form-group">
                        <label for="rol_id">Rol:</label>
                        <select name="rol_id" id="rol_id" required>
                            <option value="">Selecciona un rol</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-registrar">Registrar</button>
            </form>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('form-registro-usuario').addEventListener('submit', function (e) {
            e.preventDefault(); // Evita el envío tradicional

            const form = e.target;
            const formData = new FormData(form);

            fetch('{{ route("usuarios.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(async response => {
                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario registrado correctamente',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = '/administrador/gestionUsuarios';
                        });
                    } else {
                        const data = await response.json();
                        let errores = '';

                        if (data.errors) {
                            for (const campo in data.errors) {
                                errores += `• ${data.errors[campo].join(', ')}<br>`;
                            }
                        } else {
                            errores = 'Ha ocurrido un error inesperado.';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar usuario',
                            html: errores
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de red',
                        text: 'No se pudo enviar el formulario.'
                    });
                });
        });
    </script>

</body>

</html>
