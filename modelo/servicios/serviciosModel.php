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
}
?>
