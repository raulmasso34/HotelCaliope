<?php
require_once __DIR__ . '/../../config/Database.php'; 
class HabitacionModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerHabitacionesDisponibles() {
        $sql = "SELECT * FROM Habitaciones WHERE Disponibilidad > 1";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
