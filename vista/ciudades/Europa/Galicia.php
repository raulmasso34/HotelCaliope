<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../static/css/style.css">
    <link rel="stylesheet" href="../../../static/css/ciudades/galicia.css">
   <!--  <script src="../../../static/js/main.js"></script> -->
    <script src="../../../../static/js/calendario.js"></script>
    <script src="../../../static/js/ciudades/galicia.js"></script>
    <script src="../../../../static/js/index/carrusel_index2.js"></script>
    <title>Galicia</title>
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
                    <a href="#">Tossa de Mar</a>
                    <a href="#">Pirineos</a>
                </div>
                <div class="dropdown-section">
                    <h4>USA</h4>
                    <a href="#">Florida</a>
                    <a href="#">California</a>
                    <a href="#">Nueva York</a>
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


<section class="dispo">

</section>

<section class="servicios">

</section>

<section class="ofertas">

</section>

<section class="contacto">

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
</body>
</html>