<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BASE_PATH', realpath(dirname(__FILE__) . '/../')); 

require_once __DIR__ . '/../config/Database.php'; 
require_once __DIR__ . '/../controller/hotel/hotelController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php';
require_once __DIR__ . '/../controller/servicios/serviciosController.php';
require_once __DIR__ . '/../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../modelo/clientesModelo/ClientModel.php'; // Agregar el modelo de Cliente

// ✅ Verificar ID de reserva
if (!isset($_GET['idReserva'])) {
    die("Error: No se ha recibido el ID de la reserva.");
}

$idReserva = $_GET['idReserva'];

// ✅ Crear conexión a la base de datos antes de usarla
$database = new Database();
$db = $database->getConnection();

// ✅ Obtener reserva de la sesión o BD
$reserva = $_SESSION['Reservas'] ?? [];
if (empty($reserva)) {
    $reservaModel = new ReservaModel($db);
    $reserva = $reservaModel->obtenerReservaPorId($idReserva);
    if (!$reserva) die("Error: No se encontró la reserva.");
}

// ✅ Recuperar y preparar datos
$hotelId = $reserva['hotelId'] ?? null;
$habitacionId = $reserva['habitacionId'] ?? null;
$clienteId = $reserva['clienteId'] ?? 'No disponible';
$guests = $reserva['guests'] ?? 'No disponible';

// ✅ Obtener nombre del cliente
$clienteModel = new ClientModel($db);  // Ahora ClientModel tiene acceso a $db
$nombreCliente = $clienteModel->obtenerNombreCliente($clienteId);
$nombreCliente = htmlspecialchars($nombreCliente); // Seguridad al mostrar el nombre

$checkin = new DateTime($reserva['checkin']);
$checkout = new DateTime($reserva['checkout']);
$checkinFormatted = $checkin->format('d/m/Y');
$checkoutFormatted = $checkout->format('d/m/Y');

// ✅ Número de noches
$numeroNoches = max($checkin->diff($checkout)->days, 1);

// ✅ Obtener info de hotel y habitación
$hotelController = new hotelController();
$hotel = $hotelController->obtenerHotelPorId($hotelId);
$hotelNombre = $hotel['Nombre'] ?? 'Desconocido';

$habitacionController = new habitacionController();
$habitacion = $habitacionController->obtenerHabitacionPorId($habitacionId);
$habitacionDetalle = $habitacion['Tipo'] ?? 'Desconocido';
$precioHabitacion = $_SESSION['precioTotal'];


// ✅ Calcular subtotal habitación
$subtotalHabitacion = $precioHabitacion * $numeroNoches;

// ✅ Calcular servicios
$servicios = $reserva['servicios'] ?? [];
$totalServicios = 0;
$detallesServicios = [];
$servicioController = new serviciosController();

foreach ($servicios as $servicioId => $precio) {
    // Si el precio es numérico, usamos el valor del servicio de la sesión o base de datos.
    if (is_numeric($precio)) {
        // Obtener el servicio por ID
        $nombre = $servicioController->obtenerNombreServicioPorId($servicioId);
        
        // Verifica que el nombre del servicio no sea null
        if ($nombre === null) {
            $nombre = 'Desconocido';
        }
        
        // Asignar el precio desde la reserva
        $precio = floatval($precio);
    } else {
        // Si el precio no es numérico (por ejemplo, el valor que se pasa es el ID del servicio)
        $nombre = $servicioController->obtenerNombreServicioPorId($servicioId);
        
        // Verifica que el nombre del servicio no sea null
        if ($nombre === null) {
            $nombre = 'Desconocido';
        }
        
        // Asignar el precio desde la reserva
        $precio = floatval($precio);
    }

    $totalServicios += $precio;
    $detallesServicios[] = ['nombre' => $nombre, 'precio' => $precio];
}

// ✅ Calcular actividades
$actividades = $reserva['actividades'] ?? [];
$totalActividades = 0;
$detallesActividades = [];
$actividadController = new ActividadController();

foreach ($actividades as $id => $precio) {
    if (!is_numeric($precio)) {
        $actividad = $actividadController->obtenerActividadPorId($id);
        $precio = $actividad['Precio'] ?? 0;
        $nombre = $actividad['Nombre'] ?? 'Desconocido';
    } else {
        $actividad = $actividadController->obtenerActividadPorId($id);
        $nombre = $actividad['Nombre'] ?? 'Desconocido';
    }

    $totalActividades += floatval($precio);
    $detallesActividades[] = ['nombre' => $nombre, 'precio' => $precio];
}

