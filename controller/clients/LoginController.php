<?php
session_start();  // Iniciar sesión al principio

require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta sea correcta
require_once __DIR__ . '/../../modelo/clientesModelo/LoginModel.php';  // Asegúrate de que la ruta sea correcta
require_once __DIR__ . '/../../modelo/clientesModelo/PerfilModelo.php';  // Incluir el modelo de perfil

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class LoginController {
    private $conn;
    private $loginModel;
    private $perfilModel;

    public function __construct() {
        // Obtener la conexión a la base de datos
        $this->conn = (new Database())->getConnection();
        $this->loginModel = new LoginModel($this->conn);  // Crear una instancia del modelo de login
        $this->perfilModel = new PerfilModel($this->conn);  // Crear una instancia del modelo de perfil
    }

    // Función de login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar si el CAPTCHA fue marcado
            if (!isset($_POST['captcha'])) {
                header("Location: ../../vista/Clientes/login.php?error=Debes marcar la casilla de verificación.");
                exit();
            }
            
            $username = $_POST['Usuari'];  // Obtener el nombre de usuario del formulario
            $password = $_POST['Password'];  // Obtener la contraseña del formulario
    
            // Autenticar el usuario solo con username y password (sin DNI)
            $user = $this->loginModel->authenticate($username, $password);
    
            if ($user) {
                // Si el usuario existe y la contraseña es correcta, establecer sesión y redirigir al perfil
                $_SESSION['user_id'] = $user['Id_Client'];  // Guardar el ID del usuario en la sesión
                $_SESSION['username'] = $user['Usuari'];  // Guardar el nombre de usuario en la sesión
                header("Location: ../../vista/index.php");  // Redirigir al perfil
                exit;  // Asegúrate de que el flujo se detenga después de la redirección
            } else {
                // Si las credenciales son incorrectas
                header("Location: ../../vista/Clientes/login.php?error=Usuario o contraseña incorrectos");
                exit;
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si el CAPTCHA fue marcado
            if (!isset($_POST['captcha'])) {
                header("Location: ../../vista/Clientes/login.php?error=Debes marcar la casilla de verificación.");
                exit();
            }
        
            // Aquí iría tu código de autenticación del usuario
            echo "✔ CAPTCHA correcto. Iniciando sesión...";
        }
    }
    

    // Mostrar perfil
    public function showProfile() {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['user_id'])) {
            // Si no está autenticado, redirigir a la página de login
            header("Location: ../../vista/Clientes/login.php");  // Asegúrate de que la ruta sea correcta
            exit;
        }

        // Obtener el perfil del usuario
        $userId = $_SESSION['user_id'];
        $userProfile = $this->perfilModel->getProfile($userId);  // Obtener la información del perfil

        if ($userProfile) {
            // Mostrar la vista del perfil con los datos del usuario
            include_once __DIR__ . '/../../vista/Clientes/perfil.php';  // Cargar la vista del perfil
        } else {
            echo "No se pudo cargar el perfil.";
        }
    }

    // Método de logout
    public function logout() {
        // Eliminar las variables de sesión
        session_unset();

        // Destruir la sesión
        session_destroy();

        // Redirigir a la página de login
        header("Location: ../../vista/index.php");  // Cambia la ruta si es necesario
        exit;
    }
}

// Verificar si la acción solicitada es logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    $controller = new LoginController();
    $controller->logout();  // Llamar al método de logout
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new LoginController();
    $controller->login();  // Llamar al método de login
}
?>
