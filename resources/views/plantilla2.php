<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DINAMICO</title>

    <link rel="stylesheet" href="<?php $servername ?>\conexiondb\resources\css\ejemplo.css">
</head>

<body>

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Citas</h1>
            </div>

            <div class="col-md-12">
                <table class="table">
                    <thead id="encabezado">
                        <tr>
                            <th scope="col">ID Cita</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Total</th>
                            <th scope="col">Cédula Paciente</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const tabla = document.querySelector("#cuerpo");
        const encabezado = document.querySelector("#encabezado"); // Asegúrate de tener un `<thead>` con este ID

        const opciones = { method: "POST" };

        fetch("consulta.php", opciones)
            .then((respuesta) => respuesta.json())
            .then((resultado) => {
                if (resultado.length === 0) return;

                // Generar encabezados dinámicamente
                const columnas = Object.keys(resultado[0]); // Obtener nombres de las columnas
                encabezado.innerHTML = `<tr>${columnas.map(col => `<th scope="col">${col}</th>`).join('')}</tr>`;

                // Generar filas dinámicamente
                resultado.forEach(elemento => {
                    const filaHTML = `<tr>${columnas.map(col => `<td>${elemento[col]}</td>`).join('')}</tr>`;
                    tabla.insertAdjacentHTML("beforeend", filaHTML);
                });
            })
            .catch(error => console.error("Error al obtener los datos:", error));

    </script>

</body>

</html>