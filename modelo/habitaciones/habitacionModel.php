<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function obtenerHabitaciones() {
        $sql = "
        SELECT h.Id_Habitaciones, h.Numero_Habitacion, h.Tipo, h.Capacidad, h.Precio, h.Descripcion, 
               GROUP_CONCAT(s.Servicio ORDER BY s.Servicio SEPARATOR ', ') AS Servicios_Adicionales,
               ho.Nombre AS Hotel, ho.Direccion, p.Pais AS Pais, c.Nombre AS Continente, c.Id_Continente
        FROM Habitaciones h
        LEFT JOIN Servicio s ON h.Id_Hotel = s.Id_Hotel AND s.TipoServicio = 1  -- Solo servicios incluidos
        JOIN Hotel ho ON h.Id_Hotel = ho.Id_Hotel
        JOIN Pais p ON ho.Id_Pais = p.Id_Pais
        JOIN Continentes c ON p.Id_Continente = c.Id_Continente
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


    

    public function obtenerHabitacionesConPrecioPorTemporada($checkin, $checkout, $capacidad) {
        if ($capacidad == 3) {
            $sql = "
                SELECT h.Id_Habitaciones, h.Numero_Habitacion, h.Tipo, h.Capacidad, h.Precio AS PrecioBase, 
                       ho.Nombre AS Hotel, ho.Direccion, p.Pais AS Pais, c.Nombre AS Continente,
                       t.Nombre AS Temporada, t.PrecioMultiplicador, h.Id_Hotel, h.Descripcion
                FROM Habitaciones h
                JOIN Hotel ho ON h.Id_Hotel = ho.Id_Hotel
                JOIN Pais p ON ho.Id_Pais = p.Id_Pais
                JOIN Continentes c ON p.Id_Continente = c.Id_Continente
                LEFT JOIN Temporadas t 
                    ON (? BETWEEN t.Fecha_Inicio AND t.Fecha_Fin) 
                    OR (? BETWEEN t.Fecha_Inicio AND t.Fecha_Fin)
                WHERE h.Capacidad IN (3, 4)
            ";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $checkin, $checkout);
        } else {
            $sql = "
                SELECT h.Id_Habitaciones, h.Numero_Habitacion, h.Tipo, h.Capacidad, h.Precio AS PrecioBase, 
                       ho.Nombre AS Hotel, ho.Direccion, p.Pais AS Pais, c.Nombre AS Continente,
                       t.Nombre AS Temporada, t.PrecioMultiplicador, h.Id_Hotel, h.Descripcion
                FROM Habitaciones h
                JOIN Hotel ho ON h.Id_Hotel = ho.Id_Hotel
                JOIN Pais p ON ho.Id_Pais = p.Id_Pais
                JOIN Continentes c ON p.Id_Continente = c.Id_Continente
                LEFT JOIN Temporadas t 
                    ON (? BETWEEN t.Fecha_Inicio AND t.Fecha_Fin) 
                    OR (? BETWEEN t.Fecha_Inicio AND t.Fecha_Fin)
                WHERE h.Capacidad = ?
            ";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $checkin, $checkout, $capacidad);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $habitaciones = [];
        while ($row = $result->fetch_assoc()) {
            $multiplicador = floatval($row['PrecioMultiplicador']) ?: 1.0;
            $precioFinal = floatval($row['PrecioBase']) * $multiplicador;
    
            $row['PrecioFinal'] = $precioFinal;
            $habitaciones[] = $row;
        }
    
        return $habitaciones;
    }
    
    
    
    
    
    
    

    


   // Método en HabitacionesModel
   public function obtenerHabPorContinente($continenteId) {
        try {
            $query = "
            SELECT h.Id_Habitaciones, h.Numero_Habitacion, h.Tipo, h.Capacidad, h.Precio, h.Descripcion, 
                h.Servicios_Adicionales, ho.Nombre AS Hotel, ho.Direccion, p.Pais AS Pais, 
                c.Id_Continente, c.Nombre AS Continente
            FROM Habitaciones h
            JOIN Hotel ho ON h.Id_Hotel = ho.Id_Hotel
            JOIN Pais p ON ho.Id_Pais = p.Id_Pais
            JOIN Continentes c ON p.Id_Continente = c.Id_Continente
            WHERE c.Id_Continente = ?  
            ORDER BY h.Numero_Habitacion
            ";
            
            // Preparar la consulta
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $continenteId); // Asignar el parámetro
            $stmt->execute();

            // Obtener resultados
            $result = $stmt->get_result();

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                $habitaciones = [];
                while ($row = $result->fetch_assoc()) {
                    $habitaciones[] = $row; // Guardar cada habitación
                }
                return $habitaciones;
            } else {
                return null; // Si no hay resultados, devolver null
            }
        } catch (Exception $e) {
            error_log("Error al obtener habitaciones por continente: " . $e->getMessage());
            return null;
        }
    }



    


    
    public function obtenerHabitacionPorId($habitacionId) {
        try {
            $sql = "SELECT h.*, 
                     GROUP_CONCAT(s.Servicio SEPARATOR ', ') AS Servicios_Adicionales
              FROM Habitaciones h
              LEFT JOIN Servicio s ON h.Id_Hotel = s.Id_Hotel 
              WHERE h.Id_Habitaciones = ? AND s.TipoServicio = 1
              GROUP BY h.Id_Habitaciones";
              
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $habitacionId); // Ahora sí hay un "?" en la consulta
            $stmt->execute();
    
            $result = $stmt->get_result();
            $habitacion = $result->fetch_assoc();
            $stmt->close();
    
            // 🚨 Verifica si la consulta devuelve datos correctos
           
    
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
        $personas = $_SESSION['guests']; 
    
        $query = "SELECT * FROM Habitaciones 
                  WHERE Id_Hotel = ?
                  AND Id_Habitaciones NOT IN (
                      SELECT Id_Habitacion FROM Reservas 
                      WHERE (Checkin BETWEEN ? AND ?) 
                      OR (Checkout BETWEEN ? AND ?)
                      OR (Checkin <= ? AND Checkout >= ?)
                  ) AND Capacidad >= ?"; 
    
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . $this->conn->error);
            return [];
        }
    
        $stmt->bind_param("issssss", $hotelId, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout, $personas);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $habitaciones;
    }
    
    
}
?>
