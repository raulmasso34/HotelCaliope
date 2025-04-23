<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Privilegiado - Hotel Caliope</title>
    <link rel="stylesheet" href="../../static/css/InicioSesion.css">
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <!-- Sección Izquierda - Branding -->
        <div class="brand-section">
            <div class="brand-content">
                <img src="../../static/img/logo.png" alt="Hotel Caliope" class="brand-logo">
                <h1 class="brand-tagline">Donde el lujo se encuentra con la tradición</h1>
                <div class="brand-divider"></div>
                <p class="brand-text">Acceso exclusivo para miembros</p>
            </div>
        </div>

        <!-- Sección Derecha - Formulario -->
        <div class="form-section">
            <form method="POST" action="../../controller/clients/LoginController.php" id="loginForm" class="elegant-form">
                <h2 class="form-title">Bienvenido/a!</h2>
                
                <!-- Grupo de Input con Icono -->
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="Usuari" id="Usuari" required placeholder="Usuario">
                    <div class="input-underline"></div>
                </div>

                <!-- Grupo de Input con Icono y Toggle -->
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="Password" id="Password" required placeholder="Contraseña">
                    <button type="button" class="password-toggle">
                        <i class="fas fa-eye"></i>
                    </button>
                    <div class="input-underline"></div>
                </div>

                <!-- CAPTCHA Estilizado -->
                <div class="captcha-group">
                    <label class="captcha-label">
                        <input type="checkbox" id="captcha" name="captcha" value="1">
                        <span class="checkmark">
                        
                        </span>
                        <span class="captcha-text">Confirmo que soy un huésped humano</span>
                    </label>
                </div>

                <button class="auth-btn" type="submit">
                    <span>Acceder</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <!-- Mensaje de Error -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Enlace de Registro -->
                <div class="auth-footer">
                    <p>¿Primera vez con nosotros? <a href="registre.php">Registrate</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle de contraseña
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordField = document.getElementById('Password');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Validación de formulario
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            const captchaChecked = document.getElementById("captcha").checked;
            const errorMessage = document.querySelector('.error-message');
            
            if (!captchaChecked) {
                if (!errorMessage) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Debe confirmar su humanidad';
                    this.insertBefore(errorDiv, document.querySelector('.auth-footer'));
                }
                event.preventDefault();
            }
        });
    </script>
</body>
</html>