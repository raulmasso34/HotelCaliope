<?php
require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';  

class HabitacionController {
    private $habitacionModel;

    // Constructor, se conecta a la base de datos y crea el modelo
    public function __construct() {
        $db = new Database();
        $this->habitacionModel = new HabitacionModel($db->getConnection());
    }

    // Este método maneja la lógica para mostrar habitaciones disponibles
    public function mostrarHabitacionesDisponibles() {
        // Obtener los parámetros del formulario (ubicación, fechas, número de personas, etc.)
        $location = isset($_GET['location']) ? $_GET['location'] : null;
        $checkin = isset($_GET['checkin']) ? $_GET['checkin'] : null;
        $checkout = isset($_GET['checkout']) ? $_GET['checkout'] : null;
        $guests = isset($_GET['guests']) ? $_GET['guests'] : null;
        $habitacion_id = isset($_GET['habitacion_id']) ? $_GET['habitacion_id'] : null;

        // Validar que todos los parámetros estén presentes
        if ($location && $checkin && $checkout && $guests && $habitacion_id) {
            // Obtener las habitaciones disponibles con los filtros
            $habitaciones = $this->habitacionModel->obtenerHabitacionesDisponiblesFiltradas($location, $checkin, $checkout, $guests, $habitacion_id);
            
            // Pasar las habitaciones a la vista para mostrar los resultados
            require_once __DIR__ . '/../vista/vistaReserva.php';  // Asegúrate de que la vista esté correcta
        } else {
            echo "Faltan parámetros necesarios.";
        }
    }
}
?>
