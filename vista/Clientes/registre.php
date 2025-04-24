<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../static/css/InicioSesion.css">
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <!-- Sección Branding -->
        <div class="brand-section">
            <div class="brand-content">
                <img src="../../static/img/logo.png" alt="Hotel Logo" class="brand-logo">
                <h2 class="brand-tagline">Vive la experiencia de lujo en su máxima expresión</h2>
                <div class="brand-divider"></div>
                <p class="brand-text">Registro de miembros exclusivos</p>
            </div>
        </div>

        <!-- Sección Formulario -->
        <div class="form-section">
            <form class="elegant-form" action="../../controller/clients/RegistreController.php" method="POST" id="registerForm">
                <h2 class="form-title">Crear Cuenta</h2>

                <!-- Nombre y Apellido -->
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="Nom" placeholder="Nombre" required>
                    <div class="input-underline"></div>
                </div>

                <div class="input-group">
                    <i class="fas fa-user-tag input-icon"></i>
                    <input type="text" name="Cognom" placeholder="Apellido" required>
                    <div class="input-underline"></div>
                </div>

                <!-- DNI/NIE y Email -->
                <div class="input-group">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" name="DNI" placeholder="DNI/NIE/Pasaporte" required>
                    <div class="input-underline"></div>
                </div>

                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="CorreuElectronic" placeholder="Correo Electrónico" required>
                    <div class="input-underline"></div>
                </div>

                <!-- Teléfono y Usuario -->
                <div class="input-group">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="text" name="Telefon" placeholder="Teléfono">
                    <div class="input-underline"></div>
                </div>


                <div class="input-group">
                    <i class="fas fa-city input-icon"></i>
                    <input type="text" name="Ciudad" placeholder="Ciudad">
                    <div class="input-underline"></div>
                </div>

                <!-- Código Postal -->
                <div class="input-group">
                    <i class="fas fa-map-marker-alt input-icon"></i>
                    <input type="text" name="CodigoPostal" placeholder="Código Postal">
                    <div class="input-underline"></div>
                </div>
                <div class="input-group">
                    <i class="fas fa-user-circle input-icon"></i>
                    <input type="text" name="Usuari" placeholder="Nombre de Usuario" required>
                    <div class="input-underline"></div>
                </div>

                <!-- Contraseña y Ciudad -->
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="Password" placeholder="Contraseña" required>
                    <div class="input-underline"></div>
                </div>

                <!-- CAPTCHA Estilo Login -->
                <div class="captcha-group">
                    <label class="captcha-label">
                        <input type="checkbox" id="captcha" name="captcha" value="1">
                        <span class="checkmark"></span>
                        <span class="captcha-text">Acepto los términos y condiciones</span>
                    </label>
                </div>

                <!-- Botón de Registro -->
                <button type="submit" class="auth-btn">
                    Registrarse
                    <i class="fas fa-arrow-right"></i>
                </button>

                <!-- Enlace a Login -->
                <div class="auth-footer">
                    ¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Validación CAPTCHA -->
    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            const captchaChecked = document.getElementById("captcha").checked;
            if (!captchaChecked) {
                alert("❌ Debes aceptar los términos y condiciones");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>