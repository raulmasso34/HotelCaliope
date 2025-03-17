<?php
// ActividadModel.php

require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta a Database.php sea correcta

class ActividadModel {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener actividades de un hotel por su ID
    public function obtenerActividadesPorHotel($hotelId) {
        $sql = "SELECT Id_Actividades, Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, 
                       Capacidad_Maxima, Ubicacion, Descripcion, Precio, Nombre 
                FROM Actividades 
                WHERE Id_Hotel = ? AND Dia_Fin >= CURDATE()";  
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $hotelId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve las actividades del hotel
    }
    
    
    public function obtenerPrecioActividad($actividadId) {
        try {
            $sql = "SELECT Precio FROM Actividades WHERE Id_Actividades = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $actividadId);
            $stmt->execute();
            $precio = $stmt->get_result()->fetch_row()[0];
            $stmt->close();
            return $precio;
        } catch (Exception $e) {
            error_log("Error al obtener precio de actividad: " . $e->getMessage());
            return 0;
        }
    }
    public function obtenerNombreActividad($actividadId) {
        try {
            $sql = "SELECT Nombre,Precio FROM Actividades WHERE Id_Actividades = ?";
            $stmt = $this->conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $this->conn->error);
            }
    
            $stmt->bind_param("i", $actividadId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $nombreActividad = $row['Nombre']; // Obtiene el nombre de la actividad
            } else {
                $nombreActividad = null; // No se encontró la actividad
            }
    
            $stmt->close();
            return $nombreActividad;
        } catch (Exception $e) {
            error_log("Error al obtener nombre de actividad: " . $e->getMessage());
            return null; // Devuelve null si hay un error
        }
    }
    

    // Obtener una actividad específica por su ID
    public function obtenerActividadPorId($actividadId) {
        $sql = "SELECT * FROM Actividades WHERE Id_Actividades = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $actividadId);  // El parámetro "i" es para enteros
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve los detalles de la actividad
    }

    // Agregar una nueva actividad (Si es necesario)
    public function agregarActividad($idHotel, $diaInicio, $diaFin, $horaInicio, $horaFin, $capacidadMaxima, $ubicacion, $descripcion, $precio) {
        $sql = "INSERT INTO Actividades (Id_Hotel, Dia_Inicio, Dia_Fin, Hora_Inicio, Hora_Fin, Capacidad_Maxima, Ubicacion, Descripcion, Precio)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issssissd", $idHotel, $diaInicio, $diaFin, $horaInicio, $horaFin, $capacidadMaxima, $ubicacion, $descripcion, $precio);

        return $stmt->execute();
    }
}
?>
