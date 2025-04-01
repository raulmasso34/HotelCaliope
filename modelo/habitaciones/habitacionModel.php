<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function obtenerHabitaciones() {
        $sql = "SELECT h.*, 
                       GROUP_CONCAT(s.Servicio ORDER BY s.Servicio SEPARATOR ', ') AS Servicios_Adicionales
                FROM Habitaciones h
                LEFT JOIN Servicio s ON h.Id_Hotel = s.Id_Hotel AND s.TipoServicio = 1  -- Solo servicios incluidos
                GROUP BY h.Id_Habitaciones";
    
        $query = $this->conn->prepare($sql);
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
         // Retorna 0 si no encuentra la habitación
    }

    public function obtenerHabitacionPorId($habitacionId) {
        try {
            $sql = "SELECT h.*, 
                     GROUP_CONCAT(s.Servicio SEPARATOR ', ') AS Servicios_Adicionales
              FROM Habitaciones h
              LEFT JOIN Servicio s ON h.Id_Hotel = s.Id_Hotel 
              WHERE h.Id_Habitaciones = $habitacionId AND s.TipoServicio = 1
              GROUP BY h.Id_Habitaciones";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $habitacionId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $habitacion = $result->fetch_assoc();
            $stmt->close();
    
            // 🚨 Verifica si la consulta devuelve datos correctos
            echo "<pre>";
            print_r($habitacion);
            echo "</pre>";
    
            return $habitacion;
        } catch (Exception $e) {
            error_log("Error al obtener habitación: " . $e->getMessage());
            return null;
        }
    }
    

    public function obtenerTiposHabitacion() {
        $sql = "SELECT DISTINCT Tipo FROM Habitaciones";
        $result = $this->conn->query($sql);
        
        $tipos = [];
        while ($row = $result->fetch_assoc()) {
            $tipos[] = $row['Tipo'];
        }
        
        return $tipos; // Devuelve un array con los tipos de habitaciones únicos
    }
    
    public function obtenerHabitacionesPorHotel($hotelId) {
        if (!$this->conn) {
            error_log("Error: La conexión a la base de datos no está establecida.");
            return [];
        }
    
        $fechaActual = date('Y-m-d');
        $checkin = $_SESSION['checkin'];  
        $checkout = $_SESSION['checkout']; 
    
        $query = "SELECT * FROM Habitaciones 
                  WHERE Id_Hotel = ?
                  AND Id_Habitaciones NOT IN (
                      SELECT Id_Habitacion FROM Reservas 
                      WHERE (Checkin BETWEEN ? AND ?) 
                      OR (Checkout BETWEEN ? AND ?)
                      OR (Checkin <= ? AND Checkout >= ?)
                  )"; 
    
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . $this->conn->error);
            return [];
        }
    
        $stmt->bind_param("issssss", $hotelId, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $habitaciones;
    }
    
    
}
?>
