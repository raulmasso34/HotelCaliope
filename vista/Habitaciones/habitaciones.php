<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controller/habitacion/habitacionController.php';

$database = new Database();
$conn = $database->getConnection();
$controller = new HabitacionController($conn);

$habitaciones = $controller->obtenerHabitaciones();
if (!is_array($habitaciones)) {
    exit("Error al cargar las habitaciones");
}

// Agrupar habitaciones por continente
$habitaciones_por_continente = [];
foreach ($habitaciones as $habitacion) {
    $continente = $habitacion['Continente']; // Suponiendo que la columna Continente tiene el nombre del continente
    $tipo = $habitacion['Tipo'];
    
    if (!isset($habitaciones_por_continente[$continente])) {
        $habitaciones_por_continente[$continente] = [];
    }

    // Aseguramos que no haya habitaciones repetidas por tipo dentro del continente
    if (!isset($habitaciones_por_continente[$continente][$tipo])) {
        $habitaciones_por_continente[$continente][$tipo] = $habitacion; // Guardamos solo una habitación de ese tipo
    }
}

$baseWebPath = '../../static/img/habitaciones'; // Sin "/tipo" al final
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Habitaciones - Hotel Calíope</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

        <!-- Font Awesome para iconos -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:wght@200..1000&family=Old+Standard+TT:wght@400;700&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/habitaciones/habitaciones.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/header.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/footer.css">