// ✅ Método de pago
$metodoPagoId = isset($reserva['metodoPagoId']) ? intval($reserva['metodoPagoId']) : null;
$metodoPago = match ($metodoPagoId) {
    1 => 'Tarjeta de Crédito',
    2 => 'PayPal',
    3 => 'Transferencia Bancaria',
    default => 'No disponible'
};



// ✅ Calcular total
$precioTotal = $subtotalHabitacion + $totalServicios + $totalActividades;
$precioTotalFormateado = number_format($precioTotal, 2, '.', ',');

// ✅ Guardar en sesión
$_SESSION['Reservas'] = array_merge($_SESSION['Reservas'] ?? [], [
    'Precio_Habitacion' => $precioHabitacion,
    'Precio_Servicios' => $totalServicios,
    'Precio_Actividades' => $totalActividades,
    'Precio_Total' => $precioTotal,
    'Noches' => $numeroNoches
]);

$currentStep = 5; // Paso actual en el proceso de reserva
$pageTitle = "Selecciona tu Hotel";

// Incluir el header común usando la ruta absoluta
include BASE_PATH . '/vista/common-header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva - Luxury Stays</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../static/css/resrerva_confimada.css" rel="stylesheet">
</head>
<body>
    <div class="reserva-container">
        <!-- Header de Confirmación -->
        <div class="reserva-header">
            <div class="header-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>¡Reserva Confirmada!</h1>
            <p class="header-sub">Recibirás un email de confirmación en tu correo electrónico</p>
        </div>

        <!-- Contenido Principal -->
        <div class="reserva-grid">
            <!-- Columna Izquierda - Detalles Principales -->
            <div class="reserva-col principal">
                <div class="reserva-card">
                    <h2 class="card-title"><i class="fas fa-hotel"></i> Detalles del Alojamiento</h2>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Hotel:</span>
                            <span class="detail-value"><?= htmlspecialchars($hotelNombre) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Habitación:</span>
                            <span class="detail-value"><?= htmlspecialchars($habitacionDetalle) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fechas:</span>
                            <span class="detail-value"><?= $checkinFormatted ?> - <?= $checkoutFormatted ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Huéspedes:</span>
                            <span class="detail-value"><?= htmlspecialchars($guests) ?> personas</span>
                        </div>
                    </div>
                </div>

                <div class="reserva-card">
                    <h2 class="card-title"><i class="fas fa-receipt"></i> Resumen de Pago</h2>
                    <div class="payment-summary">
                        <div class="payment-item total">
                            <span>Total Pagado:</span>
                            <span class="price">$<?= $precioTotalFormateado ?></span>
                        </div>
                        <div class="payment-item method">
                            <span>Método de Pago:</span>
                            <span class="method-detail">
                                <i class="fas fa-credit-card"></i>
                                <?= htmlspecialchars($metodoPago) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha - Servicios Adicionales -->
            <div class="reserva-col secundaria">
                <?php if (!empty($detallesActividades)) : ?>
                <div class="reserva-card">
                    <h2 class="card-title"><i class="fas fa-ticket-alt"></i> Actividades Incluidas</h2>
                    <div class="services-list">
                        <?php foreach ($detallesActividades as $actividad) : ?>
                        <div class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="service-detail">
                                <h3><?= htmlspecialchars($actividad['nombre']) ?></h3>
                                <div class="service-price">$<?= number_format(floatval($actividad['precio']), 2) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($detallesServicios)) : ?>
                <div class="reserva-card">
                    <h2 class="card-title"><i class="fas fa-concierge-bell"></i> Servicios Adicionales</h2>
                    <div class="services-list">
                        <?php foreach ($detallesServicios as $servicio) : ?>
                        <div class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-spa"></i>
                            </div>
                            <div class="service-detail">
                                <h3><?= htmlspecialchars($servicio['nombre']) ?></h3>
                                <div class="service-price">$<?= number_format(floatval($servicio['precio']), 2) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer de la Reserva -->
        <div class="reserva-footer">
            <div class="footer-action">
                <a href="../vista/index.php" class="btn-lujo">
                    <i class="fas fa-home"></i> Volver al Inicio
                </a>
            </div>
            <div class="footer-info">
                <p>¿Necesitas ayuda? <a href="mailto:soporte@hotelcaliope.com">soporte@hotelcaliope.com</a></p>
          
            </div>
        </div>
    </div>
</body>
</html>