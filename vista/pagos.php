<?php
session_start();

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', realpath(dirname(__FILE__) . '/../')); 

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

$precioHabitacion = $_SESSION['precioTotal'];
$_SESSION['Reservas']['precioTotal'] = $precioHabitacion;

// Calcular el número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Calcular precio total de servicios
$totalServicios = 0;
foreach ($serviciosSeleccionados as $idServicio => $precio) {
    if (!is_numeric($precio)) {
        die("<p class='text-danger'>Error: Un servicio tiene un precio inválido ($precio).</p>");
    }
    $totalServicios += floatval($precio);
}

// Calcular precio total de actividades - Corregido para manejar el formato correcto
$totalActividades = 0;
if (is_array($actividadesSeleccionadas)) {
    // Si es un array asociativo de ID => precio
    if (count($actividadesSeleccionadas) > 0 && array_keys($actividadesSeleccionadas) !== range(0, count($actividadesSeleccionadas) - 1)) {
        foreach ($actividadesSeleccionadas as $actividadId => $precio) {
            if (is_numeric($precio)) {
                $totalActividades += floatval($precio);
            }
        }
    } else {
        // Si es un array numérico simple de IDs
        foreach ($actividadesSeleccionadas as $actividadId) {
            // Asegúrate de que este método exista y devuelva la información correcta
            $actividad = $actividadController->obtenerActividadPorId($actividadId);
            if ($actividad && isset($actividad['Precio']) && is_numeric($actividad['Precio'])) {
                $totalActividades += floatval($actividad['Precio']);
            }
        }
    }
}

// Calcular precio total
$precioTotal = ($precioHabitacion * $numeroNoches) + $totalActividades + $totalServicios;

// Guardar en sesión si existen nuevos datos POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];
    
    // Manejo correcto de actividades del POST
    if (isset($_POST['Id_Actividades']) && is_array($_POST['Id_Actividades'])) {
        $actividadesActualizadas = [];
        foreach ($_POST['Id_Actividades'] as $idActividad) {
            // Obtén el precio correcto de cada actividad
            $actividad = $actividadController->obtenerActividadPorId($idActividad);
            if ($actividad && isset($actividad['Precio'])) {
                $actividadesActualizadas[$idActividad] = floatval($actividad['Precio']);
            }
        }
        $_SESSION['Reservas']['actividades'] = $actividadesActualizadas;
        $actividadesSeleccionadas = $actividadesActualizadas; // Actualizar la variable local también
    }
}

$currentStep = 4; // Paso actual en el proceso de reserva
$pageTitle = "Selecciona tu Hotel";

// Incluir el header común usando la ruta absoluta
include BASE_PATH . '/vista/common-header.php';
?>

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



