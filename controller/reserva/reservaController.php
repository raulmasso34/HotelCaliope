<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';

class ReservaController {

    public function obtenerPaises() {
        $paisesModel = new PaisesModel();
        return $paisesModel->obtenerPaises();  // Devuelve todos los países
    }

    public function obtenerHabitaciones($paisId) {
        $habitacionesModel = new HabitacionesModel();
        return $habitacionesModel->obtenerHabitacionesDisponibles($paisId);
    }

    public function crearReserva($clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests) {
        $reservaModel = new ReservaModel();
        $habitacionesModel = new HabitacionesModel();

        // Aquí deberías obtener los precios de las habitaciones, actividades, etc.
        $precioHabitacion = 100; // Ejemplo de precio, lo podrías calcular o consultar de la base de datos
        $precioActividad = 50; // Ejemplo de precio
        $precioTarifa = 30; // Ejemplo de precio
        $precioTotal = $precioHabitacion + $precioActividad + $precioTarifa;

        // Crear la reserva
        $result = $reservaModel->crearReserva(
            $clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, 
            $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal
        );

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
