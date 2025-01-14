<?php
session_start();

// Verificar si hubo un error al realizar la reserva
if (!isset($_SESSION['reserva_error'])) {
    header("Location: ../vista/index.php");
    exit();
}

// Mostrar el mensaje de error
$errorMessage = $_SESSION['reserva_error'];
unset($_SESSION['reserva_error']);  // Limpiar el mensaje después de mostrarlo
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en la Reserva</title>
</head>
<body>
    <h1>Error al realizar la reserva</h1>
    <p><?php echo htmlspecialchars($errorMessage); ?></p>
    <a href="../vista/index.php">Volver al inicio</a>
</body>
</html>
