<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>citas ejemplo desde BD</title>
</head>

<body>
    <h1>citas ejemplo desde BD</h1>
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID Cita</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <!-- <th scope="col">Estado</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Total</th>
                    <th scope="col">Cédula Paciente</th> -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                    <tr>
                        <td>{{ $cita->id }}</td>
                        <td>{{ $cita->fecha }}</td>
                        <td>{{ $cita->hora }}</td>
                        <td>
                            <a href="">Editar</a>
                            <a href="">Eliminar</a>
                            <a href="">Otra accion</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</body>

</html>