<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
$reservaController = new ReservaController();

// Verificar si la reserva está en la sesión
if (isset($_SESSION['Reservas'])) {
    $reserva = $_SESSION['Reservas'];

    // Recuperar los datos de la reserva
    $habitacionId = $reserva['habitacionId'] ?? 'No disponible';
    $clienteId = $reserva['clienteId'] ?? 'No disponible';
    $hotelId = $reserva['hotelId'] ?? 'No disponible';
    $checkin = $reserva['checkin'] ?? 'No disponible';
    $checkout = $reserva['checkout'] ?? 'No disponible';
    $guests = $reserva['guests'] ?? 'No disponible';
} else {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

$hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="../static/css/pagos.css">
    <link rel="stylesheet" href="../static/css/detalles.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
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
    <h1>Pagar Reserva</h1>

    <!-- Mostrar los detalles de la reserva -->
    <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p> <!-- Asumiendo que 'Nombre' es un campo del array -->
    <p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
    <p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
    <p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
    <p><strong>Personas:</strong> <?php echo htmlspecialchars($guests); ?></p>

    <!-- Formulario de pago -->
    <form action="../controller/pago/pagoController.php" method="POST">
        <label for="numero_tarjeta">Número de Tarjeta:</label>
        <input type="text" name="numero_tarjeta" required><br>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" required><br>

        <label for="fecha_expiracion">Fecha de Expiración:</label>
        <input type="month" name="fecha_expiracion" required><br>

        <!-- Datos ocultos para procesar la reserva -->
        <input type="hidden" name="habitacionId" value="<?php echo htmlspecialchars($habitacionId); ?>">
        <input type="hidden" name="clienteId" value="<?php echo htmlspecialchars($clienteId); ?>">
        <input type="hidden" name="hotelId" value="<?php echo htmlspecialchars($hotelId); ?>">
        <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
        <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
        <input type="hidden" name="guests" value="<?php echo htmlspecialchars($guests); ?>">

        <button type="submit">Confirmar y Pagar</button>
    </form>
</body>
</html>
