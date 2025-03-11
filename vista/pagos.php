<?php
session_start();

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Depurar datos antes de la inserción



// Requerir el controlador de reservas
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
    $metodoPagoId = $reserva['metodoPagoId'] ?? 'No disponible';
    $actividadId = $reserva['actividadId'] ?? 'No disponible';
    $paisId = $reserva['paisId'] ?? 'No disponible';
    $precioTarifa = $reserva['precioTarifa'] ?? 0; // Suponiendo que esto está almacenado
    $precioActividad = $reserva['precioActividad'] ?? 0; // Suponiendo que esto también está almacenado
} else {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

// Obtener los detalles de la habitación, incluyendo el precio
$habitacionDetails = $reservaController->obtenerDetallesHabitacion($habitacionId);
$precioHabitacion = $habitacionDetails['Precio'] ?? 0; // Asegúrate de usar el nombre correcto

// Calcular el número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Calcular el precio total
$precioTotal = ($precioHabitacion * $numeroNoches) + $precioTarifa + $precioActividad;

// **Recuperar los servicios seleccionados de la sesión**
$serviciosSeleccionados = $_SESSION['Reservas']['servicios'] ?? []; // Recuperar los servicios seleccionados (si existen)
$totalServicios = $_SESSION['Reservas']['totalServicios'] ?? 0; // El precio total de los servicios

// **Sumar el precio de los servicios al precio total**
$precioTotal += $totalServicios;
var_dump($habitacionId, $clienteId, $hotelId, $checkin, $checkout, $guests, $paisId, $actividadId, $metodoPagoId, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="../static/css/pagos.css">
    <link rel="stylesheet" href="../static/css/detalles.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>

<header>
    <section class="main-up">
        <div class="main-up-left">
            <a href="../vista/index.php"> <img src="../static/img/logo_blanco.png" alt="Imagen secundaria"></a>
        </div>
        <!-- Resto del código del encabezado -->
    </section>
</header>

<h1>Pagar Reserva</h1>

<!-- Mostrar los detalles de la reserva -->
<p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
<p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
<p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
<p><strong>Precio de la Habitación:</strong> $<?php echo number_format($precioHabitacion, 2); ?></p>
<p><strong>Número de Noches:</strong> <?php echo $numeroNoches; ?></p>
<p><strong>Precio Total (sin servicios):</strong> $<?php echo number_format($precioTotal - $totalServicios, 2); ?></p>

<!-- Mostrar los servicios seleccionados -->
<?php if (!empty($serviciosSeleccionados)) : ?>
    <h3>Servicios Seleccionados:</h3>
    <ul>
        <?php foreach ($serviciosSeleccionados as $servicioId => $precioServicio) : ?>
            <li>Servicio ID: <?php echo $servicioId; ?> - Precio: $<?php echo number_format($precioServicio, 2); ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total Servicios:</strong> $<?php echo number_format($totalServicios, 2); ?></p>
<?php else : ?>
    <p>No has seleccionado servicios adicionales.</p>
<?php endif; ?>

<!-- Precio Total con Servicios -->
<p><strong>Precio Total con Servicios:</strong> $<?php echo number_format($precioTotal, 2); ?></p>

<!-- Formulario de pago -->
<form id="pagoForm" action="../controller/pago/pagoController.php" method="POST" onsubmit="mostrarPopup(event)">
    <label for="numero_tarjeta">Número de Tarjeta:</label>
    <input type="text" name="numero_tarjeta" required><br>

    <label for="cvv">CVV:</label>
    <input type="text" name="cvv" required><br>

    <label for="fecha_expiracion">Fecha de Expiración:</label>
    <input type="month" name="fecha_expiracion" required><br>

    <input type="hidden" name="habitacionId" value="<?php echo htmlspecialchars($habitacionId); ?>">
    <input type="hidden" name="clienteId" value="<?php echo htmlspecialchars($clienteId); ?>">
    <input type="hidden" name="hotelId" value="<?php echo htmlspecialchars($hotelId); ?>">
    <input type="hidden" name="paisId" value="<?php echo htmlspecialchars($paisId); ?>">
    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
    <input type="hidden" name="guests" value="<?php echo htmlspecialchars($guests); ?>">
    <input type="hidden" name="precioTotal" value="<?php echo htmlspecialchars($precioTotal); ?>"> <!-- Guardar el precio total en un campo oculto -->
    <input type="hidden" name="metodoPagoId" value="Tarjeta"> <!-- Método de pago -->

    <button type="submit">Confirmar y Pagar</button>
</form>

<script src="../static/js/pagos/pagos.js"></script>
</body>
</html>
