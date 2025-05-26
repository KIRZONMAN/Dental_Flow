<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Citas</title>
    <link rel="stylesheet" href="{{ asset('css/Citas.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="header-container-2">
        <a href="{{ route('asistente.citas.view') }}" class="btn custom-btn-outline2"><i class="fas fa-arrow-left"></i>
            Volver</a>
        <h2>Editor de citas</h2>
    </div>
    <div class="card">
        <form id="form-cita" action="{{ route('api.citas.update', $cita->id_cita) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <!-- Campo oculto para el ID -->
                <input type="hidden" name="id" id="cita-id" value="{{ $cita->id_cita }}" required>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" name="fecha" value="{{ old('fecha', $cita->fecha_cita) }} " required>
                </div>
                <div class="form-group">
                    <label for="hora">Hora:</label>
                    <input type="time" name="hora" value="{{ old('hora', $cita->hora_cita) }}" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <select name="estado">
                        <option value="pendiente" {{ $cita->estado_cita == 'pendiente' ? 'selected' : '' }}>Pendiente
                        </option>
                        <option value="cancelada" {{ $cita->estado_cita == 'cancelada' ? 'selected' : '' }}>Cancelada
                        </option>
                        <option value="confirmada" {{ $cita->estado_cita == 'confirmada' ? 'selected' : '' }}>Confirmada
                        </option>
                        <option value="completada" {{ $cita->estado_cita == 'completada' ? 'selected' : '' }}>Completada
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="motivo">Motivo:</label>
                    <input type="text" name="motivo" value="{{ old('motivo', $cita->motivo_cita ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="total">Coste total:</label>
                    <input type="number" name="total" value="{{ old('total', $cita->total_cita ?? '') }}" step="any"
                        required>
                </div>
                <div class="form-group">
                    <label for="odontologo">Odontólogo:</label>
                    <select name="odontologo">
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}" {{ $usuario->id_usuario == $cita->usuario_id ? 'selected' : '' }}>
                                {{ $usuario->nombre_completo_odontologo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit">Actualizar Cita</button>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

        </form>
    </div>
</body>

</html>
