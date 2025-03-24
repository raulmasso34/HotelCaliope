<?php
session_start();

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

// Crear una instancia del controlador
$controller = new ReservaController();

// Verificar si la instancia se ha creado correctamente
if ($controller !== null) {
    // Obtener los países a través del controlador
    $paises = $controller->obtenerPaises();

    // Verificar si se han obtenido los países y hacer algo con ellos
    
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
    <head>

        <!--ESTILOS-->
        <link rel="stylesheet" href="../../static/css/ofertas.css">

        <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../static/css/style.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        <title>Document</title>
        <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    </head>
    <body>
    <header class="main-header">

        <div class="carousel">
                <img class="carousel-background" src="../../static/img/florida/florida3.jpg" alt="Fondo 1">
                <img class="carousel-background" src="../../static/img/florida/florida4.jpg" alt="Fondo 2">
                <img class="carousel-background" src="../../static/img/florida/florida5.jpg" alt="Fondo 3">
            </div>
            
            <section class="main-up">
                <div class="main-up-left">
                    <img src="../../static/img/logo.png" alt="Imagen secundaria">
                </div>

                <div class="main-up-right">
                    <div class="links">
                       
                        <a href="../index.php">Home</a>
                        <a href="../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                        
                        <div class="dropdown">
                            <a href="#" class="dropbtn">Hoteles</a>
                            <div class="dropdown-content">
                                <div class="dropdown-section">
                                    <h4>Europa</h4>
                                    <a href="../../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                    <a href="../../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                                    <a href="../../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                                    
                                </div>
                                <div class="dropdown-section">
                                    <h4>USA</h4>
                                    <a href="../../vista/ciudades/USA/California.php">California</a>
                                    <a href="../../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                                </div>
                            </div>
                        </div>
                        <a href="../../vista/galeria/galeria.php">Galería</a>
                        <a href="../../vista/Contacto/contacto.php">Contacto</a>
                        
                        <div class="dropdown-perfil">
                            <a class="icon-perfil" href="javascript:void(0);">
                                <i class="fa-regular fa-user fa-2xl"></i> <!-- Icono de usuario -->
                            </a>
                            <div class="dropdown-perfil-content">
                                <a href="../../vista/Clientes/login.php">Iniciar sesión</a>
                                <a href="../../vista/Clientes/perfil.php">Perfil</a>
                                <a href="../../controller/clients/LoginController.php?action=logout">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menú hamburguesa (solo visible en pantallas pequeñas) -->
                <div id="menu-toggle" class="menu-toggle">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>

                <!-- Menú desplegable -->
                <div class="mobile-menu">
                    <a href="../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    <a href="../vista/galeria/galeria.php">Galería</a>
                    <a href="../vista/ofertas/ofertas.php">Ofertas</a>
                    <a href="../vista/Contacto/contacto.php">Contacto</a>
                    <a href="../vista/Clientes/login.php">Iniciar sesión</a>
                    <a href="../vista/Clientes/perfil.php">Perfil</a>
                    
                    <!-- Enlace para Hoteles con dropdown -->
                    <div class="dropdown-mobile">
                        <a href="#" class="dropbtn">Hoteles</a>
                        <div class="dropdown-content-mobile">
                            <div class="dropdown-section">
                                <h4>Europa</h4>
                                <a href="../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                <a href="../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                                <a href="../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                            </div>
                            <div class="dropdown-section">
                                <h4>USA</h4>
                                <a href="../vista/ciudades/USA/Florida.php">Florida</a>
                                <a href="../vista/ciudades/USA/California.php">California</a>
                                <a href="../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                            </div>
                        </div>
                    </div>
                </div>


            </section>

            


            <section class="main-center">
                <div class="center-up">
                    <div class="center-up-up">
                        <span style="font-size: 20px; color: rgb(230, 182, 11);">
                            <i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star "></i>
                        </span>
                    </div>
                    <div class="center-up-down">
                        <h5>Lorem ipsum dolor sit amet.</h5>
                        <H1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere, minima.</H1>
                    </div>
                </div>
                <div class="center-down">
                    <div class="form-reservas">
                        <div class="reservation-form">
                            <form id="reservationForm" action="../vista/reservas.php" method="post">
                                <!-- Campo de selección de lugar -->
                                <div class="form-group">
                                    <label for="location">Lugar</label>
                                    <select id="location" name="location" required>
                                        <?php foreach ($paises as $pais): ?>
                                            <option value="<?php echo $pais['Id_Pais']; ?>"><?php echo $pais['Pais']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Campo de fecha de check-in -->
                                <div class="form-group">
                                    <label for="checkin">Fecha de Check-in</label>
                                    <input type="date" id="checkin" name="checkin" min="<?= date('Y-m-d'); ?>" required>
                                </div>

                                <!-- Campo de fecha de check-out -->
                                <div class="form-group">
                                    <label for="checkout">Fecha de Check-out</label>
                                    <input type="date" id="checkout" name="checkout" min="<?= date('Y-m-d'); ?>" required>
                                </div>

                                <!-- Campo de número de personas -->
                                <div class="form-group">
                                    <label for="numero_personas">Número de Personas</label>
                                    <input type="number" id="numero_personas" name="numero_personas" min="1" value="<?php echo isset($_SESSION['numero_personas']) ? $_SESSION['numero_personas'] : ''; ?>" required>
                                </div>

                                <!-- Botón para enviar el formulario -->
                                <button type="submit" id="submitBtn">Reservar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </header>

            <!-- Add this after the header section -->
        <main class="offers-main">
            <!-- Season Selector -->
            <section class="season-selector">
                <div class="season-tabs">
                    <button class="season-tab active" data-season="summer">
                        <i class="fas fa-sun"></i> Ofertas de Verano
                    </button>
                    <button class="season-tab" data-season="winter">
                        <i class="fas fa-snowflake"></i> Ofertas de Invierno
                    </button>
                </div>
            </section>

            <!-- Summer Offers -->
            <section class="offers-section active" id="summer-offers">
                <div class="offers-grid">
                    <!-- Offer Card 1 -->
                    <div class="offer-card">
                        <div class="offer-image">
                            <img src="../../static/img/ofertas/verano1.jpg" alt="Oferta Verano">
                            <div class="offer-badge">-30%</div>
                        </div>
                        <div class="offer-content">
                            <h3>Escapada Playera</h3>
                            <p class="offer-location">
                                <i class="fas fa-map-marker-alt"></i> Hotel Florida
                            </p>
                            <div class="offer-details">
                                <p>7 noches de alojamiento</p>
                                <p>Desayuno incluido</p>
                                <p>Acceso a piscina infinity</p>
                            </div>
                            <div class="offer-price">
                                <span class="original-price">1200€</span>
                                <span class="discounted-price">840€</span>
                            </div>
                            <a href="#" class="offer-button">Reservar Ahora</a>
                        </div>
                    </div>

                    <!-- Add more summer offer cards here -->
                </div>
            </section>

            <!-- Winter Offers -->
            <section class="offers-section" id="winter-offers">
                <div class="offers-grid">
                    <!-- Offer Card 1 -->
                    <div class="offer-card">
                        <div class="offer-image">
                            <img src="../../static/img/ofertas/invierno1.jpg" alt="Oferta Invierno">
                            <div class="offer-badge">-25%</div>
                        </div>
                        <div class="offer-content">
                            <h3>Aventura en la Nieve</h3>
                            <p class="offer-location">
                                <i class="fas fa-map-marker-alt"></i> Hotel Pirineos
                            </p>
                            <div class="offer-details">
                                <p>5 noches de alojamiento</p>
                                <p>Pensión completa</p>
                                <p>Equipo de ski incluido</p>
                            </div>
                            <div class="offer-price">
                                <span class="original-price">1500€</span>
                                <span class="discounted-price">1125€</span>
                            </div>
                            <a href="#" class="offer-button">Reservar Ahora</a>
                        </div>
                    </div>

                    <!-- Add more winter offer cards here -->
                </div>
            </section>

              <!-- Add this after the winter offers section -->
            <section class="special-packages">
                <div class="packages-header">
                    <h2>Paquetes Especiales</h2>
                    <p>Descubre nuestras experiencias exclusivas diseñadas para hacer tu estancia inolvidable</p>
                </div>

                <div class="packages-grid">
                    <!-- All Inclusive Package -->
                    <div class="package-card">
                        <div class="package-icon">
                            <i class="fas fa-infinity"></i>
                        </div>
                        <div class="package-content">
                            <h3>Todo Incluido</h3>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-bed"></i> Hospedaje de lujo</li>
                                    <li><i class="fas fa-utensils"></i> Todas las comidas incluidas</li>
                                    <li><i class="fas fa-cocktail"></i> Bebidas ilimitadas</li>
                                    <li><i class="fas fa-swimming-pool"></i> Acceso a todas las actividades</li>
                                </ul>
                            </div>
                            <div class="package-price">
                                <span>Desde</span>
                                <h4>199€</h4>
                                <span>por persona/noche</span>
                            </div>
                            <a href="#" class="package-button">Ver Detalles</a>
                        </div>
                    </div>

                    <!-- Romantic Package -->
                    <div class="package-card">
                        <div class="package-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="package-content">
                            <h3>Paquete Romántico</h3>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-rose"></i> Decoración especial</li>
                                    <li><i class="fas fa-glass-cheers"></i> Cena a la luz de las velas</li>
                                    <li><i class="fas fa-spa"></i> Spa para parejas</li>
                                    <li><i class="fas fa-champagne-glasses"></i> Botella de champagne</li>
                                </ul>
                            </div>
                            <div class="package-price">
                                <span>Desde</span>
                                <h4>299€</h4>
                                <span>por pareja/noche</span>
                            </div>
                            <a href="#" class="package-button">Ver Detalles</a>
                        </div>
                    </div>

                    <!-- Family Package -->
                    <div class="package-card">
                        <div class="package-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="package-content">
                            <h3>Paquete Familiar</h3>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-child"></i> Actividades para niños</li>
                                    <li><i class="fas fa-baby-carriage"></i> Servicio de niñera</li>
                                    <li><i class="fas fa-percent"></i> Descuentos en habitaciones</li>
                                    <li><i class="fas fa-gamepad"></i> Club infantil</li>
                                </ul>
                            </div>
                            <div class="package-price">
                                <span>Desde</span>
                                <h4>399€</h4>
                                <span>por familia/noche</span>
                            </div>
                            <a href="#" class="package-button">Ver Detalles</a>
                        </div>
                    </div>

                    <!-- Adventure Package -->
                    <div class="package-card">
                        <div class="package-icon">
                            <i class="fas fa-mountain"></i>
                        </div>
                        <div class="package-content">
                            <h3>Paquete Aventura</h3>
                            <div class="package-features">
                                <ul>
                                    <li><i class="fas fa-hiking"></i> Excursiones guiadas</li>
                                    <li><i class="fas fa-bicycle"></i> Equipo deportivo incluido</li>
                                    <li><i class="fas fa-map-marked-alt"></i> Rutas de senderismo</li>
                                    <li><i class="fas fa-parachute-box"></i> Deportes extremos</li>
                                </ul>
                            </div>
                            <div class="package-price">
                                <span>Desde</span>
                                <h4>249€</h4>
                                <span>por persona/noche</span>
                            </div>
                            <a href="#" class="package-button">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </section>
                              



        </main>














        <section class="contacto">
        <div class="contacto-box">
            <div class="contacto-sub">
               
                <h3>No nos pierdas de vista</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam eligendi, aperiam itaque tempora perferendis consequatur?</p>
                <br> <br>

                <i class="fa-solid fa-phone fa-2xl"> 111 222 346</i>
            </div>
            <div class="contacto-sub">
                <div class="newsletter-sub">
                    <div class="news-title">
                        <h1>Inicia Sesión</h1>
                        <p>Accede a tu cuenta para disfrutar de beneficios exclusivos.</p>
                    </div>
                    <form class="news-content">
                        <input type="text" placeholder="Usuario o correo electrónico" required>
                        <input type="password" placeholder="Contraseña" required>
                        <button type="submit">Iniciar Sesión</button>
                    </form>
                    <div class="news-footer">
                        <p>¿No tienes cuenta? <a href="#">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>


    </section>

        <!-- Replace the existing footer with this one -->
    <footer class="contact-footer">
        <div class="footer-top">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section">
                    <img src="../../static/img/logo_blanco.png" alt="Hotel Caliope Logo" class="footer-logo">
                    <p>Descubre el lujo y la comodidad en nuestros hoteles exclusivos. Una experiencia única en las mejores ubicaciones.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
                        <li><a href="../galeria/galeria.php">Galería</a></li>
                        <li><a href="../ofertas/ofertas.php">Ofertas</a></li>
                        <li><a href="../Contacto/contacto.php">Contacto</a></li>
                    </ul>
                </div>

                <!-- Our Hotels -->
                <div class="footer-section">
                    <h3>Nuestros Hoteles</h3>
                    <ul class="footer-links">
                        <li><a href="../ciudades/Europa/Galicia.php">Hotel Galicia</a></li>
                        <li><a href="../ciudades/Europa/Tossa.php">Hotel Tossa de Mar</a></li>
                        <li><a href="../ciudades/USA/Florida.php">Hotel Florida</a></li>
                        <li><a href="../ciudades/USA/California.php">Hotel California</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Suscríbete para recibir nuestras mejores ofertas</p>
                    <form class="newsletter-form">
                        <div class="form-group">
                            <input type="email" placeholder="Tu email" required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-info">
                <div class="copyright">
                    <p>&copy; 2024 Hotel Caliope. Todos los derechos reservados.</p>
                </div>
                <div class="footer-bottom-links">
                    <a href="../politicas/privacidad.php">Política de Privacidad</a>
                    <a href="../politicas/cookies.php">Política de Cookies</a>
                    <a href="../politicas/avisolegal.php">Aviso Legal</a>
                </div>
            </div>
        </div>
    </footer>

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../../static/js/main.js"></script>
    <script src="../../static/js/ofertas.js"></script>
    
    </body>
</html>