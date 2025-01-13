<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';
require_once __DIR__ . '/../../config/Database.php';

class ReservaController {

    // Método para obtener todos los países disponibles
    public function obtenerPaises() {
        $paisesModel = new PaisesModel();
        return $paisesModel->obtenerPaises();  // Devuelve todos los países desde la base de datos
    }

    // Método para obtener las habitaciones disponibles según el país seleccionado
    public function obtenerHabitaciones($paisId) {
        $habitacionesModel = new HabitacionesModel();
        return $habitacionesModel->obtenerHabitacionesDisponibles($paisId);  // Devuelve todas las habitaciones disponibles para el país seleccionado
    }

    // Método para crear una reserva
    public function crearReserva($clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests) {
        // Validación de datos (puedes agregar más validaciones si es necesario)
        if (empty($clienteId) || empty($paisId) || empty($habitacionId) || empty($checkin) || empty($checkout) || empty($guests)) {
            header("Location: ../vista/error_reserva.php?error=Campos_incompletos");
            exit();
        }

        // Lógica para calcular los precios de la reserva
        $precioHabitacion = $this->obtenerPrecioHabitacion($habitacionId);
        $precioActividad = 50;  // Este precio podría obtenerse desde otro modelo o base de datos
        $precioTarifa = 30;  // Este precio podría obtenerse desde otro modelo o base de datos
        $precioTotal = $precioHabitacion + $precioActividad + $precioTarifa;

        // Crear la reserva a través del modelo
        $reservaModel = new ReservaModel();
        $result = $reservaModel->crearReserva(
            $clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, 
            $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal
        );

        // Redirigir según si la reserva fue exitosa o no
        if ($result) {
            header("Location: ../vista/confirmacion_reserva.php");
            exit();
        } else {
            header("Location: ../vista/error_reserva.php?error=Error_creacion_reserva");
            exit();
        }
    }

    // Método para obtener el precio de una habitación
    private function obtenerPrecioHabitacion($habitacionId) {
        // Aquí puedes consultar la base de datos para obtener el precio de la habitación
        // Ejemplo con un precio fijo, pero deberías consultar en la base de datos
        $habitacionesModel = new HabitacionesModel();
        $habitacion = $habitacionesModel->obtenerHabitacionPorId($habitacionId);

        // Si la habitación existe, devolver el precio
        if ($habitacion) {
            return $habitacion['Precio'];
        } else {
            return 0;  // En caso de que no se encuentre la habitación
        }
    }
}
?>
