<?php
// ServiciosController.php

require_once __DIR__ . '/../../modelo/servicios/serviciosModel.php';

class ServiciosController {
    private $serviciosModel;

    public function __construct() {
        $this->serviciosModel = new ServiciosModel();
    }

    public function obtenerServicios() {
        session_start(); // Asegurar que la sesión está iniciada
        
        if (!isset($_SESSION['hotelId'])) {
            echo json_encode(["error" => "ID de hotel no disponible en la sesión"]);
            return;
        }

        $servicios = $this->serviciosModel->obtenerServicios();
        
        if ($servicios) {
            echo json_encode($servicios);
        } else {
            echo json_encode(["error" => "No se encontraron servicios disponibles"]);
        }
    }
}

// Manejo de la solicitud
$controller = new ServiciosController();
$controller->obtenerServicios();
?>