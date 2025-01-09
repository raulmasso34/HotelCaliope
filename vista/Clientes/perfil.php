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
                echo "<table>";
                echo "<tr><th>Actividad</th><th>Habitación</th><th>Hotel</th><th>Tarifa</th><th>Precio Total</th></tr>";

                foreach ($reservations as $reservation) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($reservation['Id_Actividad']) . "</td>";
                    echo "<td>" . htmlspecialchars($reservation['Id_Habitacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($reservation['Id_Hotel']) . "</td>";
                    echo "<td>" . htmlspecialchars($reservation['Precio_Habitacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($reservation['Precio_Total']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No tienes reservas.</p>";
            }
            ?>
        </div>

        <!-- Enlace para editar el perfil -->
        <div class="edit-profile">
            <a href="editProfile.php" class="edit-link">Editar perfil</a>
        </div>
        <div class="perfil-salir"> 
            <a href="">Volver a la pantalla principal</a>
        </div>
    </div>
</div>

</body>
</html>
