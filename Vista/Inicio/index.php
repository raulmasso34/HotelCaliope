<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../static/styles/general.css">
  <link rel="stylesheet" href="../../static/styles/index.css">
  <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
  <!-- CSS de Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  
  
  <title>Document</title>
</head>
<body>
  <header>
    <section>
      <a href="../Inicio/index.php" aria-label="Ir a la página principal">
        <img src="../../static/img/logo.png" alt="Logo de Hotel Caliope">
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

        </div>
        <div class="right-desc">

        </div>
    </div>

  

  <!-- Script de inicialización de Flatpickr -->
 
 

  <footer>
  </footer>

  <script src="../../static/js/personas.js"></script>
  <script src="../../static/js/calendario.js"></script>
</body>
</html>
