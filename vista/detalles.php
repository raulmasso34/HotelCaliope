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
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../static/css/detalles.css">
    
    <!-- Ícono -->
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>

    <div class="container my-5">
        <div class="card p-4 shadow-lg detalles-container">
            <h1 class="text-center mb-4">Detalles de la Reserva</h1>
            <p><strong>Ubicación seleccionada:</strong> <?php echo htmlspecialchars($_SESSION['location']); ?></p>
            <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($checkinFormatted); ?></p>
            <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($checkoutFormatted); ?></p>
            <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($_SESSION['guests']); ?></p>
        </div>

        <h2 class="text-center mt-5">Habitaciones Disponibles</h2>
        <div class="row habitaciones-container">
            <?php if (!empty($habitaciones)): ?>
                <?php foreach ($habitaciones as $habitacion): ?>
                    <?php if ($habitacion['Estado'] === 'Disponible'): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card habitacion-card shadow-sm">
                            <div class="habitacion-imagen">
                                <?php
                                // Posibles imágenes de la habitación
                                $basePath = "../static/img/habitaciones/";
                                $tipoHabitacion = strtolower(str_replace(' ', '_', $habitacion['Tipo']));
                                
                                $imagenes = [
                                    "{$basePath}{$tipoHabitacion}.jpg",
                                    "{$basePath}{$tipoHabitacion}2.jpg", // Segunda imagen
                                    "{$basePath}hab2.jpg" // Imagen por defecto
                                ];

                                // Seleccionar la primera imagen existente
                                foreach ($imagenes as $img) {
                                    if (file_exists($img)) {
                                        $imagenPath = $img;
                                        break;
                                    }
                                }
                                ?>
                                <img src="<?php echo $imagenPath; ?>" alt="<?php echo htmlspecialchars($habitacion['Tipo']); ?>" class="card-img-top">
                            </div>

                                <div class="card-body">
                                    <h3 class="card-title"><?php echo htmlspecialchars($habitacion['Tipo']); ?></h3>
                                    <p><strong>Precio:</strong> <?php echo htmlspecialchars($habitacion['Precio']); ?> €</p>
                                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacion['Descripcion'] ?? 'Descripción no disponible'); ?></p>
                                    
                                    <!-- Botón para abrir el modal -->
                                    <button type="button" class="btn btn-info w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modal<?php echo $habitacion['Id_Habitaciones']; ?>">
                                        Ver más
                                    </button>

                                    <!-- Formulario de reserva -->
                                    <form action="../vista/confirmacion_reserva.php" method="POST">
                                        <input type="hidden" name="habitacionId" value="<?php echo $habitacion['Id_Habitaciones']; ?>">
                                        <input type="hidden" name="clienteId" value="<?php echo $_SESSION['user_id']; ?>">
                                        <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
                                        <input type="hidden" name="checkin" value="<?php echo $_SESSION['checkin']; ?>">
                                        <input type="hidden" name="checkout" value="<?php echo $_SESSION['checkout']; ?>">
                                        <input type="hidden" name="guests" value="<?php echo $_SESSION['guests']; ?>">
                                        <input type="hidden" name="paisId" value="<?php echo $_SESSION['location']; ?>">
                                        <button type="submit" class="btn btn-primary w-100 mt-2">Reservar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de información -->
                        <div class="modal fade" id="modal<?php echo $habitacion['Id_Habitaciones']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $habitacion['Id_Habitaciones']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel<?php echo $habitacion['Id_Habitaciones']; ?>"><?php echo htmlspecialchars($habitacion['Tipo']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="carousel<?php echo $habitacion['Id_Habitaciones']; ?>" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                $imagenes = [
                                                    "../static/img/habitaciones/" . strtolower(str_replace(' ', '_', $habitacion['Tipo'])) . "1.jpg",
                                                    "../static/img/habitaciones/" . strtolower(str_replace(' ', '_', $habitacion['Tipo'])) . "2.jpg",
                                                    "../static/img/habitaciones/" . strtolower(str_replace(' ', '_', $habitacion['Tipo'])) . "3.jpg"
                                                ];
                                                $primeraImagen = true;
                                                foreach ($imagenes as $imagen):
                                                    if (!file_exists($imagen)) continue;
                                                ?>
                                                    <div class="carousel-item <?php echo $primeraImagen ? 'active' : ''; ?>">
                                                        <img src="<?php echo $imagen; ?>" class="d-block w-100 modal-imagen" alt="Imagen de la habitación">
                                                    </div>
                                                <?php 
                                                $primeraImagen = false;
                                                endforeach; 
                                                ?>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $habitacion['Id_Habitaciones']; ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Anterior</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $habitacion['Id_Habitaciones']; ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Siguiente</span>
                                            </button>
                                        </div>

                                        <p class="mt-3"><strong>Descripción:</strong> <?php echo htmlspecialchars($habitacion['Descripcion']); ?></p>
                                        <p><strong>Capacidad:</strong> <?php echo htmlspecialchars($habitacion['Capacidad']); ?> personas</p>
                                        <p><strong>Servicios:</strong> 
                                            <?php echo isset($habitacion['Servicio']) && !is_null($habitacion['Servicio']) 
                                                ? htmlspecialchars($habitacion['Servicio']) 
                                                : "No especificado"; ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No hay habitaciones disponibles en este hotel.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="../static/js/detalles.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



