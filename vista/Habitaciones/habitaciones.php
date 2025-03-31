<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['checkin'] = $_POST['checkin'];
    $_SESSION['checkout'] = $_POST['checkout'];
    $_SESSION['guests'] = $_POST['numero_personas'];
    $_SESSION['habitacionId'] = $_POST['habitacionId'];

    // Redirigir a la página de reservas para mostrar los detalles del hotel
    header('Location: ../vista/reservas.php');
    exit();
}

// Incluir el controlador
require_once __DIR__ . '../../../controller/reserva/reservaController.php';
require_once __DIR__ . '../../../controller/habitacion/habitacionController.php';

// Crear una instancia del controlador
$controller = new ReservaController();
$controllerHab = new HabitacionController();



// Verificar si la instancia se ha creado correctamente
if ($controller !== null) {
    // Obtener los países a través del controlador
    $paises = $controller->obtenerPaises();

    // Verificar si se han obtenido los países y hacer algo con ellos
    
} 
$habitaciones = $controllerHab->obtenerHabitaciones() ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Hoteles Caliope</title>
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

     <!-- Font Awesome para iconos -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:wght@200..1000&family=Old+Standard+TT:wght@400;700&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/habitaciones/habitaciones.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/footer.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/header.css">
  



    <!-- Scripts -->
   
    <script src="../../static/js/habitaciones/habitaciones.js"></script>
</head>

<body>
   
    <main class="rooms-grid">
        <!-- Suite Presidencial -->
        <article class="room-card">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Suite Presidencial">
            </div>
            <div class="room-details">
                <h2 class="room-title">Suite Presidencial</h2>
                <p class="room-price">$1,200/noche</p>
                <ul class="amenities-list">
                    <li><i class="fas fa-hot-tub"></i> Jacuzzi privado con vista al mar</li>
                    <li><i class="fas fa-wine-bottle"></i> Minibar premium incluido</li>
                    <li><i class="fas fa-concierge-bell"></i> Servicio de mayordomo 24h</li>
                    <li><i class="fas fa-umbrella-beach"></i> Terraza privada con acceso directo a la playa</li>
                </ul>
                <button class="btn view-details">Ver Detalles</button>
            </div>
        </article>
    
        <!-- Suite Ejecutiva -->
        <article class="room-card">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80" alt="Suite Ejecutiva">
            </div>
            <div class="room-details">
                <h2 class="room-title">Suite Ejecutiva</h2>
                <p class="room-price">$850/noche</p>
                <ul class="amenities-list">
                    <li><i class="fas fa-briefcase"></i> Escritorio ejecutivo ergonómico</li>
                    <li><i class="fas fa-wifi"></i> WiFi de alta velocidad (1Gbps)</li>
                    <li><i class="fas fa-cocktail"></i> Bar privado con licores premium</li>
                    <li><i class="fas fa-car"></i> Estacionamiento VIP gratuito</li>
                </ul>
                <button class="btn view-details">Ver Detalles</button>
            </div>
        </article>
    
        <!-- Habitación Deluxe Familiar -->
        <article class="room-card">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Suite Familiar">
            </div>
            <div class="room-details">
                <h2 class="room-title">Suite Familiar Deluxe</h2>
                <p class="room-price">$950/noche</p>
                <ul class="amenities-list">
                    <li><i class="fas fa-child"></i> Área de juegos infantil</li>
                    <li><i class="fas fa-swimming-pool"></i> Acceso a piscina climatizada</li>
                    <li><i class="fas fa-utensils"></i> Menú infantil gourmet</li>
                    <li><i class="fas fa-gamepad"></i> Consola de videojuegos premium</li>
                </ul>
                <button class="btn view-details">Ver Detalles</button>
            </div>
        </article>
    
        <!-- Suite Romántica -->
        <article class="room-card">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Suite Romántica">
            </div>
            <div class="room-details">
                <h2 class="room-title">Suite Romántica</h2>
                <p class="room-price">$999/noche</p>
                <ul class="amenities-list">
                    <li><i class="fas fa-heart"></i> Decoración temática romántica</li>
                    <li><i class="fas fa-spa"></i> Baño de burbujas con pétalos</li>
                    <li><i class="fas fa-glass-cheers"></i> Cena romántica incluida</li>
                    <li><i class="fas fa-moon"></i> Terraza privada con jacuzzi</li>
                </ul>
                <button class="btn view-details">Ver Detalles</button>
            </div>
        </article>
    </main>

    <!-- Modal de Lujo -->
    <div class="room-modal">
        <div class="modal-luxury">
            <span class="close-luxury">&times;</span>
            <div class="modal-carousel">
                <div class="carousel-inner"><!-- Imágenes dinámicas --></div>
                <div class="carousel-controls">
                    <span class="carousel-prev" aria-label="Anterior">&#10094;</span>
                    <span class="carousel-next" aria-label="Siguiente">&#10095;</span>
                </div>
                <div class="carousel-dots"><!-- Puntos dinámicos --></div>
            </div>
            <div class="modal-content-luxury">
                <div class="luxury-columns">
                    <div class="luxury-main">
                        <h2 class="luxury-title"></h2>
                        <div class="luxury-meta">
                            <span class="luxury-price"></span>
                            <div class="luxury-rating"></div>
                        </div>
                        <div class="luxury-details">
                            <h3>Detalles Exclusivos</h3>
                            <ul class="luxury-features"></ul>
                        </div>
                    </div>
                    <div class="luxury-sidebar">
                        <div class="luxury-services">
                            <h3>Servicios Premium</h3>
                            <ul></ul>
                        </div>
                        <div class="luxury-cta">
                            <button class="luxury-book">
                                Reservar Ahora <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

    

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../static/js/main.js"></script>
    <script src="../static/js/calendario.js"></script>


    <script src="../../static/js/habitaciones/habitaciones.js"></script>

    </body>
</html>