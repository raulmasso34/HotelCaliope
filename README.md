# HotelCaliope
Realización de una pagina web para un hotel ficticio

Para que la base de datos tenga conexion, se tiene que llmar igual que como indica el codigo, en este caso HotelCaliope

private $dbname = "HotelCaliope"

Para comprobar que la conexion a la base de datos funciona correctamente, tienes que ir a tu localhost y abrir sirectamente el archivo:

         test_conexion.php

-------------------------------------- FALTA / MODIFICAR ------------------------------------------------------

- Hay que poner carrusel de fotos en el header y la parte de reserva ✅
- Hay que modificar para que puedan elegir cuantas perosnas van y el tipo(niño,adulto...)
- En la parte de descripcion de index.php, añadir carrusel con fotos de distintos lugares.✅
- Poner en para buscar habitacions lo siguiente: fecha llegada ✅, fecha salida ✅, ciudad ✅,tipo(elegir entre habitacion y actividad).(si el usuario elige habitacion le aparecera el tipo de habitacion, si elige actividad le tiene que salir cuantas personas son).

- POLTICAS DE PRIVACIDAD 


-QUE SALGAN LAS HABITACIONES DISPONIBLES DEPENDIENDO DE LA FECHA SELECCIONADA




dfwfwfwfwdwd
svdf



---------------------------------------LINKS UTILES----------------------------------
https://www.html6.es
https://fontawesome.com --> ICONOS

---------------------------------------IMPORTANTE-------------------------------------

- Los width son de 80% y margin auto, para que sea todo igual.
- Los SCRIPTS ponerlos abajo del codigo, si no NO FUNCIONA!


Comando para arreglar lo del commit

git pull --tags origin main --no-rebase





