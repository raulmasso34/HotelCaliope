<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Limpiar las variables de sesión si el usuario ha vuelto al formulario
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reset']) && $_GET['reset'] == 'true') {
    unset($_SESSION['location']);
    unset($_SESSION['checkin']);
    unset($_SESSION['checkout']);
    unset($_SESSION['guests']);
    unset($_SESSION['habitacionId']);
}

// Al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar los datos del formulario en la sesión
    $_SESSION['location'] = $_POST['location'];
    $_SESSION['checkin'] = $_POST['checkin'];
    $_SESSION['checkout'] = $_POST['checkout'];
    $_SESSION['guests'] = $_POST['numero_personas'];
    $_SESSION['habitacionId'] = $_POST['habitacionId'];

    // Redirigir a la página de reservas para mostrar los detalles del hotel
    header('Location: ../vista/reservas.php');
    exit();
}

// Incluir el controlador
require_once __DIR__ . '../../../controller/reserva/reservaController.php';

// Crear una instancia del controlador
$controller = new ReservaController();

// Verificar si la instancia se ha creado correctamente
if ($controller !== null) {
    // Obtener los países a través del controlador
    $paises = $controller->obtenerPaises();

    // Verificar si se han obtenido los países y hacer algo con ellos
    
} 
$habitaciones = $controller->obtenerHabitaciones() ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Hoteles Caliope</title>
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">

    <!-- Fuentes de Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:wght@200..1000&family=Old+Standard+TT:wght@400;700&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="../../static/css/habitaciones/habitaciones.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <!-- Scripts -->
   
    <script src="../../static/js/habitaciones/habitaciones.js"></script>
</head>

