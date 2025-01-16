<?php
session_start();  // Asegúrate de que la sesión esté iniciada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si hay datos de reserva en la sesión
if (isset($_SESSION['location'], $_SESSION['checkin'], $_SESSION['checkout'], $_SESSION['guests'], $_SESSION['habitacionId'])) {
    // Mostrar los detalles de la reserva
    echo "Ubicación seleccionada: " . $_SESSION['location'] . "<br>";
    echo "Fecha de Check-in: " . $_SESSION['checkin'] . "<br>";
    echo "Fecha de Check-out: " . $_SESSION['checkout'] . "<br>";
    echo "Número de personas: " . $_SESSION['guests'] . "<br>";
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/Clientes/login.php');
    exit;
}

// Obtener el ID del hotel desde la URL
if (isset($_GET['hotelId'])) {
    $hotelId = $_GET['hotelId'];
} else {
    header('Location: reservas.php');
    exit;
}

if (!isset($_SESSION['checkin']) || !isset($_SESSION['checkout']) || !isset($_SESSION['guests'])) {
    // Redirigir si no se han enviado los datos necesarios
    header("Location: ../vista/index.php");
    exit();
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

// Obtener las habitaciones del hotel
$queryHabitaciones = $db->prepare("SELECT * FROM Habitaciones WHERE Id_Hotel = ?");
$queryHabitaciones->bind_param("i", $hotelId);
$queryHabitaciones->execute();
$habitaciones = $queryHabitaciones->get_result()->fetch_all(MYSQLI_ASSOC);

// Cerrar la conexión después de usarla
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Hotel</title>
    <link rel="stylesheet" href="../static/css/detalles.css"> <!-- Ajusta la ruta del archivo CSS -->
</head>
<body>
    <h1>Detalles de la Reserva</h1>
    <!-- Detalles de la reserva -->
    <p><strong>Ubicación seleccionada:</strong> <?php echo htmlspecialchars($_SESSION['location']); ?></p>
    <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($_SESSION['checkin']); ?></p>
    <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($_SESSION['checkout']); ?></p>
    <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($_SESSION['guests']); ?></p>

    <h2>Habitaciones Disponibles en el Hotel</h2>
    <div class="habitaciones">
        <?php if (count($habitaciones) > 0): ?>
            <?php foreach ($habitaciones as $habitacion): ?>
                <div class="habitacion">
                    <div class="habitacion-imagen">
                        <?php
                        $imagenPath = "../static/img/habitaciones/" . strtolower(str_replace(' ', '_', $habitacion['Tipo'])) . ".jpg";
                        if (!file_exists($imagenPath)) {
                            $imagenPath = "../static/img/habitaciones/hab2.jpg";  // Imagen por defecto si no se encuentra
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
