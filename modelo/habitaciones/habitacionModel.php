<?php
class HabitacionModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener habitaciones disponibles filtradas por país, fechas y número de personas
    public function obtenerHabitacionesDisponiblesFiltradas($paisId, $checkin, $checkout, $guests) {
        $sql = "SELECT * FROM Habitaciones
                WHERE Id_Hotel IN (SELECT Id_Hotel FROM Hotel WHERE Id_Pais = ?)
                AND Disponibilidad > 0 
                AND Capacidad >= ?
                AND Id_Habitaciones NOT IN (SELECT Id_Habitacion FROM Reservas WHERE (Checkin BETWEEN ? AND ? OR Checkout BETWEEN ? AND ?))";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiisss", $paisId, $guests, $checkin, $checkout, $checkin, $checkout);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener los detalles de una habitación específica por su ID
    public function obtenerHabitacionPorId($habitacion_id) {
        // Consulta para obtener los detalles de la habitación por su ID
        $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $habitacion_id);
        $stmt->execute();

        $result = $stmt->get_result();

        // Verificar si la habitación fue encontrada
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  // Retorna los detalles de la habitación como un array asociativo
        } else {
            return null;  // Si no se encuentra la habitación, retorna null
        }
    }
}
?>
