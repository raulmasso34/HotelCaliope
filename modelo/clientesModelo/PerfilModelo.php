<?php
require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta sea correcta

class PerfilModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;  // Establecer la conexión a la base de datos
    }

    // Método para obtener el perfil del usuario por su ID
    public function getProfile($userId) {
        $sql = "SELECT * FROM Clients WHERE Id_Client = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $userId);  // Usamos 'i' para indicar que el parámetro es un entero
            $stmt->execute();  // Ejecutar la consulta
            $result = $stmt->get_result();

            // Si se encontró el usuario
            if ($user = $result->fetch_assoc()) {
                return $user;  // Retornar los datos del perfil
            } else {
                return null;  // Si no se encontró al usuario
            }
        }
        return null;  // Si hay algún error con la consulta
    }
}
?>
