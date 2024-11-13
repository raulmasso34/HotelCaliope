<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../static/styles/general.css">
  <link rel="stylesheet" href="../../static/styles/index.css">
    <!--LINK FONT AWESOME ICONOS-->
    <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>

    <!-- CSS de Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- HTML (en la sección <head>) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">


  
  
  <title>Document</title>
</head>
<body>
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
              <a href="#">Academy</a>
              <a href="#">YouTube</a>
            </div>
        </li>
        <li class="dropdown">
          <a href="#" aria-label="Ver recursos de HubSpot">Ofertas</a>
          <div class="dropdown-content">
            <a href="#">Blog</a>
            <a href="#">Academy</a>
            <a href="#">YouTube</a>
          </div>
        </li>
        <li class="dropdown">
          <a href="#" aria-label="Ver más recursos de HubSpot">Actividades</a>
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
            <!-- Fecha de Llegada -->
            <label for="checkin">Fecha de Llegada:</label>
            <input type="date" id="checkin" name="checkin" required>

            <!-- Fecha de Salida -->
            <label for="checkout">Fecha de Salida:</label>
            <input type="date" id="checkout" name="checkout" required>

            <!-- Tipo de Habitación -->
            <label for="tipo_habitacion">Tipo de Habitación:</label>
            <select id="tipo_habitacion" name="tipo_habitacion" required>
                <option value="sencilla">Sencilla</option>
                <option value="doble">Doble</option>
                <option value="suite">Suite</option>
            </select>
            <!--
            
            <div class="personas">
                <label class="personas-label" onclick="togglePersonas()">Seleccionar Tipo de Persona</label>
                <div class="personas-content" id="personas-content">
                    
                    <!-- Selección de tipo de persona 
                    <select id="tipo_persona" name="tipo_persona" onchange="mostrarCantidad()">
                    <option value="niños">Niños</option>
                    <option value="adultos">Adultos</option>
                    <option value="abuelos">Abuelos</option>
                    </select>

                    <!-- Contador de la cantidad 
                    <div class="counter-container" id="cantidad-container">
                    <label for="cantidad">Cantidad:</label>
                    <button type="button" onclick="decrement('cantidad')">-</button>
                    <input type="number" id="cantidad" name="cantidad" value="1" min="1" readonly>
                    <button type="button" onclick="increment('cantidad')">+</button>
                    </div>
                </div>
            </div>
            -->
            

            <!-- Botón de Envío -->
            <button type="submit">Reservar Ahora</button>
        </form>
    </div>

    <!--CAJA/ SECCIÓN DE LA DESCRIPCIÓN-->
    <div class="desc-box">
        <div class="left-desc">
            <strong><H1> ¿PORQUE TENEMOS LOS MEJORES HOETELES?</H1></strong>
            <div class="contenido-desc">
                <p>En Hoteles Caliope, ofrecemos una experiencia inigualable porque sabemos que cada detalle cuenta. Nos enorgullece brindar instalaciones de primer nivel, diseño sofisticado y una atmósfera acogedora que invita a la relajación. Nuestros hoteles están ubicados en destinos exclusivos, con vistas impresionantes y servicios personalizados. Nuestro equipo de profesionales apasionados está listo para atenderte, asegurándose de que disfrutes de una experiencia llena de comodidad y lujo. ¡En Hoteles Caliope, transformamos tu viaje en un momento inolvidable!</p>
            </div>
            <button type="submit">Reservar Ahora</button>  
        </div>
        
        <div class="right-desc">
            <!--AÑADIR CARRUSEL DE FOTOS-->

            <div class="carousel">
                <div class="carousel-images">
                    <img src="../../static/img/hotel1.jpg" alt="Foto 1">
                    <img src="../../static/img/hotel2.jpg" alt="Foto 2">
                    <img src="../../static/img/hotel3.jpg" alt="Foto 3">
                    <img src="../../static/img/hotel4.jpg" alt="Foto 4">
                    <script src="../../static/js/carrusel_index.js"></script>
                </div>
            </div>
        
         </div>
    </div>

  

  <!-- Script de inicialización de Flatpickr -->
 
 

  <footer>
  </footer>

  <script src="../../static/js/personas.js"></script>
  <script src="../../static/js/calendario.js"></script>
</body>
</html>
