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

    // Obtener todas las habitaciones agrupadas por tipo
    public function obtenerTodasLasHabitacionesAgrupadas() {
        $habitaciones = $this->habitacionModel->obtenerHabitaciones();
        $habitacionesAgrupadas = [];
    
        foreach ($habitaciones as $habitacion) {
            $tipo = $habitacion['Tipo'];
    
            if (!isset($habitacionesAgrupadas[$tipo])) {
                $habitacionesAgrupadas[$tipo] = [];
            }
    
            $habitacionesAgrupadas[$tipo][] = $habitacion;
        }
    
        return $habitacionesAgrupadas;
    }

    // Obtener habitaciones por continente
   // Método en HabitacionController
public function obtenerHabPorContinente($continenteId) {
    // Verificar que el parámetro continenteId no sea nulo o incorrecto
    if ($continenteId == null || $continenteId <= 0) {
        return null;
    }

    // Llamar al modelo para obtener las habitaciones
    return $this->habitacionModel->obtenerHabPorContinente($continenteId);
}

}
?>
