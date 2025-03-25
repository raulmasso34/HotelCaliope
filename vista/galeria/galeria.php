<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/Database.php'; // Necesitarás este archivo
require_once __DIR__ . '/../../controller/hotel/hotelController.php';

// Crear conexión a la base de datos
$database = new Database();
$conn = $database->getConnection();

// Instanciar controlador con la conexión
$controller = new HotelController($conn);
$hoteles = $controller->obtenerHoteles();

// Verificar y manejar errores
if ($hoteles === null || !is_array($hoteles)) {
    echo "Error al cargar los hoteles";
    exit;
}

$orden_continentes = ['Europa', 'América del Norte', 'Sudamérica', 'Asia', 'África', 'Oceanía', 'Antártida'];

// Verificar y preparar hoteles por continente
$hoteles_por_continente = [];
if (!empty($hoteles)) {
    foreach ($hoteles as $hotel) {
        $continente = $hotel['continente'];
        $hoteles_por_continente[$continente][] = $hotel;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Hoteles - Hotel Calíope</title>

    <link rel="stylesheet" href="../../static/css/galeria.css">
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

     <!-- Font Awesome para iconos -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:wght@200..1000&family=Old+Standard+TT:wght@400;700&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
</head>

<body>


    <header class="main-header">
        <div class="carousel">
            <img class="carousel-background" src="../../static/img/california/california.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../../static/img/galeria/galeria2.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../../static/img/galeria/galeria3.jpg" alt="Fondo 3">
        </div>
        
        <section class="main-up">
            <div class="main-up-left">
                <img src="../../static/img/logo_blanco.png" alt="Logo Hotel Calíope">
            </div>

            <div class="main-up-right">
                <div class="links">
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
                    <h1>Galería de Destinos Exclusivos</h1>
                </div>
            </div>
        </section>
        <div class="scroll-down">
            <a href="#gallery-section" class="scroll-down-arrow">
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
    </header>



    
    <div class="gallery-container">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">Todos los Hoteles</button>
            <button class="filter-btn" data-filter="europa">Europa</button>
            <button class="filter-btn" data-filter="norteamerica">América del Norte</button>
        </div>

        <div class="gallery-grid">
            <?php
            // Definir rutas base
            $baseServerPath = '/var/www/html/HotelCaliope/HotelCaliope-2/static';
            $baseWebPath = '/static';
            
            foreach ($orden_continentes as $continente) :
                if (!empty($hoteles_por_continente[$continente])) :
                    $directorio = $hoteles_por_continente[$continente][0]['directorio'];
            ?>
                    <div class="gallery-section <?= htmlspecialchars($directorio) ?>">
                        <h2>Hoteles en <?= htmlspecialchars($continente) ?></h2>
                        <div class="hotel-cards">
                            <?php foreach ($hoteles_por_continente[$continente] as $hotel) : 
                                // Lógica para determinar la imagen
                                $imagenFinal = '';
                                
                                if (!empty($hotel['imagen'])) {
                                    // Usar imagen de la base de datos
                                    $imagenFinal = "{$baseWebPath}/img/{$directorio}/".htmlspecialchars($hotel['imagen']);
                                } else {
                                    // Generar nombre de archivo basado en el nombre del hotel
                                    $nombreBase = str_replace('Hotel Caliope ', '', $hotel['nombre_hotel']);
                                    $nombreArchivo = strtolower(str_replace(' ', '-', $nombreBase)).'.jpg';
                                    $rutaCompleta = "{$baseServerPath}/img/{$directorio}/{$nombreArchivo}";
                                    
                                    if (file_exists($rutaCompleta)) {
                                        $imagenFinal = "{$baseWebPath}/img/{$directorio}/{$nombreArchivo}";
                                    } else {
                                        // Imagen por defecto
                                        $imagenFinal = "{$baseWebPath}/img/florida/florida1.jpg";
                                    }
                                }
                            ?>
                                <div class="hotel-card">
                                    <img src="<?= $imagenFinal ?>" 
                                        alt="<?= htmlspecialchars($hotel['nombre_hotel']) ?> en <?= htmlspecialchars($hotel['pais']) ?>">
                                    <div class="hotel-info">
                                        <h3><?= htmlspecialchars($hotel['nombre_hotel']) ?></h3>
                                        <p><?= htmlspecialchars($hotel['descripcion']) ?></p>
                                        <a href="/hoteles/<?= htmlspecialchars($directorio) ?>/<?= urlencode($hotel['pais']) ?>/<?= $hotel['id'] ?>" 
                                        class="view-more">
                                            Ver hotel
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div> <!-- Cierre faltante del div.gallery-container -->

    <script src="../../static/js/galeria.js"></script>
</body>
</html>