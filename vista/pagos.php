<?php
session_start();

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/pago/pagoController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';
require_once __DIR__ . "/../controller/servicios/serviciosController.php";

$reservaController = new ReservaController();
$pagoController = new PagoController();
$habitacionController = new HabitacionController();
$actividadController = new ActividadController();
$serviciosController = new ServiciosController();

// Validar que la reserva existe en sesión
if (!isset($_SESSION['Reservas'])) {
    die("<p class='text-danger'>Error: No se ha recibido la reserva en la sesión.</p>");
}

$reserva = $_SESSION['Reservas'];

// Obtener datos de la reserva
$habitacionId = $reserva['habitacionId'] ?? null;
$clienteId = $reserva['clienteId'] ?? null;
$hotelId = $reserva['hotelId'] ?? null;
$checkin = $reserva['checkin'] ?? null;
$checkout = $reserva['checkout'] ?? null;
$guests = $reserva['guests'] ?? null;
$metodoPagoId = $reserva['metodoPagoId'] ?? null;
$paisId = $reserva['paisId'] ?? null;

// Obtener detalles de la habitación
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);
if (!$habitacionDetails || !isset($habitacionDetails['Precio'])) {
    die("<p class='text-danger'>Error: No se encontró la habitación o su precio no está definido.</p>");
}

$precioHabitacion = floatval($habitacionDetails['Precio']);

// Calcular número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Calcular total servicios
$totalServicios = 0;
$serviciosDetalles = [];
if (!empty($reserva['servicios'])) {
    foreach ($reserva['servicios'] as $servicio) {
        list($idServicio, $precioServicio) = explode('|', $servicio);
        $servicioInfo = $serviciosController->obtenerServicioPorId(intval($idServicio));
        if ($servicioInfo) {
            $serviciosDetalles[] = "{$servicioInfo['Servicio']} - $$precioServicio";
            $totalServicios += floatval($precioServicio);
        }
    }
}

// Calcular total actividades
$totalActividades = 0;
$actividadesDetalles = [];
if (!empty($reserva['actividades'])) {
    foreach ($reserva['actividades'] as $actividad) {
        list($idActividad, $precioActividad) = explode('|', $actividad);
        $actividadInfo = $actividadController->obtenerActividadPorId(intval($idActividad));
        if ($actividadInfo) {
            $actividadesDetalles[] = "{$actividadInfo['Nombre']} - $$precioActividad";
            $totalActividades += floatval($precioActividad);
        }
    }
}

// Calcular precio total CORRECTO
$precioTotal = ($precioHabitacion * $numeroNoches) + $totalServicios + $totalActividades;

// Actualizar sesión con todos los datos
$_SESSION['Reservas'] = [
    'habitacionId' => $habitacionId,
    'clienteId' => $clienteId,
    'hotelId' => $hotelId,
    'checkin' => $checkin,
    'checkout' => $checkout,
    'guests' => $guests,
    'metodoPagoId' => $metodoPagoId,
    'paisId' => $paisId,
    'precioHabitacion' => $precioHabitacion,
    'precioTotal' => $precioTotal,
    'servicios' => $_POST['servicios'] ?? $reserva['servicios'] ?? [],
    'actividades' => $_POST['actividades'] ?? $reserva['actividades'] ?? []
];

// Manejar POST correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../static/css/pagos.css">
    <title>Pagar Reserva</title>
</head>
<body>

<h1>Pagar Reserva</h1>

<p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
<p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
<p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
<p><strong>Precio de la Habitación:</strong> $<?php echo number_format($precioHabitacion, 2); ?></p>
<p><strong>Número de Noches:</strong> <?php echo $numeroNoches; ?></p>
<p><strong>Precio Total (sin servicios):</strong> $<?php echo number_format($precioTotal - $totalServicios - $totalActividades, 2); ?></p>

<h3>Servicios Adicionales Seleccionados:</h3>

<?php
echo !empty($serviciosDetalles) ? "<ul><li>" . implode("</li><li>", $serviciosDetalles) . "</li></ul>" : "<p>No se seleccionaron servicios adicionales.</p>";
?>

<h3>Actividades Seleccionadas:</h3>
<?php
echo !empty($actividadesDetalles) ? "<ul><li>" . implode("</li><li>", $actividadesDetalles) . "</li></ul>" : "<p>No se seleccionaron actividades.</p>";
?>

<!-- Precio Total con Servicios -->
<p><strong>Precio Total:</strong> $<?php echo number_format($precioTotal, 2); ?></p>

<!-- Formulario de pago -->
<form action="../controller/pago/pagoController.php" method="POST">

<input type="hidden" name="clienteId" value="<?= htmlspecialchars($clienteId) ?>">
    <input type="hidden" name="hotelId" value="<?= htmlspecialchars($hotelId) ?>">
    <input type="hidden" name="habitacionId" value="<?= htmlspecialchars($habitacionId) ?>">
    <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin) ?>">
    <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout) ?>">
    <input type="hidden" name="guests" value="<?= htmlspecialchars($guests) ?>">
    <input type="hidden" name="paisId" value="<?= htmlspecialchars($paisId) ?>">
    <input type="hidden" name="metodoPagoId" value="<?= htmlspecialchars($metodoPagoId) ?>">
    <input type="hidden" name="precioHabitacion" value="<?= htmlspecialchars($precioHabitacion) ?>">
    <label for="numero_tarjeta">Número de Tarjeta:</label>
    <input type="text" name="numero_tarjeta" required><br>

    <label for="cvv">CVV:</label>
    <input type="text" name="cvv" required><br>

    <label for="fecha_expiracion">Fecha de Expiración:</label>
    <input type="month" name="fecha_expiracion" required><br>

    <input type="hidden" name="precioTotal" value="<?= htmlspecialchars($precioTotal); ?>">

    <button type="submit">Confirmar y Pagar</button>
</form>

<?php
echo "<pre>";
print_r($_POST);
echo "</pre>";


?>

</body>
</html>
