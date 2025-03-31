<?php
require_once __DIR__ . '/../../config/Database.php';
class PagoModel {
    
    private $conn;

    // Constructor que recibe la conexión de la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para procesar un pago
   // Método para procesar un pago
    public function procesarPago($hotelId, $clienteId, $reservaId, $metodoPago, $fechaPago, $metodoPagoId) {
        try {
            // ✅ Validar existencia de la reserva
            $sqlCheckReserva = "SELECT Id_Reserva FROM Reservas WHERE Id_Reserva = ?";
            $stmtCheck = $this->conn->prepare($sqlCheckReserva);
            $stmtCheck->bind_param("i", $reservaId);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();

            if ($result->num_rows === 0) {
                throw new Exception("Error: La reserva con ID $reservaId no existe.");
            }
            $stmtCheck->close();

            // ✅ Insertar pago
            $query = "INSERT INTO Pago (Id_Hotel, Id_Cliente, Id_Reserva, MetodoPago, Fecha_Pago, Id_MetodoPago) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
            }

            // ✅ Tipos correctos: iiissi (3 enteros, 2 strings, 1 entero)
            $stmt->bind_param("iiissi", 
                $hotelId, 
                $clienteId, 
                $reservaId, 
                $metodoPago, 
                $fechaPago, 
                $metodoPagoId
            );

            if (!$stmt->execute()) {
                throw new Exception("Error al procesar el pago: " . $stmt->error);
            }

            $stmt->close();
            return true;

        } catch (Exception $e) {
            error_log("Error en procesarPago: " . $e->getMessage());
            throw $e; // Propagar el error para manejo superior
        }
    }



   

    // Método para actualizar el estado de la reserva
    public function actualizarEstadoReserva($idReserva, $nuevoEstado) {
        $query = "UPDATE Reservas SET Estado = ? WHERE Id_Reserva = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        // Vincula los parámetros
        $stmt->bind_param("si", $nuevoEstado, $idReserva);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error al actualizar el estado de la reserva: " . $stmt->error);
        }

        $stmt->close();
    }

    
}
?>
