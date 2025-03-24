<?php
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../config/Database.php';

class HotelController {
    private $hotelModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->hotelModel = new HotelModel($db);
    }

    // Obtener detalles de un hotel específico
    public function obtenerDetallesHotel($hotelId) {
        return $this->hotelModel->obtenerDetallesHotel($hotelId);
    }

    // Obtener hoteles según un país
    public function obtenerHotelesPorPais($location) {
        return $this->hotelModel->obtenerHotelesPorPais($location);
    }

    // Obtener un hotel por su ID
    public function obtenerHotelPorId($hotelId) {
        return $this->hotelModel->obtenerHotelPorId($hotelId);
    }

    // Obtener las habitaciones disponibles en un hotel
    public function obtenerHabitaciones($hotelId) {
        return $this->hotelModel->obtenerHabitaciones($hotelId);
    }
    public function obtenerTodosHoteles() {
        return $this->hotelModel->obtenerTodosHoteles();
    }

    public function obtenerEmailHotel($hotelId) {
        if (!is_numeric($hotelId)) {
            return ['error' => 'ID de hotel inválido'];
        }
        return $this->hotelModel->obtenerEmailPorId($hotelId);
    }
}

// Manejo de peticiones directas desde el navegador o AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotelController = new HotelController();

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'obtenerDetallesHotel':
                if (!empty($_POST['hotelId'])) {
                    echo json_encode($hotelController->obtenerDetallesHotel($_POST['hotelId']));
                }
                break;

            case 'obtenerHotelesPorPais':
                if (!empty($_POST['location'])) {
                    echo json_encode($hotelController->obtenerHotelesPorPais($_POST['location']));
                }
                break;

            case 'obtenerHabitaciones':
                if (!empty($_POST['hotelId'])) {
                    echo json_encode($hotelController->obtenerHabitaciones($_POST['hotelId']));
                }
                break;

            default:
                echo json_encode(["error" => "Acción no válida"]);
                break;
        }
    }
    
}
?>
