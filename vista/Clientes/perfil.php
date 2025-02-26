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
$userId = $_SESSION['user_id'];

// Obtener el perfil del usuario
$profile = $perfilModel->getProfile($userId);
$reservations = $perfilModel->getReservations($userId);

// Verifica si se obtuvo el perfil
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
    <link rel="stylesheet" href="../../static/css/InicioSesion.css">
    <link rel="shortcut icon" href="../../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Agregar Font Awesome -->

    <style>
        .reservation-button {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    
    <div class="profile-container">
    <a href="../index.php" class="icono-salida" title="Volver atrás">
                <i class="fas fa-sign-out-alt"></i> <!-- Icono de salida -->
            </a>
        
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
            <div class="reservas-principales">
                <?php
                $tieneReservasActivas = false;
                $count = 0;

                if (isset($reservations) && !empty($reservations)) {
                    foreach ($reservations as $reservation) {
                        if ($reservation['Estado'] == 'Cancelada') {
                            continue; // Omitir reservas canceladas
                        }
                        if ($count >= 3) {
                            break; // Mostrar solo las primeras 3 reservas
                        }
                        $tieneReservasActivas = true; // Al menos una reserva activa

                        echo "<div class='reservation-button'>";
                        echo "<a href='../info_reserva.php?id=" . urlencode($reservation['Id_Reserva']) . "' class='btn-reserva'>";
                        echo "Hotel: " . htmlspecialchars($reservation['Nombre']);
                        echo "</a>";
                        echo "</div>";
                        $count++;
                    }
                }

                if (!$tieneReservasActivas) {
                    echo "<p>No tienes reservas activas.</p>";
                }
                ?>
            </div>

            <div id="more-reservations" style="display: none;">
                <?php
                // Mostrar reservas adicionales
                if (isset($reservations) && !empty($reservations)) {
                    foreach ($reservations as $reservation) {
                        if ($reservation['Estado'] == 'Cancelada') {
                            continue; // Omitir reservas canceladas
                        }
                        if ($count >= 3) {
                            echo "<div class='reservation-button'>";
                            echo "<a href='../info_reserva.php?id=" . urlencode($reservation['Id_Reserva']) . "' class='btn-reserva'>";
                            echo "Hotel: " . htmlspecialchars($reservation['Nombre']);
                            echo "</a>";
                            echo "</div>";
                        }
                        $count++;
                    }
                }
                ?>
            </div>

            <button id="show-more" class="btn-show btn-show-more">
                <i class="bi bi-plus"></i> <!-- Ícono de más -->
            </button>
            <button id="show-less" class="btn-show btn-show-less" style="display: none;">
                <i class="bi bi-dash"></i> <!-- Ícono de menos -->
            </button>
            



        </div>
    </div>

    <script src="../../static/js/perfil/pefil.js"></script>
</body>
</html>
