<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Asegúrate de que los errores se muestren

require_once '../../Modelo/UsersModel/LoginModel.php'; // Incluir el modelo

class LoginController {
    private $usuarioModel;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($dbConnection) {
        $this->usuarioModel = new LoginModel($dbConnection); 
    }

    // Método para procesar el login
    public function login() {
        session_start(); // Iniciar la sesión
    
        // Verificar si se envió el formulario de login (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que los campos existen y no están vacíos
            $username = isset($_POST['Usuari']) ? trim($_POST['Usuari']) : ''; // Nombre de usuario
            $dni = isset($_POST['DNI']) ? trim($_POST['DNI']) : ''; // DNI
            $password = isset($_POST['Password']) ? $_POST['Password'] : ''; // Contraseña
    
            // Registrar los valores recibidos en el formulario para depuración
            error_log("Usuario: " . $username);  // Log de usuario
            error_log("Password: " . $password); // Log de contraseña
            error_log("DNI: " . $dni); // Log de DNI
    
            // Verificar si los campos no están vacíos
            if (!empty($username) && !empty($dni) && !empty($password)) {
                // Buscar al usuario por nombre de usuario o DNI
                $user = $this->usuarioModel->getUserByUsername($username, $password, $dni);
                error_log("Resultado de la consulta: " . var_export($user, true)); // Log de resultado de consulta
    
                // Verificar que el usuario existe y la contraseña es correcta
                if ($user) {
                    // Autenticación exitosa
                    $_SESSION['Usuari'] = $user['Usuari']; // Nombre de usuario en sesión
                    $_SESSION['Id_Client'] = $user['Id_Client']; // ID del cliente en sesión
                    error_log("Login exitoso para el usuario: " . $user['Usuari']);
    
                    // Redirigir a la página de inicio después del login exitoso
                    header('Location: ../../Vista/Inicio/index.php');
                    exit(); // Asegúrate de que el script termine aquí
                } else {
                    // Autenticación fallida
                    $error_message = "Usuario o contraseña incorrecta.";
                    error_log("Error en la autenticación: " . $error_message);
                    header('Location: ../../Vista/InicioSesion/login.php?error=' . urlencode($error_message));
                    exit(); // Terminar el script
                }
            } else {
                // Si algún campo está vacío
                $error_message = "Por favor, complete todos los campos.";
                error_log("Campos vacíos: " . $error_message); // Log de campos vacíos
                header('Location: ../../Vista/InicioSesion/login.php?error=' . urlencode($error_message));
                exit(); // Terminar el script
            }
        } else {
            // Si no es una solicitud POST, mostrar el formulario de login
            require_once('../../Vista/InicioSesion/login.php');
        }
    }

    // Cerrar sesión
    public function logout() {
        session_start();
        session_destroy(); // Destruir la sesión
        header('Location: ../../Vista/InicioSesion/login.php'); // Redirige al formulario de login
        exit(); // Terminar el script
    }
}
