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
    <div class="signup-container">
        <!-- Cabecera -->
        <div class="signup-header">
            <img src="../../static/img/logo.png" alt="Hotel Logo" class="signup-header__logo">
            <h2 class="signup-header__title">¡Regístrate en nuestro hotel!</h2>
        </div>
        
        <!-- Formulario -->
        <form action="../../controller/clients/RegistreController.php" method="POST" class="signup-form" id="registerForm">
            <!-- Fila 1 - Nombre y Apellido -->
            <div class="signup-form__row">
                <div class="signup-form__group">
                    <label for="nom" class="signup-form__label">Nombre:</label>
                    <input type="text" id="nom" name="Nom" class="signup-form__input" required>
                </div>

                <div class="signup-form__group">
                    <label for="cognom" class="signup-form__label">Apellido:</label>
                    <input type="text" id="cognom" name="Cognom" class="signup-form__input" required>
                </div>
            </div>

            <!-- Fila 2 - DNI y Email -->
            <div class="signup-form__row">
                <div class="signup-form__group">
                    <label for="dni" class="signup-form__label">DNI/NIE/Pasaporte:</label>
                    <input type="text" id="dni" name="DNI" class="signup-form__input" required>
                </div>

                <div class="signup-form__group">
                    <label for="email" class="signup-form__label">Correo Electrónico:</label>
                    <input type="email" id="email" name="CorreuElectronic" class="signup-form__input" required>
                </div>
            </div>

            <!-- Fila 3 - Teléfono y Usuario -->
            <div class="signup-form__row">
                <div class="signup-form__group">
                    <label for="telefon" class="signup-form__label">Teléfono:</label>
                    <input type="text" id="telefon" name="Telefon" class="signup-form__input">
                </div>

                <div class="signup-form__group">
                    <label for="usuario" class="signup-form__label">Usuario:</label>
                    <input type="text" id="usuario" name="Usuari" class="signup-form__input" required>
                </div>
            </div>

            <!-- Fila 4 - Contraseña y Ciudad -->
            <div class="signup-form__row">
                <div class="signup-form__group">
                    <label for="password" class="signup-form__label">Contraseña:</label>
                    <input type="password" id="password" name="Password" class="signup-form__input" required>
                </div>

                <div class="signup-form__group">
                    <label for="ciudad" class="signup-form__label">Ciudad:</label>
                    <input type="text" id="ciudad" name="Ciudad" class="signup-form__input">
                </div>
            </div>

            <!-- Fila 5 - Código Postal -->
            <div class="signup-form__row">
                <div class="signup-form__group">
                    <label for="codigoPostal" class="signup-form__label">Código Postal:</label>
                    <input type="text" id="codigoPostal" name="CodigoPostal" class="signup-form__input">
                </div>
            </div>

            <!-- CAPTCHA -->
            <div class="signup-captcha">
                <input type="checkbox" id="captcha" name="captcha" value="1" class="signup-captcha__checkbox">
                <label for="captcha" class="signup-captcha__label">No soy un robot</label>
            </div>

            <!-- Botón de Registro -->
            <button class="signup-form__submit" type="submit">Registrarse</button>
        </form>

        <!-- Enlace a Login -->
        <div class="signup-login-link">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>

    <!-- Validación CAPTCHA -->
    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            var captchaChecked = document.getElementById("captcha").checked;
            if (!captchaChecked) {
                alert("❌ Debes marcar la casilla de verificación.");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>