<?php
// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// index.php o donde inicialices el controlador
require_once('../config/Database.php'); // Asegúrate de que esta ruta sea correcta
require_once('../models/Usuario.php'); // Asegúrate de incluir el modelo de Usuario


// Crear conexión a la base de datos    
$db = new Database();
$connection = $db->getConnection();

// Crear instancia del LoginController y llamar al método login
$loginController = new LoginController($connection);
$loginController->login(); // Llama al método login

class LoginController {
    private $usuarioModel;

    public function __construct($dbConnection) {
        // Crear una instancia del modelo con la conexión a la DB
        $this->usuarioModel = new Usuario($dbConnection);
    }

    public function login() {
        session_start(); // Iniciar la sesión

        // Verificar si se envió el formulario de login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['Username'];
            $password = $_POST['password'];

            // Verificar las credenciales
            $user = $this->usuarioModel->getUserByUsername($username);
            if ($user && password_verify($password, $user['Password'])) {
                echo "Usuario autenticado correctamente"; // Mensaje temporal
                $_SESSION['Username'] = $user['Username'];
                $_SESSION['ID_Usuari'] = $user['ID_Usuari'];
                $_SESSION['role'] = $user['role']; 
                
                // Redirige al dashboard o página de inicio
                header('Location: ../views/layout/main.php');
                exit();
            } else {
                echo "<h1>Fallo en la autenticación</h1>"; // Mensaje temporal para depurar
                $error_message = "Usuari o contrasenya incorrecta.";
                header('../views/usuarios/login.php');
                exit();
            }
            
        } else {
            // Si no es una solicitud POST, solo carga la vista de login
            require_once('../views/usuarios/login.php');
        }
    }

    // Cerrar sesión
    public function logout() {
        session_start();
        session_destroy(); // Destruye la sesión
        header('Location: ../views/usuarios/login.php'); // Redirige al formulario de login
        exit();
    }
}
?>
