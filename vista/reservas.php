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
    <title>Hoteles de Lujo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../static/css/reserva.css">
    
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
                        <a href="detalles.php?hotelId=<?php echo $hotel['Id_Hotel']; ?>" class="text-decoration-none">
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
