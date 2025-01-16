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

    public function insertarReserva($hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId, $habitacionId = null, $tarifaId = null, $precioHabitacion = null, $precioActividad = null, $precioTarifa = null, $precioTotal = null) {
        // Asegúrate de que las fechas se pasen en formato correcto (YYYY-MM-DD)
        $query = "INSERT INTO Reservas (Id_Hotel, Id_Cliente, Checkin, Checkout, Numero_Personas, Id_Pais, Id_Actividad, Id_Habitacion, Id_Tarifa, Precio_Habitacion, Precio_Actividad, Precio_Tarifa, Precio_Total) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }

        // Usa "s" para las fechas (strings) y "i" para los enteros
        $stmt->bind_param("iisssiiiddd", $hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId, $habitacionId, $tarifaId, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            echo "Error al insertar la reserva: " . $stmt->error;
            return null;
        }
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
