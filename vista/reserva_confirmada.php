<?php
session_start();


$idReserva = $_GET['idReserva'];

echo "<h1>Reserva Confirmada</h1>";
echo "<p>Su reserva con ID <strong>$idReserva</strong> ha sido confirmada.</p>";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/hotel/hotelController.php';

// ✅ Verificar si se ha recibido el ID de la reserva
if (!isset($_GET['idReserva'])) {
    die("Error: No se ha recibido el ID de la reserva.");
} 

$idReserva = $_GET['idReserva'];

// ✅ Obtener datos de la sesión si existen
$reserva = $_SESSION['Reservas'] ?? [];

// ✅ Cargar datos desde la BD si la sesión no tiene datos
if (empty($reserva)) {
    require_once __DIR__ . '/../modelo/reservas/ReservaModel.php';
    $database = new Database();
    $db = $database->getConnection();
    $reservaModel = new ReservaModel($db);
    
    $reserva = $reservaModel->obtenerReservaPorId($idReserva);
    
    if (!$reserva) {
        die("Error: No se encontró la reserva.");
    }
}

// ✅ Recuperar datos de la reserva con valores predeterminados
$hotelId = $reserva['hotelId'] ?? 'No disponible';
$habitacionId = $reserva['habitacionId'] ?? 'No disponible';
$clienteId = $reserva['clienteId'] ?? 'No disponible';
$checkin = $reserva['checkin'] ?? 'No disponible';
$checkout = $reserva['checkout'] ?? 'No disponible';
$guests = $reserva['guests'] ?? 'No disponible';

// ✅ Verificar método de pago
$metodoPagoId = isset($reserva['metodoPagoId']) ? intval($reserva['metodoPagoId']) : null;
var_dump($metodoPagoId); // Verifica el valor de metodoPagoId después de la conversión

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

// ✅ Obtener actividades y servicios seleccionados
$actividades = $reserva['actividades'] ?? [];
$servicios = $reserva['servicios'] ?? [];
// Mostrar toda la información de la sesión en formato legible
echo "<h2 class='h5 border-bottom pb-2 mt-3'>Contenido de la sesión</h2>";
echo "<pre>";
print_r($_SESSION); // Muestra la información de la sesión
echo "</pre>";
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

                <!-- ✅ Mostrar actividades seleccionadas -->
                <h2 class="h5 border-bottom pb-2 mt-3">Actividades Reservadas</h2>
                <?php if (!empty($actividades)) : ?>
                    <ul>
                        <?php foreach ($actividades as $id => $precio) : ?>
                            <li>Actividad ID: <?php echo htmlspecialchars($id); ?> - Precio: $<?php echo number_format(floatval($precio), 2); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No se seleccionaron actividades.</p>
                <?php endif; ?>

                <!-- ✅ Mostrar servicios seleccionados -->
                <h2 class="h5 border-bottom pb-2 mt-3">Servicios Adicionales</h2>
                <?php if (!empty($servicios)) : ?>
                    <ul>
                        <?php foreach ($servicios as $id => $precio) : ?>
                            <li>Servicio ID: <?php echo htmlspecialchars($id); ?> - Precio: $<?php echo number_format(floatval($precio), 2); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No se seleccionaron servicios.</p>
                <?php endif; ?>

            </div>
            
            <a href="../vista/index.php" class="btn btn-primary mt-3">Volver al inicio</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
