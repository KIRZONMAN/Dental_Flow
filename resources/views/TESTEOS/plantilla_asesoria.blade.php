<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ESTRUCTURADO</title>

    <link rel="stylesheet" href="{{ asset('css/ejemplo.css') }}">
</head>

<body>

    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Citas</h1>
            </div>

            <div class="col-md-12">
                <table class="table">
                    <thead>
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
        /*
        const tabla = document.querySelector("#cuerpo");
        const opciones = {
            method: 'POST'
        }

        fetch('consulta.php', opciones)
            .then(respuesta => respuesta.json())
            .then(resultado => {

                resultado.forEach(elemento => {
                    tabla.innerHTML += `
                        <tr>
                            <th scope="row">${elemento.id_cita}</th>
                            <td>${elemento.fecha_cita}</td>
                            <td>${elemento.hora_cita}</td>
                            <td>${elemento.estado_cita}</td>
                            <td>${elemento.motivo_cita}</td>
                            <td>${elemento.total_cita}</td>
                            <td>${elemento.paciente_id}</td>
                        </tr>`;
                });
            })
*/
    </script>

</body>

</html>
