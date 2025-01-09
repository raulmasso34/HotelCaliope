<?php
require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta sea correcta
session_start();  // Iniciar sesión para acceder a la sesión

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class LoginModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;  // Establecer la conexión a la base de datos
    }

    public function authenticate($username, $password, $dni) {
        // Validar que los campos no estén vacíos
        if (empty($username) || empty($password) || empty($dni)) {
            echo "Todos los campos son obligatorios.";
            return false;
        }

        // Consulta para obtener el usuario por su nombre de usuario y DNI
        $sql = "SELECT * FROM Clients WHERE Usuari = ? AND DNI = ?";  // Se añade la verificación del DNI

        // Preparar la consulta
        if ($stmt = $this->conn->prepare($sql)) {
            // Asociar los parámetros de la consulta
            $stmt->bind_param("ss", $username, $dni);  // Ambos parámetros son cadenas (s = string)
            $stmt->execute();  // Ejecutar la consulta
    
            // Obtener los resultados
            $result = $stmt->get_result();
    
            // Si encontramos el usuario
            if ($user = $result->fetch_assoc()) {
                // Verificar la contraseña usando password_verify
                if (password_verify($password, $user['Password'])) {
                    // La autenticación fue exitosa, devolver los datos del usuario
                    return $user;
                } else {
                    // La contraseña es incorrecta
                    echo "Contraseña incorrecta.";
                }
            } else {
                // El usuario no existe
                echo "Usuario no encontrado.";
            }
        } else {
            // Error al preparar la consulta SQL
            echo "Error al preparar la consulta SQL.";
        }
    
        return false;  // Si no se encontró el usuario, el DNI no coincide o la contraseña no es válida
    }
}
?>
