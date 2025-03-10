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

    // Recuperar los datos de la reserva, con valores predeterminados si no están definidos
    $habitacionId = $reserva['habitacionId'] ?? 'No disponible';
    $clienteId = $reserva['clienteId'] ?? 'No disponible';
    $hotelId = $reserva['hotelId'] ?? 'No disponible';
    $checkin = $reserva['checkin'] ?? 'No disponible';
    $checkout = $reserva['checkout'] ?? 'No disponible';
    $guests = $reserva['guests'] ?? 'No disponible';
    $paisId = $reserva['paisId'] ?? 'No disponible';  // Asegúrate de agregar esto
    $actividadId = $reserva['actividadId'] ?? 'No disponible';  // Asegúrate de agregar esto
    $metodoPagoId = $reserva['metodo_pago'] ?? 'No disponible';  // Asegúrate de agregar esto
    $precioHabitacion = $reserva['precioHabitacion'] ?? 'No disponible';  // Asegúrate de agregar esto
    $precioActividad = $reserva['precioActividad'] ?? 'No disponible';  // Asegúrate de agregar esto
    $precioTarifa = $reserva['precioTarifa'] ?? 'No disponible';  // Asegúrate de agregar esto
    $precioTotal = $reserva['precioTotal'] ?? 'No disponible';  // Asegúrate de agregar esto
    
    // Suponiendo que tienes un controlador que obtiene los detalles del hotel
    $hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
} else {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

// Depuración de los datos
var_dump($_SESSION['Reservas']);
var_dump($habitacionId, $clienteId, $hotelId, $checkin, $checkout, $guests, $paisId, $actividadId, $metodoPagoId, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg p-4 text-center mx-auto" style="max-width: 600px;">
            <h1 class="text-success">¡Reserva Confirmada!</h1>
            <p class="lead">Gracias por tu pago. Tu reserva ha sido realizada con éxito.</p>
            
            <div class="mt-4 text-start">
                <h2 class="h5 border-bottom pb-2">Detalles de la Reserva</h2>
                <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>
                <p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
                <p><strong>Cliente ID:</strong> <?php echo htmlspecialchars($clienteId); ?></p>
                <p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
                <p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
                <p><strong>Invitados:</strong> <?php echo htmlspecialchars($guests); ?></p>
            </div>
            
            <a href="../vista/index.php" class="btn btn-primary mt-3">Volver al inicio</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
