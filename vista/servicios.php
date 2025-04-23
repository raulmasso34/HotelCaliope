<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', realpath(dirname(__FILE__) . '/../')); 

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


$currentStep = 3; // Paso actual en el proceso de reserva
$pageTitle = "Selecciona tu Hotel";

// Incluir el header común usando la ruta absoluta
include BASE_PATH . '/vista/common-header.php';

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
    <div class="services-container">
        <div class="services-header">
            <h1><i class="fas fa-spa me-2"></i>Personaliza tu Experiencia</h1>
            <p class="mb-0">Selecciona los servicios y actividades para tu estancia</p>
        </div>
        
        <div class="services-body">
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

                <h2 class="section-title"><i class="fas fa-concierge-bell"></i> Servicios Premium</h2>
                <div class="options-grid">
                    <?php foreach ($servicios as $servicio) : ?>
                        <?php if ($servicio['TipoServicio'] == 1): ?>
                            <!-- Servicios obligatorios: seleccionados automáticamente y ocultos -->
                            <input type="hidden" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo $servicio['Precio']; ?>">
                            <?php 
                            // También los guardamos directamente en la sesión para asegurarnos que van a pagarse
                            $_SESSION['Reservas']['servicios'][$servicio['Id_Servicio']] = $servicio['Precio'];
                            ?>
                        <?php else: ?>
                            <div class="option-card">
                                <input type="checkbox" 
                                       class="option-checkbox" 
                                       id="servicio-<?php echo $servicio['Id_Servicio']; ?>" 
                                       name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" 
                                       value="<?php echo $servicio['Precio']; ?>"
                                    <?php if (isset($_SESSION['Reservas']['servicios'][$servicio['Id_Servicio']])) : ?>
                                        checked
                                    <?php endif; ?>
                                >
                                <label for="servicio-<?php echo $servicio['Id_Servicio']; ?>">
                                    <div class="option-title"><?php echo htmlspecialchars($servicio['Servicio']); ?></div>
                                    <div class="option-price">$<?php echo number_format($servicio['Precio'], 2); ?></div>
                                    <?php if (!empty($servicio['Descripcion'])): ?>
                                        <div class="option-description"><?php echo htmlspecialchars($servicio['Descripcion']); ?></div>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <h2 class="section-title"><i class="fas fa-hiking"></i> Actividades Exclusivas</h2>
                <div class="options-grid">
                    <?php foreach ($actividades as $actividad) : ?>
                        <div class="option-card">
                            <input type="checkbox" 
                                   class="option-checkbox" 
                                   id="actividad-<?php echo $actividad['Id_Actividades']; ?>" 
                                   name="actividades[<?php echo $actividad['Id_Actividades']; ?>]" 
                                   value="<?php echo $actividad['Precio']; ?>"
                                <?php if (isset($_SESSION['Reservas']['actividades'][$actividad['Id_Actividades']])) : ?>
                                    checked
                                <?php endif; ?>
                            >
                            <label for="actividad-<?php echo $actividad['Id_Actividades']; ?>">
                                <div class="option-title"><?php echo htmlspecialchars($actividad['Nombre']); ?></div>
                                <div class="option-price">$<?php echo number_format($actividad['Precio'], 2); ?></div>
                                <?php if (!empty($actividad['Descripcion'])): ?>
                                    <div class="option-description"><?php echo htmlspecialchars($actividad['Descripcion']); ?></div>
                                <?php endif; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn-continue">
                </button>
            </form>

            <!-- Modal personalizado -->
            
        </div>
    </div>

    <div class="custom-modal" id="confirmationModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fas fa-question-circle"></i>
                        <h3 class="modal-title">¿Continuar sin servicios?</h3>
                    </div>
                    <p class="modal-message">No has seleccionado ningún servicio o actividad adicional. ¿Estás seguro de que deseas continuar?</p>
                    <div class="modal-buttons">
                        <button class="modal-btn modal-btn-cancel" id="cancelBtn">Volver atrás</button>
                        <button class="modal-btn modal-btn-confirm" id="confirmBtn">Continuar sin extras</button>
                    </div>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../static/js/servicios/servicios.js"></script>
</body>
</html>