<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registarte </title>
    <link rel="stylesheet" href="../../static/styles/style.css">
</head>
<body>
    <div class="register-container">
        <!-- Logo y título -->
        <div class="header">
            <img class="logo" src="../../static/img/logo.png" alt="Hotel Logo" class="logo">
            <h2>Registrate en nuestro hotel!</h2>
        </div>
        
        <!-- Formulario de Registro -->
        <form>
            <input type="text" placeholder="Full Name" required>
            <input type="text" placeholder="DNI" required>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <input type="password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
            <a href="index.html" class="login-link">Already have an account? Login</a>
        </form>
    </div>
</body>
</html>