------------------------------------------------MYSQL-----------------------------------------
CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_reservas`()
BEGIN
    DELETE FROM Reservas WHERE Checkout < NOW();
END



 $sql = "SELECT DISTINCT h.Id_Pais, p.Pais FROM Hotel h inner join Pais p on h.Id_Pais = p.Id_Pais ";
            $stmt = $this->conn->prepare($sql);
























































---------------------------CODIGO GUARDADO X SI ACASO-----------------

  <header>
        <section class="main-up">
            <div class="main-up-left">
                <a href="../vista/index.php"><img src="../static/img/logo_blanco.png" alt="Imagen secundaria"></a>
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

    --------------------------------------------------------------------------------
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
                <h1>CONTACTO</h1>
                <div class="social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>























    confirmacion_ reserva:

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
















    -----------------------------------------------------------------pagos-------------------------------------------------------



    <?php
session_start();

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
require_once __DIR__ . '/../controller/pago/pagoController.php';
require_once __DIR__ . '/../controller/actividad/actividadController.php';
require_once __DIR__ . '/../controller/habitacion/habitacionController.php';

$reservaController = new ReservaController();
$pagoController = new PagoController();
$habitacionController = new HabitacionController();
$actividadController = new ActividadController();

if (!isset($_SESSION['Reservas'])) {
    echo "<p class='text-danger'>Error: No se ha recibido la reserva en la sesión.</p>";
    exit;
}

$reserva = $_SESSION['Reservas'];

// Recuperar los datos de la reserva
$habitacionId = $reserva['habitacionId'] ?? null;
$clienteId = $reserva['clienteId'] ?? null;
$hotelId = $reserva['hotelId'] ?? null;
$checkin = $reserva['checkin'] ?? null;
$checkout = $reserva['checkout'] ?? null;
$guests = $reserva['guests'] ?? null;
$metodoPagoId = $reserva['metodoPagoId'] ?? null;
$paisId = $reserva['paisId'] ?? null;
$precioTarifa = $reserva['precioTarifa'] ?? 0;
$actividadesSeleccionadas = $reserva['actividades'] ?? []; // Manejo de múltiples actividades

// Obtener detalles de la habitación
$habitacionDetails = $habitacionController->obtenerHabitacionPorId($habitacionId);
if (!$habitacionDetails || !isset($habitacionDetails['Precio'])) {
    die("<p class='text-danger'>Error: No se encontró la habitación o su precio no está definido.</p>");
}

// Obtener precio de la habitación
$precioHabitacion = floatval($habitacionDetails['Precio']);

// Calcular el número de noches
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$numeroNoches = $checkoutDate->diff($checkinDate)->days;

// Calcular precio total de servicios
$serviciosSeleccionados = $_SESSION['Reservas']['servicios'] ?? [];
$totalServicios = 0;
foreach ($serviciosSeleccionados as $precio) {
    if (!is_numeric($precio)) {
        die("<p class='text-danger'>Error: Un servicio tiene un precio inválido ($precio).</p>");
    }
    $totalServicios += floatval($precio);
}

// Calcular precio total de actividades
$totalActividades = 0;
foreach ($actividadesSeleccionadas as $actividadId) {
    $actividad = $actividadController->obtenerActividadesPorHotel($actividadId);
    $totalActividades += $actividad['Precio'] ?? 0;
}

// Calcular precio total
$precioTotal = ($precioHabitacion * $numeroNoches) + $precioTarifa + $totalActividades + $totalServicios;

// Guardar en sesión si existen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];
    $_SESSION['Reservas']['actividades'] = $_POST['actividades'] ?? [];
}



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
    </section>
</header>

<h1>Pagar Reserva</h1>

<!-- Mostrar detalles de la reserva -->
<p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
<p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
<p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
<p><strong>Precio de la Habitación:</strong> $<?php echo number_format($precioHabitacion, 2); ?></p>
<p><strong>Número de Noches:</strong> <?php echo $numeroNoches; ?></p>
<p><strong>Precio Total (sin servicios):</strong> $<?php echo number_format($precioTotal - $totalServicios - $totalActividades, 2); ?></p>

<h3>Servicios Adicionales Seleccionados:</h3>
<?php
require_once __DIR__ ."/../controller/servicios/serviciosController.php";
$servicioController = new ServiciosController();

$serviciosSeleccionados = $_POST['servicios'] ?? []; // Si no hay selección, deja array vacío

if (!empty($serviciosSeleccionados)) {
    echo "<ul>";
    foreach ($serviciosSeleccionados as $idServicio => $precio) {
        $nombreServicio = $servicioController->obtenerNombreServicioPorId($idServicio); // Obtener el nombre
        if ($nombreServicio) {
            echo "<li>" . htmlspecialchars($nombreServicio) . " - $" . number_format($precio, 2) . "</li>";
        } else {
            echo "<li>Servicio ID: " . htmlspecialchars($idServicio) . " (No encontrado)</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No has seleccionado servicios adicionales.</p>";
}
?>

<h3>Actividades Seleccionadas:</h3>
<?php 
require_once __DIR__ . '/../controller/actividad/actividadController.php';
$actividadController = new ActividadController();

$actividadesSeleccionadas = $_SESSION['Reservas']['actividades'] ?? [];

if (!empty($actividadesSeleccionadas)) : ?>
    <ul>
        <?php 
        foreach ($actividadesSeleccionadas as $claveActividad => $precio) : 
            // Extraer solo el ID si la clave tiene el formato "ID|Precio"
            $idActividad = explode('|', $claveActividad)[0];  
            $idActividad = intval($idActividad); // Convertir a número entero

            // Obtener el nombre de la actividad
            $nombreActividad = $actividadController->obtenerNombreActividad($idActividad);
            $precio = floatval($precio); // Asegurar que el precio sea numérico

            if (!empty($nombreActividad)) {
                echo "<li>" . htmlspecialchars($nombreActividad) . " - $" . number_format($precio, 2) . "</li>";
            } else {
                echo "<li>Actividad desconocida - $" . number_format($precio, 2) . "</li>";
            }
        endforeach; 
        ?>
    </ul>
<?php else : ?>
    <p>No has seleccionado actividades adicionales.</p>
<?php endif; ?>






<!-- Precio Total con Servicios -->
<p><strong>Precio Total con Servicios:</strong> $<?php echo number_format($precioTotal, 2); ?></p>

<!-- Formulario de pago -->
<form id="pagoForm" action="../controller/pago/pagoController.php" method="POST" onsubmit="mostrarPopup(event)">

    <label for="numero_tarjeta">Número de Tarjeta:</label>
    <input type="text" name="numero_tarjeta" required><br>

    <label for="cvv">CVV:</label>
    <input type="text" name="cvv" required><br>

    <label for="fecha_expiracion">Fecha de Expiración:</label>
    <input type="month" name="fecha_expiracion" required><br>

    <!-- Datos de la reserva -->
    <input type="hidden" name="habitacionId" value="<?= htmlspecialchars($habitacionId); ?>">
    <input type="hidden" name="clienteId" value="<?= htmlspecialchars($clienteId); ?>">
    <input type="hidden" name="hotelId" value="<?= htmlspecialchars($hotelId); ?>">
    <input type="hidden" name="paisId" value="<?= htmlspecialchars($paisId); ?>">
    <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin); ?>">
    <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout); ?>">
    <input type="hidden" name="guests" value="<?= htmlspecialchars($guests); ?>">
    <input type="hidden" name="precioTotal" value="<?= htmlspecialchars($precioTotal); ?>">
    <input type="hidden" name="metodoPagoId" value="1">

    <!-- Actividades seleccionadas -->
    <?php foreach ($actividadesSeleccionadas as $actividadId) : ?>
        <input type="hidden" name="actividades[]" value="<?= htmlspecialchars($actividadId); ?>">
    <?php endforeach; ?>

    <!-- Servicios Adicionales -->
    <?php foreach ($serviciosSeleccionados as $idServicio => $precio) : ?>
        <input type="hidden" name="servicios[<?= $idServicio; ?>]" value="<?= htmlspecialchars($precio); ?>">
    <?php endforeach; ?>

    <button type="submit">Confirmar y Pagar</button>
</form>

<script src="../static/js/pagos/pagos.js"></script>
</body>
</html>


-------------------------------------------

 <ul>
        <?php 
        foreach ($datosReserva['actividades'] as $idActividad => $precio) : 
            if ($idActividad > 0) { // Asegurar que el ID de la actividad es válido
                $nombreActividad = $actividadController->obtenerNombreActividad($idActividad);
                $precio = floatval($precio); 
                if (!empty($nombreActividad)) {
                    echo "<li>" . htmlspecialchars($nombreActividad) . " - $" . number_format($precio, 2) . "</li>";
                } else {
                    echo "<li>Actividad ID: $idActividad (No encontrada en BD)</li>";
                }
            }
        endforeach; 
        ?>
    </ul>



    header detalles:

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
