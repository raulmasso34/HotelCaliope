<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/servicios/serviciosController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php'; 

$servicioController = new ServiciosController();
$actividadController = new ActividadController();

// Verifica si el hotelId y metodoPagoId están en la sesión o en POST
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








// Obtener los datos de la reserva
$reserva = $_SESSION['Reservas'] ?? [];
$habitacionId = $reserva['habitacionId'] ?? null;
$checkin = $reserva['checkin'] ?? null;
$checkout = $reserva['checkout'] ?? null;
$guests = $reserva['guests'] ?? null;
$paisId = $reserva['paisId'] ?? null;
$metodoPagoId = $reserva['metodoPagoId'] ?? null;

// Obtener servicios y actividades del hotel
$servicios = $servicioController->obtenerServicios($hotelId) ?: [];
$actividades = $actividadController->obtenerActividadesPorHotel($hotelId) ?: [];

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
        
        <!-- Campos ocultos para mantener los datos de la reserva -->
        <input type="hidden" name="habitacionId" value="<?php echo $habitacionId ?? ''; ?>">
        <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
        <input type="hidden" name="checkin" value="<?php echo $checkin ?? ''; ?>">
        <input type="hidden" name="checkout" value="<?php echo $checkout ?? ''; ?>">
        <input type="hidden" name="guests" value="<?php echo $guests ?? ''; ?>">
        <input type="hidden" name="paisId" value="<?php echo $paisId ?? ''; ?>">
        <input type="hidden" name="metodoPagoId" value="<?php echo $metodoPagoId ?? ''; ?>">
        <input type="hidden" name="clienteId" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" name="precioTotal" value="<?= $_SESSION['Reservas']['precioTotal'] ?? '' ?>">

        <!-- Servicios disponibles -->
        <div class="servicios-container">
        <?php foreach ($servicios as $servicio) : ?>
            <label>
            <input type="checkbox" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo $servicio['Id_Servicio'] . '|' . $servicio['Precio']; ?>">

                <?php echo htmlspecialchars($servicio['Servicio']); ?> - $<?php echo number_format($servicio['Precio'], 2); ?>
            </label><br>
        <?php endforeach; ?>
        </div>

        <!-- Actividades disponibles -->
        <div class="actividades-container">
            <?php foreach ($actividades as $actividad) : ?>
                <label>
                <input type="checkbox" name="actividades[<?php echo $actividad['Id_Actividades']; ?>]" value="<?php echo $actividad['Id_Actividades'] . '|' . $actividad['Precio']; ?>">

                    <?php echo htmlspecialchars($actividad['Nombre']); ?> - $<?php echo number_format($actividad['Precio'], 2); ?>
                </label><br>
            <?php endforeach; ?>
        </div>

        <!-- Botón continuar -->
        <div class="continuar-btn">
            <input id="btn-continuar" type="submit" value="Continuar">
        </div>
    </form>

</body>
</html>
