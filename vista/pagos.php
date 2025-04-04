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
require_once __DIR__ . '/../controller/servicios/serviciosController.php';

$reservaController = new ReservaController();
$pagoController = new PagoController();
$habitacionController = new HabitacionController();
$actividadController = new ActividadController();
$servicioController = new ServiciosController();

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
$actividadesSeleccionadas = $reserva['actividades'] ?? []; // Manejo de múltiples actividades
$serviciosSeleccionados = $reserva['servicios'] ?? [];

// Obtener detalles de la habitación
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);
if (!$habitacionDetails || !isset($habitacionDetails['Precio'])) {
    die("<p class='text-danger'>Error: No se encontró la habitación o su precio no está definido.</p>");
}

$precioHabitacion = floatval($habitacionDetails['Precio']);
$_SESSION['Reservas']['Precio_Habitacion'] = $precioHabitacion;

// Calcular el número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Calcular precio total de servicios
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
$precioTotal = ($precioHabitacion * $numeroNoches) + $totalActividades + $totalServicios;

// Guardar en sesión si existen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];
    $_SESSION['Reservas']['actividades'] = $_POST['Id_Actividades'] ?? [];
}

echo "<pre>";
print_r($actividadesSeleccionadas);
echo "</pre>";


?>

<pre><?php print_r($_SESSION['Reservas']); ?></pre>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="../static/css/pagos.css">
    <link rel="stylesheet" href="../static/css/detalles.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <script>
        function validarPago(event) {
            const numeroTarjeta = document.querySelector('[name="numero_tarjeta"]').value;
            const cvv = document.querySelector('[name="cvv"]').value;
            const fechaExpiracion = document.querySelector('[name="fecha_expiracion"]').value;

            if (!numeroTarjeta || !cvv || !fechaExpiracion) {
                alert('Por favor, complete todos los campos del formulario de pago.');
                event.preventDefault();
            } else if (numeroTarjeta.length < 13 || numeroTarjeta.length > 19) {
                alert('El número de tarjeta debe tener entre 13 y 19 dígitos.');
                event.preventDefault();
            } else if (cvv.length !== 3) {
                alert('El CVV debe tener 3 dígitos.');
                event.preventDefault();
            }
        }
    </script>
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
<?php
if (!empty($actividadesSeleccionadas)) {
    echo "<ul>";
    foreach ($actividadesSeleccionadas as $idActividad => $precioActividad) {  // Obtener tanto ID como precio
        $nombreActividad = $actividadController->obtenerNombreActividad($idActividad);
        
        if ($nombreActividad !== null) {
            echo "<li>" . htmlspecialchars($nombreActividad) . " - $" . number_format($precioActividad, 2) . "</li>";
        } else {
            echo "<li>Actividad ID: " . htmlspecialchars($idActividad) . " (No encontrada)</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No has seleccionado actividades.</p>";
}
?>



<!-- Precio Total con Servicios -->
<p><strong>Precio Total con Servicios:</strong> $<?php echo number_format($precioTotal, 2); ?></p>

<!-- Formulario de pago -->
<form id="pagoForm" action="../controller/pago/pagoController.php" method="POST" onsubmit="validarPago(event)">

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
