<?php
class HabitacionModel {
    private $conn;

    // Constructor, que toma la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener las habitaciones disponibles filtradas
    public function obtenerHabitacionesDisponiblesFiltradas($location, $checkin, $checkout, $guests, $habitacion_id) {
        // Consulta SQL para filtrar las habitaciones según los parámetros recibidos
        $sql = "SELECT * FROM Habitaciones 
                WHERE Disponibilidad > 0 
                AND Id_Hotel IN (SELECT Id_Hotel FROM Hoteles WHERE Id_Pais = ?)
                AND Capacidad >= ?
                AND Id_Habitaciones = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $location, $guests, $habitacion_id);  // Bind de los parámetros

        $stmt->execute();  // Ejecutar la consulta
        $result = $stmt->get_result();

        // Verificar si se obtuvieron resultados
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);  // Retornar el resultado como un array asociativo
        } else {
            return [];  // Si no se encontraron habitaciones, retornar un array vacío
        }
    }
}
?>