<body>
    <header class="main-header">

        <div class="carousel">
            <img class="carousel-background" src="../../static/img/florida/florida3.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../../static/img/florida/florida4.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../../static/img/florida/florida5.jpg" alt="Fondo 3">
        </div>
        
        <section class="main-up">
            <div class="main-up-left">
                <img src="../../static/img/logo.png" alt="Imagen secundaria">
            </div>

            <div class="main-up-right">
                <div class="links">
                    <a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
                    <div class="dropdown">
                        <a href="#" class="dropbtn">Hoteles</a>
                        <div class="dropdown-content">
                            <div class="dropdown-section">
                                <h4>Europa</h4>
                                <a href="../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                <a href="../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                                <a href="../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                            </div>
                            <div class="dropdown-section">
                                <h4>USA</h4>
                                <a href="../vista/ciudades/USA/Florida.php">Florida</a>
                                <a href="../vista/ciudades/USA/California.php">California</a>
                                <a href="../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                            </div>
                        </div>
                    </div>

                    <a href="../vista/galeria/galeria.php">Galería</a>
                    <a href="../vista/ofertas/ofertas.php">Ofertas</a>
                    <a href="../vista/Contacto/contacto.php">Contacto</a>
                    
                    <!-- Contenedor del perfil -->
                    <div class="dropdown-perfil">
                        <a class="icon-perfil" href="javascript:void(0);">
                        <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
                        
                        </a>
                        <div class="dropdown-perfil-content">
                            <a href="../vista/Clientes/login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                            </a>
                            <a href="../vista/Clientes/perfil.php">
                                <i class="bi bi-person"></i> Perfil
                            </a>
                            <a href="../controller/clients/LoginController.php?action=logout" style="color: red;"> 
                                <i class="bi bi-box-arrow-right" style="color: red;"></i> Cerrar sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menú hamburguesa (solo visible en pantallas pequeñas) -->
            <div id="menu-toggle" class="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <!-- Menú desplegable -->
            <div class="mobile-menu">
                <a href="../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                <a href="../vista/galeria/galeria.php">Galería</a>
                <a href="../vista/ofertas/ofertas.php">Ofertas</a>
                <a href="../vista/Contacto/contacto.php">Contacto</a>
                <a href="../vista/Clientes/login.php">Iniciar sesión</a>
                <a href="../vista/Clientes/perfil.php">Perfil</a>
                
                <!-- Enlace para Hoteles con dropdown -->
                <div class="dropdown-mobile">
                    <a href="#" class="dropbtn">Hoteles</a>
                    <div class="dropdown-content-mobile">
                        <div class="dropdown-section">
                            <h4>Europa</h4>
                            <a href="../vista/ciudades/Europa/Galicia.php">Galicia</a>
                            <a href="../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                            <a href="../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                        </div>
                        <div class="dropdown-section">
                            <h4>USA</h4>
                            <a href="../vista/ciudades/USA/Florida.php">Florida</a>
                            <a href="../vista/ciudades/USA/California.php">California</a>
                            <a href="../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                        </div>
                    </div>
                </div>
            </div>


        </section>


        <section class="main-center">
            <div class="center-up">
                <div class="center-up-up">
                    <span style="font-size: 20px; color: rgb(230, 182, 11);">
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
                    <div class="reservation-form">
                    <form id="reservationForm" action="../vista/reservas.php" method="post" class="reservation-form">
                        <!-- Lugar -->
                        <div class="form-group">
                            <label for="location"><i class="fa-solid fa-map-marker-alt"></i> Lugar</label>
                            <select id="location" name="location" class="form-select" required>
                                <?php foreach ($paises as $pais): ?>
                                    <option value="<?php echo $pais['Id_Pais']; ?>">
                                        <?php echo $pais['Pais']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Fecha Check-in -->
                        <div class="form-group">
                            <label for="checkin"><i class="fa-solid fa-calendar-check"></i> Fecha de Check-in</label>
                            <input type="date" id="checkin" name="checkin" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                        </div>

                        <!-- Fecha Check-out -->
                        <div class="form-group">
                            <label for="checkout"><i class="fa-solid fa-calendar-xmark"></i> Fecha de Check-out</label>
                            <input type="date" id="checkout" name="checkout" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                        </div>

                        <!-- Número de Personas -->
                        <div class="form-group">
                            <label for="numero_personas"><i class="fa-solid fa-users"></i> Número de Personas</label>
                            <input type="number" id="numero_personas" name="numero_personas" class="form-control" min="1"
                                value="<?php echo isset($_SESSION['numero_personas']) ? $_SESSION['numero_personas'] : ''; ?>" required>
                        </div>

                        <!-- Botón de Reservar -->
                        <div class="form-group">
                            <button type="submit" id="submitBtn"><i class="fa-solid fa-bed"></i> Reservar</button>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </section>
    </header>
    
    <section class="habitaciones">
        <div class="container">
            <h2>Nuestras Habitaciones</h2>

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php 
                    // Agrupar habitaciones por tipo
                    $habitacionesPorTipo = [];
                    foreach ($habitaciones as $habitacion) {
                        $tipo = $habitacion['Tipo'];
                        if (!isset($habitacionesPorTipo[$tipo])) {
                            $habitacionesPorTipo[$tipo] = [];
                        }
                        $habitacionesPorTipo[$tipo][] = $habitacion;
                    }

                    // Mostrar un slide por cada tipo de habitación
                    foreach ($habitacionesPorTipo as $tipo => $listaHabitaciones):
                        // Ruta base para las imágenes
                        $basePath = "../../static/img/habitaciones/";

                        // Obtener el tipo de habitación y convertirlo en minúsculas con guiones bajos
                        $tipoHabitacion = strtolower(str_replace(' ', '_', $tipo));

                        // Definir las posibles rutas de imagen
                        $imagenes = [
                            "{$basePath}{$tipoHabitacion}.jpg",
                            "{$basePath}{$tipoHabitacion}1.jpg",   // Primera opción (imagen tipoHabitacion.jpg)
                            "{$basePath}{$tipoHabitacion}2.jpg",
                            "{$basePath}{$tipoHabitacion}3.jpg"
                            , // Segunda opción (tipoHabitacion2.jpg)
                            "{$basePath}default.jpg"             // Imagen por defecto
                        ];

                        // Variable para la imagen a mostrar (se define como una imagen predeterminada)
                        $imagenPath = "{$basePath}default.jpg";  // Imagen por defecto en caso de que no se encuentren otras

                        // Buscar la primera imagen existente en la lista
                        foreach ($imagenes as $img) {
                            if (file_exists($img)) {
                                $imagenPath = $img;
                                break;
                            }
                        }
                        ?>
                        <div class="swiper-slide">
                            <div class="habitacion-card">
                                <img src="<?php echo htmlspecialchars($imagenPath); ?>" alt="<?php echo htmlspecialchars($tipo); ?>" class="card-img-top">

                                <div class="habitacion-info">
                                    <h3><?php echo $tipo; ?></h3>
                                    <p><strong>Capacidad:</strong> <?php echo $listaHabitaciones[0]['Capacidad']; ?> personas</p>
                                    <p><strong>Precio:</strong> Desde $<?php echo $listaHabitaciones[0]['Precio']; ?> por noche</p>
                                    <a href="reservar.php?tipo=<?php echo urlencode($tipo); ?>" class="btn">Ver más</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Botones de navegación -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>


    <section class="preg-comunes">
        <div class="container">
            <h2>Preguntas Frecuentes</h2>
            
            <div class="faq">
                <div class="faq-item">
                    <button class="faq-question">¿Cómo puedo hacer una reserva?</button>
                    <div class="faq-answer">
                        <p>Puede realizar una reserva a través de nuestra página web o llamando directamente al hotel. También puede enviar un correo electrónico con su solicitud.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">¿El desayuno está incluido?</button>
                    <div class="faq-answer">
                        <p>Sí, el desayuno está incluido en todas nuestras tarifas, servido de 7:00 AM a 10:00 AM.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">¿Puedo cancelar mi reserva?</button>
                    <div class="faq-answer">
                        <p>Las cancelaciones se pueden hacer hasta 48 horas antes de la llegada sin ningún cargo. Pasado ese plazo, se aplicará una tarifa de cancelación.</p>
                    </div>
                </div>
                <!-- Agrega más preguntas aquí -->
            </div>
        </div>
    </section>




    <script src="../../static/js/habitaciones/habitaciones.js"></script>

    </body>
</html>