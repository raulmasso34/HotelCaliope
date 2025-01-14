<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ReservaController {

    // Método para obtener todos los países
    public function obtenerPaises() {
        $paisesModel = new PaisesModel();
        return $paisesModel->obtenerPaises();  // Devuelve todos los países
    }

    // Método para crear una reserva
    public function crearReserva() {
        // Verificar que los datos del formulario están disponibles
        if (isset($_POST['habitacionId'], $_POST['clienteId'], $_POST['paisId'], $_POST['checkin'], $_POST['checkout'], $_POST['guests'])) {
            // Obtener los datos del formulario
            $clienteId = $_POST['clienteId'];
            $paisId = $_POST['paisId'];
            $habitacionId = $_POST['habitacionId'];
            $checkin = $_POST['checkin'];
            $checkout = $_POST['checkout'];
            $guests = $_POST['guests'];

            // Instanciar los modelos
            $reservaModel = new ReservaModel();
            $habitacionesModel = new HabitacionesModel();

            // Obtener los detalles de la habitación seleccionada
            $habitacion = $habitacionesModel->obtenerHabitacionPorId($habitacionId);
            $precioHabitacion = $habitacion['Precio'];  // Asegúrate de que esta columna existe en tu base de datos

            // Para los precios de actividades y tarifas, deberías obtenerlos de las tablas correspondientes
            // Si tienes actividades o tarifas asociadas, obtén los precios aquí, como en el ejemplo anterior
            $precioActividad = 50; // Este valor debe venir de la base de datos, si es necesario
            $precioTarifa = 30;    // Este valor también debe venir de la base de datos, si es necesario

            // Calcular el precio total
            $precioTotal = $precioHabitacion + ($precioActividad * $guests) + ($precioTarifa * $guests); // Asegúrate de aplicar el cálculo correcto para el número de huéspedes

            // Crear la reserva llamando al método del modelo
            $result = $reservaModel->crearReserva(
                $clienteId, $paisId, $habitacionId, $checkin, $checkout, $guests, 
                $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal
            );

            // Redirigir a la página correspondiente dependiendo del resultado
            if ($result) {
                header("Location: ../../vista/reservas.php");
                exit();
            } else {
                // Si hay un error, redirigir a una página de error
                header("Location: ../../vista/error_reserva.php");
                exit();
            }
        } else {
            // Si falta algún dato, redirigir a una página de error
            header("Location: ../../vista/error_reserva.php");
            exit();
        }
    }
}
?>
