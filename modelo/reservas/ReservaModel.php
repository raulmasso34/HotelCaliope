<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../modelo/actividad/actividadModel.php';
require_once __DIR__ . '/../../modelo/metodopago/metodoPagoModel.php';
require_once __DIR__ . '/../../config/Database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ReservaModel {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerPaises() {
        try {
            $sql = "SELECT DISTINCT p.Pais FROM Hotel h inner join Pais p on h.Id_Pais = p.Id_Pais ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $paises = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $paises;
        } catch (Exception $e) {
            error_log("Error al obtener países: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerMetodosPago() {
        $query = $this->conn->prepare("SELECT * FROM MetodoPago WHERE Activo = 1");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerDetallesHotel($hotelId) {
        $query = $this->conn->prepare("SELECT * FROM Hotel WHERE Id_Hotel = ?");
        $query->bind_param("i", $hotelId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function obtenerDetallesHabitacion($habitacionId) {
        $query = $this->conn->prepare("SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?");
        $query->bind_param("i", $habitacionId);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }
    public function obtenerHabitaciones() {
        $query = $this->conn->prepare("SELECT * FROM Habitaciones");
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    

    public function obtenerActividades($hotelId) {
        $query = $this->conn->prepare("SELECT * FROM Actividades WHERE Id_Hotel = ?");
        $query->bind_param("i", $hotelId);
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerDetalles($hotelId) {
        $query = "SELECT * FROM Hotel WHERE Id_Hotel = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $hotelId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerPrecioActividad($actividadId) {
        try {
            $sql = "SELECT Precio FROM Actividades WHERE Id_Actividades = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $actividadId);
            $stmt->execute();
            $precio = $stmt->get_result()->fetch_row()[0];
            $stmt->close();
            return $precio ?: 0; // Retorna 0 si no se encuentra el precio
        } catch (Exception $e) {
            error_log("Error al obtener precio de actividad: " . $e->getMessage());
            return 0;
        }
    }
    
    public function obtenerPrecioTarifa($tarifaId) {
        try {
            $sql = "SELECT Precio FROM Tarifas WHERE Id_Tarifa = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $tarifaId);
            $stmt->execute();
            $precio = $stmt->get_result()->fetch_row()[0];
            $stmt->close();
            return $precio ?: 0; // Retorna 0 si no se encuentra el precio
        } catch (Exception $e) {
            error_log("Error al obtener precio de tarifa: " . $e->getMessage());
            return 0;
        }
    }
    




    
    

    public function insertarReserva($hotelId, $clienteId, $checkin, $checkout, $paisId, $actividadId, $habitacionId, $tarifaId, $numeroPersonas) {
        // Obtener el precio de la habitación
        $precioHabitacion = $this->obtenerPrecioHabitacion($habitacionId);
        
        // Verificar si se ha seleccionado una actividad
        if (empty($actividadId)) {
            $actividadId = NULL;
            $precioActividad = 0;
        } else {
            $precioActividad = $this->obtenerPrecioActividad($actividadId);
        }
        
        // Obtener el precio de la tarifa
        $precioTarifa = $this->obtenerPrecioTarifa($tarifaId);
    
        // Calcular el número de noches
        $num_noches = (new DateTime($checkout))->diff(new DateTime($checkin))->days;
        
        // Calcular el precio total basado en la habitación y el número de noches
        $precioTotal = ($precioHabitacion * $num_noches) + $precioActividad + $precioTarifa;
    
        // Realizar la inserción de la reserva
        $query = "INSERT INTO Reservas (Id_Hotel, Id_Cliente, Checkin, Checkout, Id_Pais, Id_Actividad, Id_Habitacion, Id_Tarifa, Precio_Habitacion, Precio_Actividad, Precio_Tarifa, Precio_Total, Numero_Personas) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->conn->error);
        }
    
        // Usa 'i' para enteros y 'd' para decimales
        $stmt->bind_param("iissiiiiddddd", 
            $hotelId, 
            $clienteId, 
            $checkin, 
            $checkout, 
            $paisId, 
            $actividadId, 
            $habitacionId, 
            $tarifaId, 
            $precioHabitacion, 
            $precioActividad, 
            $precioTarifa, 
            $precioTotal,
            $numeroPersonas // Asegúrate de que este sea el valor correcto
        );
    
        if ($stmt->execute()) {
            return $this->conn->insert_id; // Devuelve la ID de la reserva si todo fue exitoso
        } else {
            die("Error en la ejecución de la consulta de reserva: " . $stmt->error);
        }
    }
    
    
    

    public function getReservationDetails($reservationId) {
        // Consulta SQL con el marcador de posición "?"
        $query = "SELECT * FROM Reservas WHERE Id_Reserva = ?";
    
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
    
        // Vincular el parámetro, asegurándote de que $reservationId es un entero
        $stmt->bind_param("i", $reservationId);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Obtener los resultados
        $result = $stmt->get_result();
    
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  // Retorna la primera fila de la consulta
        } else {
            return null;  // No se encontraron resultados
        }
    }
    

    public function actualizarReservaConPago($reservaId, $idPago) {
        try {
            $query = "UPDATE Reservas 
                      SET Estado = 'Pagado', Id_Pago = ? 
                      WHERE Id_Reserva = ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $idPago, $reservaId);
            
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                throw new Exception('Error al actualizar la reserva con el pago: ' . $stmt->error);
            }
        } catch (Exception $e) {
            error_log("Error al actualizar la reserva con el pago: " . $e->getMessage());
            return false;
        }
    }

   
        public function obtenerMetodosPagoDisponibles() {
            $query = "SELECT * FROM MetodoPago WHERE Activo = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            // Usando MySQLi en lugar de PDO
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

    
   

    public function obtenerHabitacionPorId($habitacionId) {
        try {
            $sql = "SELECT * FROM Habitaciones WHERE Id_Habitaciones = ?";  
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $habitacionId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $habitacion = $result->fetch_assoc();
            $stmt->close();
            return $habitacion;
        } catch (Exception $e) {
            error_log("Error al obtener habitación: " . $e->getMessage());
            return null;
        }
    }

    public function obtenerHabitacionesPorHotel($hotelId) {
        $fechaActual = date('Y-m-d');
        $checkin = $_SESSION['checkin'];  
        $checkout = $_SESSION['checkout']; 
    
        $query = `SELECT * FROM Habitaciones 
                  WHERE Id_Hotel = ?
                  AND NOT EXISTS (
                      SELECT 1 FROM Reservas 
                      WHERE Reservas.Id_Habitacion = Habitaciones.Id_Habitaciones
                      AND (
                          (Reservas.Checkin BETWEEN ? AND ?) 
                          OR (Reservas.Checkout BETWEEN ? AND ?)
                          OR (Reservas.Checkin <= ? AND Reservas.Checkout >= ?)
                      )
                  )`; 
    
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issssss", $hotelId, $fechaActual, $fechaActual, $checkin, $checkout, $checkin, $checkout, $checkin, $checkout);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $habitaciones = [];
        while ($row = $result->fetch_assoc()) {
            $habitaciones[] = $row;
        }
    
        return $habitaciones;
    }
    
    
  
    

    public function obtenerReservaPorId($reservaId) {
        try {
            $sql = "SELECT * FROM Reservas WHERE Id_Reserva = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $reservaId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $reserva = $result->fetch_assoc();
            $stmt->close();
            return $reserva;
        } catch (Exception $e) {
            error_log("Error al obtener reserva: " . $e->getMessage());
            return null;
        }
    }

    public function procesarPago($reservaId, $metodoPagoId, $actividadId, $precioHabitacion, $precioActividad, $precioTotal) {
        try {
            $sql = "UPDATE Reservas 
                    SET Estado = 'Pagado', Id_MetodoPago = ?, Id_Actividad = ?, 
                        Precio_Habitacion = ?, Precio_Actividad = ?, Precio_Total = ? 
                    WHERE Id_Reserva = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiiii", $metodoPagoId, $actividadId, $precioHabitacion, $precioActividad, $precioTotal, $reservaId);
            
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Error al procesar pago: " . $e->getMessage());
            return false;
        }
    }

    public function reservaExistente($idReserva) {
        try {
            $sql = "SELECT COUNT(*) FROM Reservas WHERE Id_Reserva = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idReserva);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $count = $result->fetch_row()[0];
            $stmt->close();
    
            return $count;
        } catch (Exception $e) {
            error_log("Error al verificar si la reserva existe: " . $e->getMessage());
            return 0;
        }
    }

    public function obtenerPrecioHabitacion($habitacionId) {
        try {
            $sql = "SELECT Precio FROM Habitaciones WHERE Id_Habitaciones = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $habitacionId);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_row();
            
            // Cerrar el statement
            $stmt->close();
    
            // Retornar el precio si se encontró, de lo contrario retornar 0
            return $resultado ? $resultado[0] : 0; // Si no se encuentra, retornar 0
        } catch (Exception $e) {
            error_log("Error al obtener precio de habitación: " . $e->getMessage());
            return 0;
        }
    }
    

    public function obtenerActividadesPorHotel($idHotel) {
        try {
            $sql = "SELECT * FROM Actividades WHERE Id_Hotel = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idHotel);
            $stmt->execute();
            $result = $stmt->get_result();
            $actividades = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $actividades;
        } catch (Exception $e) {
            error_log("Error al obtener actividades para el hotel: " . $e->getMessage());
            return null;
        }
    }

    

    public function obtenerMetodosPagoPorCliente($idCliente) {
        try {
            $sql = "SELECT * FROM MetodoPago WHERE Id_Cliente = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idCliente);
            $stmt->execute();
            $result = $stmt->get_result();
            $metodosPago = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $metodosPago;
        } catch (Exception $e) {
            error_log("Error al obtener métodos de pago: " . $e->getMessage());
            return null;
        }
    }
    public function cancelarReserva($reservaId) {
        $query = "UPDATE Reservas SET Estado = 'Cancelado', FechaCancelacion = NOW() WHERE Id_Reserva = ?";
        
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->conn->error);
        }
        
        $stmt->bind_param("i", $reservaId);
        
        if ($stmt->execute()) {
            return true; // La reserva fue cancelada
        } else {
            die("Error en la ejecución de la consulta de cancelación: " . $stmt->error);
        }
    }
    
    

    public function marcarComoPagada($reservaId) {
        $query = "UPDATE Reservas SET Estado = 'Pagado' WHERE Id_Reserva = ?";
        
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->conn->error);
        }
        
        $stmt->bind_param("i", $reservaId);
        
        if ($stmt->execute()) {
            return true; // La reserva fue marcada como pagada
        } else {
            die("Error en la ejecución de la consulta de pago: " . $stmt->error);
        }
    }

    public function procesarReserva($data) {
        // Suponiendo que $data incluye los detalles de la reserva
        $reservaId = $this->insertarReserva(...); // Llama al método para insertar
    
        if ($data['metodoPago'] === 'pago en línea') {
            $this->marcarComoPagada($reservaId); // Marca como pagada
        }
    }

    public function getReservations($userId) {
        $query = "SELECT * FROM Reservas 
                WHERE Id_Cliente = ? 
                AND (Estado != 'Cancelada' OR 
                    (Estado = 'Cancelada' AND DATEDIFF(NOW(), FechaCancelacion) <= 10))";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservations = [];
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    public function actualizarEstadoReserva($idReserva, $nuevoEstado) {
        $query = "UPDATE Reservas SET Estado = ? WHERE Id_Reserva = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $this->conn->error);
        }
    
        // Vincular los parámetros
        $stmt->bind_param("si", $nuevoEstado, $idReserva); // "si" significa string y integer
    
        // Ejecutar la consulta
        return $stmt->execute(); // Retorna true si la actualización fue exitosa
    }
    


   
}
?>
