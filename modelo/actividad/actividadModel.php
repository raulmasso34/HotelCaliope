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
        $sql = "SELECT * FROM Actividades WHERE Id_Hotel = ? AND Fecha >= CURDATE()";  // Filtra actividades futuras
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $hotelId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve las actividades del hotel
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
