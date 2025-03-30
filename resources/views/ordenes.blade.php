<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Órdenes</title>
    <link rel="stylesheet" href="{{ asset('css/Sordenes.css') }}">

</head>

<body>
    <div class="container">
        <header>
            <img src="imagen/logo.png" alt="Dental Icon" class="dental-icon">
            <h1>Órdenes</h1>
        </header>

        <section class="order-section">
            <h2>Crear nueva orden</h2>
            <form>
                <label for="paciente">Paciente:</label>
                <input type="text" id="paciente" placeholder="Escribir paciente" class="input-field">

                <label for="tipo">Tipo de Orden:</label>
                <input type="text" id="tipo" placeholder="Escribir tipo" class="input-field">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" class="input-field" rows="4"></textarea>
            </form>
        </section>

        <section class="prescription-section">
            <h2>Crear nueva receta</h2>
            <form>
                <label for="paciente-receta">Paciente:</label>
                <input type="text" id="paciente-receta" placeholder="Escribir paciente" class="input-field">

                <label for="medicamento">Medicamento:</label>
                <input type="text" id="medicamento" placeholder="Escribir medicamento" class="input-field">

                <label for="dosis">Dosis:</label>
                <input type="text" id="dosis" placeholder="Escribir (mg)" class="input-field">

                <label for="frecuencia">Frecuencia:</label>
                <input type="text" id="frecuencia" placeholder="Escribir frecuencia" class="input-field">
            </form>
        </section>

        <footer>
            <button class="action-button green">Guardar en Historia</button>
            <button class="action-button blue">Imprimir Receta</button>
            <button class="action-button gray">Enviar</button>
        </footer>
    </div>
</body>

</html>
