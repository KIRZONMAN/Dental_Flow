<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Citas</title>
    <link rel="stylesheet" href="{{ asset('css/Citas.css') }}">

</head>
<a href="{{ route('asistente.volver') }}" class="btn btn-outline-light"><i class="fas fa-arrow-left"></i> Volver</a>
<form  id="formulario-cita" action="{{ route('citas.update', $cita->id_cita) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Campo oculto para el ID -->
    <input type="hidden" name="id" id="cita-id" value="{{ $cita->id_cita }}" required>

    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" value="{{ old('fecha', $cita->fecha_cita ) }} " required>

    <label for="hora">Hora:</label>
    <input type="time" name="hora" value="{{ old('hora', $cita->hora_cita) }}" required >

    <label for="estado">Estado:</label>
    <select name="estado" >
        <option value="pendiente" {{ $cita->estado_cita == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
        <option value="cancelada" {{ $cita->estado_cita == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
        <option value="confirmada" {{ $cita->estado_cita == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
        <option value="completada" {{ $cita->estado_cita == 'completada' ? 'selected' : '' }}>Completada</option>
    </select>

    <label for="motivo">Motivo:</label>
    <input type="text" name="motivo" value="{{ old('motivo', $cita->motivo_cita ?? '') }}" required>

    <label for="total">Total (temp):</label>
    <input type="number" name="total" value="{{ old('total', $cita->total_cita ?? '') }}" step="any" required >

    <label for="odontologo">Odontólogo:</label>
    <select name="odontologo" >
        @foreach ($usuarios as $usuario)
            <option value="{{ $usuario->id_usuario }}" {{ $usuario->id_usuario == $cita->usuario_id ? 'selected' : '' }}>
                {{ $usuario->nombre_completo_odontologo }}
            </option>
        @endforeach
    </select>

    <button type="submit">Actualizar Cita</button>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

</form>
</body>
</html>
