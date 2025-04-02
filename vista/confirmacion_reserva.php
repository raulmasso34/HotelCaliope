<?php


// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
session_start();

var_dump($reservaSession);
var_dump($_POST);
var_dump($_SESSION['Reservas']);
var_dump($_SESSION['user_id']);
// Incluir controladores correctos
require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/hotel/hotelController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';
require_once __DIR__ . '/../controller/metodoPago/metodoPagoController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php';
require_once __DIR__ . '/../controller/pais/paisController.php';

// Crear instancias de los controladores
$reservaController = new ReservaController();
$hotelController = new HotelController();
$habitacionController = new HabitacionController();
$metodoPagoController = new MetodoPagoController();
$actividadController = new ActividadController();
$paisController = new PaisController();

// Obtener ID de usuario de la sesión
$user_id = $_SESSION['user_id'] ?? null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $habitacionId = $_POST['habitacionId'] ?? null;
    $clienteId = $user_id; 
    $hotelId = $_POST['hotelId'] ?? null;
    $checkin = $_POST['checkin'] ?? null;
    $checkout = $_POST['checkout'] ?? null;
    $guests = $_POST['guests'] ?? null;
    $paisId = $_POST['paisId'] ?? null;   

    // Obtener detalles del hotel desde HotelController
    $hotelDetails = $hotelController->obtenerDetallesHotel($hotelId);
    
    // Obtener detalles de la habitación desde HabitacionController
    $habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);

    // Obtener actividades del hotel desde HotelController
    $actividades = $actividadController->obtenerActividadesPorHotel($hotelId);

    // Obtener métodos de pago desde ReservaController
    $metodosPago = $metodoPagoController->obtenerMetodosPago();

    // Obtener el nombre del país desde HotelController
    $paisNombre = $paisController->obtenerNombrePais($paisId);
    $_SESSION['Reservas'] = [
    'habitacionId' => $habitacionId,
    'clienteId' => $clienteId,
    'hotelId' => $hotelId,
    'checkin' => $checkin,
    'checkout' => $checkout,
    'guests' => $guests,
    'paisId' => $paisId,
    'metodoPagoId' => $_POST['metodoPagoId'] ?? null, // ✅ Usar solo metodoPagoId
    'Precio' => $habitacionDetails['Precio'] ?? 0 // ✅ Agregar el precio de la habitación
];

    
}


// Cerrar conexión
$database->closeConnection();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <link rel="stylesheet" href="../static/css/detalles.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/confirmacion_reserva.css">
    
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Confirmar Reserva</h1>
        <p><strong>Ubicación seleccionada:</strong> <?php echo htmlspecialchars($paisNombre) ?: 'País no disponible'; ?></p>
        <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
        <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
        <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($guests); ?></p>

        <h2 class="mt-4">Detalles del Hotel</h2>
        <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>
        <p><strong>Habitación seleccionada:</strong> <?php echo htmlspecialchars($habitacionDetails['Tipo']); ?></p>
        <p><strong>Precio por noche:</strong> <span id="precioPorNoche"><?php echo htmlspecialchars($habitacionDetails['Precio']); ?></span> €</p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacionDetails['Descripcion'] ?? 'Descripción no disponible'); ?></p>

        <h3 class="mt-3">Precio Total: <span id="precioTotal">Calculando...</span> €</h3>

        <form action="../vista/servicios.php" method="POST">
            <input type="hidden" name="habitacionId" value="<?php echo $habitacionId; ?>">
            <input type="hidden" name="clienteId" value="<?php echo $clienteId; ?>">
            <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
            <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
            <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
            <input type="hidden" name="guests" value="<?php echo $guests; ?>">
            <input type="hidden" name="paisId" value="<?php echo $paisId; ?>">
            <input type="hidden" name="Precio" value="<?php echo $habitacionDetails; ?>">
    
            <div class="mb-3">
                <label for="metodoPagoId" class="form-label">Selecciona un método de pago:</label>
                <select class="form-select" name="metodoPagoId" id="metodoPagoId" required>
                    <?php if (!empty($metodosPago)): ?>
                        <?php foreach ($metodosPago as $metodo): ?>
                            <option value="<?php echo $metodo['Id_MetodoPago']; ?>">
                                <?php echo htmlspecialchars($metodo['Tipo']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay métodos de pago disponibles</option>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Continuar a Selección de Servicios</button>
        </form>


    </div>

    <script src="../static/js/confirmacion_reservas.js">
       
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
