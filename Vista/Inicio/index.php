<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../static/styles/general.css">
  <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
  <header>
    <section>
      <a href="../Inicio/index.php" aria-label="Ir a la página principal"><img src="../../static/img/logo.png" alt="Logo de Hotel Caliope"></a>
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
                <a href="#" aria-label="Ver recursos de HubSpot">HubSpot Resources</a>
                  <div class="dropdown-content">
                    <a href="#">Blog</a>
                    <a href="#">Academy</a>
                    <a href="#">YouTube</a>
                  </div>
              </li>
              <li class="dropdown">
                <a href="#" aria-label="Ver más recursos de HubSpot">HubSpot Resources</a>
                <div class="dropdown-content">
                  <a href="#">Blog</a>
                  <a href="#">Academy</a>
                  <a href="#">YouTube</a>
                </div>
              </li>
              
            </ul>

        </nav>
      <a href="../InicioSesion/login.php"><i class="fa-solid fa-user fa-2x"></i></a>
  </header>

    <main>
      <section>
      <div class="form-container">
          <h2>Reserva tu Estancia</h2>
          <form action="#" method="post">
              <!-- Selección de ciudad -->
              <div class="form-group">
                  <label for="ciudad">Ciudad:</label>
                  <select id="ciudad" name="ciudad" required>
                      <option value="">Selecciona una ciudad</option>
                      <option value="madrid">Madrid</option>
                      <option value="barcelona">Barcelona</option>
                      <option value="sevilla">Sevilla</option>
                      <option value="valencia">Valencia</option>
                      <option value="bilbao">Bilbao</option>
                  </select>
              </div>

              <!-- Selección de fechas de check-in y check-out en una fila -->
              <div class="form-group-horizontal">
                  <div class="form-group">
                      <label for="checkin">Fecha de Check-In:</label>
                      <input type="date" id="checkin" name="checkin" required>
                  </div>
                  <div class="form-group">
                      <label for="checkout">Fecha de Check-Out:</label>
                      <input type="date" id="checkout" name="checkout" required>
                  </div>
              </div>

              <!-- Selección de habitación -->
              <div class="form-group">
                  <label for="habitacion">Tipo de Habitación:</label>
                  <select id="habitacion" name="habitacion" required>
                      <option value="">Selecciona una opción</option>
                      <option value="individual">Individual</option>
                      <option value="doble">Doble</option>
                      <option value="suite">Suite</option>
                  </select>
              </div>

              <!-- Botón de envío -->
              <button type="submit">Reservar</button>
          </form>
      </div>
    </section>

  </main>


  <footer>

  </footer>
</body>
</html>