<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente</title>
    <link rel="stylesheet" href="{{ asset('css/ARegistro.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="registro-wrapper">
        <div class="form-card">
        <a href="{{ route('asistente') }}" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i> Volver</a>
            <h2><i class="fas fa-user-plus"></i> Registro de Paciente</h2>
            <form action="{{ route('postaregistro') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="cedula"><i class="fas fa-user"></i> Cédula:</label>
                        <input type="text" id="nombre" name="cedula" required>
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
                        <input type="number" id="edad" name="edad" min="0" required>
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
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
