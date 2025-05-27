<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente</title>
    <link rel="stylesheet" href="{{ asset('css/ARegistro.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="registro-wrapper">
        <div class="form-card">
            <a href="{{ route('asistente') }}" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i>
                Volver</a>
            <h2><i class="fas fa-user-plus"></i> Registro de Paciente</h2>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form id="form-registro-paciente" action="{{ route('post.pacientes') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="cedula"><i class="fas fa-user"></i> Cédula:</label>
                        <input type="text" id="cedula" name="cedula" required pattern="\d{10}" maxlength="10"
                            title="La cédula debe tener exactamente 10 dígitos">
                    </div>
                    <div class="form-group">
                        <label for="nombre"><i class="fas fa-user"></i> Nombre:</label>
                        <input type="text" id="nombre" name="nombres_paciente" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos"><i class="fas fa-user-tag"></i> Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos_paciente" required>
                    </div>
                    <div class="form-group">
                        <label for="edad"><i class="fas fa-hourglass-half"></i> Edad:</label>
                        <input type="number" id="edad" name="edad" min="0" required min="0" max="120"
                            title="La edad debe estar entre 0 y 120 años">
                    </div>
                    <div class="form-group">
                        <label for="genero"><i class="fas fa-venus-mars"></i> Género:</label>
                        <select id="genero" name="genero">
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telefono"><i class="fas fa-phone"></i> Teléfono:</label>
                        <input type="number" id="telefono" name="telefono_paciente" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion"><i class="fas fa-map-marker-alt"></i> Dirección:</label>
                        <input type="text" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="correo"><i class="fas fa-envelope"></i> Correo Electrónico:</label>
                        <input type="email" id="correo" name="correo_paciente" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono"><i class="fa-solid fa-droplet"></i> Tipo de Sangre:</label>
                        <select id="tipo_sangre" name="tipo_sangre">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-registrar"><i class="fas fa-save"></i> Registrar</button>
            </form>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('form-registro-paciente').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch('{{ route("post.pacientes") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(async response => {
                    return response.json().then(data => {
                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Paciente registrado correctamente',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = '/asistente/aregistro';
                            });
                        } else {
                            let errores = '';
                            if (data.errors) {
                                for (const campo in data.errors) {
                                    errores += `• ${data.errors[campo].join(', ')}<br>`;
                                }
                            } else {
                                errores = 'Ha ocurrido un error inesperado. ';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error al registrar paciente',
                                html: errores
                            });
                        }
                    });

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