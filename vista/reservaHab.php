<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Definir la ruta base del proyecto
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));   




// Incluir controladores correctos
require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/hotel/hotelController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';
require_once __DIR__ . '/../controller/metodoPago/metodoPagoController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php';
require_once __DIR__ . '/../controller/pais/paisController.php';

// Crear instancias de los controladores



$metodoPagoController = new MetodoPagoController();
$actividadController = new ActividadController();
$paisController = new PaisController();

$hotelController = new HotelController();
$habitacionController = new HabitacionController();
<<<<<<< HEAD
=======



>>>>>>> 5acbb3e4d62e5b099a070000c18cdd382e1362bf
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

$hotelDetails = $hotelController->obtenerDetallesHotel($hotelId);
$habitacionesConPrecio = $habitacionController->obtenerHabitacionesConPrecioPorTemporada($_SESSION['checkin'], $_SESSION['checkout']);



// Filtrar solo las habitaciones del hotel actual
$habitaciones = array_filter($habitacionesConPrecio, function($hab) use ($hotelId) {
    return $hab['Id_Hotel'] == $hotelId;
});

if (!$hotelDetails) {
    echo "Detalles del hotel no disponibles.";
    exit;
}
$paisId = $_SESSION['location'] ?? null; 
$hotelDetails = $hotelController->obtenerDetallesHotel($hotelId);


$checkinDate = new DateTime($_SESSION['checkin']);
$checkoutDate = new DateTime($_SESSION['checkout']);
$paisNombre = $paisController->obtenerNombrePais($paisId);
$checkinFormatted = $checkinDate->format('d/m/Y');
$checkoutFormatted = $checkoutDate->format('d/m/Y');

$currentStep = 2; // Paso actual en el proceso de reserva
$pageTitle = "Selecciona tu Habitación";

// Incluir el header común usando la ruta absoluta
include BASE_PATH . '/vista/common-header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hotelDetails['Nombre'] ?? 'Hotel') ?> - Habitaciones</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../static/css/reservasHab.css">
    <!-- Ícono -->
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container-fluid hotel-reservation-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mt-4">
        <ol class="breadcrumb">
           
            <li class="breadcrumb-item active" aria-current="page">Habitaciones</li>
        </ol>
    </nav>

