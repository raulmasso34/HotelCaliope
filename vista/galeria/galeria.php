<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería - Hotel Caliope</title>
    
    <!-- Styles -->
   
    <link rel="stylesheet" href="../../static/css/galeria.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Header Section -->
    <header class="gallery-header">
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
                <a href="galeria.php" class="active">Galería</a>
                <a href="../ofertas/ofertas.php">Ofertas</a>
                <a href="../Contacto/contacto.php">Contacto</a>
            </div>
            <!-- Mobile Menu Toggle -->
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>

        <div class="gallery-hero">
            <h1>Nuestra Galería</h1>
            <p>Descubre la elegancia y el lujo de nuestros hoteles</p>
            <div class="hero-buttons">
                <a href="#europa" class="hero-btn">Hoteles en Europa</a>
                <a href="#usa" class="hero-btn">Hoteles en USA</a>
            </div>
        </div>
    </header>

    <!-- Main Gallery Section -->
    <main class="gallery-main">
        <!-- Gallery Filters -->
        <div class="gallery-filters">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-globe"></i> Todos los Hoteles
            </button>
            <button class="filter-btn" data-filter="europa">
                <i class="fas fa-landmark"></i> Europa
            </button>
            <button class="filter-btn" data-filter="usa">
                <i class="fas fa-flag-usa"></i> USA
            </button>
        </div>

        <!-- Hotel Galleries -->
        <div class="hotel-galleries">
            <!-- Europa Section -->
            <section id="europa" class="region-section europa">
                <div class="region-header">
                    <h2>Hoteles en Europa</h2>
                    <p>Descubre nuestros exclusivos hoteles en las mejores ubicaciones de Europa</p>
                </div>

                <!-- Galicia -->
                <div class="hotel-section">
                    <div class="hotel-info">
                        <h3>Hotel Galicia</h3>
                        <p>Lujo y tradición en el corazón de Galicia</p>
                    </div>
                    <div class="gallery-grid">
                        <?php
                        $galiciaImages = [
                            ['src' => 'galicia1.jpg', 'title' => 'Vista al Mar', 'desc' => 'Espectaculares vistas al Atlántico'],
                            ['src' => 'galicia2.jpg', 'title' => 'Suite Principal', 'desc' => 'Elegancia y confort'],
                            ['src' => 'galicia3.jpg', 'title' => 'Restaurante', 'desc' => 'Gastronomía gallega'],
                            ['src' => 'galicia4.jpg', 'title' => 'Spa', 'desc' => 'Relax y bienestar']
                        ];

                        foreach ($galiciaImages as $image): ?>
                            <div class="gallery-item">
                                <img src="../../static/img/Galicia/<?php echo $image['src']; ?>" 
                                     alt="<?php echo $image['title']; ?>">
                                <div class="gallery-overlay">
                                    <h4><?php echo $image['title']; ?></h4>
                                    <p><?php echo $image['desc']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Similar structure for Tossa and Pirineos -->
                <!-- ... -->
            </section>

            <!-- USA Section -->
            <section id="usa" class="region-section usa">
                <div class="region-header">
                    <h2>Hoteles en Estados Unidos</h2>
                    <p>Experimenta el lujo americano en nuestros hoteles premium</p>
                </div>

                <!-- Similar structure for Florida, California, and New York -->
                <!-- ... -->
            </section>
        </div>
    </main>

    <!-- Footer -->
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
                        <li><a href="galeria.php">Galería</a></li>
                        <li><a href="../ofertas/ofertas.php">Ofertas</a></li>
                        <li><a href="../Contacto/contacto.php">Contacto</a></li>
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

    <!-- Modal for Image Preview -->
    <div class="gallery-modal">
        <span class="modal-close">&times;</span>
        <img class="modal-image" src="" alt="">
        <div class="modal-nav prev"><i class="fas fa-chevron-left"></i></div>
        <div class="modal-nav next"><i class="fas fa-chevron-right"></i></div>
        <div class="modal-caption"></div>
    </div>

    <script src="../../static/js/galeria.js"></script>
</body>
</html>
