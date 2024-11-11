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
        
        <form action="../../Controller/Users/RegistrerController.php" method="POST">
        <input type="text" name="Nom" placeholder="Nombre" required>
        <input type="text" name="Cognom" placeholder="Apellido" required>
        <input type="text" name="DNI" placeholder="DNI" required>
        <input type="email" name="CorreuElectronic" placeholder="Correo Electrónico" required>
        <input type="text" name="Telefon" placeholder="Teléfono">
        <input type="text" name="Usuari" placeholder="Usuario" required>
        <input type="password" name="Password" placeholder="Contraseña" required>
        <input type="text" name="Ciudad" placeholder="Ciudad">
        <input type="text" name="CodigoPostal" placeholder="Código Postal">
        <button type="submit">Registrar</button>
    </form>
    </div>
</body>
</html>