<div class="luxury-container">
    <!-- Debugging info if needed -->
    <?php /*<pre><?php print_r($_SESSION['Reservas']); ?></pre>*/ ?>

    <div class="reservation-wrapper">
        <!-- Sección de Resumen -->
        <div class="summary-card">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Detalles de la Reserva
            </h2>

            <div class="detail-group">
                <div class="detail-row">
                    <span class="detail-label">Habitación</span>
                    <span class="detail-value"><?php echo htmlspecialchars($habitacionId); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-in</span>
                    <span class="detail-value"><?php echo htmlspecialchars($checkin); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-out</span>
                    <span class="detail-value"><?php echo htmlspecialchars($checkout); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Noches</span>
                    <span class="detail-value"><?php echo $numeroNoches; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Precio Habitación</span>
                    <span class="detail-value">$<?php echo number_format($precioHabitacion, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Subtotal</span>
                    <span class="detail-value">$<?php echo number_format($precioTotal - $totalServicios - $totalActividades, 2); ?></span>
                </div>
            </div>

            <?php if (!empty($serviciosSeleccionados)) : ?>
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                Servicios Adicionales
            </h2>
            <div class="detail-group">
                <?php foreach ($serviciosSeleccionados as $idServicio => $precio) : 
                    $nombreServicio = $servicioController->obtenerNombreServicioPorId($idServicio); ?>
                    <div class="detail-row">
                        <span class="detail-label"><?php echo htmlspecialchars($nombreServicio ?? "Servicio $idServicio"); ?></span>
                        <span class="detail-value">$<?php echo number_format($precio, 2); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($actividadesSeleccionadas)) : ?>
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
                Actividades
            </h2>
            <div class="detail-group">
                <?php 
                if (count($actividadesSeleccionadas) > 0 && array_keys($actividadesSeleccionadas) !== range(0, count($actividadesSeleccionadas) - 1)) {
                    // Es un array asociativo ID => precio
                    foreach ($actividadesSeleccionadas as $idActividad => $precioActividad) :
                        $nombreActividad = $actividadController->obtenerNombreActividad($idActividad); 
                ?>
                    <div class="detail-row">
                        <span class="detail-label"><?php echo htmlspecialchars($nombreActividad ?? "Actividad $idActividad"); ?></span>
                        <span class="detail-value">$<?php echo number_format($precioActividad, 2); ?></span>
                    </div>
                <?php 
                    endforeach;
                } else {
                    // Es un array numérico de IDs
                    foreach ($actividadesSeleccionadas as $idActividad) :
                        $nombreActividad = $actividadController->obtenerNombreActividad($idActividad);
                        $actividad = $actividadController->obtenerActividadPorId($idActividad);
                        $precioActividad = isset($actividad['Precio']) ? $actividad['Precio'] : 0;
                ?>
                    <div class="detail-row">
                        <span class="detail-label"><?php echo htmlspecialchars($nombreActividad ?? "Actividad $idActividad"); ?></span>
                        <span class="detail-value">$<?php echo number_format($precioActividad, 2); ?></span>
                    </div>
                <?php 
                    endforeach;
                }
                ?>
            </div>
            <?php endif; ?>

            <div class="total-box">
                <div class="total-label">Total a Pagar</div>
                <div class="total-amount">$<?php echo number_format($precioTotal, 2); ?></div>
            </div>
        </div>

        <!-- Sección de Pago -->
        <div class="payment-card">
            <h2 class="section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                Información de Pago
            </h2>

            <form id="pagoForm" action="../controller/pago/pagoController.php" method="POST" onsubmit="validarPago(event)">
                <div class="payment-form-group">
                    <input type="text" name="numero_tarjeta" class="payment-input" placeholder="Número de Tarjeta" required>
                    <svg class="payment-icon" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                    </svg>
                </div>

                <div class="payment-form-group">
                    <input type="text" name="cvv" class="payment-input" placeholder="CVV" required>
                    <svg class="payment-icon" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 17a2 2 0 0 0 2-2a2 2 0 0 0-2-2a2 2 0 0 0-2 2a2 2 0 0 0 2 2m6-9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2h1m-6-2a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3Z"/>
                    </svg>
                </div>

                <div class="payment-form-group">
                    <input type="month" name="fecha_expiracion" class="payment-input" placeholder="MM/AA" required>
                </div>

                <input type="hidden" name="pago_enviado" value="1">
                
                <!-- Incluir también el ID de reserva si es necesario -->
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

                <!-- Actividades seleccionadas - mantiene la lógica original -->
                <?php 
                if (!empty($actividadesSeleccionadas)) {
                    if (count($actividadesSeleccionadas) > 0 && array_keys($actividadesSeleccionadas) !== range(0, count($actividadesSeleccionadas) - 1)) {
                        // Es un array asociativo ID => precio
                        foreach ($actividadesSeleccionadas as $idActividad => $precioActividad) : ?>
                            <input type="hidden" name="actividades[<?= htmlspecialchars($idActividad); ?>]" value="<?= htmlspecialchars($precioActividad); ?>">
                        <?php endforeach;
                    } else {
                        // Es un array numérico de IDs
                        foreach ($actividadesSeleccionadas as $idActividad) {
                            $actividad = $actividadController->obtenerActividadPorId($idActividad);
                            $precioActividad = isset($actividad['Precio']) ? $actividad['Precio'] : 0;
                        ?>
                            <input type="hidden" name="actividades[<?= htmlspecialchars($idActividad); ?>]" value="<?= htmlspecialchars($precioActividad); ?>">
                        <?php }
                    }
                }
                ?>

                <!-- Servicios Adicionales -->
                <?php foreach ($serviciosSeleccionados as $idServicio => $precio) : ?>
                    <input type="hidden" name="servicios[<?= $idServicio; ?>]" value="<?= htmlspecialchars($precio); ?>">
                <?php endforeach; ?>

                <button type="submit" class="confirm-button">
                    Realizar Pago
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script src="../static/js/pagos/pagos.js"></script>
</body>
</html>