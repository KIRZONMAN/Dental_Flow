<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="{{ asset('css/Citas.css') }}">
</head>

<body>
    <a href="{{ route('asistente.citas.view') }}" class="btn btn-outline-light">
        <i class="fas fa-arrow-left"></i> Volver
    </a>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('api.citas.update', $cita->id_cita) }}" method="POST" id="formulario-cita">
        @csrf
        @method('PUT')

        <label>Fecha:</label>
        <input type="date" name="fecha" value="{{ old('fecha', $cita->fecha_cita) }}" required>

        <label>Hora:</label>
        <input type="time" name="hora" value="{{ old('hora', $cita->hora_cita) }}" required>

        <label>Estado:</label>
        <select name="estado">
            <option value="pendiente" {{ $cita->estado_cita == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="confirmada"{{ $cita->estado_cita == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
            <option value="cancelada"{{ $cita->estado_cita == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            <option value="completada"{{ $cita->estado_cita == 'completada' ? 'selected' : '' }}>Completada</option>
        </select>

        <label>Motivo:</label>
        <input type="text" name="motivo" value="{{ old('motivo', $cita->motivo_cita) }}" required>

        <label>Total:</label>
        <input type="number" name="total" step="any" value="{{ old('total', $cita->total_cita) }}" required>

        <label>Odontólogo:</label>
        <select name="odontologo">
            @foreach ($usuarios as $u)
                <option value="{{ $u->id_usuario }}" {{ $u->id_usuario == $cita->usuario_id ? 'selected' : '' }}>
                    {{ $u->nombre_completo_odontologo }}
                </option>
            @endforeach
        </select>

        <button type="submit">Actualizar Cita</button>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </form>
</body>

</html>
