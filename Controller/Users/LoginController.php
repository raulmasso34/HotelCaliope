<?php
// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../Configuracion/Database.php'); 
require_once('../../Modelo/UsersModel/LoginModel.php');

// Crear conexión a la base de datos    
$db = new Database();
$connection = $db->getConnection();

// Crear instancia del LoginController y llamar al método login
$loginController = new LoginController($connection);
$loginController->login(); // Llama al método login

class LoginController {
    private $usuarioModel;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($dbConnection) {
        // Crear una instancia del modelo con la conexión a la DB
        $this->usuarioModel = new Usuario($dbConnection);
    }

    public function login() {
        session_start(); // Iniciar la sesión
    
        // Verificar si se envió el formulario de login (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que los campos existen y no están vacíos
            $username = isset($_POST['Usuari']) ? trim($_POST['Usuari']) : ''; // Nombre de usuario
            $dni = isset($_POST['DNI']) ? trim($_POST['DNI']) : ''; // DNI
            $password = isset($_POST['Password']) ? $_POST['Password'] : ''; // Contraseña
    
            // Verificar si los campos no están vacíos
            if (!empty($username) && !empty($dni) && !empty($password)) {
                // Buscar al usuario por nombre de usuario o DNI
                $user = $this->usuarioModel->getUserByUsername($username, $dni);
                
                // Verificar que el usuario existe y la contraseña es correcta
                if ($user && password_verify($password, $user['Password'])) {
                    // Autenticación exitosa
                    $_SESSION['Usuari'] = $user['Usuari']; // Nombre de usuario en sesión
                    $_SESSION['Id_Client'] = $user['Id_Client']; // ID del cliente en sesión
        
                    // Redirigir al dashboard o página de inicio
                    header('Location: ../../Vista/Inicio/index.php');
                    exit();
                } else {
                    // Autenticación fallida, redirigir a la página de login con un mensaje de error
                    $error_message = "Usuario o contraseña incorrecta.";
                    header('Location: ../../Vista/InicioSesion/login.php?error=' . urlencode($error_message));
                    exit();
                }
            } else {
                // Si algún campo está vacío, redirigir con mensaje de error
                $error_message = "Por favor, complete todos los campos.";
                header('Location: ../../Vista/InicioSesion/login.php?error=' . urlencode($error_message));
                exit();
            }
        } else {
            // Si no es una solicitud POST, mostrar el formulario de login
            require_once('../../Vista/InicioSesion/login.php');
        }
    }
    
    // Cerrar sesión
    public function logout() {
        session_start();
        session_destroy(); // Destruye la sesión
        header('Location: ../../Vista/InicioSesion/login.php'); // Redirige al formulario de login
        exit();
    }
}
