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
} else {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

$hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="../static/css/pagos.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>
    <h1>Pagar Reserva</h1>

    <!-- Mostrar los detalles de la reserva -->
    <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p> <!-- Asumiendo que 'Nombre' es un campo del array -->
    <p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
    <p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
    <p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
    <p><strong>Personas:</strong> <?php echo htmlspecialchars($guests); ?></p>

    <!-- Formulario de pago -->
    <form action="../controller/pago/pagoController.php" method="POST">
        <label for="numero_tarjeta">Número de Tarjeta:</label>
        <input type="text" name="numero_tarjeta" required><br>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" required><br>

        <label for="fecha_expiracion">Fecha de Expiración:</label>
        <input type="month" name="fecha_expiracion" required><br>

        <!-- Datos ocultos para procesar la reserva -->
        <input type="hidden" name="habitacionId" value="<?php echo htmlspecialchars($habitacionId); ?>">
        <input type="hidden" name="clienteId" value="<?php echo htmlspecialchars($clienteId); ?>">
        <input type="hidden" name="hotelId" value="<?php echo htmlspecialchars($hotelId); ?>">
        <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
        <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
        <input type="hidden" name="guests" value="<?php echo htmlspecialchars($guests); ?>">

        <button type="submit">Confirmar y Pagar</button>
    </form>
</body>
</html>
