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
require_once __DIR__ . '../../../controller/reserva/reservaController.php';

// Crear una instancia del controlador
$controller = new ReservaController();

// Verificar si la instancia se ha creado correctamente
if ($controller !== null) {
    // Obtener los países a través del controlador
    $paises = $controller->obtenerPaises();

    // Verificar si se han obtenido los países y hacer algo con ellos
    
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $hotel = $_POST['hotel'];  // Obtener el hotel seleccionado

    // Determinar el correo del hotel según la selección
    $hotelEmails = [
        'galicia' => 'contacto@hotelgalicia.com',
        'pirineos' => 'contacto@hotelpirineos.com',
        'tossa' => 'contacto@hoteltossademar.com',
        'florida' => 'contacto@hotelflorida.com',
        'california' => 'contacto@hotelcalifornia.com',
        'newyork' => 'contacto@hotelnewyork.com'
    ];

    // Obtener el correo correspondiente al hotel seleccionado
    $hotelEmail = $hotelEmails[$hotel] ?? 'contacto@defaulthotel.com';  // Correo por defecto si no se encuentra el hotel

    // Asunto y mensaje para el correo
    $subject = "Mensaje de $name desde el formulario de contacto";
    $body = "Nombre: $name\nCorreo: $email\n\nMensaje:\n$message";

    // Enviar el correo
    if (mail($hotelEmail, $subject, $body)) {
        echo "Mensaje enviado correctamente a $hotelEmail";
    } else {
        echo "Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:wght@200..1000&family=Old+Standard+TT:wght@400;700&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <title>Document</title>
    <link rel="stylesheet" href="../../static/css/GENERAL/header.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/footer.css">
    <link rel="stylesheet" href="../../static/css/contacto/contacto.css">
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>

<body>
<header class="main-header">
        <div class="carousel">
            <img class="carousel-background" src="../../static/img/california/california.jpg" alt="Fondo 1">
            <img class="carousel-background" src="../../static/img/Galicia/galicia1.jpg" alt="Fondo 2">
            <img class="carousel-background" src="../../static/img/europa/pirineos.jpg" alt="Fondo 3">
        </div>
        
        <section class="main-up">
            <div class="main-up-left">
                <img src="../../static/img/logo_blanco.png" alt="Logo Hotel Calíope">
            </div>

            <div class="main-up-right">
                <div class="links">
                    <a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                    
                    <div class="dropdown">
                        <a href="../../vista/hoteles.php" class="dropbtn">Hoteles</a>
                        <div class="dropdown-content">
                            <div class="dropdown-section">
                                <h4>Europa</h4>
                                <a href="../../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                <a href="../../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                                <a href="../../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                            </div>
                            <div class="dropdown-section">
                                <h4>USA</h4>
                                <a href="../../vista/ciudades/USA/Florida.php">Florida</a>
                                <a href="../../vista/ciudades/USA/California.php">California</a>
                                <a href="../../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                            </div>
                        </div>
                    </div>

                    <a href="../../vista/galeria/galeria.php">Galería</a>
                    <a href="../../vista/ofertas/ofertas.php">Ofertas</a>
                    <a href="../../vista/Contacto/contacto.php">Contacto</a>
                    
                    <!-- Contenedor del perfil -->
                    <div class="dropdown-perfil">
                        <a class="icon-perfil" href="javascript:void(0);">
                            <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
                        </a>
                        <div class="dropdown-perfil-content">
                            <a href="../../vista/Clientes/login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                            </a>
                            <a href="../../vista/Clientes/perfil.php">
                                <i class="bi bi-person"></i> Perfil
                            </a>
                            <a href="../../controller/clients/LoginController.php?action=logout" style="color: red;"> 
                                <i class="bi bi-box-arrow-right" style="color: red;"></i> Cerrar sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menú hamburguesa -->
            <div id="menu-toggle" class="menu-toggle">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <!-- Menú móvil -->
            <div class="mobile-menu">
                <a href="../../vista/Habitaciones/habitaciones.php">Habitaciones</a>
                <a href="../../vista/galeria/galeria.php">Galería</a>
                <a href="../../vista/ofertas/ofertas.php">Ofertas</a>
                <a href="../../vista/Contacto/contacto.php">Contacto</a>
                <a href="../../vista/Clientes/login.php">Iniciar sesión</a>
                <a href="../../vista/Clientes/perfil.php">Perfil</a>
                
                <div class="dropdown-mobile">
                    <a href="#" class="dropbtn">Hoteles</a>
                    <div class="dropdown-content-mobile">
                        <div class="dropdown-section">
                            <h4>Europa</h4>
                            <a href="../../vista/ciudades/Europa/Galicia.php">Galicia</a>
                            <a href="../../vista/ciudades/Europa/Tossa.php">Tossa de Mar</a>
                            <a href="../../vista/ciudades/Europa/Pirineos.php">Pirineos</a>
                        </div>
                        <div class="dropdown-section">
                            <h4>USA</h4>
                            <a href="../../vista/ciudades/USA/Florida.php">Florida</a>
                            <a href="../../vista/ciudades/USA/California.php">California</a>
                            <a href="../../vista/ciudades/USA/NuevaYork.php">Nueva York</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="main-center">
            <div class="center-up">
                <div class="center-up-up">
                    <span style="font-size: 20px; color: rgb(230, 182, 11);">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </span>
                </div>
                <div class="center-up-down">
                    <h5> <b>Contacta con nosotros para más información!</b></h5>
                    <h1>CONTACTO</h1>
                </div>
            </div>
        </section>
        <div class="scroll-down">
            <a href="#contact-section" class="scroll-down-arrow">
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        </div>
    </header>

    <main class="contact-main">
        <!-- Contact Stats Section -->
        <section class="contact-stats">
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <div class="stat-info">
                        <h3>6 Hoteles</h3>
                        <p>En ubicaciones exclusivas</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>24/7 Atención</h3>
                        <p>Servicio personalizado</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3>5 Estrellas</h3>
                        <p>Calidad garantizada</p>
                    </div>
                </div>
            </div>
        </section>




        <!-- Contact Info Cards -->
        <section class="contact-info" id="contact-section">
            <div class="info-container">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Llámanos</h3>
                    <p>+34 999 999 999</p>
                    <a href="tel:+34999999999" class="card-link">Llamar ahora</a>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Escríbenos</h3>
                    <p>info@hotelcaliope.com</p>
                    <a href="mailto:info@hotelcaliope.com" class="card-link">Enviar email</a>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Visítanos</h3>
                    <p>Calle Principal 123, Ciudad</p>
                    <a href="#map" class="card-link">Ver en mapa</a>
                </div>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="contact-form-section" id="contact-form">
            <div class="form-container">
                <div class="form-header">
                    <h2>Envíanos un Mensaje</h2>
                    <p>Nos pondremos en contacto contigo lo antes posible</p>
                </div>
                
                <form id="contactForm" action="" method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i> Nombre
                            </label>
                            <input type="text" id="name" name="name" required 
                                placeholder="Tu nombre completo">
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email" name="email" required 
                                placeholder="tu@email.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hotel">
                            <i class="fas fa-hotel"></i> Hotel
                        </label>
                        <select id="hotel" name="hotel" required>
                            <option value="">Selecciona un hotel</option>
                            <option value="galicia">Hotel Galicia</option>
                            <option value="pirineos">Hotel Pirineos</option>
                            <option value="tossa">Hotel Tossa de Mar</option>
                            <option value="florida">Hotel Florida</option>
                            <option value="california">Hotel California</option>
                            <option value="newyork">Hotel New York</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">
                            <i class="fas fa-comment"></i> Mensaje
                        </label>
                        <textarea id="message" name="message" rows="5" required 
                                placeholder="¿En qué podemos ayudarte?"></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Enviar Mensaje</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </section>

        
    </main>

    <footer class="footer">
        <div class="footer-content">
            <!-- Columna 1 - Logo y Descripción -->
            <div class="footer-section">
                <img src="../../static/img/logo_blanco.png" alt="Logo Hotel Calíope" class="footer-logo">
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
        


    <script>
        // Initialize map
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([40.416775, -3.703790], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            L.marker([40.416775, -3.703790]).addTo(map)
                .bindPopup('Hotel Caliope')
                .openPopup();
        });
    </script>


        <script src="../../static/js/contacto.js"></script>
</body>
</html>