<?php
require_once __DIR__ . '/../../config/Database.php';  // Incluir la configuración de la base de datos

class LoginModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;  // Establecer la conexión a la base de datos
    }

    // Función de autenticación
    public function authenticate($username, $password) {
        // Validar que los campos no estén vacíos
        if (empty($username) || empty($password)) {
            return false;
        }
    
        // Consulta para obtener el usuario solo por su nombre de usuario
        $sql = "SELECT * FROM Clients WHERE Usuari = ?";
    
        // Preparar la consulta
        if ($stmt = $this->conn->prepare($sql)) {
            // Asociar los parámetros de la consulta
            $stmt->bind_param("s", $username);  // Un solo parámetro (s = string)
            $stmt->execute();  // Ejecutar la consulta
    
            // Obtener los resultados
            $result = $stmt->get_result();
    
            // Si encontramos el usuario
            if ($user = $result->fetch_assoc()) {
                // Verificar la contraseña usando password_verify
                if (password_verify($password, $user['Password'])) {
                    // La autenticación fue exitosa, devolver los datos del usuario
                    return $user;
                }
            }
            
            $stmt->close();
        }
    
        return false;  // Si no se encontró el usuario o la contraseña no es válida
    }
}
?>
