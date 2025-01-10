<?php
class ReservaModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Insertar una nueva reserva en la base de datos
    public function insertarReserva($id_cliente, $id_actividad, $id_habitacion, $id_hotel, $id_tarifa, $precio_habitacion, $precio_total, $checkin, $checkout, $numero_personas) {
        // Preparamos la consulta de inserción
        $sql = "INSERT INTO Reservas (Id_Cliente, Id_Actividad, Id_Habitacion, Id_Hotel, Id_Tarifa, Precio_Habitacion, Precio_Total, Checkin, Checkout, Numero_Personas) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        // Vinculamos los parámetros
        $stmt->bind_param("iiiiidssii", $id_cliente, $id_actividad, $id_habitacion, $id_hotel, $id_tarifa, $precio_habitacion, $precio_total, $checkin, $checkout, $numero_personas);

        // Ejecutamos la consulta y verificamos si fue exitosa
        if ($stmt->execute()) {
            return $this->conn->insert_id;  // Devuelve el ID de la reserva insertada
        } else {
            return false;
        }
    }
}
?>
