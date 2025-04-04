<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dental Flow</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>

    <!-- Fondo animado -->
    <div class="background"></div>

    <!-- Contenedor principal -->
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-container shadow-lg p-4">
            <div class="text-center">
                <img src="{{ asset('imagen/placeholder.png') }}" id="logo" class="mb-3">
                <h2 class="text-white">Dental Flow</h2>
                <p class="text-light">Accede a tu cuenta</p>
            </div>

            <form id="loginForm">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" id="btnLogin" class="btn w-100 fw-bold">Ingresar</button>
            </form>

            <div id="errorMessage" class="alert alert-danger mt-3 text-center d-none">
                <i class="fas fa-exclamation-circle"></i> Usuario o contraseña incorrectos
            </div>

            <div id="emptyFields" class="alert alert-warning mt-3 text-center d-none">
                <i class="fas fa-exclamation-triangle"></i> Todos los campos son obligatorios
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const errorMessage = document.getElementById("errorMessage");
            const emptyFields = document.getElementById("emptyFields");

            emptyFields.classList.add("d-none");
            errorMessage.classList.add("d-none");

            if (username === "" || password === "") {
                emptyFields.classList.remove("d-none");
                return;
            }

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
                errorMessage.classList.remove("d-none");
            }
        });
    </script>

</body>

</html>
