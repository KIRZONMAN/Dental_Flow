<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Configuración Laboratorista</title>
  <link rel="stylesheet" href="{{ asset('css/Config2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/Config4.css') }}">
</head>

<body>
  <div class="config-container">
    <div class="config-header">
      <h1>Configuración del Laboratorista</h1>
    </div>

    <form method="POST" action="{{ route('laboratorista.configuracion') }}">
      @csrf
      <div class="config-section">
        <h2 class="section-title">Perfil</h2>

        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $nombre) }}">
        </div>

        <div class="form-group">
          <label for="especialidad">Especialidad</label>
          <input type="text" id="especialidad" value="{{ $especialidad }}" readonly>
        </div>

        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $telefono) }}">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $email) }}">
        </div>
      </div>

      <button type="submit" class="btn-guardar">Guardar configuración</button>
    </form>
  </div>
</body>

</html>
