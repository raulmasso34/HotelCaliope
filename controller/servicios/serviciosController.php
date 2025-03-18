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
    
    public function obtenerNombreServicio($hotelId) {
        try {
            // Validamos que el hotelId sea un número válido
            if (!is_numeric($hotelId) || $hotelId <= 0) {
                return [];
            }
    
            // Llamamos al modelo para obtener los servicios
            return $this->serviciosModel->obtenerNombreServicios($hotelId);
        } catch (Exception $e) {
            error_log("Error en obtenerNombreServicio: " . $e->getMessage());
            return []; // Retorna un array vacío en caso de error
        }
    }

    public function obtenerNombreServicioPorId($servicioId) {
        try {
            return $this->serviciosModel->obtenerNombreServicio($servicioId);
        } catch (Exception $e) {
            error_log("Error al obtener nombre del servicio: " . $e->getMessage());
            return null; // Retorna null si hay un error
        }
    }

    public function obtenerServicioPorId($servicioId){
        try {
            return $this->serviciosModel->obtenerServicioPorId($servicioId);
            } catch (Exception $e) {
                error_log("Error al obtener servicio por id: " . $e->getMessage());
                return null; // Retorna null si hay un error
            }
    }

    
}
    
?>
