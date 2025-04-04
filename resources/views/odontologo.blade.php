<?php
$usuario = "Dr. [Nombre]";
$citas = [
    ["hora" => "10:00 AM", "paciente" => "Juan Perez", "estado" => "✅ Confirmada"],
    ["hora" => "11:00 AM", "paciente" => "Ana Lucia", "estado" => "⏳ Pendiente"],
    ["hora" => "12:00 PM", "paciente" => "Elber Gomez", "estado" => "❌ Cancelada"]
];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Odontólogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/Sodontologo.css') }}">

</head>

<body>
    <header class="d-flex justify-content-between align-items-center p-3 bg-light shadow-sm">
        <div class="d-flex align-items-center">
            <img src="imagen/logo.png" alt="Logo" width="50">
            <h4 class="ms-3">Panel Odontólogo</h4>
        </div>
        <div>
            <a href="/configuracion" class="btn btn-outline-secondary me-2">
                <i class="fas fa-cog"></i> Configuración
            </a>
            <button class="btn btn-outline-primary"><i class="fas fa-user"></i> Perfil</button>
        </div>
    </header>

    <main class="container mt-4">
        <h2 class="text-primary text-center">Hola <?php echo $usuario; ?> 👋</h2>

        <!-- Sección de Citas -->
        <section class="mt-4">
            <h3 class="text-secondary">Próximas Citas</h3>
            <a href="/agenda" class="btn btn-info my-2">
                <i class="fas fa-calendar-alt"></i> Ver Agenda
            </a>

            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita) { ?>
                        <tr>
                            <td><?php echo $cita["hora"]; ?></td>
                            <td><?php echo $cita["paciente"]; ?></td>
                            <td
                                class="fw-bold <?php echo ($cita['estado'] == '✅ Confirmada') ? 'text-success' : (($cita['estado'] == '⏳ Pendiente') ? 'text-warning' : 'text-danger'); ?>">
                                <?php echo $cita["estado"]; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <!-- Estado de Citas -->
        <section class="estado-citas mt-4 p-3 border rounded shadow-sm">
            <h3 class="text-secondary">Estado de Citas</h3>
            <p class="text-success">✅ Confirmadas</p>
            <p class="text-warning">⏳ Reprogramadas: 2</p>
            <p class="text-danger">❌ Canceladas: 1</p>
            <div>
                <button class="btn btn-success me-2"><i class="fas fa-play"></i> Iniciar Consulta</button>
                <button class="btn btn-primary"><i class="fas fa-sync-alt"></i> Actualizar</button>
            </div>
        </section>

        <!-- Sección de Órdenes -->
        <section class="ordenes mt-4 p-3 border rounded shadow-sm">
            <h3 class="text-secondary">Órdenes</h3>
            <a href="/ordenes" class="btn btn-outline-dark">
                <i class="fas fa-file-medical"></i> Administrar Órdenes
            </a>
        </section>


        <!-- Solicitudes -->
        <section class="solicitudes mt-4 p-3 border rounded shadow-sm">
            <h3 class="text-secondary">Solicitudes</h3>
            <div class="d-flex gap-3">
                <a href="/gestionInsumos" class="btn btn-outline-dark">
                    <i class="fas fa-box-open"></i> Gestionar insumos
                </a>
                <a href="/gestionPedidos" class="btn btn-outline-dark">
                    <i class="fas fa-clipboard-list"></i> Gestión de pedidos
                </a>
                <a href="/solicitud" class="btn btn-outline-dark">
                    <i class="fas fa-tooth"></i> Solicitar prótesis
                </a>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
