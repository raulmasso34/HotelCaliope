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

$currentStep = 3; // Paso actual en el proceso de reserva
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
    <header>
        <section class="main-up">
            <div class="main-up-left">
                <a href="../vista/index.php"><img src="../static/img/logo_blanco.png" alt="Logo del hotel" class="logo-header"></a>
            </div>
        </section>
    </header>

    <div class="container">
        <h1 class="titulo-principal">Confirmación de Pago</h1>

        <div class="resumen-reserva">
            <div class="detalle-seccion">
                <h2 class="titulo-seccion">Detalles de la Reserva</h2>
                <div class="detalle-item">
                    <span class="etiqueta-detalle">Habitación:</span>
                    <span><?php echo htmlspecialchars($habitacionId); ?></span>
                </div>
                <div class="detalle-item">
                    <span class="etiqueta-detalle">Check-in:</span>
                    <span><?php echo htmlspecialchars($checkin); ?></span>
                </div>
                <div class="detalle-item">
                    <span class="etiqueta-detalle">Check-out:</span>
                    <span><?php echo htmlspecialchars($checkout); ?></span>
                </div>
                <div class="detalle-item">
                    <span class="etiqueta-detalle">Noches:</span>
                    <span><?php echo $numeroNoches; ?></span>
                </div>
            </div>

            <?php if (!empty($serviciosSeleccionados)) : ?>
            <div class="detalle-seccion">
                <h2 class="titulo-seccion">Servicios Adicionales</h2>
                <ul class="lista-servicios">
                    <?php foreach ($serviciosSeleccionados as $idServicio => $precio) : 
                        $nombreServicio = $servicioController->obtenerNombreServicioPorId($idServicio); ?>
                        <li>
                            <span><?php echo htmlspecialchars($nombreServicio ?? "Servicio $idServicio"); ?></span>
                            <span class="precio-destacado">$<?php echo number_format($precio, 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($actividadesSeleccionadas)) : ?>
            <div class="detalle-seccion">
                <h2 class="titulo-seccion">Actividades</h2>
                <ul class="lista-servicios">
                    <?php foreach ($actividadesSeleccionadas as $idActividad => $precioActividad) : 
                        $nombreActividad = $actividadController->obtenerNombreActividad($idActividad); ?>
                        <li>
                            <span><?php echo htmlspecialchars($nombreActividad ?? "Actividad $idActividad"); ?></span>
                            <span class="precio-destacado">$<?php echo number_format($precioActividad, 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="detalle-seccion">
                <div class="detalle-item total">
                    <span class="etiqueta-detalle">Total a Pagar:</span>
                    <span class="precio-destacado">$<?php echo number_format($precioTotal, 2); ?></span>
                </div>
            </div>
        </div>

        <form id="pagoForm" action="../controller/pago/pagoController.php" method="POST" class="formulario-pago">
            <h2 class="titulo-seccion">Datos de Pago</h2>

            <div class="input-grupo">
                <label for="numero_tarjeta">Número de Tarjeta</label>
                <input type="text" name="numero_tarjeta" class="input-tarjeta" placeholder="1234 5678 9012 3456" required>
            </div>

            <div class="input-grupo">
                <label for="cvv">Código de Seguridad (CVV)</label>
                <input type="text" name="cvv" class="input-tarjeta" placeholder="123" required>
            </div>

            <div class="input-grupo">
                <label for="fecha_expiracion">Fecha de Expiración</label>
                <input type="month" name="fecha_expiracion" class="input-tarjeta" required>
            </div>

            <!-- Campos ocultos (se mantienen igual) -->
            <?php /* Todos los campos hidden se mantienen igual */ ?>

            <button type="submit" class="boton-primario">Confirmar Pago</button>
        </form>
    </div>

    <script src="../static/js/pagos/pagos.js"></script>
</body>
</html>