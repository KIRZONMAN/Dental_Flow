<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historia Clínica {{ $paciente->cedula }}</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    h1 { text-align: center; }
    .section { margin-bottom: 20px; }
    .label { font-weight: bold; width: 150px; display: inline-block; }
  </style>
</head>
<body>
  <h1>Historia Clínica</h1>

  <div class="section">
    <div><span class="label">Paciente:</span> {{ $paciente->nombres_paciente }} {{ $paciente->apellidos_paciente }}</div>
    <div><span class="label">Cédula:</span> {{ $paciente->cedula }}</div>
    <div><span class="label">Edad:</span> {{ $paciente->edad }}</div>
    <div><span class="label">Género:</span> {{ ucfirst($paciente->genero) }}</div>
  </div>

  <div class="section">
    <div><span class="label">Teléfono:</span> {{ $paciente->telefono_paciente }}</div>
    <div><span class="label">Correo:</span> {{ $paciente->correo_paciente }}</div>
    <div><span class="label">Dirección:</span> {{ $paciente->direccion_paciente }}</div>
    <div><span class="label">Tipo de sangre:</span> {{ $paciente->tipo_sangre }}</div>
  </div>

  {{-- Aquí puedes añadir más secciones: antecedentes, tratamientos, etc. --}}
</body>
</html>
