<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';

$reservaController = new ReservaController();

// Verifica si ya tienes el hotelId en la sesión
if (isset($_POST['hotelId'])) {
    $_SESSION['hotelId'] = $_POST['hotelId']; // Guardamos el hotelId en la sesión cuando se selecciona
}

$hotelId = $_SESSION['hotelId'] ?? null; // Recuperamos el hotelId de la sesión

// Si el hotelId no está definido, muestra un mensaje de error
if ($hotelId === null) {
    echo "No se ha seleccionado un hotel.";
    exit; // Termina la ejecución si no se ha seleccionado un hotel
}

// Obtener los servicios desde el controlador
$servicios = $reservaController->mostrarServicios();

// Verifica si se ha enviado el formulario para seleccionar servicios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['servicios'])) {
    // Recuperar los servicios seleccionados del formulario
    $serviciosSeleccionados = $_POST['servicios'];

    // Guardamos los servicios seleccionados en la sesión
    $_SESSION['Reservas']['servicios'] = $serviciosSeleccionados;
    
    // (Opcional) Guardamos el precio total de los servicios seleccionados en la sesión
    $totalServicios = array_sum($serviciosSeleccionados); // Sumar el precio de todos los servicios seleccionados
    $_SESSION['Reservas']['totalServicios'] = $totalServicios;

    // Redirigir a la página de pagos
    header("Location: pagos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/servicios.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Servicios</title>
</head>
<body>

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

    <h1>¿Quieres alguno de estos servicios?</h1>
    <div class="servicios-container">
        <?php if (!empty($servicios)) : ?>
            <!-- Mostrar los servicios -->
            <form action="" method="POST"> <!-- Enviamos el formulario con los servicios seleccionados -->
                <div class="servicios-lista">
                    <?php foreach ($servicios as $servicio) : ?>
                        <?php 
                        // Definir la ruta de la imagen según el nombre del servicio
                        $imagen = '../static/img/servicios/' . strtolower(str_replace(' ', '_', $servicio['Servicio'])) . '.jpg'; 
                        // Comprobar si la imagen existe
                        $imagen_path = file_exists($imagen) ? $imagen : 'images/default.jpg'; // Imagen por defecto si no se encuentra la específica
                        ?>
                        <div class="servicio" id="servicio-<?php echo $servicio['Id_Servicio']; ?>">
                            <img src="<?php echo $imagen_path; ?>" alt="Imagen de <?php echo $servicio['Servicio']; ?>" class="imagen-servicio">
                            <h3><?php echo $servicio['Servicio']; ?></h3>
                            <p><?php echo $servicio['Descripcion']; ?></p>
                            <p>Precio: <?php echo $servicio['Precio']; ?>€</p>
                            <!-- Checkbox para seleccionar el servicio -->
                            <label>
                                <input type="checkbox" name="servicios[<?php echo $servicio['Id_Servicio']; ?>]" value="<?php echo $servicio['Precio']; ?>">
                                Seleccionar
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Continuar a pagos -->
                <div class="continuar-btn">
                    <input type="submit" value="Continuar con servicio" id="btn-continuar">
                </div>
            </form>
        <?php else : ?>
            <p>No hay servicios disponibles en este momento.</p>
        <?php endif; ?>
    </div>

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

</body>
</html>
