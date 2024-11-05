<?php
// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../Configuracion/Database.php'); 
require_once('../../Modelo/UersModel/LoginModel.php');

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
            // Validar que los campos existen y no están vacíos
            $username = isset($_POST['Username']) ? $_POST['Username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (!empty($username) && !empty($password)) {
                // Verificar las credenciales
                $user = $this->usuarioModel->getUserByUsername($username);
                
                if ($user && password_verify($password, $user['Password'])) {
                    // Autenticación correcta
                    $_SESSION['Usuari'] = $user['Usuari'];
                    $_SESSION['Id_Client'] = $user['Id_Client'];
                    
                    // Redirige al dashboard o página de inicio
                    header('Location: ../../Vista/Inicio/index.php');
                    exit();
                } else {
                    // Autenticación fallida, redirige a la página de login
                    $error_message = "Usuari o contrasenya incorrecta.";
                    header('Location: ../../Vista/InicioSesion/login.php?error=' . urlencode($error_message));
                    exit();
                }
            } else {
                echo "<h1>Faltan datos de usuario o contraseña</h1>"; // Mensaje para depurar
            }
        } else {
            // Si no es una solicitud POST, solo carga la vista de login
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
?>
