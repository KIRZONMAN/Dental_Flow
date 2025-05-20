<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">✏️ Editar Usuario</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('administrador.usuarios.update', $usuario->id_usuario) }}" method="POST" class="row g-3">
      @csrf
      @method('PUT')

      <div class="col-md-6">
        <label for="nombres_usuario" class="form-label">Nombres</label>
        <input
          type="text"
          id="nombres_usuario"
          name="nombres_usuario"
          class="form-control @error('nombres_usuario') is-invalid @enderror"
          value="{{ old('nombres_usuario', $usuario->nombres_usuario) }}"
          required
        >
        @error('nombres_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="apellidos_usuario" class="form-label">Apellidos</label>
        <input
          type="text"
          id="apellidos_usuario"
          name="apellidos_usuario"
          class="form-control @error('apellidos_usuario') is-invalid @enderror"
          value="{{ old('apellidos_usuario', $usuario->apellidos_usuario) }}"
          required
        >
        @error('apellidos_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="correo_usuario" class="form-label">Correo electrónico</label>
        <input
          type="email"
          id="correo_usuario"
          name="correo_usuario"
          class="form-control @error('correo_usuario') is-invalid @enderror"
          value="{{ old('correo_usuario', $usuario->correo_usuario) }}"
          required
        >
        @error('correo_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="contrasena_usuario" class="form-label">Contraseña <small class="text-muted">(dejar en blanco para no cambiar)</small></label>
        <input
          type="password"
          id="contrasena_usuario"
          name="contrasena_usuario"
          class="form-control @error('contrasena_usuario') is-invalid @enderror"
        >
        @error('contrasena_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="telefono_usuario" class="form-label">Teléfono</label>
        <input
          type="text"
          id="telefono_usuario"
          name="telefono_usuario"
          class="form-control @error('telefono_usuario') is-invalid @enderror"
          value="{{ old('telefono_usuario', $usuario->telefono_usuario) }}"
          required
        >
        @error('telefono_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-6">
        <label for="direccion_usuario" class="form-label">Dirección</label>
        <input
          type="text"
          id="direccion_usuario"
          name="direccion_usuario"
          class="form-control @error('direccion_usuario') is-invalid @enderror"
          value="{{ old('direccion_usuario', $usuario->direccion_usuario) }}"
          required
        >
        @error('direccion_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-4">
        <label for="estado_usuario" class="form-label">Estado</label>
        <select
          id="estado_usuario"
          name="estado_usuario"
          class="form-select @error('estado_usuario') is-invalid @enderror"
          required
        >
          <option value="activo"   {{ old('estado_usuario', $usuario->estado_usuario) == 'activo'   ? 'selected' : '' }}>Activo</option>
          <option value="inactivo" {{ old('estado_usuario', $usuario->estado_usuario) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('estado_usuario')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-md-8">
        <label for="rol_id" class="form-label">Rol</label>
        <select
          id="rol_id"
          name="rol_id"
          class="form-select @error('rol_id') is-invalid @enderror"
          required
        >
          @foreach($roles as $rol)
            <option
              value="{{ $rol->id_rol }}"
              {{ old('rol_id', $usuario->rol_id) == $rol->id_rol ? 'selected' : '' }}
            >
              {{ $rol->nombre_rol }}
            </option>
          @endforeach
        </select>
        @error('rol_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-12 d-flex justify-content-between mt-4">
        <a href="{{ route('administrador.usuarios') }}" class="btn btn-secondary">
          ← Volver a Usuarios
        </a>
        <button type="submit" class="btn btn-primary">
          Guardar cambios
        </button>
      </div>
    </form>
  </div>
</body>
</html>
