<?php
require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';  

class HotelController {

    private $hotelModel;

    public function __construct() {
        $db = new Database();
        $this->hotelModel = new HotelModel($db->getConnection());
    }

    // Función para obtener los hoteles filtrados por ubicación
    public function obtenerHoteles($location) {
        // Obtener los hoteles disponibles por ubicación
        return $this->hotelModel->obtenerHotelesPorPais($location);
    }
}
?>
