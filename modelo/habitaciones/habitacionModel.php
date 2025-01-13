<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function obtenerHabitacionesDisponibles($paisId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Hotel = ? AND Disponibilidad = 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paisId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
