<?php
session_start();  // Iniciar sesión para acceder a la sesión
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

// Incluir la vista del perfil
require_once __DIR__ . '/../../vista/Clientes/perfil.php';
?>
