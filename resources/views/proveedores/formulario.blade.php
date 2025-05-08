<form action="{{ route('proveedor.actualizar') }}" method="POST">
    @csrf <!-- Token de seguridad obligatorio, Evita ataques CSRF-->

    <label>NIT:</label>
    <input type="text" name="nit" required maxlength="20">

    <label>Nombre:</label>
    <input type="text" name="nombre" required maxlength="50">

    <label>Teléfono:</label>
    <input type="text" name="telefono" required maxlength="50">

    <label>Correo:</label>
    <input type="email" name="correo" required maxlength="50">

    <button type="submit">Actualizar</button>
</form>

<!-- Mostrar mensaje de éxito -->
@if (session('success'))
    <p>{{ session('success') }}</p>
@endif
