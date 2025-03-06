<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/servicios.css">
    <title>Document</title>
</head>
<body>

    <header>
        <section class="main-up">
            <div class="main-up-left">
               <a href="../vista/index.php"> <img src="../static/img/logo_blanco.png" alt="Imagen secundaria"></a>
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
                            <a href="../controller/clients/LoginController.php?action=logout">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
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
    </header>

    <h1>¿Quieres alguno de estos servicios?</h1>
    <div class="servicios-container">
        <div class="servicio">
            <img src="../static/img/servicios/spa.jpg" alt="Spa">
            <h2>Spa</h2>
            <p>Disfruta de un momento de relajación en nuestro spa con sauna y masajes.</p>
            <ul>
                <li><strong>Masajes:</strong> Relájate con terapias personalizadas.</li>
                <li><strong>Sauna:</strong> Acceso ilimitado a la zona de sauna.</li>
                <li><strong>Hidromasaje:</strong> Baños termales con minerales naturales.</li>
            </ul>
            <button onclick="reservarServicio('Spa')">Reservar</button>
        </div>
        <div class="servicio">
            <img src="../static/img/servicios/limpieza.jpg" alt="Limpieza">
            <h2>Limpieza</h2>
            <p>Servicio de limpieza diaria para que disfrutes de una habitación impecable.</p>
            <ul>
                <li><strong>Diaria:</strong> Limpieza y cambio de sábanas.</li>
                <li><strong>Profunda:</strong> Limpieza completa cada 3 días.</li>
            </ul>
            <button onclick="reservarServicio('Limpieza')">Reservar</button>
        </div>
        <div class="servicio">
            <img src="../static/img/servicios/parking.jpg" alt="Parking">
            <h2>Parking</h2>
            <p>Estacionamiento privado y seguro para tu comodidad.</p>
            <ul>
                <li><strong>24/7:</strong> Seguridad y vigilancia las 24 horas.</li>
                <li><strong>Cubierto:</strong> Espacios protegidos contra el clima.</li>
            </ul>
            <button onclick="reservarServicio('Parking')">Reservar</button>
        </div>
        <div class="servicio">
            <img src="../static/img/servicios/taxi.jpg" alt="Taxi">
            <h2>Taxi</h2>
            <p>Servicio de taxi disponible las 24 horas para tus traslados.</p>
            <ul>
                <li><strong>Al aeropuerto:</strong> Traslados rápidos y seguros.</li>
                <li><strong>Dentro de la ciudad:</strong> Movilidad cómoda y confiable.</li>
            </ul>
            <button onclick="reservarServicio('Taxi')">Reservar</button>
        </div>
    </div>

    <section class="beneficios">
        <h2>Beneficios adicionales de nuestros servicios</h2>
        <div class="beneficios-container">
            <div class="beneficio">
                <h3>✅ Servicios personalizados</h3>
                <p>Ajustamos cada servicio según tus necesidades y horarios.</p>
            </div>
            <div class="beneficio">
                <h3>💆 Comodidad y bienestar</h3>
                <p>Desde el Spa hasta el servicio de taxi, todo pensado para tu confort.</p>
            </div>
            <div class="beneficio">
                <h3>🕒 Disponibilidad 24/7</h3>
                <p>Acceso a limpieza, parking y traslados en cualquier momento del día.</p>
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

    
</body>
</html>