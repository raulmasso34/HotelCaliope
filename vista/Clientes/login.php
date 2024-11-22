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
    <title>Login - Hotel Caliope</title>
    <link rel="stylesheet" href="../../static/css/InicioSesion.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <img class="logo" src="../../static/img/logo.png" alt="Hotel Logo">
            <h2>Bienvenido al Hotel Caliope</h2>
        </div>
        
        <!-- Formulario de Login -->
        <form method="POST" action="../../Controller/Users/LoginController.php">
            <label for="Usuari">Usuario:</label>
            <input type="text" name="Usuari" id="Usuari" required>

            <label for="DNI">DNI:</label>
            <input type="text" name="DNI" id="DNI" required>

            <label for="Password">Contraseña:</label>
            <input type="password" name="Password" id="Password" required>

            <button class="login-btn" type="submit">Iniciar sesión</button>
        </form>

    
    </form>
        <div class="register-link">
            <p>¿No tienes cuenta? <a href="registre.php">Regístrate aquí</a></p>
        </div>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
