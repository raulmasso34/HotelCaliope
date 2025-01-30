<?php
session_start();  // Iniciar sesión para acceder a la sesión

// Mostrar errores si es necesario
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Si no está autenticado, redirigir a login
    exit();
}

// Incluir la configuración de la base de datos y el modelo
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../modelo/clientesModelo/PerfilModelo.php';

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

// Obtener las reservas del usuario usando el método getReservations
$reservations = $perfilModel->getReservations($userId);

// Si no hay reservas, inicializamos el array vacío
if ($reservations === null) {
    $reservations = [];
}

// Cerrar la conexión
$db->closeConnection();

// Pasar las variables a la vista para su visualización
include __DIR__ . '/../../vista/Clientes/perfil.php';  // Cambiar 'require' por 'include' para cargar la vista
?>
