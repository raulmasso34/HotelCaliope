<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/servicios/serviciosController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php'; 

$servicioController = new ServiciosController();
$actividadController = new ActividadController();

// Verifica si el hotelId está en la sesión o en POST
if (isset($_POST['hotelId'])) {
    $_SESSION['hotelId'] = $_POST['hotelId'];
}

if (isset($_POST['metodoPagoId'])) {
    $_SESSION['Reservas']['metodoPagoId'] = $_POST['metodoPagoId'];
}

$hotelId = $_SESSION['hotelId'] ?? null;

// Si no hay hotel seleccionado, mostrar error y salir
if (!$hotelId) {
    echo "<p style='color:red;'>No se ha seleccionado un hotel.</p>";
    exit;
}

// Verifica si la reserva existe en la sesión
if (!isset($_SESSION['Reservas'])) {
    echo "<p style='color:red;'>Error: No se ha recibido la reserva en la sesión.</p>";
    exit;
}

$_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];
$_SESSION['Reservas']['actividades'] = $_POST['actividades'] ?? [];

$reserva = $_SESSION['Reservas'] ?? [];

// Extraer variables de la sesión
$habitacionId = $reserva['habitacionId'] ?? null;
$checkin = $reserva['checkin'] ?? null;
$checkout = $reserva['checkout'] ?? null;
$guests = $reserva['guests'] ?? null;
$paisId = $reserva['paisId'] ?? null;
$metodoPagoId = $reserva['metodoPagoId'] ?? null;
$precioHabitacion = $reserva['precioHabitacion'] ?? ($reserva['Precio_Habitacion'] ?? null);

// Asignar precioHabitacion si aún no está definido
if (!isset($_SESSION['Reservas']['precioHabitacion']) && isset($precioHabitacion)) {
    $_SESSION['Reservas']['precioHabitacion'] = $precioHabitacion;
}

// Obtener servicios y actividades del hotel
$servicios = $servicioController->obtenerServicios($hotelId);
if (!is_array($servicios)) {
    $servicios = [];
}

$actividades = $actividadController->obtenerActividadesPorHotel($hotelId);
if (!is_array($actividades)) {
    $actividades = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar los servicios seleccionados en la sesión
    $_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];

    // Guardar las actividades seleccionadas en la sesión
    $_SESSION['Reservas']['actividades'] = $_POST['actividades'] ?? [];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/servicios.css">
    <script src="../static/js/servicios/servicios.js"></script>
    <title>Selecciona Servicios y Actividades</title>
</head>
<body>

    <h1>¿Quieres añadir algún servicio?</h1>
    
    <form action="../vista/pagos.php" method="POST">
        <!-- Datos ocultos para asegurar la continuidad -->
        <input type="hidden" name="habitacionId" value="<?php echo $_SESSION['Reservas']['habitacionId'] ?? ''; ?>">
        <input type="hidden" name="hotelId" value="<?php echo $_SESSION['hotelId']; ?>">
        <input type="hidden" name="checkin" value="<?php echo $_SESSION['Reservas']['checkin'] ?? ''; ?>">
        <input type="hidden" name="checkout" value="<?php echo $_SESSION['Reservas']['checkout'] ?? ''; ?>">
        <input type="hidden" name="guests" value="<?php echo $_SESSION['Reservas']['guests'] ?? ''; ?>">
        <input type="hidden" name="paisId" value="<?php echo $_SESSION['Reservas']['paisId'] ?? ''; ?>">
        <input type="hidden" name="metodoPagoId" value="<?php echo $_SESSION['Reservas']['metodoPagoId'] ?? ''; ?>">
        <input type="hidden" name="precioHabitacion" value="<?php echo $_SESSION['Reservas']['precioHabitacion'] ?? ''; ?>">

        <h2>Servicios disponibles</h2>
<div class="servicios-container">
<?php foreach ($servicios as $servicio) : ?>
    <?php if ($servicio['TipoServicio'] == 1): ?>
        <!-- Servicios obligatorios: seleccionados automáticamente y ocultos -->
        <input type="hidden" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo $servicio['Precio']; ?>">
        <?php 
        // También los guardamos directamente en la sesión para asegurarnos que van a pagarse
        $_SESSION['Reservas']['servicios'][$servicio['Id_Servicio']] = $servicio['Precio'];
        ?>
    <?php else: ?>
        <label>
            <input type="checkbox" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo $servicio['Precio']; ?>"
                <?php if (isset($_SESSION['Reservas']['servicios'][$servicio['Id_Servicio']])) : ?>
                    checked
                <?php endif; ?>
            >
            <?php echo htmlspecialchars($servicio['Servicio']); ?> - $<?php echo number_format($servicio['Precio'], 2); ?>
        </label><br>
    <?php endif; ?>
<?php endforeach; ?>
</div>

        
        <h2>Actividades disponibles</h2>
        <div class="actividades-container">
            <?php foreach ($actividades as $actividad) : ?>
                <label>
                <input type="checkbox" name="actividades[<?php echo $actividad['Id_Actividades']; ?>]" value="<?php echo $actividad['Precio']; ?>"
                    <?php if (isset($_SESSION['Reservas']['actividades'][$actividad['Id_Actividades']])) : ?>
                        checked
                    <?php endif; ?>
                >
                    <?php echo htmlspecialchars($actividad['Nombre']); ?> - $<?php echo number_format($actividad['Precio'], 2); ?>
                </label><br>
            <?php endforeach; ?>
        </div>

        <div class="continuar-btn">
            <input id="btn-continuar" type="submit" value="Continuar">
        </div>
    </form>

    <hr>

    <h2>Datos almacenados en la sesión</h2>
    <pre><?php print_r($_SESSION['Reservas']); ?></pre>

</body>
</html>
