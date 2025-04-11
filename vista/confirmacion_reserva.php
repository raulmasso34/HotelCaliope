<?php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));  
// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
session_start();


if (isset($_POST['precioFinal'])) {
    $_SESSION['precioTotal'] = $_POST['precioFinal'];
}


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

    // Obtener multiplicador de temporada (usando el nombre correcto)
// Obtener multiplicador de temporada
// Obtener multiplicador de temporada
$temporada = $habitacionController->obtenerHabitacionesConPrecioPorTemporada($checkin, $checkout);

// Verificar si PrecioMultiplicador existe


// Obtener detalles de la habitación
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);

// Verificar si PrecioFinal existe en los detalles de la habitación
$precioFinal = $_SESSION['precioTotal'];


// Cálculo del precio final con el multiplicador de temporada
$precioBase = (float)$habitacionDetails['Precio']; // Asegúrate de convertir a float

// Calcular el precio total en base a las noches
$fechaCheckin = new DateTime($checkin);
$fechaCheckout = new DateTime($checkout);
$intervalo = $fechaCheckin->diff($fechaCheckout);
$noches = $intervalo->days;
$precioTotal = $precioFinal * $noches;

// Guardar los valores correctamente en la sesión
$_SESSION['Reservas'] = [
    'habitacionId' => $habitacionId,
    'clienteId' => $clienteId,
    'hotelId' => $hotelId,
    'checkin' => $checkin,
    'checkout' => $checkout,
    'guests' => $guests,
    'paisId' => $paisId,
    'metodoPagoId' => $_POST['metodoPagoId'] ?? null,
    'PrecioFinal' => $precioFinal, 
    'PrecioTotal' => $precioTotal
];


}


// Cerrar conexión
$database->closeConnection();

 // Verifica que contiene 'PrecioMultiplicador'

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
    <title>Confirmación de Reserva</title>
    <link rel="stylesheet" href="../static/css/detalles.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/confirmacion_reserva.css">
</head>
<body>
    <div class="reservation-container">
        <div class="reservation-header">
            <h1><i class="fas fa-concierge-bell me-2"></i>Confirmación de Reserva</h1>
            <p class="mb-0">Revise los detalles de su estancia</p>
        </div>
        
        <div class="reservation-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"><i class="fas fa-info-circle me-2"></i>Detalles de la Reserva</h2>
                    
                    <div class="detail-card">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Ubicación seleccionada:</strong> 
                                <p><?php echo htmlspecialchars($paisNombre) ?: 'País no disponible'; ?></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <i class="far fa-calendar-check"></i>
                            <div>
                                <strong>Fechas de estancia:</strong>
                                <p><?php echo htmlspecialchars($checkin); ?> al <?php echo htmlspecialchars($checkout); ?></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <i class="fas fa-user-friends"></i>
                            <div>
                                <strong>Huéspedes:</strong>
                                <p><?php echo htmlspecialchars($guests); ?> persona(s)</p>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="section-title"><i class="fas fa-hotel me-2"></i>Detalles del Alojamiento</h2>
                    
                    <div class="detail-card">
                        <div class="detail-item">
                            <i class="fas fa-hotel"></i>
                            <div>
                                <strong>Hotel:</strong>
                                <p><?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <i class="fas fa-bed"></i>
                            <div>
                                <strong>Habitación:</strong>
                                <p><?php echo htmlspecialchars($habitacionDetails['Tipo']); ?></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <i class="fas fa-tag"></i>
                            <div>
                                <strong>Precio por noche:</strong>
                                <p><span id="precioPorNoche"><?php echo htmlspecialchars($_SESSION['Reservas']['PrecioFinal']); ?></span> €</p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <i class="fas fa-align-left"></i>
                            <div>
                                <strong>Descripción:</strong>
                                <p><?php echo htmlspecialchars($habitacionDetails['Descripcion'] ?? 'Descripción no disponible'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="price-display">
                        <h3>Total de su estancia</h3>
                        <div class="total-price"><span id="precioTotal"><?php echo htmlspecialchars($_SESSION['Reservas']['PrecioTotal']); ?></span> €</div>
                        <p class="mb-0"><?php echo $noches; ?> noches</p>
                    </div>
                    
                    <form action="../vista/servicios.php" method="POST">
                        <input type="hidden" name="habitacionId" value="<?php echo $habitacionId; ?>">
                        <input type="hidden" name="clienteId" value="<?php echo $clienteId; ?>">
                        <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
                        <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
                        <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
                        <input type="hidden" name="guests" value="<?php echo $guests; ?>">
                        <input type="hidden" name="paisId" value="<?php echo $paisId; ?>">
                        <input type="hidden" name="PrecioFinal" value="<?php echo $precioFinal; ?>"> 
                        <input type="hidden" name="PrecioTotal" value="<?php echo $_SESSION['Reservas']['PrecioTotal']; ?>"> 

                        <div class="mb-4">
                            <label for="metodoPagoId" class="form-label">Método de Pago</label>
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

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-arrow-right me-2"></i>Continuar a Servicios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../static/js/confirmacion_reservas.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>