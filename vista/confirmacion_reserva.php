<?php
// Conexión a la base de datos
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();

// Obtener los métodos de pago desde la base de datos
$queryMetodosPago = $db->prepare("SELECT * FROM MetodoPago WHERE Activo = 1");
$queryMetodosPago->execute();
$metodosPago = $queryMetodosPago->get_result()->fetch_all(MYSQLI_ASSOC);

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
            // Mostrar los métodos de pago obtenidos de la base de datos
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
