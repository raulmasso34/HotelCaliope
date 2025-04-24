<?php
session_start();
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controller/clients/EditController.php';  // Ajusta la ruta según tu estructura

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: edit_profile.php');  // O la página donde esté tu formulario
    exit();
}

$clienteId = $_SESSION['user_id'];

// Crear conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Crear instancia del controlador
$editController = new EditController($db);

// Obtener datos del formulario
$newUsername = isset($_POST['username']) ? trim($_POST['username']) : '';
$currentPassword = isset($_POST['current_password']) ? trim($_POST['current_password']) : '';
$newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
$confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

// Validar que la nueva contraseña coincida con la confirmación
if (!empty($newPassword) && $newPassword !== $confirmPassword) {
    $_SESSION['message'] = 'La nueva contraseña y su confirmación no coinciden';
    $_SESSION['message_type'] = 'error';
    header('Location: edit_profile.php');  // Volver al formulario
    exit();
}

// Procesar la actualización
$result = $editController->updateCredentials($clienteId, $newUsername, $currentPassword, $newPassword);

// Guardar mensaje en la sesión para mostrarlo después de la redirección
if (isset($result['success'])) {
    $_SESSION['message'] = $result['success'];
    $_SESSION['message_type'] = 'success';
    header('Location: perfil.php'); // Redirigir al perfil si todo salió bien
} else {
    $_SESSION['message'] = $result['error'];
    $_SESSION['message_type'] = 'error';
    header('Location: edit_profile.php'); // Volver al formulario si hubo error
}
exit();
?>