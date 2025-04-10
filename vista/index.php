<?php
session_start();
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
    header('Location: ../vista/lugares.php');
    exit();
}

// Incluir el controlador
require_once __DIR__ . '/../controller/reserva/reservaController.php';

// Crear una instancia del controlador
$controller = new ReservaController();

// Verificar si la instancia se ha creado correctamente
if ($controller !== null) {
    // Obtener los países a través del controlador
    $paises = $controller->obtenerPaises();

    // Verificar si se han obtenido los países y hacer algo con ellos
    
} 
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
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../static/css/GENERAL/footer.css">
    <link rel="stylesheet" href="../static/css/GENERAL/header.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <header class="main-header">

    
        <section class="main-up">
            <div class="main-up-left">
                <img src="../static/img/logo_blanco.png" alt="Imagen secundaria">
            </div>

            <div class="main-up-right">
                <div class="links">
                    <a href="../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
                    <div class="dropdown">
                        <a href="../vista/hoteles.php" class="dropbtn">Hoteles</a>
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
            
            <img class="carousel-background" src="../static/img/florida/florida3.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../static/img/florida/florida4.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../static/img/florida/florida5.jpg" alt="Fondo 3">



            <div class="center-up">
                <div class="center-up-up">
                    <span style="font-size: 20px; color: rgb(230, 182, 11);">
                        <i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star "></i>
                    </span>
                </div>
                <div class="center-up-down">
                    <h5>EXPERIENCIAS QUE TRASPASAN LO ORDINARIO</h5>
                    <H1>Descubre nuestros hoteles de lujo</H1>
                </div>
            </div>
            <div class="center-down">
                <div class="form-reservas">
                    <div class="reservation-form">
                    <form id="reservationForm" action="../vista/lugares.php" method="post" class="reservation-form">
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
                            <input type="number" id="numero_personas" name="numero_personas" class="form-control" min="1" max="5"
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

  

    <!-------------------------------HOTLES------------------------->

    <section class="hoteles-nu">
        <div class="hoteles-txt">
            <h1>Nuestros hoteles en...</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat sequi nisi repudiandae atque? Cupiditate ipsum natus optio ab quasi ex?</p>
        </div>
        <div class="hoteles-box">
            <!-- Hotel 1 -->
            <div class="hoteles-nu-gen">
                <div class="sub-hoteles-nu">
                    <img class="sub-img" src="../static/img/california/california.jpg" alt="">
                </div>
                <div class="sub-hoteles-nu">
                    <h1>Florida</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi blanditiis odio eaque beatae quod...</p>
                    <div class="hoteles-boton">
                        <button class="ver-mas-btn" data-hotel="florida">VER MÁS</button>
                        <button>RESERVAR</button>
                    </div>
                </div>
            </div>

            <!-- Hotel 2 -->
            <div class="hoteles-nu-gen">
                <div class="sub-hoteles-nu">
                    <img class="sub-img" src="../static/img/california/california.jpg" alt="">
                </div>
                <div class="sub-hoteles-nu">
                    <h1>California</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi blanditiis odio eaque beatae quod...</p>
                    <div class="hoteles-boton">
                        <button class="ver-mas-btn" data-hotel="california">VER MÁS</button>
                        <button>RESERVAR</button>
                    </div>
                </div>
            </div>

            <!-- Hotel 3 -->
            <div class="hoteles-nu-gen">
                <div class="sub-hoteles-nu">
                    <img class="sub-img" src="../static/img/california/california.jpg" alt="">
                </div>
                <div class="sub-hoteles-nu">
                    <h1>New York</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi blanditiis odio eaque beatae quod...</p>
                    <div class="hoteles-boton">
                        <button class="ver-mas-btn" data-hotel="new-york">VER MÁS</button>
                        <button>RESERVAR</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
 <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <img src="../static/img/logo.png" alt="Logo" class="modal-logo">
                <h2 id="modal-title">Detalles del hotel</h2>
            </div>
            <p id="modal-description">Aquí vendrá más información sobre el hotel...</p>
        </div>
    </div>



    <!--------------------------BENEFICIOS-------------------------------->

    <section class="ben-gen">
        <div class="ben-box">
            <div class="ben-txt">
                <h1>BENEFICIOS</h1>
            </div>
            <div class="ben-ben">

                <div class="ben-sub">
                    <i class="fa-solid fa-utensils fa-xl"></i>
                    <h1>Gastronomía de Primera</h1>
                    <p>Disfruta de una experiencia culinaria excepcional con nuestra variedad de restaurantes y bares. Platos locales e internacionales preparados por chefs expertos para satisfacer todos los gustos.</p>
                </div>

                <div class="ben-sub">
                    <i class="fa-solid fa-mountain-sun fa-xl"></i>
                    <h1>Entornos Únicos</h1>
                    <p>Ubicados en destinos emblemáticos como el corazón de la ciudad o rodeados de naturaleza en la montaña. Cada hotel ofrece una experiencia auténtica y adaptada al entorno, ideal para desconectar o descubrir nuevos lugares.</p>
                </div>


                <div class="ben-sub">
                    <i class="fa-solid fa-gem fa-xl"></i>
                    <h1>Lujo y Confort</h1>
                    <p>Cada detalle ha sido pensado para tu comodidad. Habitaciones elegantes, amenities de alta gama y un ambiente exclusivo que eleva tu estancia a otro nivel.</p>
                </div>

                <div class="ben-sub">
                    <i class="fa-solid fa-briefcase fa-xl"></i>
                    <h1>Espacios para Negocios</h1>
                    <p>Salas de reuniones completamente equipadas, Wi-Fi de alta velocidad y atención personalizada para que tus viajes de trabajo sean tan productivos como placenteros.</p>
                </div>

                <div class="ben-sub">
                    <i class="fa-solid fa-trophy fa-xl"></i>
                    <h1> Entretenimiento</h1>
                    <p>Desde deportes acuáticos hasta espectáculos en vivo, siempre hay algo que hacer. Nuestro equipo de animación se encarga de que cada día esté lleno de diversión.</p>
                </div>

                <div class="ben-sub">
                    <i class="fa-solid fa-bed fa-xl"></i>
                    <h1>Descanso Garantizado</h1>
                    <p>Camas ultra cómodas, cortinas blackout y aislamiento acústico. Aquí, el descanso es prioridad para que te despiertes renovado cada mañana.</p>
                </div>

            </div>
        </div>
    </section>

        <!------------------------PROMOCIONES------------------------>

        <section class="promociones">
            <div class="promo-header">
                <h6>HOTEL CALIOPE</h6>
                <h2>HABITACIONES DESTACADAS</h2>
                <p>¡Vive la experiencia Calíope con nuestras promociones exclusivas! Descuentos, beneficios y escapadas únicas te esperan.</p>
            </div>

            <div class="promo-container">
                <button class="promo-btn prev">←</button>

                <div class="promo-slider" id="promoSlider">
                <div class="promo-card">
                    <img src="../static/img/florida/florida2.jpg" alt="Oferta 1">
                    <div class="promo-info">
                    <h4>Oferta Romántica</h4>
                    <h6>23€/Noche</h6>
                    <p>Escápate con tu persona favorita y disfruta de un ambiente exclusivo con cava y desayuno incluido.</p>
                    </div>
                </div>

                <div class="promo-card">
                    <img src="../static/img/florida/florida2.jpg" alt="Oferta 2">
                    <div class="promo-info">
                    <h4>Relax Total</h4>
                    <h6>53€/Noche</h6>
                    <p>Incluye acceso al spa, masaje relajante y cena para dos personas en nuestro restaurante panorámico.</p>
                    </div>
                </div>

                <div class="promo-card">
                    <img src="../static/img/florida/florida2.jpg" alt="Oferta 3">
                    <div class="promo-info">
                    <h4>Escapada Familiar</h4>
                    <h6>39€/Noche</h6>
                    <p>Ideal para familias: habitaciones conectadas, actividades infantiles y cena gratuita para menores de 12.</p>
                    </div>
                </div>
                <div class="promo-card">
                    <img src="../static/img/florida/florida2.jpg" alt="Oferta 2">
                    <div class="promo-info">
                    <h4>Relax Total</h4>
                    <h6>53€/Noche</h6>
                    <p>Incluye acceso al spa, masaje relajante y cena para dos personas en nuestro restaurante panorámico.</p>
                    </div>
                </div>
                <div class="promo-card">
                    <img src="../static/img/florida/florida2.jpg" alt="Oferta 2">
                    <div class="promo-info">
                    <h4>Relax Total</h4>
                    <h6>53€/Noche</h6>
                    <p>Incluye acceso al spa, masaje relajante y cena para dos personas en nuestro restaurante panorámico.</p>
                    </div>
                </div>
                <div class="promo-card">
                    <img src="../static/img/florida/florida2.jpg" alt="Oferta 2">
                    <div class="promo-info">
                    <h4>Relax Total</h4>
                    <h6>53€/Noche</h6>
                    <p>Incluye acceso al spa, masaje relajante y cena para dos personas en nuestro restaurante panorámico.</p>
                    </div>
                </div>

                <!-- Puedes seguir añadiendo más promo-card aquí -->
                </div>

                <button class="promo-btn next">→</button>
            </div>
        </section>



    <!--------------------------------OPINIONES------------------------>

    <section class="opiniones">
        <div class="opiniones-box">
            <h1>REVIEWS</h1>
            <div class="opiniones-carousel">
                <!-- Cada opinión -->
                <div class="opinion active">
                    <p>"Excelente servicio, volveré sin dudarlo. ¡Gracias, Hotel Calíope!"</p>
                    <span>- Juan Pérez</span>
                </div>
                <div class="opinion">
                    <p>"Un lugar increíble, perfecto para desconectar y relajarse."</p>
                    <span>- María López</span>
                </div>
                <div class="opinion">
                    <p>"Atención de primera clase, instalaciones impecables."</p>
                    <span>- Luis Rodríguez</span>
                </div>
            </div>
            <!-- Botones de control -->
            <div class="carousel-dots">
                <button class="dot active" data-index="0"></button>
                <button class="dot" data-index="1"></button>
                <button class="dot" data-index="2"></button>
            </div>
        </div>
    </section>
    


    <!-------------------------------DESCUBRIR------------------------->


    <section class="descubrir">
        <div class="descubrir-box">

            <!-- Servicio 1 -->
            <div class="descubrir-row">
                <div class="descubrir-img">
                    <img src="../static/img/florida/florida3.jpg" alt="Imagen servicio 1">
                </div>
                <div class="descubrir-info">
                    <h5>DESCUBRE</h5>
                    <h3>SPA Y BIENESTAR</h3>
                    <p>Relájate y rejuvenece con nuestros exclusivos tratamientos de spa, diseñados para tu bienestar. Desde masajes relajantes hasta terapias de belleza, nuestra zona de bienestar te ofrece una experiencia única para desconectar y recargar energías.</p>
                </div>
            </div>

            <!-- Servicio 2 (invertido) -->
            <div class="descubrir-row reverse">
                <div class="descubrir-img">
                    <img src="../static/img/california/california.jpg" alt="Imagen servicio 2">
                </div>
                <div class="descubrir-info">
                    <h5>DESCUBRE</h5>
                    <h3>TOURS Y AVENTURAS</h3>
                    <p>Explora los alrededores con nuestras opciones de tours y actividades de aventura. Desde senderismo en los Pirineos hasta paseos urbanos por Nueva York, nuestras excursiones están diseñadas para los amantes de la naturaleza y la cultura local.</p>
                </div>
            </div>

        </div>
    </section>




    <section class="mapa">
        <div class="mapa-box">
            <h2>MAPA INTERCATIVO</h2>
            <p>Descubre en este mapa interactivo todas las áreas donde puedes encontrarnos. Explora nuestras ubicaciones estratégicas, diseñadas para ofrecerte experiencias únicas y memorables en cada destino. ¡Planea tu próxima aventura con nosotros!</p>
            <div id="map"></div>
        </div>
       
    </section>
    <section class="contacto-alt">
        <div class="contacto-alt-box">
            <!-- Info de contacto -->
            <div class="contacto-alt-sub info">
                <h3>¿Tienes dudas?</h3>
                <p>Estamos aquí para ayudarte. Puedes llamarnos, escribirnos o visitarnos. Nuestro equipo estará encantado de asistirte.</p>

                <div class="contact-info">
                    <div class="info-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>Llámanos: <strong>111 222 346</strong></span>
                    </div>

                    <div class="info-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Email: <strong>info@hotelcaliope.com</strong></span>
                    </div>

                    <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Dirección: <strong>Calle Mar Azul, 123, Barcelona</strong></span>
                    </div>

                    <div class="info-item">
                    <i class="fa-solid fa-clock"></i>
                    <span>Horario de atención: <strong>09:00 - 20:00</strong> (Lunes a Sábado)</span>
                    </div>
                </div>
            </div>


            <!-- Formulario -->
            <div class="contacto-alt-sub form">
            <h1>Inicia Sesión</h1>
            <p class="subtext">Beneficios exclusivos esperan por ti.</p>
            <form method="POST" action="../controller/clients/LoginController.php">
                <input type="text" name="Usuari" id="Usuari" placeholder="Usuario" required>
                <input type="text" name="DNI" id="DNI" placeholder="DNI" required>
                <input type="password" name="Password" id="Password" placeholder="Contraseña" required>
                <button class="login-btn" type="submit">Entrar</button>
            </form>
            <p class="register-text">¿No tienes cuenta? <a href="../vista/Clientes/registre.php">Regístrate aquí</a></p>
            </div>
        </div>
    </section>




    <footer class="footer">
        <div class="footer-content">
            <!-- Columna 1 - Logo y Descripción -->
            <div class="footer-section">
                <img src="../static/img/logo_blanco.png" alt="Logo Hotel Calíope" class="footer-logo">
                <p>Descubre el lujo y la comodidad en cada rincón del mundo con Hotel Calíope.</p>
            </div>

            <!-- Columna 2 - Enlaces rápidos -->
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/hoteles.php">Hoteles</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/galeria/galeria.php">Galería</a></li>
                    <li><i class="fas fa-angle-right"></i><a href="../../vista/ofertas/ofertas.php">Ofertas</a></li>
                </ul>
            </div>

            <!-- Columna 3 - Contacto -->
            <div class="footer-section">
                <h3>Contacto</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +34 123 456 789</li>
                    <li><i class="fas fa-envelope"></i> info@hotelcaliope.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Calle Principal 123, Madrid</li>
                </ul>
            </div>

            <!-- Columna 4 - Redes Sociales -->
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Sección Inferior -->
        <div class="footer-bottom">
            <div class="footer-links">
                <a href="../../vista/politicas/privacidad.php">Política de Privacidad</a>
                <a href="../../vista/politicas/cookies.php">Política de Cookies</a>
                <a href="../../vista/politicas/avisolegal.php">Aviso Legal</a>
            </div>
            <p>&copy; 2025 Hotel Calíope. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../static/js/main.js"></script>
    <script src="../static/js/calendario.js"></script>

    <script>
     document.addEventListener("DOMContentLoaded", () => {
    const dots = document.querySelectorAll('.dot');
    const opinions = document.querySelectorAll('.opinion');

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = dot.dataset.index;
            opinions.forEach(op => op.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            opinions[index].classList.add('active');
            dot.classList.add('active');
        });
    });

    // Inicializar la primera opinión como activa por defecto
    opinions[0].classList.add('active');
    dots[0].classList.add('active');

    // Promociones - Slider con botones
    const slider = document.getElementById('promoSlider');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');

    if (slider && nextBtn && prevBtn) {
        nextBtn.addEventListener('click', () => {
            slider.scrollBy({
                left: slider.offsetWidth,
                behavior: 'smooth'
            });
        });

        prevBtn.addEventListener('click', () => {
            slider.scrollBy({
                left: -slider.offsetWidth,
                behavior: 'smooth'
            });
        });
    }

    // Efecto de ocultar la imagen al hacer scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    });
});

    </script>




