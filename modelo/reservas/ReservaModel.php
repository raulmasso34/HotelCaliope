<?php
require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta a Database.php sea correcta
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ReservaModel {

    private $conn;

    public function __construct($db) {
        // Usar la conexión proporcionada por la clase Database
        $this->conn = $db;
    }

    // Obtener los países (si es necesario en tu flujo)
    public function obtenerPaises() {
        try {
            $sql = "SELECT * FROM Pais";  // Asegúrate de que la tabla se llame 'Pais'
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve los países como un array
        } catch (Exception $e) {
            return null;  // Si ocurre algún error, podemos manejarlo o devolver null
        }
    }

    // Obtener una habitación por su ID
    public function obtenerHabitacionPorId($habitacionId) {
        try {
            $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";  // Cambié 'Id_Habitacion' a 'Id_Habitaciones'
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $habitacionId);  // El "i" es para un parámetro entero
            $stmt->execute();
        
            $result = $stmt->get_result();
            return $result->fetch_assoc();  // Devuelve los detalles de la habitación
        } catch (Exception $e) {
            return null;  // Si ocurre un error, puedes devolver null
        }
    }

    // Crear una nueva reserva
    public function agregarReserva($idCliente, $idHabitacion, $idHotel, $checkin, $checkout, $numPersonas, $precioTotal) {
        try {
            // Asegúrate de que tu tabla de reservas tenga las columnas necesarias
            $sql = "INSERT INTO Reservas (Id_Cliente, Id_Habitacion, Id_Hotel, Checkin, Checkout, Numero_Personas, Precio_Total) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiissii", $idCliente, $idHabitacion, $idHotel, $checkin, $checkout, $numPersonas, $precioTotal);

            if ($stmt->execute()) {
                $reservaId = $this->conn->insert_id;  // Obtener el ID de la nueva reserva
                return $reservaId ?: false;  // Retorna el ID de la reserva o false si no se pudo insertar
            }
        } catch (Exception $e) {
            return false;  // Si hay un error en la creación de la reserva
        }
    }

    // Obtener detalles de la reserva por su ID
    public function obtenerReservaPorId($reservaId) {
        try {
            $sql = "SELECT * FROM Reservas WHERE Id_Reserva = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $reservaId);
            $stmt->execute();

            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Retorna los detalles de la reserva
        } catch (Exception $e) {
            return null;  // Si ocurre algún error, puedes devolver null
        }
    }

    // Obtener actividades disponibles para un hotel
    public function obtenerActividadesPorHotel($idHotel) {
        try {
            $sql = "SELECT * FROM Actividades WHERE Id_Hotel = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idHotel);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve las actividades disponibles
        } catch (Exception $e) {
            return null;  // Si ocurre un error, puedes devolver null
        }
    }

    // Obtener métodos de pago registrados para un cliente
    public function obtenerMetodosPagoPorCliente($idCliente) {
        try {
            $sql = "SELECT * FROM MetodoPago WHERE Id_Cliente = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idCliente);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve los métodos de pago del cliente
        } catch (Exception $e) {
            return null;  // Si ocurre un error, puedes devolver null
        }
    }

    // Procesar el pago de la reserva (y asociar la actividad si es seleccionada)
    public function procesarPago($reservaId, $metodoPagoId, $actividadId) {
        try {
            // 1. Actualizar el estado de la reserva para reflejar que ha sido pagada
            $sql = "UPDATE Reservas SET Estado = 'Pagado', Id_MetodoPago = ? WHERE Id_Reserva = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $metodoPagoId, $reservaId);
            
            if ($stmt->execute()) {
                // 2. Registrar la actividad seleccionada para la reserva (opcional, si la actividad se asocia)
                if ($actividadId) {
                    $sqlActividad = "INSERT INTO Actividades_Reservadas (Id_Reserva, Id_Actividad) VALUES (?, ?)";
                    $stmtActividad = $this->conn->prepare($sqlActividad);
                    $stmtActividad->bind_param("ii", $reservaId, $actividadId);
                    $stmtActividad->execute();
                }

                return true;  // Pago y actividad procesados con éxito
            }
        } catch (Exception $e) {
            return false;  // Error al procesar el pago
        }
    }
}
?>
