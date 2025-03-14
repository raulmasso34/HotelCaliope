<?php

require_once __DIR__ . '/../../modelo/servicios/serviciosModel.php';
require_once __DIR__ . '/../../config/Database.php';

class ServiciosController {
    private $serviciosModel;

    public function __construct() {
        $this->serviciosModel = new ServiciosModel();
    }

    public function obtenerServicios($hotelId) {
        if (!$hotelId) {
            return []; // Si no hay hotel seleccionado, devuelve un array vacío
        }

        return $this->serviciosModel->obtenerServicios($hotelId);
    }
}
?>
