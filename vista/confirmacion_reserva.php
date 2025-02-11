<?php
// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
session_start();
require_once __DIR__ . '/../controller/reserva/reservaController.php';
$reservaController = new ReservaController();

// Usamos correctamente el objeto reservaController
$user_id = $_SESSION['user_id'] ?? null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos del formulario
    $habitacionId = $_POST['habitacionId'] ?? null;
    $clienteId = $user_id; // ID del usuario desde la sesión
    $hotelId = $_POST['hotelId'] ?? null;  // Asegurarse de que el hotelId se obtiene
    $checkin = $_POST['checkin'] ?? null;
    $checkout = $_POST['checkout'] ?? null;
    $guests = $_POST['guests'] ?? null;
    $paisId = $_POST['paisId'] ?? null;
    $actividadId = $_POST['actividadId'] ?? null;
    $metodoPagoId = $_POST['metodo_pago'] ?? null;

    // Llamamos al método obtenerDetallesHotel usando el hotelId
    $hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
    // Llamamos al método obtenerDetallesHabitacion usando el habitacionId
    $habitacionDetails = $reservaController->obtenerDetallesHabitacion($habitacionId);

    // Llamamos al método obtenerActividadesPorHotel solo después de que hotelId esté definido
    $actividades = $reservaController->obtenerActividadesPorHotel($hotelId);
    $metodosPago = $reservaController->obtenerMetodosPagoDisponibles();
    $paisNombre = $reservaController->obtenerNombrePais($paisId);

    // Guardar los datos de la reserva en la sesión
    $_SESSION['Reservas'] = [
        'habitacionId' => $habitacionId,
        'clienteId' => $clienteId,
        'hotelId' => $hotelId,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'guests' => $guests,
        'paisId' => $paisId,
        'actividadId' => $actividadId,
        'metodo_pago' => $metodoPagoId
    ];

    // Verificar si se han guardado correctamente los datos
   
}

// Cerrar la conexión a la base de datos
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
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

        <form action="../vista/pagos.php" method="POST">
            <input type="hidden" name="habitacionId" value="<?php echo $habitacionId; ?>">
            <input type="hidden" name="clienteId" value="<?php echo $clienteId; ?>">
            <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
            <input type="hidden" name="checkin" id="checkin" value="<?php echo $checkin; ?>">
            <input type="hidden" name="checkout" id="checkout" value="<?php echo $checkout; ?>">
            <input type="hidden" name="guests" value="<?php echo $guests; ?>">
            <input type="hidden" name="paisId" value="<?php echo $paisId; ?>">

            <div class="mb-3">
                <label for="actividadId" class="form-label">Selecciona una actividad (opcional):</label>
                <select class="form-select" name="actividadId" id="actividadId">
                    <option value="">Ninguna actividad</option>
                    <?php foreach ($actividades as $actividad): ?>
                        <option value="<?php echo $actividad['Id_Actividades']; ?>">
                            <?php echo htmlspecialchars($actividad['Nombre'] ?: 'Sin nombre disponible'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Selecciona un método de pago:</label>
                <select class="form-select" name="metodo_pago" id="metodo_pago" required>
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

            <button type="submit" class="btn btn-primary w-100">Confirmar Reserva y Pagar</button>
        </form>
    </div>

    <script src="../static/js/confirmacion_reservas.js">
       
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
