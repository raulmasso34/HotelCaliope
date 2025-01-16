<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar que los datos necesarios fueron enviados desde detalles.php
if (isset($_POST['habitacionId'], $_POST['clienteId'], $_POST['hotelId'], $_POST['checkin'], $_POST['checkout'], $_POST['guests'], $_POST['paisId'])) {
    // Obtener los detalles de la reserva
    $habitacionId = $_POST['habitacionId'];
    $clienteId = $_POST['clienteId'];
    $hotelId = $_POST['hotelId'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = $_POST['guests'];
    $paisId = $_POST['paisId'];

    // Mostrar los detalles de la reserva
    echo "<h1>Confirmar Reserva</h1>";
    echo "<p><strong>Ubicación seleccionada:</strong> " . htmlspecialchars($paisId) . "</p>";
    echo "<p><strong>Fecha de Check-in:</strong> " . htmlspecialchars($checkin) . "</p>";
    echo "<p><strong>Fecha de Check-out:</strong> " . htmlspecialchars($checkout) . "</p>";
    echo "<p><strong>Número de personas:</strong> " . htmlspecialchars($guests) . "</p>";
} else {
    echo "Faltan algunos datos necesarios. Por favor, vuelve a la página de detalles.";
    exit;
}

// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();

// Obtener detalles del hotel
$queryHotel = $db->prepare("SELECT * FROM Hotel WHERE Id_Hotel = ?");
$queryHotel->bind_param("i", $hotelId);
$queryHotel->execute();
$hotelDetails = $queryHotel->get_result()->fetch_assoc();

// Obtener detalles de la habitación seleccionada
$queryHabitacion = $db->prepare("SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?");
$queryHabitacion->bind_param("i", $habitacionId);
$queryHabitacion->execute();
$habitacionDetails = $queryHabitacion->get_result()->fetch_assoc();

// Obtener actividades disponibles
$queryActividades = $db->prepare("SELECT * FROM Actividades WHERE Id_Hotel = ?");
$queryActividades->bind_param("i", $hotelId);
$queryActividades->execute();
$actividades = $queryActividades->get_result()->fetch_all(MYSQLI_ASSOC);

// Cerrar la conexión
$database->closeConnection();

// Mostrar los detalles del hotel y la habitación seleccionada
echo "<h2>Detalles del Hotel: " . htmlspecialchars($hotelDetails['Nombre']) . "</h2>";
echo "<p><strong>Habitación seleccionada:</strong> " . htmlspecialchars($habitacionDetails['Tipo']) . "</p>";
echo "<p><strong>Precio:</strong> " . htmlspecialchars($habitacionDetails['Precio']) . " €</p>";
echo "<p><strong>Descripción:</strong> " . htmlspecialchars($habitacionDetails['Descripcion'] ?? 'Descripción no disponible') . "</p>";

// Mostrar la selección de actividad y el formulario para el pago
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./../static/css/confirmacion_reserva.css">
</head>
<body>
<form action="../controller/reserva/reservaController.php" method="POST">
    <!-- Detalles de la reserva -->
    <input type="hidden" name="habitacionId" value="<?php echo $habitacionId; ?>">
    <input type="hidden" name="clienteId" value="<?php echo $clienteId; ?>">
    <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
    <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
    <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
    <input type="hidden" name="guests" value="<?php echo $guests; ?>">
    <input type="hidden" name="paisId" value="<?php echo $paisId; ?>">

   <!-- Selección de actividad (opcional) -->
   <label for="actividad">Selecciona una actividad (opcional):</label>
    <select name="actividad" id="actividad">
        <option value="">Ninguna actividad</option> <!-- Opción sin actividad -->
        <?php 
        // Verificar si hay actividades disponibles
        if (!empty($actividades)): ?>
            <?php foreach ($actividades as $actividad): ?>
                <!-- Verificar si el campo 'Nombre' existe y no es nulo -->
                <option value="<?php echo htmlspecialchars($actividad['Id_Actividades']); ?>">
                    <?php echo htmlspecialchars($actividad['Nombre'] ?: 'Sin nombre disponible'); ?>
                </option>

            <?php endforeach; ?>
        <?php else: ?>
            <!-- Mostrar mensaje si no hay actividades disponibles -->
            <option value="">No hay actividades disponibles</option>
        <?php endif; ?>
    </select>
    <!-- Selección del método de pago -->
    <label for="metodo_pago">Selecciona un método de pago:</label>
    <select name="metodo_pago" id="metodo_pago" required>
        <option value="tarjeta">Tarjeta de Crédito</option>
        <option value="paypal">PayPal</option>
        <!-- Agregar más métodos de pago si es necesario -->
    </select>

    <button type="submit">Confirmar Reserva y Pagar</button>
</form>

</body>
</html>


