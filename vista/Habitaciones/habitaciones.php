<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '../../../config/Database.php';
require_once __DIR__ . '../../../controller/habitacion/habitacionController.php';

$controllerHab = new HabitacionController();
$habitaciones = $controllerHab->obtenerTodasLasHabitacionesAgrupadas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones - Hoteles Calíope</title>
    <link rel="stylesheet" href="../../static/css/habitaciones/habitaciones.css?v=1.2">
    <link rel="stylesheet" href="../../static/css/GENERAL/footer.css?v=1.1">
    <link rel="stylesheet" href="../../static/css/GENERAL/header.css?v=1.1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <h5> <b>Contacta con nosotros para más información!</b></h5>
                    <h1>NUESTRAS HABITACIONES</h1>
                </div>
            </div>
        </section>
        <div class="scroll-down">
            <a href="#rooms-container" class="scroll-down-arrow">
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
    </header>











    <main id="rooms-container" class="rooms-container">
        <h1 class="section-title">Nuestras Habitaciones</h1>

        <?php if (!empty($habitaciones)): ?>
            <?php foreach ($habitaciones as $tipo => $listaHabitaciones): ?>
                <section class="room-type-section">
                    <h2 class="room-type-title"><?= htmlspecialchars($tipo ?? 'Sin Tipo') ?></h2>
                    <div class="rooms-grid">
                        <?php 
                        $contador = 0;
                        foreach ($listaHabitaciones as $habitacion): 
                            if ($contador >= 1) break;
                            $contador++;

                            // Datos de la habitación
                            $idHabitacion = $habitacion['Id_Habitaciones'] ?? 0;
                            $numeroHabitacion = $habitacion['Numero_Habitacion'] ?? 'N/A';
                            $tipoHabitacion = htmlspecialchars($habitacion['Tipo'] ?? 'Desconocido');
                            $capacidad = $habitacion['Capacidad'] ?? 0;
                            $precio = $habitacion['Precio'] ?? 100;
                            $descripcion = htmlspecialchars($habitacion['Descripcion'] ?? 'Sin descripción');
                            $servicios = isset($habitacion['Servicios_Adicionales']) 
                                ? array_filter(explode(',', $habitacion['Servicios_Adicionales']), 'trim') 
                                : [];

                            // Lógica para imágenes
                            $imagenes = [];
                            if (!empty($habitacion['imagen_url'])) {
                                $imagenes[] = htmlspecialchars($habitacion['imagen_url']);
                            } else {
                                $nombreBase = strtolower(str_replace(' ', '-', $tipoHabitacion));
                                for ($i = 1; $i <= 3; $i++) {
                                    $ruta = "../../static/img/habitaciones/{$nombreBase}{$i}.jpg";
                                    if (file_exists($ruta)) $imagenes[] = $ruta;
                                }
                                if (empty($imagenes)) $imagenes[] = "../../static/img/habitaciones/default.jpg";
                            }
                        ?>
                            <article class="room-card" 
                                data-id="<?= $idHabitacion ?>"
                                data-tipo="<?= $tipoHabitacion ?>"
                                data-precio="<?= $precio ?>"
                                data-descripcion="<?= $descripcion ?>"
                                data-capacidad="<?= $capacidad ?>"
                                data-servicios="<?= htmlspecialchars(json_encode($servicios)) ?>"
                                data-imagenes="<?= htmlspecialchars(json_encode($imagenes)) ?>">
                                
                                <div class="room-image">
                                    <img src="<?= $imagenes[0] ?>" 
                                        alt="Habitación <?= $tipoHabitacion ?>" 
                                        loading="lazy">
                                </div>

                                <div class="room-details">
                                    <h3 class="room-title">Habitación <?= $tipoHabitacion ?></h3>
                                    <p class="room-number">Número: <?= $numeroHabitacion ?></p>
                                    <div class="price-container">
                                        <p class="room-price">$<?= number_format($precio, 2) ?></p>
                                        <span class="price-period">/noche</span>
                                    </div>

                                    <div class="room-info">
                                        <p class="capacity">
                                            <i class="fas fa-user-friends"></i>
                                            <?= $capacidad ?> personas
                                        </p>
                                        <p class="description"><?= $descripcion ?></p>
                                    </div>

                                    <ul class="amenities-list">
                                        <?php if (!empty($servicios)): ?>
                                            <?php foreach ($servicios as $servicio): ?>
                                                <li>
                                                    <i class="fas fa-check-circle"></i>
                                                    <?= htmlspecialchars(trim($servicio)) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li>No incluye servicios adicionales.</li>
                                        <?php endif; ?>
                                    </ul>

                                    <button class="btn view-details">Ver Detalles</button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-rooms">
                <img src="../../static/img/empty-state.svg" alt="No hay habitaciones" class="empty-illustration">
                <h2>No hay habitaciones disponibles en este momento</h2>
            </div>
        <?php endif; ?>
    </main>

    <!-- Modal -->
    <div class="room-modal" style="display: none;">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-carousel">
                <div class="carousel-inner"></div>
                <div class="carousel-controls">
                    <button class="carousel-prev">&#10094;</button>
                    <button class="carousel-next">&#10095;</button>
                </div>
                <div class="carousel-dots"></div>
            </div>
            <div class="modal-details">
                <h2 class="modal-title"></h2>
                <div class="price-container">
                    <span class="modal-price"></span>
                    <span class="price-period">/noche</span>
                </div>
                <div class="modal-info">
                    <p><i class="fas fa-user-friends"></i> <span class="modal-capacity"></span> personas</p>
                    <p class="modal-description"></p>
                </div>
                <div class="modal-services">
                    <h3>Servicios incluidos:</h3>
                    <ul class="services-list"></ul>
                </div>
                <button class="btn book-now">Reservar ahora</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../static/js/habitaciones/habitaciones.js"></script>
</body>
</html>