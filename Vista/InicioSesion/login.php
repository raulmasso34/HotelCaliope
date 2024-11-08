<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
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
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Login</button>
            <a href="registre.php" class="login-link">No tienes cuenta? Regístrate</a>
        </form>
    </div>
</body>
</html>
