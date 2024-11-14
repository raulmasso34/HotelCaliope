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
                            <a href="#">Pirineos</a>
                            <a href="#">Galicia</a>
                            <a href="#">California</a>
                            <a href="#">Floridas</a>
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
    

    <!--CAJA/ SECCIÓN DE LA DESCRIPCIÓN-->
    <div class="desc-box">
            <div class="left-desc">
                <strong><h1>¿POR QUÉ TENEMOS LOS MEJORES HOTELES?</h1></strong>
                <div class="contenido-desc">
                    <p>En Hoteles Caliope, ofrecemos una experiencia inigualable porque sabemos que cada detalle cuenta. Nos enorgullece brindar instalaciones de primer nivel, diseño sofisticado y una atmósfera acogedora que invita a la relajación. Nuestros hoteles están ubicados en destinos exclusivos, con vistas impresionantes y servicios personalizados. Nuestro equipo de profesionales apasionados está listo para atenderte, asegurándose de que disfrutes de una experiencia llena de comodidad y lujo. ¡En Hoteles Caliope, transformamos tu viaje en un momento inolvidable!</p>
                </div>
                <button type="submit">Reservar Ahora</button>  
            </div>
            <div class="right-desc">
                <div class="carousel">
                    <div class="carousel-images">
                        <img src="../../static/img/index/hotel1.jpg" alt="Foto 1">
                        <img src="../../static/img/index/hotel2.jpg" alt="Foto 2">
                        <img src="../../static/img/index/hotel3.jpg" alt="Foto 3">
                        <img src="../../static/img/index/hotel4.jpg" alt="Foto 4">
                        <img src="../../static/img/index/hotel5.jpg" alt="Foto 4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="desc-hoteles">
        <div class="hoteles">
        <div class="hoteles-img">
            <img src="../../static/img/index/ny.jpg" alt="Foto 1" class="active">
            <img src="../../static/img/index/ny2.jpg" alt="Foto 2">
            <img src="../../static/img/index/ny3.jpg" alt="Foto 3">
            <img src="../../static/img/hotel4.jpg" alt="Foto 4">
            
            <!-- Botones para mover las imágenes -->
            <button class="carousel-control prev">❮</button>
            <button class="carousel-control next">❯</button>
        </div>
            <div class="desc-ciudades">
                <h1>NEW YORK</h1>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse totam explicabo consequuntur reiciendis distinctio fugit quaerat porro repellendus maxime natus. Voluptates qui reiciendis dolor fuga exercitationem quidem aspernatur, debitis amet, accusantium quae, et asperiores dignissimos ullam velit aperiam ipsum. </p>
                <button class="button-desc-ciudades">Ver mas</button>
                
            </div>
        </div>
        <div class="hoteles">
            <div class="hoteles-img">
                
                <img src="../../static/img/index/tossa2.jpg" alt="Foto 2">
                <img src="../../static/img/index/tossa3.jpg" alt="Foto 3">
                <img src="../../static/img/index/tossa4.jpg" alt="Foto 4">
                <button class="carousel-control prev" onclick="prevSlide()">❮</button>
                <button class="carousel-control next" onclick="nextSlide()">❯</button>
            </div>
            
            <div class="desc-ciudades">
                <h1>TOSA DE MAR</h1>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse totam explicabo consequuntur reiciendis distinctio fugit quaerat porro repellendus maxime natus. Voluptates qui reiciendis dolor fuga exercitationem quidem aspernatur, debitis amet, accusantium quae, et asperiores dignissimos ullam velit aperiam ipsum. </p>
                <button class="button-desc-ciudades">Ver mas</button>
                
            </div>
        </div>
        <div class="hoteles">
            <div class="hoteles-img">
                    <img src="../../static/img/index/index-img1.jpg" alt="Foto 1" class="">
                    <img src="../../static/img/index/index-img2.jpg" alt="Foto 2">
                    <img src="../../static/img/index/index-img3.jpg" alt="Foto 3">
                    <button class="carousel-control prev" onclick="prevSlide()">❮</button>
                    <button class="carousel-control next" onclick="nextSlide()">❯</button>
            </div>
            <div class="desc-ciudades">
                <h1>PIRINEOS</h1>

                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Esse totam explicabo consequuntur reiciendis distinctio fugit quaerat porro repellendus maxime natus. Voluptates qui reiciendis dolor fuga exercitationem quidem aspernatur, debitis amet, accusantium quae, et asperiores dignissimos ullam velit aperiam ipsum. </p>
                <button class="button-desc-ciudades">Ver mas</button>
                    
            </div>
            </div>
        </div>
    </div>

    <footer></footer>

    <script src="../../static/js/personas.js"></script>
    <script src="../../static/js/calendario.js"></script>
    <script src="../../static/js/carrusel_index.js"></script>
</body>
</html>