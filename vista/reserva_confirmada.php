<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
$reservaController = new ReservaController();

// Verificar si la reserva está en la sesión
if (isset($_SESSION['Reservas'])) {
    $reserva = $_SESSION['Reservas'];

    // Recuperar los datos de la reserva
    $habitacionId = $reserva['habitacionId'] ?? 'No disponible';
    $clienteId = $reserva['clienteId'] ?? 'No disponible';
    $hotelId = $reserva['hotelId'] ?? 'No disponible';
    $checkin = $reserva['checkin'] ?? 'No disponible';
    $checkout = $reserva['checkout'] ?? 'No disponible';
    $guests = $reserva['guests'] ?? 'No disponible';
    
    // Suponiendo que tienes un controlador que obtiene los detalles del hotel
    // Ejemplo:
    $hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
} else {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="../static/css/resrerva_confimada.css"> <!-- Enlazamos al archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>¡Reserva Confirmada!</h1>
        <p>Gracias por tu pago. Tu reserva ha sido realizada con éxito.</p>
        
        <div class="details">
            <h2>Detalles de la Reserva</h2>
            <!-- Mostrar el nombre del hotel -->
            <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p> <!-- Asegúrate de que 'Nombre' exista en el array -->
            <p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
            <p><strong>Cliente ID:</strong> <?php echo htmlspecialchars($clienteId); ?></p>
            <p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
            <p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
            <p><strong>Invitados:</strong> <?php echo htmlspecialchars($guests); ?></p>
        </div>

        <p><a href="../vista/index.php">Volver al inicio</a></p>
    </div>
</body>
</html>
