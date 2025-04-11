<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../modelo/actividad/actividadModel.php';
require_once __DIR__ . '/../../modelo/metodopago/metodoPagoModel.php';
require_once __DIR__ . '/../../modelo/servicios/serviciosModel.php';
require_once __DIR__ . '/../../config/Database.php';

class ReservaModel {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerPaises() {
        try {
            $sql = "SELECT DISTINCT h.Id_Pais, p.Pais FROM Hotel h inner join Pais p on h.Id_Pais = p.Id_Pais ";
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
 

    public function obtenerPrecioTarifa($idTarifa) {
        try {
            $sql = "SELECT Precio FROM Tarifas WHERE Id_Tarifa = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idTarifa);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_row();
            
            // Cerrar el statement
            $stmt->close();
    
            // Retornar el precio si se encontró
            return $resultado ? $resultado[0] : 0; // Si no se encuentra, retornar 0
        } catch (Exception $e) {
            error_log("Error al obtener precio de tarifa: " . $e->getMessage());
            return 0;
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
            $query = `UPDATE Reservas 
                      SET Estado = 'Pagado', Id_Pago = ? 
                      WHERE Id_Reserva = ?`;
            
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
            $sql = `UPDATE Reservas 
                    SET Estado = 'Pagado', Id_MetodoPago = ?, Id_Actividad = ?, 
                        Precio_Habitacion = ?, Precio_Actividad = ?, Precio_Total = ? 
                    WHERE Id_Reserva = ?` ;
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
        // Lista de estados válidos según la base de datos
        $estadosValidos = ['Por pagar', 'Pagado', 'Cancelado'];
    
        // Verifica si el nuevo estado es válido
        if (!in_array($nuevoEstado, $estadosValidos)) {
            throw new Exception("Error: Estado inválido '$nuevoEstado'.");
        }
    
        $query = "UPDATE Reservas SET Estado = ? WHERE Id_Reserva = ?";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }
    
        $stmt->bind_param("si", $nuevoEstado, $idReserva);
    
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error al actualizar el estado de la reserva: " . $stmt->error);
        }
    
        $stmt->close();
    }
    
    
    public function insertarReserva($idCliente, $idHabitacion, $idHotel, $idTarifa, $precioHabitacion, $precioActividad, $precioTarifa, $precioServicio, $precioTotal, $checkin, $checkout, $numeroPersonas, $idPais) {
        try {
            // Validación de datos obligatorios
            if (!$idCliente || !$idHabitacion || !$idHotel || !$precioTotal || !$checkin || !$checkout || !$numeroPersonas || !$idPais) {
                throw new Exception("Datos obligatorios faltantes.");
            }
    
            // 🔴 SQL Corregido (14 columnas = 14 valores)
            $sql = "INSERT INTO Reservas 
                    (Id_Cliente, Id_Habitacion, Id_Hotel, Id_Tarifa, Precio_Habitacion, Precio_Actividad, 
                     Precio_Tarifa, Precio_Servicio, Precio_Total, Checkin, Checkout, Numero_Personas, Id_Pais, Estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pagado')";
    
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }
    
            // 🔴 bind_param Corregido (13 parámetros)
            $stmt->bind_param(
                "iiiidddddsssi", 
                $idCliente, 
                $idHabitacion, 
                $idHotel, 
                $idTarifa, 
                $precioHabitacion, 
                $precioActividad, 
                $precioTarifa, 
                $precioServicio, 
                $precioTotal, 
                $checkin, 
                $checkout, 
                $numeroPersonas, 
                $idPais
            );
    
            if ($stmt->execute()) {
                $idReserva = $this->conn->insert_id;
                $stmt->close();
                return $idReserva;
            } else {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log("Error en insertarReserva: " . $e->getMessage());
            return false;
        }
    }

    public function asociarServicioAReserva($idReserva, $idServicio) {
        // ✅ Consulta SQL corregida para MySQLi
        $sql = "INSERT INTO Reserva_Servicio (Id_Reserva, Id_Servicio) VALUES (?, ?)";
    
        // ✅ Preparar la consulta con MySQLi
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->conn->error);
        }
    
        // ✅ Bind de parámetros en MySQLi
        $stmt->bind_param("ii", $idReserva, $idServicio);
    
        // ✅ Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            throw new Exception("Error al insertar servicio en reserva: " . $stmt->error);
        }
    }

    
    public function obtenerDetalleReserva($id_reserva) {
        $sql = "SELECT 
                    r.Id_Reserva, 
                    c.Nom AS Nombre_Cliente, 
                    h.Nombre AS Nombre_Hotel, 
                    ha.Tipo AS Tipo_Habitacion, 
                    ha.Numero_Habitacion AS Numero_Habitacion, 
                    p.Pais AS Nombre_Pais, 
                    r.Precio_Habitacion, 
                    r.Checkin, 
                    r.Checkout, 
                    r.Numero_Personas,
                    r.Precio_Actividad,
                    r.Precio_Servicio,
                    r.Precio_Total
                FROM Reservas r
                LEFT JOIN Clients c ON r.Id_Cliente = c.Id_Client
                LEFT JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
                LEFT JOIN Habitaciones ha ON r.Id_Habitacion = ha.Id_Habitaciones
                LEFT JOIN Pais p ON r.Id_Pais = p.Id_Pais
                WHERE r.Id_Reserva = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_reserva);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }




    
    
    public function asociarActividadAReserva($idReserva, $idActividad, $precio) {
        try {
            $query = "INSERT INTO Reservas_Actividades (Id_Reserva, Id_Actividad, Precio_Actividad) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Error en la consulta: " . $this->conn->error);
            }
            
            $stmt->bind_param("iid", $idReserva, $idActividad, $precio);
            
            if (!$stmt->execute()) {
                throw new Exception("Error al asociar actividad: " . $stmt->error);
            }
            
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log("Error en asociarActividadAReserva: " . $e->getMessage());
            return false;
        }
    }
    


   
}
?>
