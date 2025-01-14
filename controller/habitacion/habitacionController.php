<?php
require_once __DIR__ . '/../modelo/habitaciones/habitacionModel.php';  // Asegúrate de ajustar la ruta

class HabitacionController {
    private $habitacionModel;

    public function __construct() {
        // Instanciamos el modelo de Habitaciones
        $this->habitacionModel = new HabitacionesModel();
    }

    // Método para obtener las habitaciones disponibles por Id_Hotel
    public function obtenerHabitacionesDisponibles($hotelId) {
        // Obtenemos las habitaciones disponibles para el hotel seleccionado
        $habitaciones = $this->habitacionModel->obtenerHabitacionesDisponiblesPorHotel($hotelId);
        return $habitaciones;
    }

    // Método para obtener información de una habitación por su ID
    public function obtenerHabitacion($habitacionId) {
        // Obtenemos los detalles de una habitación específica
        $habitacion = $this->habitacionModel->obtenerHabitacionPorId($habitacionId);
        return $habitacion;
    }
}
?>
