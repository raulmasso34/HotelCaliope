<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
$reservaController = new ReservaController();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/Clientes/login.php');
    exit;
}

if (!isset($_SESSION['location'], $_SESSION['checkin'], $_SESSION['checkout'], $_SESSION['guests'], $_GET['hotelId'])) {
    header("Location: ../vista/index.php");
    exit;
}

$hotelId = $_GET['hotelId'];

$hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
$habitaciones = $reservaController->obtenerHabitacionesPorHotel($hotelId);

if (!$hotelDetails) {
    echo "Detalles del hotel no disponibles.";
    exit;
}

// Convertir las fechas a formato legible
$checkinDate = new DateTime($_SESSION['checkin']);
$checkoutDate = new DateTime($_SESSION['checkout']);

$checkinFormatted = $checkinDate->format('d/m/Y');
$checkoutFormatted = $checkoutDate->format('d/m/Y');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Hotel</title>
    <link rel="stylesheet" href="../static/css/detalles.css">
</head>
<body>
    <h1>Detalles de la Reserva</h1>
    <p><strong>Ubicación seleccionada:</strong> <?php echo htmlspecialchars($_SESSION['location']); ?></p>
    <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($checkinFormatted); ?></p>
    <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($checkoutFormatted); ?></p>
    <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($_SESSION['guests']); ?></p>

    <h2>Habitaciones Disponibles en el Hotel</h2>
    <div class="habitaciones">
        <?php if (!empty($habitaciones)): ?>
            <?php foreach ($habitaciones as $habitacion): ?>
                <div class="habitacion">
                    <div class="habitacion-imagen">
                        <?php
                        $imagenPath = "../static/img/habitaciones/" . strtolower(str_replace(' ', '_', $habitacion['Tipo'])) . ".jpg";
                        if (!file_exists($imagenPath)) {
                            $imagenPath = "../static/img/habitaciones/hab2.jpg";
                        }
                        ?>
                        <img src="<?php echo $imagenPath; ?>" alt="<?php echo htmlspecialchars($habitacion['Tipo']); ?>" class="imagen-habitacion">
                    </div>
                    <div class="habitacion-info">
                        <h3><?php echo htmlspecialchars($habitacion['Tipo']); ?></h3>
                        <p><strong>Precio:</strong> <?php echo htmlspecialchars($habitacion['Precio']); ?> €</p>
                        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacion['Descripcion'] ?? 'Descripción no disponible'); ?></p>
                        <form action="../vista/confirmacion_reserva.php" method="POST">
                            <input type="hidden" name="habitacionId" value="<?php echo $habitacion['Id_Habitaciones']; ?>">
                            <input type="hidden" name="clienteId" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
                            <input type="hidden" name="checkin" value="<?php echo $_SESSION['checkin']; ?>">
                            <input type="hidden" name="checkout" value="<?php echo $_SESSION['checkout']; ?>">
                            <input type="hidden" name="guests" value="<?php echo $_SESSION['guests']; ?>">
                            <input type="hidden" name="paisId" value="<?php echo $_SESSION['location']; ?>">
                            <button type="submit">Reservar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay habitaciones disponibles en este hotel.</p>
        <?php endif; ?>
    </div>
</body>
</html>
