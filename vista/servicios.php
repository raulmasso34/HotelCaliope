<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/servicios/serviciosController.php';  // Nombre correcto del controlador

$servicioController = new ServiciosController();

// Verifica si ya tienes el hotelId en la sesión
if (isset($_POST['hotelId'])) {
    $_SESSION['hotelId'] = $_POST['hotelId']; // Guardamos el hotelId en la sesión
}

$hotelId = $_SESSION['hotelId'] ?? null;

// Si el hotelId no está definido, muestra un mensaje de error y termina la ejecución
if (!$hotelId) {
    echo "<p style='color:red;'>No se ha seleccionado un hotel.</p>";
    exit;
}

// Obtener los servicios del hotel, asegurando que sea un array válido
$servicios = $servicioController->obtenerServicios($hotelId);
if (!is_array($servicios)) {
    $servicios = [];  // Evita errores si la consulta falla
}

// Si el usuario envía el formulario con los servicios seleccionados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['servicios'])) {
    $_SESSION['Reservas']['servicios'] = $_POST['servicios']; // Guardamos los servicios en la sesión
    header("Location: pagos.php"); // Redirige a la página de pago
    exit;
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/servicios.css">
    <script src="../static/js/servicios/servicios.js"></script>
    <title>Servicios</title>
</head>
<body>

    <h1>¿Quieres alguno de estos servicios?</h1>
    <div class="servicios-container">
        <?php if (!empty($servicios)) : ?>
            <form action="" method="POST">
                <div class="servicios-lista">
                    <?php foreach ($servicios as $servicio) : ?>
                        <?php 
                        $imagen = '../static/img/servicios/' . strtolower(str_replace(' ', '_', $servicio['Servicio'])) . '.jpg'; 
                        $imagen_path = file_exists($imagen) ? $imagen : '../static/img/servicios/default.jpg';
                        ?>
                        <div class="servicio">
                            <img class="imagen-servicio" src="<?php echo $imagen_path; ?>" alt="<?php echo htmlspecialchars($servicio['Servicio']); ?>">
                            <h3><?php echo htmlspecialchars($servicio['Servicio']); ?></h3>
                            <p><?php echo htmlspecialchars($servicio['Descripcion']); ?></p>
                            <p>Precio: <?php echo number_format($servicio['Precio'], 2); ?>€</p>
                            <label>
                            <input type="checkbox" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo htmlspecialchars($servicio['Precio'] ?? 10); ?>">


                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="continuar-btn">
                    <input id="btn-continuar" type="submit" value="Continuar con servicio">
                </div>
            </form>
        <?php else : ?>
            <p>No hay servicios disponibles en este momento.</p>
        <?php endif; ?>
    </div>
            
</body>
</html>

