<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="../../static/css/InicioSesion.css">
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="registro-container">
        <!-- Logo y título -->
        <div class="registro-header">
            <img src="../../static/img/logo.png" alt="Hotel Logo" class="registro-logo">
            <h2>¡Regístrate en nuestro hotel!</h2>
        </div>
        
        <!-- Formulario de Registro -->
        <form action="../../controller/clients/RegistreController.php" method="POST" id="registerForm">
            <div class="registro-form-row">
                <div class="registro-form-group">
                    <label for="nom">Nombre:</label>
                    <input type="text" id="nom" name="Nom" required>
                </div>

                <div class="registro-form-group">
                    <label for="cognom">Apellido:</label>
                    <input type="text" id="cognom" name="Cognom" required>
                </div>
            </div>

            <div class="registro-form-row">
                <div class="registro-form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="DNI" required>
                </div>

                <div class="registro-form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="CorreuElectronic" required>
                </div>
            </div>

            <div class="registro-form-row">
                <div class="registro-form-group">
                    <label for="telefon">Teléfono:</label>
                    <input type="text" id="telefon" name="Telefon">
                </div>

                <div class="registro-form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="Usuari" required>
                </div>
            </div>

            <div class="registro-form-row">
                <div class="registro-form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="Password" required>
                </div>

                <div class="registro-form-group">
                    <label for="ciudad">Ciudad:</label>
                    <input type="text" id="ciudad" name="Ciudad">
                </div>
            </div>

            <div class="registro-form-row">
                <div class="registro-form-group">
                    <label for="codigoPostal">Código Postal:</label>
                    <input type="text" id="codigoPostal" name="CodigoPostal">
                </div>
            </div>

            <!-- CAPTCHA Fake -->
            <input type="checkbox" id="captcha" name="captcha" value="1">
            <label for="captcha">No soy un robot</label><br>

            <button class="registre-btn" type="submit">Registrarse</button>
        </form>

        <div class="register-link">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>

    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            var captchaChecked = document.getElementById("captcha").checked;
            if (!captchaChecked) {
                alert("❌ Debes marcar la casilla de verificación.");
                event.preventDefault(); // Evita que se envíe el formulario
            }
        });
    </script>
</body>
</html>
