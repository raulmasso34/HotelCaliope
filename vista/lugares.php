<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Definir la ruta base del proyecto
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));   

include '../config/Database.php';
require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/hotel/hotelController.php';

// Conectar a la base de datos
$database = new Database();
$db = $database->getConnection();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/Clientes/login.php');
    exit;
}

// Crear instancia del controlador
$reservaController = new ReservaController();
$hotelController = new HotelController();
// Resetear sesión si el usuario regresa al formulario
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reset']) && $_GET['reset'] == 'true') {
    unset($_SESSION['location'], $_SESSION['checkin'], $_SESSION['checkout'], $_SESSION['guests'], $_SESSION['habitacionId']);
}

// Guardar datos en sesión al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['checkin'] = $_POST['checkin'];
    $_SESSION['checkout'] = $_POST['checkout'];
    $_SESSION['guests'] = $_POST['numero_personas'];
    $_SESSION['habitacionId'] = $_POST['habitacionId'];

    header('Location: ../vista/lugares.php');
    exit();
}

// Obtener lista de países desde el controlador
$paises = $reservaController->obtenerPaises();

// Validar si hay una ubicación seleccionada
$location = $_SESSION['location'] ?? null;
if (!$location) {
    echo "No se ha seleccionado una ubicación.";
    exit;
}

// Obtener los hoteles disponibles en la ubicación seleccionada

$hoteles = $hotelController->obtenerHotelesPorPais($location);

$currentStep = 1; // Paso actual en el proceso de reserva
$pageTitle = "Selecciona tu Hotel";

// Incluir el header común usando la ruta absoluta
include BASE_PATH . '/vista/common-header.php';


$database->closeConnection();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../static/css/GENERAL/footer.css">
    <link rel="stylesheet" href="../static/css/GENERAL/header.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles de Lujo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../static/css/lugares.css">
    
    <!-- Ícono -->
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <div class="container my-5">
        <h1 class="text-center text-uppercase fw-bold mb-5" style="color: #2C3E50; font-size: 2.8rem;">Nuestros Hoteles</h1>

        <div class="row">
            <?php if (count($hoteles) > 0): ?>
                <?php foreach ($hoteles as $hotel): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="reservaHab.php?hotelId=<?php echo $hotel['Id_Hotel']; ?>" class="text-decoration-none">
                            <div class="card hotel-card shadow-sm">
                                <div class="hotel-image">
                                <?php
                                    $ciudad = strtolower(str_replace(' ', '_', $hotel['Ciudad'])); // Convierte el nombre a formato carpeta

                                    // Construye la ruta de la imagen según la ciudad
                                    $imagenPath = "../static/img/{$ciudad}/{$ciudad}.jpg";

                                    // Si la imagen específica no existe, intenta una imagen por defecto para la ciudad
                                    if (!file_exists($imagenPath)) {
                                        $imagenPath = "../static/img/Galicia/galicia1.jpg"; // Imagen general de la ciudad
                                    }

                                    // Si tampoco existe, usa una imagen de respaldo genérica
                                    if (!file_exists($imagenPath)) {
                                        $imagenPath = "../static/img/habitaciones/hab1.jpg"; // Imagen de respaldo
                                    }
                                    ?>
                                    <img src="<?php echo $imagenPath; ?>" alt="<?php echo htmlspecialchars($hotel['Ciudad']); ?>" class="card-img-top">

                                </div>
                                <div class="card-body text-center">
                                    <h2 class="card-title" style="color: #B8860B; font-size: 1.8rem;"><?php echo htmlspecialchars($hotel['Nombre']); ?></h2>
                                    <p class="card-text"><strong>Ubicación:</strong> <?php echo htmlspecialchars($hotel['Ciudad']); ?></p>
                                    <p class="card-text"><strong>Categoría:</strong> <?php echo htmlspecialchars($hotel['Estrellas']); ?> Estrellas</p>
                                    <p class="card-text">Un refugio de lujo en <?php echo htmlspecialchars($hotel['Ciudad']); ?>, diseñado para una experiencia inigualable.</p>
                                    <button class="btn btn-dark w-100">Ver detalles</button>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No se encontraron hoteles disponibles en la ubicación seleccionada.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
