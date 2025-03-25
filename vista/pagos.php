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

$reservaController = new ReservaController();
$pagoController = new PagoController();
$habitacionController = new HabitacionController();
$actividadController = new ActividadController();

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
$paisId = $reserva['paisId'] ?? null;
$precioTarifa = $reserva['precioTarifa'] ?? 0;
$actividadesSeleccionadas = $reserva['actividades'] ?? []; // Manejo de múltiples actividades

// Obtener detalles de la habitación
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);
if (!$habitacionDetails || !isset($habitacionDetails['Precio'])) {
    die("<p class='text-danger'>Error: No se encontró la habitación o su precio no está definido.</p>");
}

// Obtener precio de la habitación
$precioHabitacion = floatval($habitacionDetails['Precio']);

// Calcular el número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Calcular precio total de servicios
$serviciosSeleccionados = $_SESSION['Reservas']['servicios'] ?? [];
$totalServicios = 0;
foreach ($serviciosSeleccionados as $precio) {
    if (!is_numeric($precio)) {
        die("<p class='text-danger'>Error: Un servicio tiene un precio inválido ($precio).</p>");
    }
    $totalServicios += floatval($precio);
}

// Calcular precio total de actividades
$totalActividades = 0;
foreach ($actividadesSeleccionadas as $actividadId) {
    $actividad = $actividadController->obtenerActividadesPorHotel($actividadId);
    $totalActividades += $actividad['Precio'] ?? 0;
}

// Calcular precio total
$precioTotal = ($precioHabitacion * $numeroNoches) + $precioTarifa + $totalActividades + $totalServicios;

// Guardar en sesión si existen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];
    $_SESSION['Reservas']['actividades'] = $_POST['actividades'] ?? [];
}






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
    </section>
</header>

<h1>Pagar Reserva</h1>

<!-- Mostrar detalles de la reserva -->
<p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
<p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
<p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
<p><strong>Precio de la Habitación:</strong> $<?php echo number_format($precioHabitacion, 2); ?></p>
<p><strong>Número de Noches:</strong> <?php echo $numeroNoches; ?></p>
<p><strong>Precio Total (sin servicios):</strong> $<?php echo number_format($precioTotal - $totalServicios - $totalActividades, 2); ?></p>

<h3>Servicios Adicionales Seleccionados:</h3>
<?php
require_once __DIR__ ."/../controller/servicios/serviciosController.php";
$servicioController = new ServiciosController();

$serviciosSeleccionados = $_POST['servicios'] ?? []; // Si no hay selección, deja array vacío

if (!empty($serviciosSeleccionados)) {
    echo "<ul>";
    foreach ($serviciosSeleccionados as $idServicio => $precio) {
        $nombreServicio = $servicioController->obtenerNombreServicioPorId($idServicio); // Obtener el nombre
        if ($nombreServicio) {
            echo "<li>" . htmlspecialchars($nombreServicio) . " - $" . number_format($precio, 2) . "</li>";
        } else {
            echo "<li>Servicio ID: " . htmlspecialchars($idServicio) . " (No encontrado)</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No has seleccionado servicios adicionales.</p>";
}
?>

<h3>Actividades Seleccionadas:</h3>
<ul>
<?php
if (!empty($_SESSION['Reservas']['actividades'])) {
    foreach ($_SESSION['Reservas']['actividades'] as $idActividad => $precio) {
        $nombreActividad = $actividadController->obtenerNombreActividad($idActividad) ?? "Actividad no encontrada";
        echo "<li>$nombreActividad - Precio: $" . number_format($precio, 2) . "</li>";
    }
} else {
    echo "<li>No se seleccionaron actividades.</li>";
}
?>
</ul>






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
    <input type="hidden" name="clienteId" value="<?= htmlspecialchars($clienteId); ?>">
    <input type="hidden" name="hotelId" value="<?= htmlspecialchars($hotelId); ?>">
    <input type="hidden" name="paisId" value="<?= htmlspecialchars($paisId); ?>">
    <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin); ?>">
    <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout); ?>">
    <input type="hidden" name="guests" value="<?= htmlspecialchars($guests); ?>">
    <input type="hidden" name="precioTotal" value="<?= htmlspecialchars($precioTotal); ?>">
    <input type="hidden" name="metodoPagoId" value="1">

    <!-- Actividades seleccionadas -->
    <?php foreach ($actividadesSeleccionadas as $actividadId) : ?>
        <input type="hidden" name="actividades[]" value="<?= htmlspecialchars($actividadId); ?>">
    <?php endforeach; ?>

    <!-- Servicios Adicionales -->
    <?php foreach ($serviciosSeleccionados as $idServicio => $precio) : ?>
        <input type="hidden" name="servicios[<?= $idServicio; ?>]" value="<?= htmlspecialchars($precio); ?>">
    <?php endforeach; ?>

    <button type="submit">Confirmar y Pagar</button>
</form>

<script src="../static/js/pagos/pagos.js"></script>
</body>
</html>
