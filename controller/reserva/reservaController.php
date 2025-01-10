<?php
require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';  
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';  

class ReservaController {

    private $habitacionModel;
    private $hotelModel;

    public function __construct() {
        $db = new Database();
        $this->habitacionModel = new HabitacionModel($db->getConnection());
        $this->hotelModel = new HotelModel($db->getConnection());
    }

    // Función para realizar la reserva
    public function reservar() {
        // Recibir los datos del formulario
        $location = isset($_GET['location']) ? $_GET['location'] : null;
        $checkin = isset($_GET['checkin']) ? $_GET['checkin'] : null;
        $checkout = isset($_GET['checkout']) ? $_GET['checkout'] : null;
        $guests = isset($_GET['guests']) ? $_GET['guests'] : null;
        $habitacion_id = isset($_GET['habitacion_id']) ? $_GET['habitacion_id'] : null;

        // Validar los datos recibidos (aquí puedes agregar más validaciones si es necesario)
        if ($location && $checkin && $checkout && $guests && $habitacion_id) {

            // Obtener las habitaciones disponibles con los parámetros
            $habitacionesDisponibles = $this->habitacionModel->obtenerHabitacionesDisponiblesFiltradas($location, $checkin, $checkout, $guests, $habitacion_id);

            // Obtener los hoteles disponibles según la ubicación
            $hotelesDisponibles = $this->hotelModel->obtenerHotelesPorUbicacion($location);

            // Pasar los datos a la vista de resultados
            include __DIR__ . '/../../vista/resultados/resultados.php';  // Redirigir a la vista con los resultados

        } else {
            echo "Faltan datos para realizar la reserva.";
        }
    }
}

// Crear el controlador y ejecutar el método de reserva
$reservaController = new ReservaController();
$reservaController->reservar();
