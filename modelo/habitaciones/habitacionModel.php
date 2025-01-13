<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener habitaciones disponibles por país
    public function obtenerHabitacionesDisponibles($paisId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Pais = ? AND Disponibilidad > 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paisId);  // Usamos el parámetro entero para el país
        $stmt->execute();
    
        $result = $stmt->get_result();
        $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
    
        // Depuración: Verificar que estamos obteniendo habitaciones
        echo "Habitaciones obtenidas desde la base de datos:<br>";
        var_dump($habitaciones);  // Verifica que se obtienen habitaciones correctamente
        
        if ($result->num_rows > 0) {
            return $habitaciones;  // Devuelve todas las habitaciones disponibles
        } else {
            echo "No se encontraron habitaciones disponibles para el país: $paisId<br>";
            return [];  // Si no se encuentra ninguna habitación disponible, devolvemos un array vacío
        }
    }
    
    

    // Obtener una habitación por ID para obtener detalles como el precio
    public function obtenerHabitacionPorId($habitacionId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $habitacionId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve los detalles de la habitación seleccionada
    }
}
?>
