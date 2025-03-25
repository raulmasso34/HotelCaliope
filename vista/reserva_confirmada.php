<?php
session_start();
print_r($_SESSION); // Muestra toda la información almacenada en la sesión
// Mostrar errores en desarrollo (puedes desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/hotel/hotelController.php';

if (!isset($_SESSION['Reservas']) || empty($_SESSION['Reservas'])) {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

// ✅ Obtener datos de la reserva de la sesión
$reserva = $_SESSION['Reservas'];

// ✅ Recuperar datos con valores predeterminados para evitar errores
$hotelId = $reserva['hotelId'] ?? 'No disponible';
$habitacionId = $reserva['habitacionId'] ?? 'No disponible';
$clienteId = $reserva['clienteId'] ?? 'No disponible';
$checkin = $reserva['checkin'] ?? 'No disponible';
$checkout = $reserva['checkout'] ?? 'No disponible';
$guests = $reserva['guests'] ?? 'No disponible';

// ✅ Verificar y asignar método de pago
$metodoPagoId = $reserva['metodoPagoId'] ?? null;
$metodoPago = match ($metodoPagoId) {
    1 => 'Tarjeta de Crédito',
    2 => 'PayPal',
    3 => 'Transferencia Bancaria',
    default => 'No disponible'
};

// ✅ Formatear el precio total
$precioTotal = isset($reserva['precioTotal']) && is_numeric($reserva['precioTotal'])
    ? '$' . number_format(floatval($reserva['precioTotal']), 2, '.', '')
    : 'No disponible';

// ✅ Obtener detalles del hotel
$hotelController = new HotelController();
$hotelDetails = $hotelController->obtenerDetallesHotel($hotelId);
$hotelNombre = $hotelDetails['Nombre'] ?? 'Hotel Desconocido';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg p-4 text-center mx-auto" style="max-width: 600px;">
            <h1 class="text-success">¡Reserva Confirmada!</h1>
            <p class="lead">Gracias por tu pago. Tu reserva ha sido realizada con éxito.</p>
            
            <div class="mt-4 text-start">
                <h2 class="h5 border-bottom pb-2">Detalles de la Reserva</h2>
                <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelNombre); ?></p>
                <p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
                <p><strong>Cliente ID:</strong> <?php echo htmlspecialchars($clienteId); ?></p>
                <p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
                <p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
                <p><strong>Invitados:</strong> <?php echo htmlspecialchars($guests); ?></p>
                <p><strong>Método de Pago:</strong> <?php echo htmlspecialchars($metodoPago); ?></p>
                <p><strong>Total Pagado:</strong> <?php echo htmlspecialchars($precioTotal); ?></p>
            </div>
            
            <a href="../vista/index.php" class="btn btn-primary mt-3">Volver al inicio</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
