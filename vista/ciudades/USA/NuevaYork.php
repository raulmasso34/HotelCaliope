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
    <link rel="stylesheet" href="../../../static/css/ciudades/newyork.css">
    <link rel="shortcut icon" href="../../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <title>Nueva York</title>
</head>
<body>
<header class="main-header">
        <div class="carousel">
            <img class="carousel-background" src="../../../static/img/ny/ny7.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../../../static/img/ny/ny5.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../../../static/img/ny/ny8.jpg" alt="Fondo 3">
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
                                <a href="../../../vista/ciudades/USA/California.php">California</a>
                                <a href="#">Nueva York</a>
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
                    <h5>Descubre el Encanto de </h5>
                    <h1>NUEVA YORK</h1>
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
                <h1>Elegancia Urbana en Midtown Manhattan</h1>
            </div>
            <div class="main-txt">
                <p>Ubicado en el corazón de Nueva York, el Hotel Calíope ofrece una experiencia de lujo contemporáneo con vistas icónicas al skyline. Nuestras suites con diseño neoyorquino, el rooftop con barra de martinis y el spa urbano con tratamientos inspirados en Central Park le brindarán una estancia inolvidable. A pocos pasos de Times Square, Broadway y las mejores galerías de arte de la Quinta Avenida.</p>

                <div class="main-botones">
                        <button>DESCUBRIR</button>
                        <button><a href="../../galeria/galeria.php">GALERÍA</a></button>
                    </div>
            </div>
        </div>
        <div class="main-box-right">
            <div class="img-left">
                <img class="img-main" src="../../../static/img/ny/ny1.jpg" alt="Vista del skyline de Nueva York desde el Hotel Calíope">
            </div>
            <div class="img-right">
                <img class="img-main" src="../../../static/img/ny/ny4.jpg" alt="Lobby del hotel con diseño moderno y arte neoyorquino">
            </div>
        </div>
    </div>
</section>

<div id="hotelModal" class="hotel-modal">
    <div class="hotel-modal-content">
        <span class="close-btn">&times;</span>
        <div class="modal-body">
            <img id="modal-image" src="../../../static/img/ny/ny1.jpg" alt="Hotel Calíope" class="modal-image">
            <h2>HOTEL CALÍOPE</h2>
            <h3>Estilo y sofisticación en el corazón de Nueva York</h3>
            <p>En pleno Midtown Manhattan, el Hotel Calíope redefine el lujo urbano con un diseño vanguardista, vistas panorámicas y una experiencia neoyorquina inolvidable.</p>
            
            <div class="modal-details">
                <div class="detail-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>123 Madison Ave, Nueva York, NY</span>
                </div>
                <div class="detail-item">
                    <i class="fa-solid fa-star"></i>
                    <span>Clasificación: 5 estrellas</span>
                </div>
                <div class="detail-item">
                    <i class="fa-solid fa-wifi"></i>
                    <span>WiFi de alta velocidad</span>
                </div>
            </div>
            
            <div class="modal-amenities">
                <h4>Servicios destacados:</h4>
                <div class="amenities-list">
                    <span><i class="fa-solid fa-city"></i> Terraza con vistas a la ciudad</span>
                    <span><i class="fa-solid fa-utensils"></i> Restaurante gourmet internacional</span>
                    <span><i class="fa-solid fa-dumbbell"></i> Gimnasio 24h</span>
                    <span><i class="fa-solid fa-martini-glass-citrus"></i> Sky bar en la azotea</span>
                </div>
            </div>
            
            <button class="modal-contact-btn"><a href="../../Contacto/contacto.php">CONTACTAR</a></button>
        </div>
    </div>
</div>


<!-- Coloca el script al final del cuerpo -->
<section class="dispo">
  <h1>Habitaciones y Actividades</h1>
  <div class="carousels-container">
    <!-- Primer carrusel -->
    <div class="carousels">
      <button class="left-btn" id="left-btn1"><i class="arrow"></i></button>
      <img id="carousel1" src="" alt="Habitaciones del hotel">
      <button class="right-btn" id="right-btn1"><i class="arrow"></i></button>
      <h2>Habitaciones</h2>
      <p>Descubre nuestras cómodas habitaciones con increíbles vistas.</p>
    </div>
    
    <!-- Segundo carrusel -->
    <div class="carousels">
    <button class="left-btn" id="left-btn2"><i class="arrow"></i></button>
    <img id="carousel2" src="" alt="Actividades del hotel">
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
    <script src="../../../static/js/ciudades/newyork.js"></script>
 
</body>
</html>