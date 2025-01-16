<?php
// PagoModel.php

class PagoModel {
    private $conn;

    // Constructor que recibe la conexión de la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para procesar un pago
    public function procesarPago($hotelId, $clienteId, $reservaId, $metodoPago, $fechaPago, $metodoPagoId) {
        $query = "INSERT INTO Pago (Id_Hotel, Id_Cliente, Id_Reserva, MetodoPago, Fecha_Pago, Id_MetodoPago) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiisss", $hotelId, $clienteId, $reservaId, $metodoPago, $fechaPago, $metodoPagoId);

        if ($stmt->execute()) {
            echo "Pago procesado con éxito.";
        } else {
            echo "Error al procesar el pago: " . $stmt->error;
        }
    }
}
?>
