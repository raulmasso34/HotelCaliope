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
        
        <form action="/HotelCaliope/HotelCaliope-2/Controller/Users/RegistreController.php" method="POST">
        <label>Nombre:</label>
        <input type="text" name="Nom" required><br>

        <label>Apellido:</label>
        <input type="text" name="Cognom" required><br>

        <label>DNI:</label>
        <input type="text" name="DNI" required><br>

        <label>Correo Electrónico:</label>
        <input type="email" name="CorreuElectronic" required><br>

        <label>Teléfono:</label>
        <input type="text" name="Telefon"><br>

        <label>Usuario:</label>
        <input type="text" name="Usuari" required><br>

        <label>Contraseña:</label>
        <input type="password" name="Password" required><br>

        <label>Ciudad:</label>
        <input type="text" name="Ciudad"><br>

        <label>Código Postal:</label>
        <input type="text" name="CodigoPostal"><br>

        <input type="submit" value="Registrarse">
    </form>
    <a href="login.php" class="login-link">Ya tienes cueta? Inicia sesión</a>
    </div>
</body>
</html>
