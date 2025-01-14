<?php
class ReservaModel {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    // Método para crear una reserva
    public function crearReserva($clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, 
                                 $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal) {
        // Preparar la consulta SQL para insertar los datos de la reserva
        $query = "INSERT INTO Reservas (Id_Cliente, Id_Pais, Id_Habitacion, Checkin, Checkout, Numero_Personas, 
                                        Precio_Habitacion, Precio_Actividad, Precio_Tarifa, Precio_Total) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta
        $stmt = $this->db->prepare($query);

        // Asegúrate de que las fechas están en formato 'YYYY-MM-DD'
        // Si las fechas son del tipo 'string' y están en formato correcto, puedes pasarlas directamente.

        // Ejecutar la consulta con los parámetros proporcionados
        $stmt->bind_param("iiissiiidi", 
                          $clienteId,  // id_cliente
                          $paisId,     // id_pais
                          $habitacionId,  // id_habitacion
                          $checkin,   // checkin (fecha)
                          $checkout,  // checkout (fecha)
                          $guests,    // numero_personas
                          $precioHabitacion, // precio_habitacion
                          $precioActividad,  // precio_actividad
                          $precioTarifa,     // precio_tarifa
                          $precioTotal);     // precio_total

        // Ejecutar y verificar si la inserción fue exitosa
        if ($stmt->execute()) {
            return true;  // Reserva exitosa
        } else {
            return false; // Error al crear la reserva
        }
    }
}
?>
