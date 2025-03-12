<?php
require_once __DIR__ . '/../../modelo/pais/paisModel.php';

class PaisController {
    private $paisesModel;

    public function __construct() {
        $this->paisesModel = new PaisesModel();
    }

    // Método para obtener todos los países
    public function obtenerPaises() {
        return $this->paisesModel->obtenerPaises();
    }

    // Método para obtener el nombre de un país por su ID
    public function obtenerNombrePais($paisId) {
        return $this->paisesModel->obtenerNombrePais($paisId);
    }
}
