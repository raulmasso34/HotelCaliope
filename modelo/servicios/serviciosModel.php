<?php
// ActividadModel.php

require_once __DIR__ . '/../../config/Database.php';  

class ServiciosModel {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    
    public function obtenerServicios() {
        $sql = "SELECT * FROM Servicio WHERE Id_Hotel = ?";
        $stmt = $this->conn->prepare($sql);
        
        // Usamos bind_param para pasar el valor de $_SESSION['hotelId'] como parámetro
        $stmt->bind_param("i", $_SESSION['hotelId']);  // 'i' es para un entero
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        
        // Obtener todos los servicios
        $servicios = $result->fetch_all(MYSQLI_ASSOC);  // Devuelve todos los servicios como un array
        return $servicios;  // Devuelve los servicios del hotel
    }

    public function obtenerNombreServicios($hotelId) {
        try {
            $sql = "SELECT Servicio FROM Servicio WHERE Id_Hotel = ?";
            $stmt = $this->conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
            }
    
            $stmt->bind_param("i", $hotelId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $servicios = [];
    
            while ($row = $result->fetch_assoc()) {
                $servicios[] = $row['Servicio'];  // Guardamos solo los nombres de los servicios
            }
    
            $stmt->close();
            return $servicios;
        } catch (Exception $e) {
            error_log("Error al obtener servicios: " . $e->getMessage());
            return []; // Retorna un array vacío si hay error
        }
    }

    public function obtenerNombreServicio($servicioId) {
        $sql = "SELECT Servicio FROM Servicio WHERE Id_Servicio = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $servicioId);
        $stmt->execute();
        $result = $stmt->get_result();
        $nombre = $result->fetch_row()[0] ?? null; // Devuelve el nombre o null si no existe
        $stmt->close();
        return $nombre;
    }
    
    
}
?>
