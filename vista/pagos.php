<?php
session_start();

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/pago/pagoController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';

$reservaController = new ReservaController();
$pagoController = new PagoController();
$habitacionController = new HabitacionController();

// Verificar si la reserva está en la sesión
if (!isset($_SESSION['Reservas'])) {
    echo "<p class='text-danger'>Error: No se ha recibido la reserva en la sesión.</p>";
    exit;
}

$reserva = $_SESSION['Reservas'];

// Recuperar los datos de la reserva
$habitacionId = $reserva['habitacionId'] ?? null;
$clienteId = $reserva['clienteId'] ?? null;
$hotelId = $reserva['hotelId'] ?? null;
$checkin = $reserva['checkin'] ?? null;
$checkout = $reserva['checkout'] ?? null;
$guests = $reserva['guests'] ?? null;
$metodoPagoId = $reserva['metodoPagoId'] ?? null;
$actividadId = $reserva['actividadId'] ?? null;
$paisId = $reserva['paisId'] ?? null;
$precioTarifa = $reserva['precioTarifa'] ?? 0;
$precioActividad = $reserva['precioActividad'] ?? 0;

echo "<pre>";
print_r($_SESSION['Reservas']);
echo "</pre>";


// Obtener los detalles de la habitación
// Obtener los detalles de la habitación, incluyendo el precio
// Obtener los detalles de la habitación
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);

if (!$habitacionDetails || !isset($habitacionDetails['Precio'])) {
    die("<p class='text-danger'>Error: No se encontró la habitación o su precio no está definido.</p>");
}

// Verificar si se obtiene el precio de la habitación
$precioHabitacion = floatval($habitacionDetails['Precio']);
echo "<p>Precio de la habitación obtenido: $precioHabitacion</p>";



// Calcular el número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Recuperar los servicios seleccionados y su costo total
$serviciosSeleccionados = $_SESSION['Reservas']['servicios'] ?? [];
$totalServicios = 0; // Inicializar correctamente
foreach ($serviciosSeleccionados as $servicioId => $precio) {
    if (!is_numeric($precio)) {
        die("<p class='text-danger'>Error: Un servicio tiene un precio inválido ($precio).</p>");
    }
    $totalServicios += floatval($precio);
}





$precioTotal = ($precioHabitacion * $numeroNoches) + $precioTarifa + $precioActividad + $totalServicios;

echo "<p>Precio total calculado: $precioTotal</p>";
echo "Precio de la habitación a enviar: " . $precioHabitacion;
$fechaPago = date("Y-m-d H:i:s"); // Incluye la hora
 // Asegúrate de que la fecha esté bien formateada
error_log("Fecha a insertar: " . $fechaPago);



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

    <!-- Datos de la reserva -->
    <input type="hidden" name="habitacionId" value="<?= htmlspecialchars($habitacionId); ?>">
    <input type="hidden" name="precioHabitacion" value="<?= htmlspecialchars($precioHabitacion); ?>">

    <input type="hidden" name="clienteId" value="<?= htmlspecialchars($clienteId); ?>">
    <input type="hidden" name="hotelId" value="<?= htmlspecialchars($hotelId); ?>">
    <input type="hidden" name="paisId" value="<?= htmlspecialchars($paisId); ?>">
    <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin); ?>">
    <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout); ?>">
    <input type="hidden" name="guests" value="<?= htmlspecialchars($guests); ?>">
    <input type="hidden" name="precioTotal" value="<?= htmlspecialchars($precioTotal); ?>">
    <input type="hidden" name="metodoPagoId" value="1">


    <!-- Actividad (Opcional) -->
    <input type="hidden" name="actividadId" value="<?= isset($actividadId) ? htmlspecialchars($actividadId) : ''; ?>">

    <!-- Tarifa (Opcional) -->
    <input type="hidden" name="tarifaId" value="<?= isset($tarifaId) ? htmlspecialchars($tarifaId) : ''; ?>">

    <!-- Servicios Adicionales -->
    <?php
    if (!empty($_SESSION['Reservas']['servicios'])) {
        foreach ($_SESSION['Reservas']['servicios'] as $idServicio => $precio) {
            echo '<input type="hidden" name="servicios[' . $idServicio . ']" value="' . htmlspecialchars($precio) . '">';
        }
    }
    ?>


    <button type="submit">Confirmar y Pagar</button>
</form>


<script src="../static/js/pagos/pagos.js"></script>
</body>
</html>
