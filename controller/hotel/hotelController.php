<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../modelo/hotel/HotelModel.php'; 
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';

class HotelController {
    private $hotelModel;
    private $reservaModel;

    public function __construct() {
        $db = new Database();
        $connection = $db->getConnection();
        $this->hotelModel = new HotelModel($connection);
        $this->reservaModel = new ReservaModel($connection);
    }

    public function obtenerHoteles($paisId) {
        return $this->hotelModel->obtenerHotelesPorPais($paisId);
    }

    public function mostrarDetallesHotel($hotelId) {
        $hotelDetails = $this->reservaModel->obtenerHotelPorId($hotelId);
        $habitaciones = $this->reservaModel->obtenerHabitacionPorHotelId($hotelId);

        include '../vista/detalles_hotel.php';
    }
}

if (isset($_GET['hotelId'])) {
    $hotelId = $_GET['hotelId'];
    $controller = new HotelController();
    $controller->mostrarDetallesHotel($hotelId);
} else {
    header('Location: reservas.php');
    exit;
}
?>