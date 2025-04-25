<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '../../../controller/clients/EditController.php';


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$clienteId = $_SESSION['user_id'];

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Crear instancia del controlador
$editController = new EditController($db);

// Variable para mensajes
$message = '';
$messageType = '';

// Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = isset($_POST['username']) ? trim($_POST['username']) : '';
    $currentPassword = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';
    $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    
    // Validar que la nueva contraseña coincida con la confirmación
    if (!empty($newPassword) && $newPassword !== $confirmPassword) {
        $message = 'La nueva contraseña y su confirmación no coinciden';
        $messageType = 'error';
    } else {
        // Procesar la actualización
        $result = $editController->updateCredentials($clienteId, $newUsername, $currentPassword, $newPassword);
        
        if (isset($result['success'])) {
            $message = $result['success'];
            $messageType = 'success';
        } else {
            $message = $result['error'];
            $messageType = 'error';
        }
    }
}

// Obtener datos actuales del cliente
$clientData = $editController->getClientData($clienteId);

// Obtener historial de cambios (opcional)
// $clientHistory = $editController->getClientHistory($clienteId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../../static/css/editPerfil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>
<body>
    <div class="profile-edit-wrapper">

        <!-- Barra lateral -->
        <aside class="profile-sidebar">
            <div class="logo-container">
                <img src="../../static/img/logo_blanco.png" alt="Logo" class="brand-logo">
                <span class="company-name">Hotel Caliope</span>
            </div>

            <nav class="profile-nav">
                <a href="perfil.php" class="nav-item active"><i class="bi bi-person"></i> Perfil</a>
                <a href="../index.php" class="nav-item"><i class="bi bi-house"></i> Inicio</a>
                <a href="../Contacto/contacto.php" class="nav-item"><i class="bi bi-envelope-at"></i> Contacto</a>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <div class="profile-content">
            <div class="profile-header">
                <h1 class="profile-title"><i class="bi bi-person"></i>Editar Perfil</h1>
            </div>

            <div class="profile-edit-container">
                <?php if (!empty($message)): ?>
                    <div class="message-alert message-<?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="procesar_edicion.php" class="profile-form">

                    <div class="form-section">
                        <div class="form-group">
                            <label for="username" class="form-label">Nombre de Usuario:</label>
                            <input type="text" id="username" name="username" class="form-input"
                                   value="<?php echo htmlspecialchars($clientData['Usuari']); ?>" readonly>
                        </div>
                    </div>
                    
                    

                    <div class="form-section">
                        <div class="form-header">
                            <h3><i class="bi bi-lock"></i>Cambiar Contraseña</h3>
                            <p class="section-description">Deja estos campos en blanco si no deseas cambiar tu contraseña.</p>
                        </div>

                        <div class="form-group">
                            <label for="current_password" class="form-label">Contraseña Actual:</label>
                            <input type="password" id="current_password" name="current_password" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="new_password" class="form-label">Nueva Contraseña:</label>
                            <input type="password" id="new_password" name="new_password" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña:</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-input">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="action-button primary-button">Guardar Cambios</button>
                        <a href="perfil.php" class="action-button secondary-button">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
