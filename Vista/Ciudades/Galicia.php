<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../static/styles/general.css">
  <link rel="stylesheet" href="../../static/styles/index.css">
  <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="../../static/js/carrusel_index2.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="../../static/styles/ciudades/newyork.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
  <title>Hoteles Caliope</title>
</head>
<body>
    <div class="background-carousel">
        <header>
            <section>
                <a href="../Inicio/index.php" aria-label="Ir a la página principal">
                    <img class="logo-header" src="../../static/img/logo.png" alt="Logo de Hotel Caliope">
                </a>
            </section>
            <nav id="menu" class="menu">
                <ul>
                    <li class="dropdown">
                        <a href="" aria-label="Ver ciudades disponibles">Ciudades</a>
                        <div class="dropdown-content">
                            <a href="../Ciudades/NewYork.php">New York</a>
                            <a href="../Ciudades/California.php">California</a>
                            <a href="../Ciudades/Florida.php">Florida</a>
                            <a href="../Ciudades/Tossa.php">Tossa De Mar</a>
                            <a href="../Ciudades/Pirineos.php">Pirineos</a>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" aria-label="Ver ofertas">Ofertas</a>
                        <div class="dropdown-content">
                            <a href="#">Blog</a>
                            <a href="#">Academy</a>
                            <a href="#">YouTube</a>
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
    
</section>
<section id="ciudad" class="ciudad">
  <div id="imagen-ny" class="imagen-ny">
    <img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="newyork">
  </div>
  <div id="descripcion-ciudad" class="descripcion-ciudad">
    <h3 id="titulo-desc">NUEVA YORK</h3>
    <p id="descripcion">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    <button id="sabermas-descripcion">Saber mas</button>
  </div>
</section>

<section id="tres-imagenes" class="tres-imagenes">
<section id="contenido">
    <div id="imagenes">
        <img src="../../static/img/ciudades/nuevayork/ny.jpeg"" alt="contenido">
    </div>
    <div>
        <p id="texto-contenido">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <button id="boton-contenido">ir</button></div>
</section>
<section id="contenido">
    <div id="imagenes">
    <img src="../../static/img/ciudades/nuevayork/ny.jpeg"" alt="contenido">
    </div>
    <div>
        <p id="texto-contenido">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        <button id="boton-contenido">ir</button>
    </div>
</section>
<section id="contenido">
    <div id="imagenes">
    <img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="contenido">
    </div>
    <div>
        <p id="texto-contenido">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
    <button id="boton-contenido">ir</button>
    </div>
</section>
</section>

<section id="galeria">
<section id="imagen-grande">
<img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="imagen1">
</section>
<section id="imagenes-peques">
<div id="imagen1"><img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="imagen2"></div>
<div id="imagen2"><img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="imagen3"></div>
<div id="imagen3"><img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="imagen4"></div>
<div id="imagen4"><img src="../../static/img/ciudades/nuevayork/ny.jpeg" alt="imagen5"></div>
</section>
</section>
  
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
</html>