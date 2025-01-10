<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';
require_once __DIR__ . '/../../modelo/reservas/reservaModel.php';  // Asegúrate de tener este modelo de reservas

class ReservaController {

    private $habitacionModel;
    private $hotelModel;
    private $paisModel;
    private $reservaModel;

    public function __construct() {
        $db = new Database();
        $this->habitacionModel = new HabitacionModel($db->getConnection());
        $this->hotelModel = new HotelModel($db->getConnection());
        $this->paisModel = new PaisModel($db->getConnection());
        $this->reservaModel = new ReservaModel($db->getConnection());  // Modelo de reservas
    }

    // Función para manejar la reserva
    public function reservar() {
        // Obtener los datos del formulario
        $paisId = isset($_POST['location']) ? $_POST['location'] : null;
        $checkin = isset($_POST['checkin']) ? $_POST['checkin'] : null;
        $checkout = isset($_POST['checkout']) ? $_POST['checkout'] : null;
        $guests = isset($_POST['guests']) ? $_POST['guests'] : null;
        $habitacion_id = isset($_POST['habitacion_id']) ? $_POST['habitacion_id'] : null;
        $id_cliente = 1; // Esto debe ser de alguna sesión de usuario, por ejemplo: $_SESSION['id_cliente']
        $id_actividad = null; // Esto se puede adaptar si tienes actividades
        $id_tarifa = 1; // Este valor dependerá de la tarifa seleccionada

        // Validar que todos los campos necesarios estén completos
        if ($paisId && $checkin && $checkout && $guests && $habitacion_id) {

            // Obtener habitaciones disponibles filtradas por los parámetros de ubicación, fechas y número de personas
            $habitacionesDisponibles = $this->habitacionModel->obtenerHabitacionesDisponiblesFiltradas($paisId, $checkin, $checkout, $guests);
            
            // Obtener la habitación seleccionada
            $habitacionSeleccionada = $this->habitacionModel->obtenerHabitacionPorId($habitacion_id);

            // Obtener la tarifa de la habitación
            $precioHabitacion = $habitacionSeleccionada['Precio'];

            // Calcular el precio total (esto es solo un ejemplo)
            $numeroNoches = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);  // Calcular número de noches
            $precioTotalHabitacion = $precioHabitacion * $numeroNoches;
            $precioTotal = $precioTotalHabitacion;  // Aquí puedes agregar más cálculos si tienes actividades o tarifas

            // Registrar la reserva
            $reservaId = $this->reservaModel->insertarReserva($id_cliente, $id_actividad, $habitacion_id, $paisId, $id_tarifa, $precioHabitacion, $precioTotal, $checkin, $checkout, $guests);

            if ($reservaId) {
                echo "Reserva realizada con éxito. ID de reserva: " . $reservaId;
            } else {
                echo "Hubo un error al realizar la reserva.";
            }

        } else {
            echo "Faltan datos para realizar la reserva.";
        }
    }
}

// Crear el controlador y ejecutar el método de reserva
$reservaController = new ReservaController();
$reservaController->reservar();
?>
