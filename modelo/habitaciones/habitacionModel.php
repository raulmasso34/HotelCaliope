<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function obtenerHabitaciones() {
        $query = $this->conn->prepare("SELECT * FROM Habitaciones");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPrecioHabitacion($habitacionId) {
        $query = "SELECT Precio FROM Habitaciones WHERE Id_Habitaciones = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $habitacionId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['Precio'];
        }
        return 0; // Retorna 0 si no encuentra la habitación
    }

    public function obtenerHabitacionPorId($habitacionId) {
        try {
            $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";  
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $habitacionId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $habitacion = $result->fetch_assoc();
            $stmt->close();
            return $habitacion;
        } catch (Exception $e) {
            error_log("Error al obtener habitación: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerHabitacionesPorHotel($hotelId) {
        $fechaActual = date('Y-m-d');
        $checkin = $_SESSION['checkin'];  
        $checkout = $_SESSION['checkout']; 
    
        $query = `SELECT * FROM Habitaciones 
                  WHERE Id_Hotel = ?
                  AND NOT EXISTS (
                      SELECT 1 FROM Reservas 
                      WHERE Reservas.Id_Habitacion = Habitaciones.Id_Habitaciones
                      AND (
                          (Reservas.Checkin BETWEEN ? AND ?) 
                          OR (Reservas.Checkout BETWEEN ? AND ?)
                          OR (Reservas.Checkin <= ? AND Reservas.Checkout >= ?)
                      )
                  )`; 
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issssss", $hotelId, $fechaActual, $fechaActual, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $habitaciones = [];
        while ($row = $result->fetch_assoc()) {
            $habitaciones[] = $row;
        }
    
        return $habitaciones;
    }
}
?>
