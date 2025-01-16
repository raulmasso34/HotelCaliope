<?php
// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
session_start();

// Verificar si hay un usuario autenticado y obtener el ID de usuario
$user_id = $_SESSION['user_id'] ?? null; // Asegúrate de que el ID del usuario esté en la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos del formulario
    $habitacionId = $_POST['habitacionId'] ?? null;
    $clienteId = $user_id; // ID del usuario desde la sesión
    $hotelId = $_POST['hotelId'] ?? null;
    $checkin = $_POST['checkin'] ?? null;
    $checkout = $_POST['checkout'] ?? null;
    $guests = $_POST['guests'] ?? null;
    $paisId = $_POST['paisId'] ?? null;
    $actividadId = $_POST['actividadId'] ?? null;
    $metodoPagoId = $_POST['metodo_pago'] ?? null;

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
    echo "<pre>";
    print_r($_SESSION['Reservas']);
    echo "</pre>";
}

// Obtener los métodos de pago disponibles
$queryMetodosPago = $db->prepare("SELECT * FROM MetodoPago WHERE Activo = 1");
$queryMetodosPago->execute();
$metodosPago = $queryMetodosPago->get_result()->fetch_all(MYSQLI_ASSOC);

// Obtener los detalles del hotel
$queryHotel = $db->prepare("SELECT * FROM Hotel WHERE Id_Hotel = ?");
$queryHotel->bind_param("i", $_POST['hotelId']);
$queryHotel->execute();
$hotelDetails = $queryHotel->get_result()->fetch_assoc();

// Obtener los detalles de la habitación seleccionada
$queryHabitacion = $db->prepare("SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?");
$queryHabitacion->bind_param("i", $_POST['habitacionId']);
$queryHabitacion->execute();
$habitacionDetails = $queryHabitacion->get_result()->fetch_assoc();

// Obtener las actividades disponibles en el hotel
$queryActividades = $db->prepare("SELECT * FROM Actividades WHERE Id_Hotel = ?");
$queryActividades->bind_param("i", $_POST['hotelId']);
$queryActividades->execute();
$actividades = $queryActividades->get_result()->fetch_all(MYSQLI_ASSOC);

// Cerrar la conexión a la base de datos
$database->closeConnection();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <link rel="stylesheet" href="./../static/css/confirmacion_reserva.css">
</head>
<body>
    <h1>Confirmar Reserva</h1>

    <p><strong>Ubicación seleccionada:</strong> <?php echo htmlspecialchars($paisId); ?></p>
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
            <?php
            if (!empty($metodosPago)):
                foreach ($metodosPago as $metodo):
            ?>
                <option value="<?php echo $metodo['Id_MetodoPago']; ?>">
                    <?php echo htmlspecialchars($metodo['Tipo']); ?>
                </option>
            <?php
                endforeach;
            else:
            ?>
                <option value="">No hay métodos de pago disponibles</option>
            <?php endif; ?>
        </select>

        <button type="submit">Confirmar Reserva y Pagar</button>
    </form>
</body>
</html>
