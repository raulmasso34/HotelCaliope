<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '../../../config/Database.php';
require_once __DIR__ . '../../../controller/habitacion/habitacionController.php';
require_once __DIR__ . '/../../controller/hotel/hotelController.php';

$database = new Database();
$conn = $database->getConnection();

$hotel_id = $_GET['hotel_id'] ?? 0;

$controllerHotel = new HotelController($conn);
$hotel = $controllerHotel->obtenerHotelPorId($hotel_id);

$controllerHab = new HabitacionController();
$habitaciones = $controllerHab->obtenerHabitacionesPorHotel($hotel_id);

// Resto del código similar al original con modificaciones...
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Head similar al original -->
</head>
<body>

    <header class="main-header">
        <!-- Header modificado para mostrar datos del hotel -->
        <div class="center-up-down">
            <h1><?= htmlspecialchars($hotel['Nombre']) ?></h1>
            <div class="hotel-location">
                <i class="fas fa-map-marker-alt"></i>
                <?= htmlspecialchars($hotel['Ciudad']) ?>, <?= htmlspecialchars($hotel['pais']) ?>
            </div>
        </div>
    </header>

    <main id="rooms-container" class="rooms-container">
        <!-- Mismo código de listado de habitaciones que antes -->
    </main>

    <!-- Mismo modal y scripts -->
</body>
</html>