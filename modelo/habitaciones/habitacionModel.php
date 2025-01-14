<?php
require_once __DIR__ . '/../../config/Database.php';

class HabitacionesModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener habitaciones disponibles por hotel
    public function obtenerHabitacionesDisponiblesPorHotel($hotelId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Hotel = ? AND Disponibilidad > 0"; // Filtramos por hotel en lugar de país
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $hotelId);  // Usamos el parámetro entero para el hotel
        $stmt->execute();
    
        $result = $stmt->get_result();
        $habitaciones = $result->fetch_all(MYSQLI_ASSOC);
    
        // Si no se encuentran habitaciones disponibles
        if ($result->num_rows > 0) {
            return $habitaciones;  // Devuelve todas las habitaciones disponibles
        } else {
            return [];  // Si no hay habitaciones disponibles, devolvemos un array vacío
        }
    }

    // Obtener una habitación por ID para obtener detalles como el precio
    public function obtenerHabitacionPorId($habitacionId) {
        $sql = "SELECT * FROM Habitaciones WHERE Id_Habitacion = ?";  // Corregido el nombre de la columna
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $habitacionId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve los detalles de la habitación seleccionada
    }

    // Agregar una nueva reserva (esto puede depender de tu lógica de negocio)
    public function agregarReserva($idCliente, $idHabitacion, $idHotel, $checkin, $checkout, $numPersonas, $precioTotal) {
        // Asegúrate de tener las columnas necesarias en la tabla de reservas
        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Habitacion, Id_Hotel, Checkin, Checkout, Numero_Personas, Precio_Total) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiissii", $idCliente, $idHabitacion, $idHotel, $checkin, $checkout, $numPersonas, $precioTotal);

        if ($stmt->execute()) {
            return $this->conn->insert_id;  // Retorna el ID de la nueva reserva
        } else {
            return false;  // Si no se ejecuta, devolvemos false
        }
    }
}
?>
