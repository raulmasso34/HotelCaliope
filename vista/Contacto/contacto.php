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

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../static/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <title>Document</title>
    <link rel="stylesheet" href="../../static/css/contacto/contacto.css">
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>

<body>
    <!-- Add this right after the <body> tag -->
    <header class="main-header">
    <!-- Navigation Bar -->
    <nav class="nav-bar">
        <div class="nav-left">
            <a href="../index.php">
                <img src="../../static/img/logo.png" alt="Hotel Caliope Logo" class="nav-logo">
            </a>
        </div>
        <div class="nav-right">
            <a href="../Habitaciones/habitaciones.php">Habitaciones</a>
            <div class="nav-dropdown">
                <a href="#" class="dropbtn">Hoteles</a>
                <div class="dropdown-content">
                    <div class="dropdown-section">
                        <h4>Europa</h4>
                        <a href="../ciudades/Europa/Galicia.php">Galicia</a>
                        <a href="../ciudades/Europa/Tossa.php">Tossa de Mar</a>
                        <a href="../ciudades/Europa/Pirineos.php">Pirineos</a>
                    </div>
                    <div class="dropdown-section">
                        <h4>USA</h4>
                        <a href="../ciudades/USA/Florida.php">Florida</a>
                        <a href="../ciudades/USA/California.php">California</a>
                        <a href="../ciudades/USA/NuevaYork.php">Nueva York</a>
                    </div>
                </div>
            </div>
            <a href="../galeria/galeria.php">Galería</a>
            <a href="../ofertas/ofertas.php">Ofertas</a>
            <a href="contacto.php" class="active">Contacto</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="hero-content">
            <h1 class="animate-text">Contacta con Nosotros</h1>
            <p class="animate-text-delay">Tu satisfacción es nuestra prioridad</p>
            <div class="hero-buttons animate-text-delay">
                <a href="#contact-form" class="hero-btn primary">Enviar Mensaje</a>
                <a href="tel:+34999999999" class="hero-btn secondary">
                    <i class="fas fa-phone"></i> Llamar Ahora
                </a>
            </div>
        </div>
        <div class="hero-overlay"></div>
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
        <section class="contact-info">
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

        <!-- Replace the map section with this footer -->
    <footer class="contact-footer">
        <div class="footer-top">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section">
                    <img src="../../static/img/logo_blanco.png" alt="Hotel Caliope Logo" class="footer-logo">
                    <p>Descubre el lujo y la comodidad en nuestros hoteles exclusivos. Una experiencia única en las mejores ubicaciones.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="../Habitaciones/habitaciones.php">Habitaciones</a></li>
                        <li><a href="../galeria/galeria.php">Galería</a></li>
                        <li><a href="../ofertas/ofertas.php">Ofertas</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </div>

                <!-- Our Hotels -->
                <div class="footer-section">
                    <h3>Nuestros Hoteles</h3>
                    <ul class="footer-links">
                        <li><a href="../ciudades/Europa/Galicia.php">Hotel Galicia</a></li>
                        <li><a href="../ciudades/Europa/Tossa.php">Hotel Tossa de Mar</a></li>
                        <li><a href="../ciudades/USA/Florida.php">Hotel Florida</a></li>
                        <li><a href="../ciudades/USA/California.php">Hotel California</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Suscríbete para recibir nuestras mejores ofertas</p>
                    <form class="newsletter-form">
                        <div class="form-group">
                            <input type="email" placeholder="Tu email" required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-info">
                <div class="copyright">
                    <p>&copy; 2024 Hotel Caliope. Todos los derechos reservados.</p>
                </div>
                <div class="footer-bottom-links">
                    <a href="../politicas/privacidad.php">Política de Privacidad</a>
                    <a href="../politicas/cookies.php">Política de Cookies</a>
                    <a href="../politicas/avisolegal.php">Aviso Legal</a>
                </div>
            </div>
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
</body>
</html>