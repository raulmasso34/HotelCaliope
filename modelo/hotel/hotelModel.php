<?php
require_once __DIR__ . '/../../config/Database.php'; 
class HotelModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener los hoteles según la ubicación
    public function obtenerHotelesPorUbicacion($location) {
        $sql = "SELECT * FROM Hoteles WHERE Id_Pais = ?";  // Filtra por el país (ubicación)
        
        // Preparar la consulta
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $location); // "i" para integer
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];  // Si ocurre un error, retorna un array vacío
        }
    }
}
?>
