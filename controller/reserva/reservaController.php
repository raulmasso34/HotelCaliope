<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';

class ReservaController {

    // Método para obtener todos los países
    public function obtenerPaises() {
        $paisesModel = new PaisesModel();
        return $paisesModel->obtenerPaises();  // Devuelve todos los países
    }

    // Método para obtener las habitaciones disponibles para un país específico
    public function obtenerHabitaciones($paisId) {
        $habitacionesModel = new HabitacionesModel();
    
        // Depurar el paisId recibido
        echo "Pais seleccionado: " . $paisId . "<br>";
        
        // Llamada al modelo para obtener las habitaciones disponibles
        $habitaciones = $habitacionesModel->obtenerHabitacionesDisponibles($paisId);
        
        // Depuración: Verificar qué datos están siendo devueltos por el modelo
        echo "Habitaciones obtenidas:<br>";
        var_dump($habitaciones);  // Verifica que las habitaciones son correctas
        
        return $habitaciones;  // Devuelve las habitaciones disponibles para el país
    }
    

    // Método para crear una reserva
    public function crearReserva($clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests) {
        $reservaModel = new ReservaModel();
        $habitacionesModel = new HabitacionesModel();

        // Obtener el precio de la habitación seleccionada desde la base de datos
        $habitacion = $habitacionesModel->obtenerHabitacionPorId($habitacionId);
        $precioHabitacion = $habitacion['Precio'];  // Asegúrate de que esta columna existe en tu base de datos

        // Para los precios de actividades y tarifas, deberías obtenerlos de las tablas correspondientes
        // Aquí es solo un ejemplo de cómo hacerlo:
        $precioActividad = 50; // Este valor debe venir de la base de datos, si es necesario
        $precioTarifa = 30;    // Este valor también debe venir de la base de datos, si es necesario

        // Calcular el precio total
        $precioTotal = $precioHabitacion + $precioActividad + $precioTarifa;

        // Crear la reserva llamando al método del modelo
        $result = $reservaModel->crearReserva(
            $clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, 
            $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal
        );

        // Redirigir a la página correspondiente dependiendo del resultado
        if ($result) {
            header("Location: ../vista/confirmacion_reserva.php");
            exit();
        } else {
            header("Location: ../vista/error_reserva.php");
            exit();
        }
    }
}
?>