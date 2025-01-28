<?php
session_start();  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Si no está autenticado, redirigir a login
    exit();
}

require_once __DIR__ . '/../../config/Database.php';  // Incluir la configuración de la base de datos
require_once __DIR__ . '/../../modelo/clientesModelo/PerfilModelo.php';  // Incluir el modelo del perfil

// Crear la conexión a la base de datos
$db = new Database();
$conn = $db->getConnection();



// Crear una instancia del modelo PerfilModel
$perfilModel = new PerfilModel($conn);

// Obtener el ID del usuario desde la sesión
$userId = $_SESSION['user_id'];  // Recuperamos el ID del usuario que inició sesión

// Obtener el perfil del usuario
$profile = $perfilModel->getProfile($userId);
$reservations = $perfilModel->getReservations($userId);

if ($profile === null) {
    echo "Error al obtener el perfil.";
    exit();
}

// Cerrar la conexión
$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../../static/css/InicioSesion.css"> <!-- Añade el enlace a tu archivo CSS -->
</head>
<body>
    <div class="profile-container">
        <h1 class="profile-title">Perfil de <?php echo htmlspecialchars($profile['Nom']) . " " . htmlspecialchars($profile['Cognom']); ?></h1>
        
        <div class="profile-info">
            <p><strong>Nombre de usuario:</strong> <span class="profile-detail"><?php echo htmlspecialchars($profile['Usuari']); ?></span></p>
            <p><strong>DNI:</strong> <span class="profile-detail"><?php echo htmlspecialchars($profile['DNI']); ?></span></p>
            <p><strong>Email:</strong> <span class="profile-detail"><?php echo htmlspecialchars($profile['CorreuElectronic']); ?></span></p>
            <p><strong>Teléfono:</strong> <span class="profile-detail"><?php echo htmlspecialchars($profile['Telefon']); ?></span></p>
            <p><strong>Ciudad:</strong> <span class="profile-detail"><?php echo htmlspecialchars($profile['Ciudad']); ?></span></p>
            <p><strong>Código Postal:</strong> <span class="profile-detail"><?php echo htmlspecialchars($profile['CodigoPostal']); ?></span></p>
        </div>

        <!-- Mostrar las reservas -->
        <div class="reservas-info">
            <h2>Reservas:</h2>
            <?php
            if (isset($reservations) && !empty($reservations)) {
                $visibleReservations = array_slice($reservations, 0, 3);
                $hiddenReservations = array_slice($reservations, 3);

                foreach ($visibleReservations as $reservation) {
                    echo "<div class='reservation-button'>";
                    echo "<a href='../info_reserva.php?id=" . urlencode($reservation['Id_Reserva']) . "' class='btn-reserva'>";
                    echo "Hotel: " . htmlspecialchars($reservation['Nombre']);
                    echo "</a>";
                    echo "</div>";
                }

                if (!empty($hiddenReservations)) {
                    echo "<div id='more-reservations' class='hidden-reservations'>";
                    foreach ($hiddenReservations as $reservation) {
                        echo "<div class='reservation-button'>";
                        echo "<a href='../info_reserva.php?id=" . urlencode($reservation['Id_Reserva']) . "' class='btn-reserva'>";
                        echo "Hotel: " . htmlspecialchars($reservation['Nombre']);
                        echo "</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "<button id='show-more' class='toggle-reservations-btn'>Ver más reservas</button>";
                    echo "<button id='show-less' class='toggle-reservations-btn' style='display: none;'>Ocultar</button>";
                }
            } else {
                echo "<p>No tienes reservas.</p>";
            }
            ?>
        </div>

    
        <div class="perfil-salir"> 
            <a href="../index.php">Volver a la pantalla principal</a>
        </div>
    </div>
</div>


<script src="../../static/js/perfil/pefil.js"></script>
</body>
</html>
