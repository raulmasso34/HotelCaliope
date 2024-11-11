<?php
require_once __DIR__ . '/../../Configuracion/Database.php';  // Asegúrate de que la ruta sea correcta

class LoginModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;  // Establecer la conexión
    }

    public function authenticate($username, $password) {
        // Consulta para obtener el usuario por su nombre
        $sql = "SELECT * FROM Clients WHERE Usuari = ?";

        // Preparar la consulta
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("s", $username);  // Asociar el parámetro
            $stmt->execute();  // Ejecutar la consulta

            // Obtener los resultados
            $result = $stmt->get_result();

            // Si encontramos el usuario
            if ($user = $result->fetch_assoc()) {
                // Verificar la contraseña usando password_verify
                if (password_verify($password, $user['Password'])) {
                    return $user;  // Usuario autenticado correctamente
                }
            }
        }

        return false;  // Si no se encontró el usuario o la contraseña no es válida
    }
}
?>
