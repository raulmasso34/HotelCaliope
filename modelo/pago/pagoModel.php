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
        $query = "INSERT INTO Pago (Id_Hotel, Id_Cliente, Id_Reserva, MetodoPago, Fecha_Pago, Id_MetodoPago) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Verifica si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . $this->conn->error);
        }

        // Vincula los parámetros
        // Asegúrate de que 'MetodoPago' es un string y 'Id_MetodoPago' es un entero
        $stmt->bind_param("iiissi", $hotelId, $clienteId, $reservaId, $metodoPago, $fechaPago, $metodoPagoId);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            echo "Pago procesado con éxito.";
        } else {
            throw new Exception("Error al procesar el pago: " . $stmt->error);
        }

        $stmt->close();
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
