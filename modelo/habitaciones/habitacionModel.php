<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para obtener las habitaciones disponibles
    public function obtenerHabitacionesDisponibles($paisId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Pais = ? AND Disponibilidad > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paisId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para obtener una habitación por su ID
    public function obtenerHabitacionPorId($habitacionId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $habitacionId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si se encuentra una habitación, devuelve la información
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  // Devuelve un solo registro
        } else {
            return null;  // Si no encuentra ninguna habitación
        }
    }
}
?>
