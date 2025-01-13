<?php
require_once __DIR__ . '/../modelo/HabitacionModel.php';  // Asegúrate de ajustar la ruta

class HabitacionController {
    private $habitacionModel;

    public function __construct() {
        // Instanciamos el modelo de Habitaciones
        $this->habitacionModel = new HabitacionModel();
    }

    // Método para obtener las habitaciones disponibles
    public function obtenerHabitacionesDisponibles() {
        $habitaciones = $this->habitacionModel->obtenerHabitacionesDisponibles();  // Obtener todas las habitaciones disponibles
        return $habitaciones;
    }

    // Método para obtener información de una habitación por su ID
    public function obtenerHabitacion($id) {
        $habitacion = $this->habitacionModel->obtenerHabitacionPorId($id);  // Obtener una habitación específica
        return $habitacion;
    }

    // Aquí podrías agregar otros métodos para crear, actualizar o eliminar habitaciones si es necesario
}
?>
