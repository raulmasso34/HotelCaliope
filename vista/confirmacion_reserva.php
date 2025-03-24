<?php
// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
session_start();

// Incluir controladores
require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/hotel/hotelController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';
require_once __DIR__ . '/../controller/metodoPago/metodoPagoController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php';
require_once __DIR__ . '/../controller/pais/paisController.php';

// Crear instancias de controladores
$reservaController = new ReservaController();
$hotelController = new HotelController();
$habitacionController = new HabitacionController();
$metodoPagoController = new MetodoPagoController();
$actividadController = new ActividadController();
$paisController = new PaisController();

// Obtener ID de usuario
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
    $metodoPagoId = $_POST['metodoPagoId'] ?? null;

    // Validar datos requeridos
    $camposRequeridos = ['habitacionId', 'hotelId', 'checkin', 'checkout', 'guests', 'paisId'];
    foreach ($camposRequeridos as $campo) {
        if (empty($_POST[$campo])) {
            die("Error: Campo requerido faltante: $campo");
        }
    }

    // Almacenar en sesión
    $_SESSION['Reservas'] = [
        'habitacionId' => $habitacionId,
        'clienteId' => $clienteId,
        'hotelId' => $hotelId,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'guests' => $guests,
        'paisId' => $paisId,
        'metodoPagoId' => $metodoPagoId
    ];

    // Redirigir para evitar reenvío de formulario
    header("Location: confirmacion_reserva.php");
    exit;
}

// Obtener datos de la sesión
if (!isset($_SESSION['Reservas'])) {
    die("Error: No se han recibido los datos de reserva.");
}

$reserva = $_SESSION['Reservas'];

// Obtener detalles necesarios
$hotelDetails = $hotelController->obtenerDetallesHotel($reserva['hotelId']);
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($reserva['habitacionId']);
$metodosPago = $metodoPagoController->obtenerMetodosPago();
$paisNombre = $paisController->obtenerNombrePais($reserva['paisId']);

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
        <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($reserva['checkin']); ?></p>
        <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($reserva['checkout']); ?></p>
        <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($reserva['guests']); ?></p>

        <h2 class="mt-4">Detalles del Hotel</h2>
        <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>
        <p><strong>Habitación seleccionada:</strong> <?php echo htmlspecialchars($habitacionDetails['Tipo']); ?></p>
        <p><strong>Precio por noche:</strong> <span id="precioPorNoche"><?php echo htmlspecialchars($habitacionDetails['Precio']); ?></span> €</p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacionDetails['Descripcion'] ?? 'Descripción no disponible'); ?></p>

        <h3 class="mt-3">Precio Total: <span id="precioTotal">Calculando...</span> €</h3>

        <form action="../vista/servicios.php" method="POST">
            <input type="hidden" name="habitacionId" value="<?php echo $reserva['habitacionId']; ?>">
            <input type="hidden" name="clienteId" value="<?php echo $reserva['clienteId']; ?>">
            <input type="hidden" name="hotelId" value="<?php echo $reserva['hotelId']; ?>">
            <input type="hidden" name="checkin" value="<?php echo $reserva['checkin']; ?>">
            <input type="hidden" name="checkout" value="<?php echo $reserva['checkout']; ?>">
            <input type="hidden" name="guests" value="<?php echo $reserva['guests']; ?>">
            <input type="hidden" name="paisId" value="<?php echo $reserva['paisId']; ?>">

            <div class="mb-3">
                <label for="metodoPagoId" class="form-label">Selecciona un método de pago:</label>
                <select class="form-select" name="metodoPagoId" id="metodoPagoId" required>
                    <?php if (!empty($metodosPago)): ?>
                        <?php foreach ($metodosPago as $metodo): ?>
                            <option value="<?php echo $metodo['Id_MetodoPago']; ?>" <?php echo ($metodo['Id_MetodoPago'] == $reserva['metodoPagoId']) ? 'selected' : ''; ?>>
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

    <script src="../static/js/confirmacion_reservas.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>