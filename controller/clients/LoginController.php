<?php
require_once __DIR__ . '/../../Configuracion/Database.php';  // Asegúrate de que la ruta sea correcta
require_once __DIR__ . '/../../Modelo/UsersModel/LoginModel.php';  // Asegúrate de que la ruta sea correcta
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class LoginController {
    private $conn;
    private $loginModel;

    public function __construct() {
        // Obtener la conexión a la base de datos
        $this->conn = (new Database())->getConnection();
        $this->loginModel = new LoginModel($this->conn);  // Crear una instancia del modelo
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['Usuari'];  // Obtener el nombre de usuario del formulario
            $dni = $_POST['DNI'];  // Obtener el DNI del formulario
            $password = $_POST['Password'];  // Obtener la contraseña del formulario

            // Autenticar el usuario
            $user = $this->loginModel->authenticate($username, $password, $dni);

            if ($user) {
                // Si el usuario existe y la contraseña es correcta, redirigir al dashboard
                echo "Bienvenido, " . $user['Usuari'];  // O usar header("Location: dashboard.php"); para redirigir
                header("Location: ../../Vista/Inicio/index.php");
                exit;
            } else {
                // Si las credenciales son incorrectas
                echo "Usuario o contraseña incorrectos.";
            }
        }
    }
}

// Crear el controlador y ejecutar el método login
$controller = new LoginController();
$controller->login();
?>
