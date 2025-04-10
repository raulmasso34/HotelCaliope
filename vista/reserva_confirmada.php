<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$precioHabitacion = isset($habitacion['PrecioTota']) ? floatval($habitacion['Precio']) : 0;

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg p-4 text-center mx-auto" style="max-width: 600px;">
            <h1 class="text-success">¡Reserva Confirmada!</h1>
            <p class="lead">Gracias por tu pago. Tu reserva ha sido realizada con éxito.</p>

            <div class="mt-4 text-start">
                <h2 class="h5 border-bottom pb-2">Detalles de la Reserva</h2>
                <p><strong>Hotel:</strong> <?= htmlspecialchars($hotelNombre) ?></p>
                <p><strong>Habitación:</strong> <?= htmlspecialchars($habitacionDetalle) ?></p>
                <p><strong>Cliente:</strong> <?= $nombreCliente ?></p>
                <p><strong>Check-in:</strong> <?= $checkinFormatted ?></p>
                <p><strong>Check-out:</strong> <?= $checkoutFormatted ?></p>
                <p><strong>Invitados:</strong> <?= htmlspecialchars($guests) ?></p>
                <p><strong>Método de Pago:</strong> <?= htmlspecialchars($metodoPago) ?></p>
                <p><strong>Total Pagado:</strong> <span class="fw-bold">$<?= $precioTotalFormateado ?></span></p>

                <?php if (!empty($detallesActividades)) : ?>
                <h2 class="h5 border-bottom pb-2 mt-4">Actividades Reservadas</h2>
                    <ul>
                        <?php foreach ($detallesActividades as $actividad) : ?>
                            <li>Actividad: <?= htmlspecialchars($actividad['nombre']) ?> - Precio: $<?= number_format(floatval($actividad['precio']), 2) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No se seleccionaron actividades.</p>
                <?php endif; ?>

                <h2 class="h5 border-bottom pb-2 mt-3">Servicios Adicionales</h2>
                <?php if (!empty($detallesServicios)) : ?>
                    <ul>
                        <?php foreach ($detallesServicios as $servicio) : ?>
                            <li>Servicio: <?= htmlspecialchars($servicio['nombre']) ?> - Precio: $<?= number_format(floatval($servicio['precio']), 2) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p>No se seleccionaron servicios.</p>
                <?php endif; ?>
            </div>

            <a href="../vista/index.php" class="btn btn-primary mt-4">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
