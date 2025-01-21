<?php
session_start();

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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <title>Document</title>
</head>
<body>
    <header class="main-header">

        <div class="carousel">
            <img class="carousel-background" src="../static/img/florida/florida3.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../static/img/florida/florida4.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../static/img/florida/florida5.jpg" alt="Fondo 3">
        </div>
        
        <section class="main-up">
            <div class="main-up-left">
                <img src="../static/img/logo.png" alt="Imagen secundaria">
            </div>

            <div class="main-up-right">
                <div class="links">
                    <a href="../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
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
                    
                    <div class="dropdown-perfil">
                        <a class="icon-perfil" href="javascript:void(0);">
                            <i class="fa-regular fa-user fa-2xl"></i> <!-- Icono de usuario -->
                        </a>
                        <div class="dropdown-perfil-content">
                            <a href="../vista/Clientes/login.php">Iniciar sesión</a>
                            <a href="../vista/Clientes/perfil.php">Perfil</a>
                            <a href="..//controller/clients/LoginController.php?action=logout">Cerrar sesión</a>
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
                        <form id="reservationForm" action="../vista/reservas.php" method="post">
                            <!-- Campo de selección de lugar -->
                            <div class="form-group">
                                <label for="location">Lugar</label>
                                <select id="location" name="location" required>
                                    <?php foreach ($paises as $pais): ?>
                                        <option value="<?php echo $pais['Id_Pais']; ?>"><?php echo $pais['Pais']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Campo de fecha de check-in -->
                            <div class="form-group">
                                <label for="checkin">Fecha de Check-in</label>
                                <input type="date" id="checkin" name="checkin" min="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <!-- Campo de fecha de check-out -->
                            <div class="form-group">
                                <label for="checkout">Fecha de Check-out</label>
                                <input type="date" id="checkout" name="checkout" min="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <!-- Campo de número de personas -->
                            <div class="form-group">
                                <label for="numero_personas">Número de Personas</label>
                                <input type="number" id="numero_personas" name="numero_personas" min="1" value="<?php echo isset($_SESSION['numero_personas']) ? $_SESSION['numero_personas'] : ''; ?>" required>
                            </div>

                            <!-- Botón para enviar el formulario -->
                            <button type="submit" id="submitBtn">Reservar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </header>

    <div class="main-main">
        <div class="main-box">
            <div class="main-box-box">
                <div class="stars-main">
                    <span style="font-size: 20px;  color: rgb(230, 182, 11);">
                    <i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star "></i>
                    </span>
                </div>
                <div class="main-title">
                    <h3>LOREM IST AME TUU </h3>
                    <h1>Lorem ipsum dolor </h1>
                </div>
                <div class="main-txt">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem adipisci soluta alias voluptatem facere? Vitae iure ratione saepe quos blanditiis fugiat molestias, maxime reprehenderit harum. Quod molestiae consectetur perferendis deserunt.</p>

                    <div class="main-botones">
                        <button>VER MAS</button>
                        <button>Reservar</button>
                    </div>
                   
                </div>
            </div>
            <div class="main-box-right">
                <div class="img-left">
                    <img class="img-main" src="../static/img/florida/florida1.jpg" alt="">
                </div>
                <div class="img-right">
                    <img class="img-main" src="../static/img/florida/florida3.jpg" alt="">
                </div>
                    
            </div>
        </div>
    </div>

    <!-------------------------------HOTLES------------------------->

    <section class="hoteles-nu">
        <div class="hoteles-txt">
            <h1>Nuestros hoteles en...</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat sequi nisi repudiandae atque? Cupiditate ipsum natus optio ab quasi ex?</p>
        </div>
        <div class="hoteles-box">
            <div class="hoteles-nu-gen">
                <div class="sub-hoteles-nu">
                    <img class="sub-img" src="../static/img/california/california.jpg" alt="">
                </div>
                <div class="sub-hoteles-nu">
                    <h1>
                       Florida
                    </h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi blanditiis odio eaque beatae quod, porro repellendus fugit, vero deleniti sint consectetur id quasi distinctio itaque ratione magni maiores tenetur! Molestias!</p>
                    <div class="hoteles-boton">
                    <button>VER MAS</button>
                    <button>RESERVAR</button>
                    </div>
                   
                </div>
            </div>
            <div class="hoteles-nu-gen">
                <div class="sub-hoteles-nu">
                    <img class="sub-img" src="../static/img/california/california.jpg" alt="">
                </div>
                <div class="sub-hoteles-nu">
                    <h1>
                       California
                    </h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi blanditiis odio eaque beatae quod, porro repellendus fugit, vero deleniti sint consectetur id quasi distinctio itaque ratione magni maiores tenetur! Molestias!</p>
                    <div class="hoteles-boton">
                    <button>VER MAS</button>
                    <button>RESERVAR</button>
                    </div>
                   
                </div>
            </div>
            <div class="hoteles-nu-gen">
                <div class="sub-hoteles-nu">
                    <img class="sub-img" src="../static/img/california/california.jpg" alt="">
                </div>
                <div class="sub-hoteles-nu">
                    <h1>
                       New York
                    </h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi blanditiis odio eaque beatae quod, porro repellendus fugit, vero deleniti sint consectetur id quasi distinctio itaque ratione magni maiores tenetur! Molestias!</p>
                    <div class="hoteles-boton">
                    <button>VER MAS</button>
                    <button>RESERVAR</button>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>

    <!--------------------------BENEFICIOS-------------------------------->

    <section class="ben-gen">
        <div class="ben-box">
            <div class="ben-txt">
                <h1>BENEFICIOS</h1>
            </div>
            <div class="ben-ben">
                <div class="ben-sub">
                    <i class="fa-solid fa-utensils fa-xl"></i>
                    <h1>BENEFIT </h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A officia, cum impedit doloremque perferendis dolore, tempora dolorem, quis asperiores non minima obcaecati corporis delectus! Sit beatae, cumque velit laudantium odio autem corrupti error quasi at unde assumenda saepe architecto modi.</p>
                </div>
                <div class="ben-sub">
                
                <i class="fa-solid fa-umbrella-beach fa-xl"></i>
                <h1>BENEFIT </h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A officia, cum impedit doloremque perferendis dolore, tempora dolorem, quis asperiores non minima obcaecati corporis delectus! Sit beatae, cumque velit laudantium odio autem corrupti error quasi at unde assumenda saepe architecto modi.</p>
                </div>
                <div class="ben-sub">
                    <i class="fa-solid fa-gem fa-xl"></i>
                    <h1>BENEFIT </h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A officia, cum impedit doloremque perferendis dolore, tempora dolorem, quis asperiores non minima obcaecati corporis delectus! Sit beatae, cumque velit laudantium odio autem corrupti error quasi at unde assumenda saepe architecto modi.</p>
                </div>
                <div class="ben-sub">
                    <i class="fa-solid fa-briefcase fa-xl"></i>
                    <h1>BENEFIT </h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A officia, cum impedit doloremque perferendis dolore, tempora dolorem, quis asperiores non minima obcaecati corporis delectus! Sit beatae, cumque velit laudantium odio autem corrupti error quasi at unde assumenda saepe architecto modi.</p>
                </div>
                <div class="ben-sub">
                    <i class="fa-solid fa-trophy fa-xl"></i>
                    <h1>BENEFIT </h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A officia, cum impedit doloremque perferendis dolore, tempora dolorem, quis asperiores non minima obcaecati corporis delectus! Sit beatae, cumque velit laudantium odio autem corrupti error quasi at unde assumenda saepe architecto modi.</p>
                </div>
                <div class="ben-sub">
                    <i class="fa-solid fa-bed fa-xl"></i>
                    <h1>BENEFIT </h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. A officia, cum impedit doloremque perferendis dolore, tempora dolorem, quis asperiores non minima obcaecati corporis delectus! Sit beatae, cumque velit laudantium odio autem corrupti error quasi at unde assumenda saepe architecto modi.</p>

                </div>
            </div>
        </div>
    </section>

    <section class="promociones">
        <div class="promociones-box">
            <div class="prom">
                <h6>HOTEL CALIOPE</h6>
                <h5>PROMOCIONES</h5>
                <p>¡Vive la experiencia Calíope con nuestras promociones exclusivas!
                    Disfruta de noches inolvidables con descuentos únicos, beneficios especiales y sorpresas diseñadas para ti.<br><br><br>
                    🌟 Relájate más, paga menos.<br><br>
                    🌴 Tu escape perfecto, ahora al mejor precio.<br><br><br>
                    ¡No dejes pasar esta oportunidad!</p>
            </div>
            <div class="prom-white">
                <img class="img-prom" src="../static/img/florida/florida2.jpg" alt="">
                <h4>Oferta 1</h4>
                <H6> 23€/Noche</H6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim et laudantium accusamus veniam </p>
            </div>
            <div class="prom-white">
                <img class="img-prom" src="../static/img/florida/florida2.jpg" alt="">
                <h4>Oferta 2</h4>
                <H6> 53€/Noche</H6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim et laudantium accusamus veniam </p>
            </div>
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


    <section class="descubrir">
        <div class="descubrir-box">
            <div class="descubrir-sub">
                <img class="desc-img" src="../static/img/florida/florida3.jpg" alt="">
            </div>
            <div class="descubrir-sub">
                <h5>DISCOVER</h5>
                <h3> SERVICIO 1</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam ab dolore consequuntur impedit tempore culpa aperiam aspernatur illo blanditiis repellat fuga sunt quisquam ad eum vel magnam quos exercitationem, necessitatibus omnis quam quis. Dolore obcaecati nostrum in harum deleniti laudantium magnam repudiandae iusto quae evenie</p>
            </div>
            <div class="descubrir-sub">
                <h5>DISCOVER</h5>
                <h3> SERVICIO 2</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam ab dolore consequuntur impedit tempore culpa aperiam aspernatur illo blanditiis repellat fuga sunt quisquam ad eum vel magnam quos exercitationem, necessitatibus omnis quam quis. Dolore obcaecati nostrum in harum deleniti laudantium magnam repudiandae iusto quae eaa</p>
            </div>
            <div class="descubrir-sub">
                <img class="desc-img" src="../static/img/california/california.jpg" alt="">
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
                    <form class="news-content" method="POST" action="../controller/clients/LoginController.php">
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
        <div id="privacy-banner" class="privacy-banner">
            <p>Este sitio web utiliza cookies para garantizar que obtengas la mejor experiencia. Consulta nuestra <a href="../vista/politicas/privacidad.php">Política de Privacidad</a>.</p>
            <button id="accept-btn">Aceptar</button>
        </div>

    </footer>

    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../static/js/main.js"></script>
    <script src="../static/js/calendario.js"></script>
</body>
</html>