<<<<<<< HEAD
    <div class="row">
        <!-- Sidebar de detalles de reserva -->
        <div class="col-lg-3 mb-4">
            <div class="card p-4 reservation-sidebar">
                <h2 class="text-center mb-4">Detalles de su Reserva</h2>
                <div class="reservation-detail-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <h6>Ubicación</h6>
                        <p><?php echo htmlspecialchars($_SESSION['location']); ?></p>
                    </div>
                </div>
                <div class="reservation-detail-item">
                    <i class="bi bi-calendar-check"></i>
                    <div>
                        <h6>Check-in</h6>
                        <p><?php echo htmlspecialchars($checkinFormatted); ?></p>
                    </div>
                </div>
                <div class="reservation-detail-item">
                    <i class="bi bi-calendar-x"></i>
                    <div>
                        <h6>Check-out</h6>
                        <p><?php echo htmlspecialchars($checkoutFormatted); ?></p>
                    </div>
                </div>
                <div class="reservation-detail-item">
                    <i class="bi bi-people-fill"></i>
                    <div>
                        <h6>Huéspedes</h6>
                        <p><?php echo htmlspecialchars($_SESSION['guests']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Información del hotel -->
            <div class="card mt-4 hotel-info-sidebar">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($hotelDetails['Nombre'] ?? 'Hotel'); ?></h5>
                    <p class="card-text"><i class="bi bi-star-fill text-warning"></i> <?php echo htmlspecialchars($hotelDetails['Categoria'] ?? ''); ?> Estrellas</p>
                    <p class="card-text"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($hotelDetails['Direccion'] ?? ''); ?></p>
                    <p class="card-text"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($hotelDetails['Telefono'] ?? ''); ?></p>
                </div>
            </div>
=======
   
    <div class="container my-5">
        <div class="card p-4 shadow-lg detalles-container">
            <h1 class="text-center mb-4">Detalles de la Reserva</h1>
            <p><strong>Ubicación seleccionada:</strong> <?php echo htmlspecialchars($paisNombre) ?: 'País no disponible'; ?></p>
            <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>

            <p><strong>Fecha de Check-in:</strong> <?php echo htmlspecialchars($checkinFormatted); ?></p>
            <p><strong>Fecha de Check-out:</strong> <?php echo htmlspecialchars($checkoutFormatted); ?></p>
            <p><strong>Número de personas:</strong> <?php echo htmlspecialchars($_SESSION['guests']); ?></p>
>>>>>>> 5acbb3e4d62e5b099a070000c18cdd382e1362bf
        </div>

        <!-- Contenido principal -->
        <div class="col-lg-9">
            <!-- Encabezado del hotel -->
            <div class="hotel-header mb-5">
                <h1 class="hotel-title"><?php echo htmlspecialchars($hotelDetails['Nombre'] ?? 'Hotel'); ?></h1>
                <div class="hotel-rating">
                    <?php 
                    $stars = $hotelDetails['Categoria'] ?? 0;
                    for ($i = 0; $i < 5; $i++): 
                    ?>
                        <i class="bi bi-star-fill <?php echo $i < $stars ? 'text-warning' : 'text-secondary'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="hotel-location"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($hotelDetails['Direccion'] ?? ''); ?></p>
            </div>

            <!-- Habitaciones disponibles -->
            <h2 class="section-title">Habitaciones Disponibles</h2>
            
            <?php if (!empty($habitaciones)): ?>
                <div class="row habitaciones-container">
                    <?php foreach ($habitaciones as $habitacion): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card habitacion-card shadow-sm h-100">
                                <div class="habitacion-imagen">
                                    <?php
                                    $basePath = "../static/img/habitaciones/";
                                    $tipoHabitacion = strtolower(str_replace(' ', '_', $habitacion['Tipo']));
                                    
                                    $imagenes = [
                                        "{$basePath}{$tipoHabitacion}.jpg",
                                        "{$basePath}{$tipoHabitacion}2.jpg",
                                        "{$basePath}individual1.jpg"
                                    ];

                                    foreach ($imagenes as $img) {
                                        if (file_exists($img)) {
                                            $imagenPath = $img;
                                            break;
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo $imagenPath; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($habitacion['Tipo']); ?>">
                                    <div class="price-badge">
                                        <?php echo htmlspecialchars($habitacion['PrecioFinal']); ?> €
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title"><?php echo htmlspecialchars($habitacion['Tipo']); ?></h3>
                                    <div class="room-features mb-3">
                                        <span class="feature"><i class="bi bi-people"></i> <?php echo htmlspecialchars($habitacion['Capacidad']); ?> personas</span>
                                        <?php if (!empty($habitacion['Servicio'])): ?>
                                            <span class="feature"><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($habitacion['Servicio']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="card-text flex-grow-1"><?php echo htmlspecialchars($habitacion['Descripcion'] ?? 'Descripción no disponible'); ?></p>
                                    
                                    <div class="mt-auto">
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-details w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modal<?php echo $habitacion['Id_Habitaciones']; ?>">
                                            <i class="bi bi-eye"></i> Ver detalles
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
                                            <input type="hidden" name="precioFinal" value="<?php echo htmlspecialchars($habitacion['PrecioFinal']); ?>">

                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-bookmark-check"></i> Reservar ahora
                                            </button>
                                        </form>
                                    </div>
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
                                            <div class="carousel-inner rounded">
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

                                        <div class="row mt-4">
                                            <div class="col-md-8">
                                                <h6>Descripción</h6>
                                                <p><?php echo htmlspecialchars($habitacion['Descripcion']); ?></p>
                                                
                                                <h6 class="mt-3">Servicios incluidos</h6>
                                                <ul class="service-list">
                                                    <?php if (!empty($habitacion['Servicio'])): ?>
                                                        <li><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($habitacion['Servicio']); ?></li>
                                                    <?php endif; ?>
                                                    <li><i class="bi bi-check-circle"></i> Capacidad: <?php echo htmlspecialchars($habitacion['Capacidad']); ?> personas</li>
                                                    <li><i class="bi bi-check-circle"></i> Wifi gratuito</li>
                                                    <li><i class="bi bi-check-circle"></i> Aire acondicionado</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="price-summary">
                                                    <h6>Resumen de precios</h6>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Precio por noche:</span>
                                                        <span><?php echo htmlspecialchars($habitacion['PrecioFinal']); ?> €</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Noches:</span>
                                                        <span><?php echo $checkinDate->diff($checkoutDate)->days; ?></span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between fw-bold">
                                                        <span>Total:</span>
                                                        <span><?php echo htmlspecialchars($habitacion['PrecioFinal'] * $checkinDate->diff($checkoutDate)->days); ?> €</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="../vista/confirmacion_reserva.php" method="POST" class="w-100">
                                            <input type="hidden" name="habitacionId" value="<?php echo $habitacion['Id_Habitaciones']; ?>">
                                            <input type="hidden" name="clienteId" value="<?php echo $_SESSION['user_id']; ?>">
                                            <input type="hidden" name="hotelId" value="<?php echo $hotelId; ?>">
                                            <input type="hidden" name="checkin" value="<?php echo $_SESSION['checkin']; ?>">
                                            <input type="hidden" name="checkout" value="<?php echo $_SESSION['checkout']; ?>">
                                            <input type="hidden" name="guests" value="<?php echo $_SESSION['guests']; ?>">
                                            <input type="hidden" name="paisId" value="<?php echo $_SESSION['location']; ?>">
                                            <input type="hidden" name="precioFinal" value="<?php echo htmlspecialchars($habitacion['PrecioFinal']); ?>">

                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-bookmark-check"></i> Confirmar Reserva
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No hay habitaciones disponibles en este hotel para las fechas seleccionadas.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script personalizado -->
<script src="../static/js/detalles.js"></script>

</body>
</html>