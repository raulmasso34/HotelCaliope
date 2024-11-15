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
  <script src="../../static/js/index/carrusel_index2.js"></script>
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

</head>
</body>