<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="../../static/styles/style.css">
</head>
<body>
    <div class="register-container">
        <!-- Logo y título -->
        <div class="header">
            <img src="../../static/img/logo.png" alt="Hotel Logo" class="logo">
            <h2>¡Regístrate en nuestro hotel!</h2>
        </div>
        
        <!-- Formulario de Registro -->
        <form action="register_process.php" method="POST">
            <input type="text" name="full_name" placeholder="Nombre Completo" required>
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
            <button type="submit">Registrarse</button>
            <a href="login.php" class="login-link">¿Ya tienes una cuenta? Inicia sesión</a>
        </form>
    </div>
</body>
</html>
