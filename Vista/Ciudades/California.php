<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../static/styles/general.css">
  <link rel="stylesheet" href="../../static/styles/ciudades/california.css">
  <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">

    <!--SCRIPTS PARA CARROUSELS-->
    <script src="../../../static/js/index/personas.js"></script>
    <script src="../../../static/js/calendario.js"></script>
    <script src="../../static/js/ciudades/california.js"></script>
    <script src="../../../static/js/index/carrusel_index2.js"></script>

  <title>Hoteles Caliope</title>
</head>
<body>

    <div class="background-carousel">
        <header>
            <section>
                <a href="../Inicio/index.php" aria-label="Ir a la página principal">
                <img class="logo-header"  src="../../static/img/logo-blanco.png" alt="hotel caliope logo blanco">
                </a>
            </section>
            <nav id="menu" class="menu">
                <ul>
                    <li class="dropdown">
                        <a href="" aria-label="Ver ciudades disponibles">Ciudades</a>
                        <div class="dropdown-content">
                            <a href="../Ciudades/NewYork.php">New York</a>
                            <a href="#">Pirineos</a>
                            <a href="#">Galicia</a>
                            <a href="#">California</a>
                            <a href="#">Floridas</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="../Ofertas/ofertasIndex.php" aria-label="Ver ofertas">Ofertas</a>
                        <div class="dropdown-content">
                            <a href="#">Packs</a>
                            <a href="#">Temporadas</a>
                            <a href="#">De ultimo minuto</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" aria-label="Ver actividades">Actividades</a>
                        <div class="dropdown-content">
                            <a href="#">Blog</a>
                            <a href="#">Academy</a>
                            <a href="#">YouTube</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <a class="login-btn" href="../InicioSesion/login.php">
                <i class="fa-solid fa-user fa-3x"></i>
            </a>
        </header>

        <div class="form-reservas">
            <h1>Haz tu reserva!</h1>
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
    </div>

    <div class="general-box">

        <div class="left-cali">
        <strong>
            <h1>CALIFORNIA, <br>UNA EXPERIENCIA INOLVIDABLE</h1>
        </strong>
                
            <div class="contenido-desc">
                   
                <p>
                    En Hoteles Caliope, ofrecemos una experiencia inigualable porque sabemos que cada detalle cuenta. Nos enorgullece brindar instalaciones de primer nivel, diseño sofisticado y una atmósfera acogedora que invita a la relajación. Nuestros hoteles están ubicados en destinos exclusivos, con vistas impresionantes y servicios personalizados. Nuestro equipo de profesionales apasionados está listo para atenderte, asegurándose de que disfrutes de una experiencia llena de comodidad y lujo. ¡En Hoteles Caliope, transformamos tu viaje en un momento inolvidable!
                </p>
            </div>

        </div>
        <div class="right-cali">
            <div class="carousel">
                <div class="carousel-images">
                    <img src="../../static/img/ciudades/california/california1.jpg" alt="Foto 1">
                    <img src="../../static/img/ciudades/california/california2.jpg" alt="Foto 2">
                    <img src="../../static/img/ciudades/california/california.jpg" alt="Foto 3">
                   s
                </div>
            </div>
        </div>

    </div>














    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="../../static/img/logo-blanco.png" alt="hotel caliope logo blanco">
                <p>Hotel Caliope - Un viaje de lujo</p>
            </div>

            <div class="footer-links">
                <h4>Enlaces rápidos</h4>
                <ul>
                    <li><a href="../Inicio/index.php">Inicio</a></li>
                    <li><a href="../Ciudades/NewYork.php">Ciudades</a></li>
                    <li><a href="#">Ofertas</a></li>
                    <li><a href="#">Actividades</a></li>
                    <li><a href="../InicioSesion/login.php">Iniciar sesión</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contacto</h4>
                <p><strong>Teléfono:</strong> +123 456 789</p>
                <p><strong>Email:</strong> contacto@hotelcaliope.com</p>
                <p><strong>Dirección:</strong> Calle Ficticia, 123, Ciudad, País</p>
            </div>

            <div class="footer-socials">
                <h4>Síguenos</h4>
                <div class="social-icons">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Hotel Caliope. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</head>