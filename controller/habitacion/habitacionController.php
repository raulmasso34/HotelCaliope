<?php
require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';  
 

class HabitacionController {
    private $habitacionModel;

    public function __construct() {
        $db = new Database();
        $this->habitacionModel = new HabitacionModel($db->getConnection());
    }

    public function mostrarHabitacionesDisponibles() {
        $habitaciones = $this->habitacionModel->obtenerHabitacionesDisponibles();
        return $habitaciones;
    }
}
?>
