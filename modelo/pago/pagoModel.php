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
    

    public function insertarReserva($hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId, $habitacionId = null, $tarifaId = null, $precioHabitacion = null, $precioActividad = null, $precioTarifa = null, $precioTotal = null) {
        try {
            // Prepare la consulta SQL
            $query = "INSERT INTO Reservas (Id_Hotel, Id_Cliente, Checkin, Checkout, Numero_Personas, Id_Pais, Id_Actividad, Id_Habitacion, Id_Tarifa, Precio_Habitacion, Precio_Actividad, Precio_Tarifa, Precio_Total) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Preparar el statement
            $stmt = $this->conn->prepare($query);
            
            if (!$stmt) {
                throw new Exception('Error en la preparación de la consulta: ' . $this->conn->error);
            }
    
            // Vincular los parámetros
            $stmt->bind_param("iisssiiiddd", $hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId, $habitacionId, $tarifaId, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                $stmt->close();
                return $this->conn->insert_id;  // Devuelve el ID de la nueva reserva
            } else {
                throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
            }
        } catch (Exception $e) {
            error_log("Error al insertar la reserva: " . $e->getMessage());
            return null;
        }
    }
    
}
?>
