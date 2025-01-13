<?php
require_once __DIR__ . '/../../config/Database.php';

class ReservaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crearReserva($clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal) {
        $checkin = date('Y-m-d', strtotime($checkin));
        $checkout = date('Y-m-d', strtotime($checkout));

        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Pais, Id_Habitacion, Fecha_Checkin, Fecha_Checkout, Numero_Personas, Precio_Habitacion, Precio_Actividad, Precio_Tarifa, Precio_Total) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiissiiii", $clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal);

        return $stmt->execute();
    }
}
?>
