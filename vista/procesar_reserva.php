<?php
session_start();  // Mantiene los detalles de la reserva
require_once '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
require_once __DIR__ . '/../controller/reserva/reservaController.php';
$controller = new ReservaController(); // Instanciamos el controlador correctamente

// Verificar que la reserva y el hotel estén definidos
if (!isset($_SESSION['reservaId'], $_SESSION['hotelId'])) {
    echo "<h1>Error</h1><p>No se encontró la información de la reserva.</p>";
    exit;
}

$reservaId = $_SESSION['reservaId'];
$hotelId = $_SESSION['hotelId'];

// Obtener detalles del hotel
$hotelDetails = $controller->obtenerDetallesHotel($hotelId);

// Obtener detalles de la habitación (si está disponible en la sesión)
$habitacionId = isset($_SESSION['habitacionId']) ? $_SESSION['habitacionId'] : null;
$habitacionDetails = $habitacionId ? $controller->obtenerDetallesHabitacion($habitacionId) : null;

// Obtener las actividades disponibles para el hotel
$actividades = $controller->obtenerActividadesPorHotel($hotelId);

// Obtener los métodos de pago disponibles
$metodosPago = $controller->obtenerMetodosPagoDisponibles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <link rel="stylesheet" href="../static/css/detalles.css">
</head>
<body>
    <h1>Confirmación de Reserva</h1>

    <!-- Sección de detalles de la reserva -->
    <h2>Detalles de la Reserva</h2>
    <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>
    <p><strong>Check-in:</strong> <?php echo htmlspecialchars($reserva['Checkin']); ?></p>
    <p><strong>Check-out:</strong> <?php echo htmlspecialchars($reserva['Checkout']); ?></p>
    <p><strong>Número de Personas:</strong> <?php echo htmlspecialchars($reserva['Numero_Personas']); ?></p>
    <p><strong>Precio Habitación:</strong> <?php echo htmlspecialchars($reserva['Precio_Habitacion']); ?> €</p>

    <!-- Sección para seleccionar actividades -->
    <h2>Seleccionar Actividades</h2>
    <form action="procesar_reserva.php" method="POST">
        <input type="hidden" name="reservaId" value="<?php echo $reservaId; ?>">

        <?php if (count($actividades) > 0): ?>
            <label for="actividad">Elija una actividad:</label>
            <select name="actividad">
                <option value="">-- Seleccione una actividad --</option>
                <?php foreach ($actividades as $actividad): ?>
                    <option value="<?php echo $actividad['Id_Actividades']; ?>">
                        <?php echo htmlspecialchars($actividad['Descripcion'] . " - " . $actividad['Precio'] . " €"); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <p>No hay actividades disponibles.</p>
        <?php endif; ?>

        <!-- Sección para seleccionar método de pago -->
        <h2>Método de Pago</h2>
        <?php if (count($metodosPago) > 0): ?>
            <label for="metodo_pago">Seleccione un método de pago:</label>
            <select name="metodo_pago">
                <?php foreach ($metodosPago as $metodo): ?>
                    <option value="<?php echo $metodo['Id_MetodoPago']; ?>">
                        <?php echo htmlspecialchars($metodo['Titular'] . " - " . $metodo['Num_Tarjeta']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <p>No hay métodos de pago registrados.</p>
        <?php endif; ?>

        <button type="submit">Confirmar Reserva</button>
    </form>

</body>
</html>
