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
     <!-- Font Awesome para iconos -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>


    <header class="main-header">
        <nav class="nav-container">
            <div class="logo-container">
                <a href="/">
                    <img src="../../static/img/logo.png" alt="Hotel Calíope Logo" class="logo">
                </a>
            </div>
            
            <div class="nav-links">
                <a href="/" class="nav-link"><i class="fas fa-home"></i> Inicio</a>
                <a href="/vista/hoteles.php" class="nav-link"><i class="fas fa-hotel"></i> Hoteles</a>
                <a href="/vista/servicios.php" class="nav-link"><i class="fas fa-concierge-bell"></i> Servicios</a>
                <a href="/vista/reservas.php" class="nav-link"><i class="fas fa-calendar-alt"></i> Reservas</a>
                <a href="/vista/Contacto/contacto.php" class="nav-link"><i class="fas fa-envelope"></i> Contacto</a>
            </div>

            <div class="user-actions">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <a href="/vista/Clientes/perfil.php" class="user-link">
                        <i class="fas fa-user"></i> Mi Perfil
                    </a>
                    <a href="/vista/Clientes/logout.php" class="user-link">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                <?php else: ?>
                    <a href="/vista/Clientes/login.php" class="user-link">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                    <a href="/vista/Clientes/registre.php" class="user-link">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                <?php endif; ?>
            </div>

            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>

        <div class="header-title">
            <h1>Galería de Hoteles</h1>
            <p>Descubre nuestros hoteles alrededor del mundo</p>
        </div>
    </header>
    <div class="gallery-container">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">Todos los Hoteles</button>
            <?php
            // Generar botones de filtro dinámicamente
            $continentes = array_unique(array_column($hoteles, 'directorio'));
            foreach ($continentes as $directorio) {
                $nombre_continente = array_search($directorio, array_column($hoteles, 'directorio', 'continente'));
                echo '<button class="filter-btn" data-filter="'.$directorio.'">'.$nombre_continente.'</button>';
            }
            ?>
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
                                        $imagenFinal = "{$baseWebPath}/img/default.jpg";
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