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
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Perfil</h1>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="procesar_edicion.php">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($clientData['Usuari']); ?>" required>
            </div>
            
            <h2>Cambiar Contraseña</h2>
            <p>Deja estos campos en blanco si no deseas cambiar tu contraseña.</p>
            
            <div class="form-group">
                <label for="current_password">Contraseña Actual:</label>
                <input type="password" id="current_password" name="current_password">
            </div>
            
            <div class="form-group">
                <label for="new_password">Nueva Contraseña:</label>
                <input type="password" id="new_password" name="new_password">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>