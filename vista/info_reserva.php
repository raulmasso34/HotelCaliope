<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/Database.php';
$database = new Database();
$db = $database->getConnection(); 

require_once __DIR__ . '/../controller/reserva/reservaController.php';

$reservaController = new ReservaController();


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener tus estilos CSS -->
</head>
<body>
    <div class="reservation-details">
        <h1>Detalles de la Reserva</h1>

        <!-- Verificamos si hay reserva para mostrar -->
        <?php if (isset($Id_Reserva)): ?>
            <p><strong>ID Reserva:</strong> <?php echo htmlspecialchars($Id_Reserva); ?></p>
            <p><strong>ID Cliente:</strong> <?php echo htmlspecialchars($Id_Cliente); ?></p>
            <p><strong>ID Actividad:</strong> <?php echo htmlspecialchars($Id_Actividad); ?></p>
            <p><strong>ID Habitación:</strong> <?php echo htmlspecialchars($Id_Habitacion); ?></p>
            <p><strong>ID Hotel:</strong> <?php echo htmlspecialchars($Id_Hotel); ?></p>
            <p><strong>Check-in:</strong> <?php echo htmlspecialchars($Checkin); ?></p>
            <p><strong>Check-out:</strong> <?php echo htmlspecialchars($Checkout); ?></p>
            <p><strong>Número de Personas:</strong> <?php echo htmlspecialchars($Numero_Personas); ?></p>
            <p><strong>Precio Total:</strong> <?php echo htmlspecialchars($Precio_Total); ?></p>
        <?php else: ?>
            <p>No se encontraron detalles para esta reserva.</p>
        <?php endif; ?>

        <div class="back-link">
            <a href="reservas.php">Volver a las reservas</a>
        </div>
    </div>
</body>
</html>

