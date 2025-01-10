<?php
require_once __DIR__ . '/../../config/Database.php'; 
class ReservaModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearReserva($clienteId, $habitacionId, $checkin, $checkout, $precioTotal) {
        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Habitacion, Fecha_Checkin, Fecha_Checkout, Precio_Total)
                VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("iissd", $clienteId, $habitacionId, $checkin, $checkout, $precioTotal);
            return $stmt->execute();
        }
        return false;
    }
}
?>