<script>
    // Parallax suave del fondo
    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        const bg = document.querySelector('.opiniones::before'); // No se puede seleccionar pseudo-elementos directamente
        const section = document.querySelector('.opiniones');

        // Alternativa: aplicar el efecto directamente en la sección
        section.style.setProperty('--scroll-offset', `${scrollY * 0.4}px`);
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const images = document.querySelectorAll('.carousel-background');
  let currentImage = 0;
  
  function changeBackground() {
    images[currentImage].style.opacity = 0;
    currentImage = (currentImage + 1) % images.length;
    images[currentImage].style.opacity = 1;
    
    setTimeout(changeBackground, 5000); // Cambia cada 5 segundos
  }
  
  setTimeout(changeBackground, 5000); // Inicia el carrusel
});
</script>


<script>
   // Obtener el modal
var modal = document.getElementById("modal");

// Obtener los botones "Ver más"
var btns = document.querySelectorAll(".ver-mas-btn");

// Obtener el <span> (x) que cierra el modal
var span = document.getElementsByClassName("close")[0];

// Cuando el usuario haga clic en un botón "Ver más"
btns.forEach(function(btn) {
    btn.onclick = function() {
        var hotel = this.getAttribute('data-hotel');
        var title = "";
        var description = "";

        // Personalizar el modal según el hotel
        if (hotel === "florida") {
            title = "Florida";
            description = "Descubre nuestro hotel en Florida, un lugar ideal para disfrutar del sol, la playa y todo lo que este destino tiene para ofrecer. Ofrecemos lujosas habitaciones, restaurantes de alta calidad y un servicio excepcional.";
        } else if (hotel === "california") {
            title = "California";
            description = "En California, disfruta de la vibrante vida urbana de Los Ángeles o de la tranquilidad de nuestras ubicaciones cercanas a la playa. Un destino único para tus vacaciones o viajes de negocio.";
        } else if (hotel === "new-york") {
            title = "New York";
            description = "Experimenta el bullicio de Nueva York, un hotel donde la comodidad se encuentra en el centro de la ciudad. Ideal para quienes buscan explorar los íconicos lugares de la Gran Manzana.";
        }

        // Cambiar el contenido del modal
        document.getElementById("modal-title").innerText = title;
        document.getElementById("modal-description").innerText = description;

        // Mostrar el modal con animación
        modal.style.display = "block";
        setTimeout(function() {
            modal.querySelector('.modal-content').classList.add('show');
        }, 10);
    }
});

// Cuando el usuario haga clic en <span> (x), cerrar el modal
span.onclick = function() {
    modal.querySelector('.modal-content').classList.remove('show');
    setTimeout(function() {
        modal.style.display = "none";
    }, 300);
}

// Cuando el usuario haga clic fuera del modal, cerrarlo
window.onclick = function(event) {
    if (event.target == modal) {
        modal.querySelector('.modal-content').classList.remove('show');
        setTimeout(function() {
            modal.style.display = "none";
        }, 300);
    }
}

</script>



</body>
</html>