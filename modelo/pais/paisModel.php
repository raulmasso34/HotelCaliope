<?php
require_once __DIR__ . '/../../config/Database.php';

class PaisesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todos los países de la base de datos
    public function obtenerPaises() {
        $sql = "SELECT * FROM Pais";  // Asumimos que tienes una tabla 'paises' con al menos 'Id_Pais' y 'Nombre'

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve un array asociativo
    }
    public function obtenerNombrePais($paisId) {
        $sql = "SELECT Pais FROM Pais WHERE Id_Pais = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paisId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $pais = $result->fetch_assoc();
            return $pais['Pais']; // Retorna el nombre del país
        } else {
            return null; // Si no se encuentra el país
        }
    }
}
?>
