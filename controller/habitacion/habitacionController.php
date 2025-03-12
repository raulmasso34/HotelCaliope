<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/habitaciones/habitacionModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class HabitacionController {
    private $habitacionModel;

    public function __construct() {
        $this->habitacionModel = new HabitacionesModel();
    }

    // Obtener todas las habitaciones
    public function obtenerHabitaciones() {
        return $this->habitacionModel->obtenerHabitaciones();
    }

    // Obtener precio de una habitación por ID
    public function obtenerPrecioHabitacion($habitacionId) {
        return $this->habitacionModel->obtenerPrecioHabitacion($habitacionId);
    }

    // Obtener detalles de una habitación por ID
    public function obtenerHabitacionPorId($habitacionId) {
        return $this->habitacionModel->obtenerHabitacionPorId($habitacionId);
    }

    // Obtener habitaciones disponibles en un hotel
    public function obtenerHabitacionesPorHotel($hotelId) {
        return $this->habitacionModel->obtenerHabitacionesPorHotel($hotelId);
    }
}
?>