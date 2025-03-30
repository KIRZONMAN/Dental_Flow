<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica Dental</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Contenedor del login -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" id="contLogin">
            <h2 class="text-center mb-3">Iniciar Sesión</h2>
            <img id="imgUser" class="img-fluid d-block mx-auto mb-3"
                src="https://cdn-icons-png.flaticon.com/512/6073/6073873.png" width="80">

            <form action="/login" id="loginForm" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="usuario" required>
                    <label for="username">Usuario</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <label for="password">Contraseña</label>
                </div>
                <button type="submit" id="btnLogin" class="btn btn-primary w-100">Ingresar</button>
            </form>
            <div id="errorMessage" class="alert alert-danger mt-3 d-none">Usuario o contraseña incorrectos</div>
        </div>
    </div>

    <!-- Script de validación -->
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            const users = {
                "cajero": "1234",
                "admin": "admin123",
                "odontologo": "odont123",
                "asistente": "asist456"
            };

            if (users[username] && users[username] === password) {
                const pages = {
                    "cajero": "/cajero",
                    "admin": "/administrador",
                    "odontologo": "/odontologo",
                    "asistente": "/asistente"
                };
                window.location.href = pages[username];
            } else {
                document.getElementById("errorMessage").classList.remove("d-none");
            }
        });
    </script>
</body>

</html>
