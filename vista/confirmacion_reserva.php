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
    <link rel="stylesheet" href="./../static/css/confirmacion_reserva.css">
</head>
<body>
    <h1>Confirmar Reserva</h1>

    <p><strong>Ubicación seleccionada:</strong> 
    <?php 
    if ($paisNombre) {
        echo htmlspecialchars($paisNombre);  // Muestra el nombre del país
    } else {
        echo "País no disponible";  // En caso de que no se encuentre el país
    }
    ?>
    </p>
    <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
    <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
    <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($guests); ?></p>

    <h2>Detalles del Hotel: <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></h2>
    <p><strong>Habitación seleccionada:</strong> <?php echo htmlspecialchars($habitacionDetails['Tipo']); ?></p>
    <p><strong>Precio:</strong> <?php echo htmlspecialchars($habitacionDetails['Precio']); ?> €</p>
    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacionDetails['Descripcion'] ?? 'Descripción no disponible'); ?></p>

    <!-- Formulario de pago -->
    <form action="../vista/pagos.php" method="POST">
        <!-- Detalles de la reserva -->
        <input type="hidden" name="habitacionId" value="<?php echo $habitacionId; ?>">
        <input type="hidden" name="clienteId" value="<?php echo $clienteId; ?>">
        <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
        <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
        <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
        <input type="hidden" name="guests" value="<?php echo $guests; ?>">
        <input type="hidden" name="paisId" value="<?php echo $paisId; ?>">

        <!-- Selección de actividad (opcional) -->
        <label for="actividadId">Selecciona una actividad (opcional):</label>
        <select name="actividadId" id="actividadId">
            <option value="">Ninguna actividad</option>
            <?php 
            if (!empty($actividades)):
                foreach ($actividades as $actividad):
            ?>
                <option value="<?php echo $actividad['Id_Actividades']; ?>">
                    <?php echo htmlspecialchars($actividad['Nombre'] ?: 'Sin nombre disponible'); ?>
                </option>
            <?php 
                endforeach;
            endif;
            ?>
        </select>

        <!-- Selección del método de pago desde la base de datos -->
        <label for="metodo_pago">Selecciona un método de pago:</label>
        <select name="metodo_pago" id="metodo_pago" required>
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

        <button type="submit">Confirmar Reserva y Pagar</button>
    </form>
</body>
</html>
