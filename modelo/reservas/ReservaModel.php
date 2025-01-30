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
            $sql = "SELECT * FROM Pais";
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

    public function insertarReserva($hotelId, $clienteId, $checkin, $checkout, $paisId, $actividadId, $habitacionId, $tarifaId, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal, $NumeroPersonas) {
        // Primero, realizamos la inserción de la reserva
        $query = "INSERT INTO Reservas (Id_Hotel, Id_Cliente, Checkin, Checkout, Id_Pais, Id_Actividad, Id_Habitacion, Id_Tarifa, Precio_Habitacion, Precio_Actividad, Precio_Tarifa, Precio_Total, Numero_Personas) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error preparing statement: ' . $this->conn->error);
        }
        
        // Usamos 's' para los campos de tipo string como checkin y checkout
        $stmt->bind_param("iissiiiiddddd", 
            $hotelId, 
            $clienteId, 
            $checkin,  // Esta es una fecha, tipo 's'
            $checkout, // Esta es una fecha, tipo 's'
            $paisId, 
            $actividadId, 
            $habitacionId, 
            $tarifaId, 
            $precioHabitacion, 
            $precioActividad, 
            $precioTarifa, 
            $precioTotal,
            $NumeroPersonas
        );
        
        if ($stmt->execute()) {
            // Una vez que la reserva se ha realizado, obtenemos la ID de la reserva insertada
            $reservaId = $this->conn->insert_id;
    
            // Actualizamos la disponibilidad de la habitación y el estado a 'Reservada'
            $queryUpdate = "UPDATE Habitaciones 
                            SET Fecha_Disponibilidad_Inicio = ?, Fecha_Disponibilidad_Fin = ?, Disponibilidad = 0, Estado = 'Reservada' 
                            WHERE Id_Habitaciones = ? AND (Fecha_Disponibilidad_Inicio IS NULL OR Fecha_Disponibilidad_Fin IS NULL)";
            
            $stmtUpdate = $this->conn->prepare($queryUpdate);
            if ($stmtUpdate === false) {
                die('Error preparing update statement: ' . $this->conn->error);
            }
            
            // Para el caso de que no existan fechas, asignamos las fechas de la reserva.
            // Usamos 's' para las fechas (tipo string) y 'i' para el ID de la habitación.
            $stmtUpdate->bind_param("ssi", 
                $checkin,  // Fecha de inicio de disponibilidad (Checkin)
                $checkout, // Fecha de fin de disponibilidad (Checkout)
                $habitacionId // ID de la habitación
            );
            
            if ($stmtUpdate->execute()) {
                return $reservaId;  // Devuelve la ID de la reserva si todo fue exitoso
            } else {
                die("Error en la actualización de disponibilidad y estado: " . $stmtUpdate->error);
            }
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

    
    public function obtenerHabitaciones($hotelId) {
        $query = "SELECT * FROM Habitaciones WHERE Id_Hotel = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $hotelId);
        $stmt->execute();
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
        // Fecha actual para comprobar las reservas pasadas
        $fechaActual = date('Y-m-d');
        $checkin = $_SESSION['checkin'];  // Obtener la fecha de checkin desde la sesión
        $checkout = $_SESSION['checkout']; // Obtener la fecha de checkout desde la sesión
        
        // Consulta para obtener solo las habitaciones disponibles
        $query = "SELECT * FROM Habitaciones 
                  WHERE Id_Hotel = ? 
                  AND Estado = 'Disponible' 
                  AND (Fecha_Disponibilidad_Fin IS NULL OR Fecha_Disponibilidad_Fin >= ?)
                  AND (Fecha_Disponibilidad_Inicio IS NULL OR Fecha_Disponibilidad_Inicio <= ?) 
                  AND NOT EXISTS (
                      SELECT 1 FROM Reservas 
                      WHERE Reservas.Id_Habitacion = Habitaciones.Id_Habitaciones
                      AND (
                          (Reservas.Checkin BETWEEN ? AND ?) 
                          OR (Reservas.Checkout BETWEEN ? AND ?)
                          OR (Reservas.Checkin <= ? AND Reservas.Checkout >= ?)
                      )
                  )"; 
    
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
    
    public function actualizarEstadoHabitacionReservada($habitacionId) {
        // Actualiza el estado de la habitación a 'Reservada'
        $query = "UPDATE Habitaciones 
                  SET Estado = 'Reservada' 
                  WHERE Id_Habitaciones = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $habitacionId);
        $stmt->execute();
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
            $precio = $stmt->get_result()->fetch_row()[0];
            $stmt->close();
            return $precio;
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

    public function obtenerPrecioActividad($actividadId) {
        try {
            $sql = "SELECT Precio FROM Actividades WHERE Id_Actividad = ?";
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
   
}
?>
