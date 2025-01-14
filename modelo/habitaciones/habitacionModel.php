<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener habitación por ID para obtener detalles como el precio
    public function obtenerHabitacionPorId($habitacionId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $habitacionId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve los detalles de la habitación seleccionada
    }
}
?>
