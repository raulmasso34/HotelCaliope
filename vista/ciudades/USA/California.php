<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../static/css/GENERAL/footer.css">
    <link rel="stylesheet" href="../../../static/css/GENERAL/header.css">
    <link rel="stylesheet" href="../../../static/css/ciudades/california.css">
    <link rel="shortcut icon" href="../../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <title>CALIFORNIA</title>
</head>
<body>
<header class="main-header">
        <div class="carousel">
            <img class="carousel-background" src="../../../static/img/florida/florida2.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../../../static/img/california/california2.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../../../static/img/california/california.jpg" alt="Fondo 3">
        </div>
        
        <section class="main-up">
            <div class="main-up-left">
                <img src="../../../static/img/logo_blanco.png" alt="Logo Hotel Calíope">
            </div>

            <div class="main-up-right">
                <div class="links">
                <a href="../../../vista/index.php">Home</a>
                    <a href="../../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
                    <div class="dropdown">
                        <a href="#" class="dropbtn">Hoteles</a>
                        <div class="dropdown-content">
                            <div class="dropdown-section">
                                <h4>Europa</h4>
                                <a href="../../../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                <a href="../../../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                                <a href="../../../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                            </div>
                            <div class="dropdown-section">
                                <h4>USA</h4>
                                <a href="../../../vista/ciudades/USA/Florida.php">Florida</a>
                                <a href="#">California</a>
                                <a href="../../../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                            </div>
                        </div>
                    </div>

                    <a href="../../../vista/galeria/galeria.php">Galería</a>
                    
                    <a href="../../../vista/Contacto/contacto.php">Contacto</a>
                    
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
                            <a href="#">California</a>
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
                    <h5>Descubre el Encanto de </h5>
                    <h1>CALIFORNIA</h1>
                </div>
            </div>
        </section>
        <div class="scroll-down">
        <a href="#gallery-section" class="scroll-down-arrow">
            <i class="fa-solid fa-chevron-down"></i>
        </a>
    </div>
    </header>


<section class="main-main">
    <div class="main-box">
        <div class="main-box-box">
            <div class="stars-main" id="stars-main">
                <span style="font-size: 20px; color: rgb(230, 182, 11);">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </span>
            </div>
            <div class="main-title">
                <h3>HOTEL CALÍOPE</h3>
                <h1>Lujo Californiano</h1>
            </div>
            <div class="main-txt">
                <p>Ubicado en la exclusiva costa de Malibú, el Hotel Calíope ofrece una experiencia única donde el glamour de California se fusiona con la elegancia mediterránea. Disfrute de suites con vistas al Pacífico, gastronomía de fusión con productos locales y acceso privado a playas de arena dorada. Nuestro spa inspirado en los viñedos de Napa Valley y nuestra piscina infinity con vistas al atardecer completan la experiencia.</p>

                <div class="main-botones">
                    <button>EXPLORAR</button>
                    <button>RESERVAR</button>
                </div>
            </div>
        </div>
        <div class="main-box-right">
            <div class="img-left">
                <img class="img-main" src="../../../static/img/california/california2.jpg" alt="Vista del Hotel Calíope en Malibú al atardecer">
            </div>
            <div class="img-right">
                <img class="img-main" src="../../../static/img/california/california.jpg" alt="Suite premium con terraza y vista al océano">
            </div>
        </div>
    </div>
</section>


<!-- Coloca el script al final del cuerpo -->
<section class="dispo">
  <h1>Habitaciones y Actividades</h1>
  <div class="carousels-container">
    <!-- Primer carrusel -->
    <div class="carousels">
      <button class="left-btn" id="left-btn1"><i class="arrow"></i></button>
      <img id="carousel1" src="" alt="">
      <button class="right-btn" id="right-btn1"><i class="arrow"></i></button>
      <h2>Habitaciones</h2>
      <p>Descubre nuestras cómodas habitaciones con increíbles vistas.</p>
    </div>
    
    <!-- Segundo carrusel -->
    <div class="carousels">
      <button class="left-btn" id="left-btn2"><i class="arrow"></i></button>
      <img id="carousel2" src="" alt="">
      <button class="right-btn" id="right-btn2"><i class="arrow"></i></button>
      <h2>Actividades</h2>
      <p>Explora las actividades que ofrecemos para disfrutar al máximo.</p>
    </div>
  </div>
</section>

<section class="servicios">
    <h1>SERVICIOS</h1>
   
       
    <table class="tabla-servicios">
        <tr>
            <td>
                <p>Parking</p>
                <i class="fa-solid fa-square-parking"></i>
            </td>
            <td>
                <p>Piscina</p>
                <i class="fa-solid fa-water-ladder"></i>
            </td>
            <td>
                <p>Wifi Gratis</p>
                <i class="fa-solid fa-wifi"></i>
            </td>
        </tr>
        <tr>
            <td>
                <p>Servicio Habitaciones</p>
                <i class="fa-solid fa-bell-concierge"></i>
            </td>
            <td>
                <p>Cafeteria</p>
                <i class="fa-solid fa-mug-saucer"></i>
            </td>
            <td>
                <p>Lavadora</p>
                <i class="fa-solid fa-jug-detergent"></i>
            </td>
        </tr>
        <tr>
            <td>
                <p>Samart TV</p>
                <i class="fa-solid fa-tv"></i>
            </td>
            <td>
                <p>Climatizacion Individual</p>
                <i class="fa-solid fa-fan"></i>
            </td>
            <td>
                <p>Campo de Futbol</p>
                <i class="fa-regular fa-futbol"></i>
            </td>
        </tr>
    </table>

</section>


<section class="mapa-galicia">
<div class="mapa-box-galicia">
            <h2>MAPA INTERCATIVO</h2>
            <p>Descubre en este mapa interactivo todas las áreas donde puedes encontrarnos. 
                Explora nuestras ubicaciones estratégicas, diseñadas para ofrecerte experiencias únicas y memorables en cada destino. 
                ¡Planea tu próxima aventura con nosotros!</p>
            <div id="map"></div>
        </div>
</section>

<footer class="footer">
        <div class="footer-content">
            <!-- Columna 1 - Logo y Descripción -->
            <div class="footer-section">
                <img src="../../../static/img/logo_blanco.png" alt="Logo Hotel Calíope" class="footer-logo">
                <p>Descubre el lujo y la comodidad en cada rincón del mundo con Hotel Calíope.</p>
            </div>

            <!-- Columna 2 - Enlaces rápidos -->
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/hoteles.php">Hoteles</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/galeria/galeria.php">Galería</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/Contacto/contacto.php">Contacto</a></li>
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
                <a href="../vista/politicas/privacidad.php">Política de Privacidad</a>
                <a href="../vista/politicas/cookies.php">Política de Cookies</a>
                <a href="../vista/politicas/avisolegal.php">Aviso Legal</a>
            </div>
            <p>&copy; 2025 Hotel Calíope. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../static/js/main.js"></script>
    <script src="../../../../static/js/calendario.js"></script>
    <script src="../../../static/js/ciudades/california.js"></script>
    <script src="../../../static/js/ciudades/carrousel.js"></script>
</body>
</html>