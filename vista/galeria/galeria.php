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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/galeria.css">
    <link rel="stylesheet" href="../../static/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <title>Document</title>
</head>

<body>
    <header class="main-header1">
    <div class="carousel">
        <img class="carousel-background" src="../../static/img/florida/florida3.jpg" alt="Fondo 1">
        <img class="carousel-background" src="../../static/img/florida/florida4.jpg" alt="Fondo 2">
        <img class="carousel-background" src="../../static/img/florida/florida5.jpg" alt="Fondo 3">
    </div>
       
        <section class="main-up">
            <div class="main-up-left">
               <a href="../index.php"><img src="../../static/img/logo.png" alt="Imagen secundaria"></a> 
            </div>
            <div class="main-up-right">
                <div class="links">
                    <a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
                    <div class="dropdown">
                        <a href="#" class="dropbtn">Hoteles</a>
                        <div class="dropdown-content">
                            <div class="dropdown-section">
                                <h4>Europa</h4>
                                <a href="../../vista/ciudades/Europa/Galicia.php">Galicia</a>
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
                    <a href="../../vista/galeria/galeria.php">Galeria</a>
                <a href="../../vista/ofertas/ofertas.php">Ofertas</a>
                <a href="../../vista/Contacto/contacto.php">Contacto</a>
            </div>
        

        </section>
        <section class="main-center">
            <div class="center-up">
                <div class="center-up-up">
                </div>
                <div class="center-up-down">
                    
                    <p class="titleGallery">GALLERY</p>
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


    <div class="main">
        <h1>NUESTRA GALERIA</h1>

        <div class="galerias">
            
            <div class="galeriaGen">
                <h1>GALICIA</h1>
                <div class="galeriaGen2">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                </div>
            </div>
            <div class="galeriaGen">
                <h1>TOSSA DE MAR</h1>
            <div class="galeriaGen2">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                </div>
            </div>
            <div class="galeriaGen">
                <h1>PIRINEOS</h1>
            <div class="galeriaGen2">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                </div>
            </div>
            <div class="galeriaGen">
                <h1>FLORIDA</h1>
            <div class="galeriaGen2">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                </div>
            </div>
            <div class="galeriaGen">
                <h1>CALIFORNIA</h1>
            <div class="galeriaGen2">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                </div>
            </div>
            <div class="galeriaGen">
                <h1>NEW YORK</h1>
            <div class="galeriaGen2">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                    <img class="gal" src="../../static/img/california/california.jpg" alt="">
                </div>
            </div>
    
        </div>
    </div>



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
                    <form class="news-content  method="POST" action="../controller/clients/LoginController.php">
                    <label for="Usuari">Usuario:</label>
                        <input type="text" name="Usuari" id="Usuari" required>

                        <label for="DNI">DNI:</label>
                        <input type="text" name="DNI" id="DNI" required>

                        <label for="Password">Contraseña:</label>
                        <input type="password" name="Password" id="Password" required>

                        <button class="login-btn" type="submit">Iniciar sesión</button>
                    </form>
                    <div class="news-footer">
                        <p>¿No tienes cuenta? <a href="../vista/Clientes/registre.php">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>


    </section>


    <footer class="main-footer">
        <div class="footer-box">
            <!-- Sección: Sobre el Hotel -->
            <div class="footer-sec">
                <h1>SOBRE LOS HOTELS</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam incidunt iste dolorum expedita eligendi omnis quia facere quod autem! Voluptatem.</p>
                <a href="../vista/index.php"><img class="img-footer" src="../static/img/logo_blanco.png" alt=""></a>
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
                <h1>LINKS</h1>
                <div class="links-footer">
                    <a href="#">Sobre nosotros</a>
                    <a href="#">Servicios</a>
                    <a href="#">Hoteles</a>
                </div>
            </div>

            <!-- Sección: Contacto y Redes Sociales -->
            <div class="footer-sec">
                <h1>DÓNDE NOS ENCONTRAMOS</h1>
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
            <p>Lorem ipsum dolor sit ame</p>
        </div>
    </footer>

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../../static/js/main.js"></script>

</body>
</html> 