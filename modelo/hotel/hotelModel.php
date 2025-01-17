<?php
require_once __DIR__ . '/../../config/Database.php';

class HotelModel {
    private $conn;

    public function __construct($db) {
        // Se pasa la conexión a la base de datos al modelo
        $this->conn = $db;
    }

    
   
    public function obtenerHotelesPorPais($location) {
        $query = $this->conn->prepare("SELECT * FROM Hotel WHERE Id_Pais = ?");
        $query->bind_param("i", $location);
        $query->execute();
        $result = $query->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener un hotel por su ID
    public function obtenerHotelPorId($hotelId) {
        $sql = "SELECT * FROM Hotel WHERE Id_Hotel = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $hotelId);  // Usamos bind_param para evitar inyección SQL
        $stmt->execute();
        $result = $stmt->get_result();

        // Devuelve el hotel si existe
        return $result->fetch_assoc();
    }

    // Si necesitas más funciones, puedes agregarlas aquí, por ejemplo:
    // - obtenerHotelesPorEstrellas($estrellas)
}
?>
