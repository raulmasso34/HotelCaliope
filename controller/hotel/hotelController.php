<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/hotel/HotelModel.php';  // Asegúrate de que la ruta sea correcta

class HotelController {

    private $hotelModel;

    public function __construct() {
        // Establecemos la conexión con la base de datos y luego instanciamos el modelo
        $db = new Database();
        $this->hotelModel = new HotelModel($db->getConnection());
    }

    // Función para obtener los hoteles filtrados por ubicación (país)
    public function obtenerHoteles($paisId) {
        // Usamos el modelo para obtener los hoteles disponibles por país
        return $this->hotelModel->obtenerHotelesPorPais($paisId);
    }
    
    // En el futuro puedes agregar más funciones aquí, por ejemplo:
    // - Función para obtener los detalles de un hotel por su ID
    // - Función para obtener hoteles por ciudad o estrellas
}
?>
