<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';

$reservaController = new ReservaController();

// Verifica si ya tienes el hotelId en la sesión
if (isset($_POST['hotelId'])) {
    $_SESSION['hotelId'] = $_POST['hotelId']; // Guardamos el hotelId en la sesión cuando se selecciona
}

$hotelId = $_SESSION['hotelId'] ?? null; // Recuperamos el hotelId de la sesión

// Si el hotelId no está definido, muestra un mensaje de error
if ($hotelId === null) {
    echo "No se ha seleccionado un hotel.";
    exit; // Termina la ejecución si no se ha seleccionado un hotel
}

// Obtener los servicios desde el controlador
$servicios = $reservaController->mostrarServicios();

// Verifica si se ha enviado el formulario para seleccionar servicios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['servicios'])) {
    // Recuperar los servicios seleccionados del formulario
    $serviciosSeleccionados = $_POST['servicios'];

    // Guardamos los servicios seleccionados en la sesión
    $_SESSION['Reservas']['servicios'] = $serviciosSeleccionados;
    
    // (Opcional) Guardamos el precio total de los servicios seleccionados en la sesión
    $totalServicios = array_sum($serviciosSeleccionados); // Sumar el precio de todos los servicios seleccionados
    $_SESSION['Reservas']['totalServicios'] = $totalServicios;

    // Redirigir a la página de pagos
    header("Location: pagos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/servicios.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Servicios</title>
</head>
<body>

    <h1>¿Quieres alguno de estos servicios?</h1>
    <div class="servicios-container">
        <?php if (!empty($servicios)) : ?>
            <!-- Mostrar los servicios -->
            <form action="" method="POST"> <!-- Enviamos el formulario con los servicios seleccionados -->
                <div class="servicios-lista">
                    <?php foreach ($servicios as $servicio) : ?>
                        <?php 
                        // Definir la ruta de la imagen según el nombre del servicio
                        $imagen = '../static/img/servicios/' . strtolower(str_replace(' ', '_', $servicio['Servicio'])) . '.jpg'; 
                        // Comprobar si la imagen existe
                        $imagen_path = file_exists($imagen) ? $imagen : 'images/default.jpg'; // Imagen por defecto si no se encuentra la específica
                        ?>
                        <div class="servicio" id="servicio-<?php echo $servicio['Id_Servicio']; ?>">
                            <img src="<?php echo $imagen_path; ?>" alt="Imagen de <?php echo $servicio['Servicio']; ?>" class="imagen-servicio">
                            <h3><?php echo $servicio['Servicio']; ?></h3>
                            <p><?php echo $servicio['Descripcion']; ?></p>
                            <p>Precio: <?php echo $servicio['Precio']; ?>€</p>
                            <!-- Checkbox para seleccionar el servicio -->
                            <label>
                            <input type="checkbox" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo $servicio['Precio']; ?>">

                                Seleccionar
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Continuar a pagos -->
                <div class="continuar-btn">
                    <input type="submit" value="Continuar con servicio" id="btn-continuar">
                </div>
            </form>
        <?php else : ?>
            <p>No hay servicios disponibles en este momento.</p>
        <?php endif; ?>
    </div>

</body>
</html>
