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
    <link rel="stylesheet" href="../../../static/css/style.css">
    <link rel="stylesheet" href="../../../static/css/ciudades/newyork.css">
    
    <title>PIRINEOS</title>
</head>
<body>
<header class="main-header">
    <div class="carousel">
        <img class="carousel-background" src="../../../static/img/florida/florida3.jpg" alt="Fondo 1">
        <img class="carousel-background" src="../../../static/img/florida/florida4.jpg" alt="Fondo 2">
        <img class="carousel-background" src="../../../static/img/florida/florida5.jpg" alt="Fondo 3">
    </div>
       
        <section class="main-up">
            <div class="main-up-left">
                <img src="../../../static/img/logo.png" alt="Imagen secundaria">
            </div>
            <div class="main-up-right">
    <div class="links">
        <a href="#">Sobre nosotros</a>
        <a href="#">Servicios</a>
        <div class="dropdown">
            <a href="#" class="dropbtn">Hoteles</a>
            <div class="dropdown-content">
                <div class="dropdown-section">
                    <h4>Europa</h4>
                    <a href="../Europa/Galicia.php">Galicia</a>
                    <a href="../Europa/Tossa.php">Tossa de Mar</a>
                </div>
                <div class="dropdown-section">
                    <h4>USA</h4>
                    <a href="../USA/NuevaYork.php">NuevaYork</a>
                    <a href="../USA/Florida.php">Florida</a>
                    <a href="../USA/California.php">California</a>
                   
                </div>
            </div>
        </div>
    </div>
    </div>

        </section>
        <section class="main-center">
            <div class="center-up">
                <div class="center-up-up">
                <span style="font-size: 20px;  color: rgb(230, 182, 11);">
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
                
                <div class="formulario">
                    <form action="" method="post">
                        <label for="checkin">Fecha de Llegada:</label>
                        <input type="date" id="checkin" name="checkin" required>
                        <label for="checkout">Fecha de Salida:</label>
                        <input type="date" id="checkout" name="checkout" required>
                        <label for="tipo_habitacion">Tipo de Habitación:</label>
                        <select id="tipo_habitacion" name="tipo_habitacion" required>
                            <option value="sencilla">Sencilla</option>
                            <option value="doble">Doble</option>
                            <option value="suite">Suite</option>
                        </select>
                        <button type="submit">Reservar Ahora</button>
                    </form>
                </div>
            </div>
    
          
        </section>
</header>

<section class="main-main">
        <div class="main-box">
            <div class="main-box-box">
                <div class="stars-main">
                    <span style="font-size: 20px;  color: rgb(230, 182, 11);">
                    <i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star "></i>
                    </span>
                </div>
                <div class="main-title">
                    <h3>LOREM IST AME TUU </h3>
                    <h1>Lorem ipsum dolor </h1>
                </div>
                <div class="main-txt">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem adipisci soluta alias voluptatem facere? Vitae iure ratione saepe quos blanditiis fugiat molestias, maxime reprehenderit harum. Quod molestiae consectetur perferendis deserunt.</p>

                    <div class="main-botones">
                        <button>VER MAS</button>
                        <button>Reservar</button>
                    </div>
                   
                </div>
            </div>
            <div class="main-box-right">
                <div class="img-left">
                    <img class="img-main" src="../../../static/img/florida/florida1.jpg" alt="">
                </div>
                <div class="img-right">
                    <img class="img-main" src="../../../static/img/florida/florida3.jpg" alt="">
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

<section class="ofertas">
<h1>OFERTAS</h1>
  <div class="carousels-container-ofertas">
    <!-- Primer carrusel -->
    <div class="carousels-ofertas">
      <button class="left-btn-ofertas" id="left-btn1-ofertas"><i class="arrow-ofertas"></i></button>
      <img id="carousel1-ofertas" src="" alt="">
      <button class="right-btn-ofertas" id="right-btn1-ofertas"><i class="arrow-ofertas"></i></button>
      <h2>Habitaciones</h2>
      <p>Descubre nuestras cómodas habitaciones con increíbles vistas.</p>
    </div>
    
    <!-- Segundo carrusel -->
    <div class="carousels-ofertas">
      <button class="left-btn-ofertas" id="left-btn2-ofertas"><i class="arrow-ofertas"></i></button>
      <img id="carousel2-ofertas" src="" alt="">
      <button class="right-btn-ofertas" id="right-btn2-ofertas"><i class="arrow-ofertas"></i></button>
      <h2>Actividades</h2>
      <p>Explora las actividades que ofrecemos para disfrutar al máximo.</p>
    </div>

    <div class="carousels-ofertas">
      <button class="left-btn-ofertas" id="left-btn3-ofertas"><i class="arrow-ofertas"></i></button>
      <img id="carousel3-ofertas" src="" alt="">
      <button class="right-btn-ofertas" id="right-btn3-ofertas"><i class="arrow-ofertas"></i></button>
      <h2>SERVICIOS</h2>
      <p>Explora los servicios que ofrecemos para disfrutar al máximo.</p>
    </div>
  </div>
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

<footer class="main-footer">
        <div class="footer-box">
            <!-- Sección: Sobre el Hotel -->
            <div class="footer-sec">
                <h1>Sobre el hotel</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam incidunt iste dolorum expedita eligendi omnis quia facere quod autem! Voluptatem.</p>
                <a href="../../../vista/index.php"><img class="img-footer" src="../../../static/img/logo_blanco.png" alt="logo-blanco"></a>
                <div class="language-selector">
                <select id="language-select" onchange="changeLanguage()">
                    <option value="es">Español</option>
                    <option value="en">English</option>
                    <option value="fr">Français</option>
                </select>
                </div>
            </div>

            <!-- Sección: Links -->
            <div class="footer-sec">
                <h1>Links</h1>
                <div class="links-footer">
                    <a href="#">Sobre nosotros</a>
                    <a href="#">Servicios</a>
                    <a href="#">Hoteles</a>
                </div>
            </div>

            <!-- Sección: Contacto y Redes Sociales -->
            <div class="footer-sec">
                <h1>Dónde nos encontramos</h1>
                <div class="sec-tres">
                    <p>Calle xxx 99999 <br> Lorem ipsum, España</p>
                    <span class="contact-info">
                        <i class="fa-solid fa-phone"></i> 999 999 999
                    </span>
                    <span class="contact-info">
                        <i class="fa-solid fa-envelope"></i> hotelcalope@gmail.com
                    </span>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="privacidad">
            
        </div>
    </footer>

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../static/js/main.js"></script>
    <script src="../../../../static/js/calendario.js"></script>
    <script src="../../../static/js/ciudades/newyork.js"></script>
    <script src="../../../static/js/ciudades/carrousel.js"></script>
</body>
</html>