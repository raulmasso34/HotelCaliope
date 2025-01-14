<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/Clientes/login.php');
    exit;
}

$location = $_POST['location'];  // Obtener el valor de la ubicación

// Verificar que se haya recibido un valor para la ubicación
if (!isset($location)) {
    echo "No se ha seleccionado una ubicación.";
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
include '../config/Database.php';

$database = new Database();
$db = $database->getConnection();  // Obtener la conexión

// Obtener hoteles del país seleccionado
$query = $db->prepare("SELECT * FROM Hotel WHERE Id_Pais = ?");
$query->bind_param("i", $location);  // Usar bind_param para valores seguros
$query->execute();
$result = $query->get_result();

// Verificar si se encontraron hoteles
if ($result->num_rows > 0) {
    $hoteles = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No se encontraron hoteles disponibles en la ubicación seleccionada.";
    exit;
}

// Cerrar la conexión después de usarla
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoteles Disponibles</title>
    <link rel="stylesheet" href="../static/css/reserva.css">
</head>
<body>
    <div class="container">
        <h1>Hoteles Disponibles</h1>
        <div class="hotels">
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
        </div>
    </div>
</body>
</html>
