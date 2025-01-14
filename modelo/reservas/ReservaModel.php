<?php
require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta a Database.php sea correcta
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ReservaModel {

    private $conn;

    public function __construct() {
        // Crear conexión con la base de datos
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function obtenerPaises() {
        $sql = "SELECT * FROM Pais";  // Asegúrate de que la tabla se llame 'Paises'
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve los países como un array
    }

    // Obtener una habitación por su ID
    public function obtenerHabitacionPorId($habitacionId) {
        // Usamos 'Id_Habitaciones' ya que esa es la columna correcta en la tabla Habitaciones
        $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";  // Cambié 'Id_Habitacion' a 'Id_Habitaciones'
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $habitacionId);  // El "i" es para un parámetro entero
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve los detalles de la habitación
    }

    // Crear una nueva reserva
    // Crear una nueva reserva
    // Crear una nueva reserva
    public function agregarReserva($idCliente, $idHabitacion, $idHotel, $checkin, $checkout, $numPersonas, $precioTotal) {
        // Asegúrate de que tu tabla de reservas tenga las columnas necesarias
        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Habitacion, Id_Hotel, Checkin, Checkout, Numero_Personas, Precio_Total) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiissii", $idCliente, $idHabitacion, $idHotel, $checkin, $checkout, $numPersonas, $precioTotal);

        if ($stmt->execute()) {
            // Verificar que $this->conn->insert_id esté devolviendo un valor
            $reservaId = $this->conn->insert_id;
            if ($reservaId) {
                return $reservaId;  // Retorna el ID de la nueva reserva
            }
        }
        return false;  // Si no se ejecuta correctamente, devuelve false
    }



    // Obtener detalles de la reserva por su ID
    // Obtener detalles de la reserva por su ID
    public function obtenerReservaPorId($reservaId) {
        $sql = "SELECT * FROM Reservas WHERE Id_Reserva = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reservaId);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Retorna los detalles de la reserva
    }

}
?>
