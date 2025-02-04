<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();  // Obtener la conexión

// Limpiar las variables de sesión si el usuario ha vuelto al formulario
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reset']) && $_GET['reset'] == 'true') {
    unset($_SESSION['location']);
    unset($_SESSION['checkin']);
    unset($_SESSION['checkout']);
    unset($_SESSION['guests']);
    unset($_SESSION['habitacionId']);
}

// Al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar los datos del formulario en la sesión
    $_SESSION['location'] = $_POST['location'];  // Guardar el valor de la ubicación seleccionada
    $_SESSION['checkin'] = $_POST['checkin'];
    $_SESSION['checkout'] = $_POST['checkout'];
    $_SESSION['guests'] = $_POST['numero_personas'];  // Guardamos el valor de 'numero_personas' en la sesión
    $_SESSION['habitacionId'] = $_POST['habitacionId'];

    // Redirigir a la página de reservas para mostrar los detalles del hotel
    header('Location: ../vista/reservas.php');
    exit();
}

// Incluir el controlador
require_once __DIR__ . '/../controller/reserva/reservaController.php';

// Crear una instancia del controlador
$reservaController = new ReservaController();

$paises = $reservaController->obtenerPaises();


// Obtener la ubicación seleccionada de la sesión
$location = $_SESSION['location'] ?? null;  // Se obtiene la ubicación de la sesión

// Validar que haya una ubicación seleccionada
if (!$location) {
    echo "No se ha seleccionado una ubicación.";
    exit;
}

// Obtener los hoteles disponibles para la ubicación seleccionada
$hoteles = $reservaController->obtenerHotelesPorPais($location);
// Obtener la ubicación seleccionada de la sesión
$location = $_SESSION['location'] ?? null;  // Se obtiene la ubicación de la sesión

// Validar que haya una ubicación seleccionada
if (!$location) {
    echo "No se ha seleccionado una ubicación.";
    exit;
}

$database->closeConnection();

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles Disponibles</title>
    <link rel="stylesheet" href="../static/css/reserva.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1>Hoteles Disponibles</h1>
        <div class="hotels">
            <!-- Verificar si hay hoteles disponibles antes de mostrar el contenido -->
            <?php if (count($hoteles) > 0): ?>
                <?php foreach ($hoteles as $hotel): ?>
                    <a href="detalles.php?hotelId=<?php echo $hotel['Id_Hotel']; ?>" class="hotel">
                        <div class="hotel">
                            <div class="hotel-image">
                                <?php
                                $ciudad = strtolower(str_replace(' ', '_', $hotel['Ciudad']));
                                $imagenPath = "../static/img/{$ciudad}/{$ciudad}.jpg";
                                if (!file_exists($imagenPath)) {
                                    $imagenPath = "../static/img/habitaciones/hab1.jpg";
                                }
                                ?>
                                <img src="<?php echo $imagenPath; ?>" alt="<?php echo $hotel['Ciudad']; ?>" />
                            </div>

                            <div class="hotel-info">
                                <h2><?php echo htmlspecialchars($hotel['Nombre']); ?></h2>
                                <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($hotel['Ciudad']); ?></p>
                                <p><strong>Estrellas:</strong> <?php echo htmlspecialchars($hotel['Estrellas']); ?> estrellas</p>
                                <p><strong>Descripción:</strong> Este es el hotel <?php echo htmlspecialchars($hotel['Nombre']); ?>, ubicado en <?php echo htmlspecialchars($hotel['Ciudad']); ?>.</p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron hoteles disponibles en la ubicación seleccionada.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
