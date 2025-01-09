<?php
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

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['Usuari'];  // Obtener el nombre de usuario del formulario
            $dni = $_POST['DNI'];  // Obtener el DNI del formulario
            $password = $_POST['Password'];  // Obtener la contraseña del formulario

            // Autenticar el usuario
            $user = $this->loginModel->authenticate($username, $password, $dni);

            if ($user) {
                // Si el usuario existe y la contraseña es correcta, establecer sesión y redirigir al perfil
                session_start();  // Iniciar sesión
                $_SESSION['user_id'] = $user['Id_Client'];  // Guardar el ID del usuario en la sesión
                $_SESSION['username'] = $user['Usuari'];  // Guardar el nombre de usuario en la sesión
                header("Location: /perfil");  // Redirigir al perfil
                exit;
            } else {
                // Si las credenciales son incorrectas
                echo "Usuario o contraseña incorrectos.";
            }
        }
    }

    public function showProfile() {
        // Verificar si el usuario ha iniciado sesión
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Si no está autenticado, redirigir a la página de login
            header("Location: /login");
            exit;
        }

        // Obtener el perfil del usuario
        $userId = $_SESSION['user_id'];
        $userProfile = $this->perfilModel->getProfile($userId);  // Obtener la información del perfil

        if ($userProfile) {
            // Mostrar la vista del perfil con los datos del usuario
            include_once __DIR__ . '/../../vista/perfil.php';  // Cargar la vista del perfil
        } else {
            echo "No se pudo cargar el perfil.";
        }
    }

    public function logout() {
        // Cerrar la sesión del usuario
        session_start();
        session_unset();
        session_destroy();
        header("Location: /login");  // Redirigir al login
        exit;
    }
}
?>