</head>
<body>
<header class="main-header">
        <div class="carousel">
            <img class="carousel-background" src="../../static/img/california/california.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../../static/img/Galicia/galicia1.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../../static/img/europa/pirineos.jpg" alt="Fondo 3">
        </div>
        
        <section class="main-up">
            <div class="main-up-left">
                <img src="../../static/img/logo_blanco.png" alt="Logo Hotel Calíope">
            </div>

            <div class="main-up-right">
                <div class="links">
                    <a href="../../vista/index.php">Home</a>
                    <a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
                    <div class="dropdown">
                        <a href="../../vista/hoteles.php" class="dropbtn">Hoteles</a>
                        <div class="dropdown-content">
                            <div class="dropdown-section">
                                <h4>Europa</h4>
                                <a href="../../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                <a href="../../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                                <a href="../../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                            </div>
                            <div class="dropdown-section">
                                <h4>USA</h4>
                                <a href="../../vista/ciudades/USA/Florida.php">Florida</a>
                                <a href="../../vista/ciudades/USA/California.php">California</a>
                                <a href="../../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                            </div>
                        </div>
                    </div>

                    <a href="../../vista/galeria/galeria.php">Galería</a>
                    <a href="../../vista/ofertas/ofertas.php">Ofertas</a>
                    <a href="../../vista/Contacto/contacto.php">Contacto</a>
                    
                    <!-- Contenedor del perfil -->
                    <div class="dropdown-perfil">
                        <a class="icon-perfil" href="javascript:void(0);">
                            <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
                        </a>
                        <div class="dropdown-perfil-content">
                            <a href="../../vista/Clientes/login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                            </a>
                            <a href="../../vista/Clientes/perfil.php">
                                <i class="bi bi-person"></i> Perfil
                            </a>
                            <a href="../../controller/clients/LoginController.php?action=logout" style="color: red;"> 
                                <i class="bi bi-box-arrow-right" style="color: red;"></i> Cerrar sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menú hamburguesa -->
            <div id="menu-toggle" class="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <!-- Menú móvil -->
            <div class="mobile-menu">
                <a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                <a href="../../vista/galeria/galeria.php">Galería</a>
                <a href="../../vista/ofertas/ofertas.php">Ofertas</a>
                <a href="../../vista/Contacto/contacto.php">Contacto</a>
                <a href="../../vista/Clientes/login.php">Iniciar sesión</a>
                <a href="../../vista/Clientes/perfil.php">Perfil</a>
                
                <div class="dropdown-mobile">
                    <a href="#" class="dropbtn">Hoteles</a>
                    <div class="dropdown-content-mobile">
                        <div class="dropdown-section">
                            <h4>Europa</h4>
                            <a href="../../vista/ciudades/Europa/Galicia.php">Galicia</a>
                            <a href="../../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                            <a href="../../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                        </div>
                        <div class="dropdown-section">
                            <h4>USA</h4>
                            <a href="../../vista/ciudades/USA/Florida.php">Florida</a>
                            <a href="../../vista/ciudades/USA/California.php">California</a>
                            <a href="../../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="main-center">
            <div class="center-up">
                <div class="center-up-up">
                    <span style="font-size: 20px; color: rgb(230, 182, 11);">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </span>
                </div>
                <div class="center-up-down">
                    <h5>Descubre Nuestros Hoteles</h5>
                    <h1>Nuestras Habitaciones</h1>
                </div>
            </div>
        </section>
        <div class="scroll-down">
            <a href="#gallery-section" class="scroll-down-arrow">
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
    </header>


    <div id="gallery-section" class="gallery-container">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">Todas las Habitaciones</button>
            <?php foreach ($habitaciones_por_continente as $continente => $habitaciones) : ?>
                <button class="filter-btn" data-filter="<?= strtolower(str_replace(' ', '', $continente)) ?>">
                    <?= htmlspecialchars($continente) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="gallery-grid">
            <?php foreach ($habitaciones_por_continente as $continente => $habitaciones) : ?>
                <div class="gallery-section <?= strtolower(str_replace(' ', '', $continente)) ?>">
                    <h2>Habitaciones en <?= htmlspecialchars($continente) ?></h2>
                    <div class="hotel-cards">
                        <?php foreach ($habitaciones as $habitacion) : ?>
                            <div class="hotel-card">
                            <img src="<?= $baseWebPath ?>/<?= htmlspecialchars($habitacion['Tipo']) ?>.jpg" 
                            alt="Habitación tipo <?= htmlspecialchars($habitacion['Tipo']) ?>">
                                <div class="hotel-info">
                                    <h3><?= htmlspecialchars($habitacion['Tipo']) ?></h3>
                                    <p>Capacidad: <?= htmlspecialchars($habitacion['Capacidad']) ?> personas</p>
                                    <p>Precio: $<?= htmlspecialchars($habitacion['Precio']) ?></p>
                                    <p><?= htmlspecialchars($habitacion['Descripcion']) ?></p>
                                    <a href="#" class="view-more">Ver detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <!-- Columna 1 - Logo y Descripción -->
            <div class="footer-section">
                <img src="../../static/img/logo_blanco.png" alt="Logo Hotel Calíope" class="footer-logo">
                <p>Descubre el lujo y la comodidad en cada rincón del mundo con Hotel Calíope.</p>
            </div>

            <!-- Columna 2 - Enlaces rápidos -->
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/hoteles.php">Hoteles</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/galeria/galeria.php">Galería</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/ofertas/ofertas.php">Ofertas</a></li>
                </ul>
            </div>

            <!-- Columna 3 - Contacto -->
            <div class="footer-section">
                <h3>Contacto</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +34 123 456 789</li>
                    <li><i class="fas fa-envelope"></i> info@hotelcaliope.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Calle Principal 123, Madrid</li>
                </ul>
            </div>

            <!-- Columna 4 - Redes Sociales -->
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Sección Inferior -->
        <div class="footer-bottom">
            <div class="footer-links">
                <a href="../../vista/politicas/privacidad.php">Política de Privacidad</a>
                <a href="../../vista/politicas/cookies.php">Política de Cookies</a>
                <a href="../../vista/politicas/avisolegal.php">Aviso Legal</a>
            </div>
            <p>&copy; 2025 Hotel Calíope. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="../../static/js/habitaciones/habitaciones.js"></script>
</body>
</html>
