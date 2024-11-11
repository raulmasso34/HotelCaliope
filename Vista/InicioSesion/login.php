<!-- /Vista/InicioSesion/login.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel Caliope</title>
    <link rel="stylesheet" href="../../static/styles/style.css">
</head>
<body>
    <div class="login-container">
        <div class="header">
            <img class="logo" src="../../static/img/logo.png" alt="Hotel Logo">
            <h2>Bienvenido al Hotel Caliope</h2>
        </div>
        
        <!-- Formulario de Login -->
        <form action="../../Controller/Users/LoginController.php" method="POST">
            <input type="text" name="Usuari" placeholder="Usuario" required>
            <input type="text" name="DNI" placeholder="DNI" required>
            <input type="password" name="Password" placeholder="Contraseña" required>

            <button type="submit">Login</button>
           
        </form>
        <a href="registre.php" class="login-link">No tienes cuenta? Regístrate</a>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
