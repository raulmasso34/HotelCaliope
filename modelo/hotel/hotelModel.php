<?php
require_once __DIR__ . '/../../config/Database.php';

class HotelModel {
    private $conn;

    public function __construct($db) {
        // Se pasa la conexión a la base de datos al modelo
        $this->conn = $db;
    }

  
    public function obtenerDetallesHotel($hotelId) {
        $query = $this->conn->prepare("SELECT * FROM Hotel WHERE Id_Hotel = ?");
        $query->bind_param("i", $hotelId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
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

    public function obtenerHabitaciones($hotelId) {
        // Definir la consulta SQL
        $query = "SELECT * FROM Habitaciones WHERE Id_Hotel = ?";  // Usar "?" en lugar de ":hotelId"
    
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
    
        // Limpiar los datos de entrada
        $hotelId = htmlspecialchars(strip_tags($hotelId));
    
        // Enlazar el parámetro
        $stmt->bind_param("i", $hotelId); // "i" significa entero
    
        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();  // Obtener el resultado de la consulta
    
        // Si hay resultados, los devuelve como un array asociativo
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);  // Devuelve todas las habitaciones del hotel
        } else {
            return null;  // Si no se encuentran habitaciones, retorna null
        }
    }

    public function obtenerTodosHoteles() {
        $query = "SELECT Id_Hotel, Nombre, CorreoElectronico FROM Hotel";
        $result = $this->conn->query($query);
        
        if (!$result) {
            error_log("Error MySQLi: " . $this->conn->error);
            return [];
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerHoteles() {
        $query = "SELECT 
                    h.Id_Hotel AS id,
                    h.Nombre AS nombre_hotel,
                    h.Descripcion AS descripcion,
                    h.Ciudad AS ciudad,
                    h.Estrellas AS estrellas,
                    p.Pais AS pais,  
                    c.Nombre AS continente,
                    c.Directorio AS directorio,
                    GROUP_CONCAT(s.Servicio ORDER BY s.Servicio ASC) AS servicios
                  FROM Hotel h
                  JOIN Pais p ON h.Id_Pais = p.Id_Pais
                  JOIN Continentes c ON p.Id_Continente = c.Id_Continente
                  LEFT JOIN Servicio s ON h.Id_Hotel = s.Id_Hotel
                  WHERE s.TipoServicio IS NULL OR s.TipoServicio = 0  -- Si solo quieres servicios gratuitos
                  GROUP BY h.Id_Hotel
                  ORDER BY c.Nombre, p.Pais";
    
        $result = $this->conn->query($query);
    
        if (!$result) {
            error_log("Error en consulta: " . $this->conn->error);
            return [];
        }
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    

    public function obtenerEmailPorId($hotelId) {
        $stmt = $this->conn->prepare("SELECT CorreoElectronico FROM Hotel WHERE Id_Hotel = ?");
        $stmt->bind_param("i", $hotelId);
        
        if (!$stmt->execute()) {
            error_log("Error ejecutando consulta: " . $stmt->error);
            return null;
        }
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}

    // Si necesitas más funciones, puedes agregarlas aquí, por ejemplo:
    // - obtenerHotelesPorEstrellas($estrellas)

?>
