<?php
// ActividadController.php

require_once __DIR__ . '/../../modelo/actividad/actividadModel.php';
require_once __DIR__ . '/../../config/Database.php';

class ActividadController {
    private $actividadModel;

    public function __construct() {
        $this->actividadModel = new ActividadModel();
    }

    // Obtener actividades por hotel
    public function obtenerActividadesPorHotel($hotelId) {
        return $this->actividadModel->obtenerActividadesPorHotel($hotelId);
    }

    // Obtener el precio de una actividad
    public function obtenerPrecioActividad($actividadId) {
        return $this->actividadModel->obtenerPrecioActividad($actividadId);
    }

    // Obtener el nombre de la actividad por su ID
    public function obtenerNombreActividad($actividadId) {
        return $this->actividadModel->obtenerNombreActividad($actividadId);
    }

    // Obtener detalles de una actividad por su ID
    public function obtenerActividadPorId($actividadId) {
        return $this->actividadModel->obtenerActividadPorId($actividadId);
    }

    // Agregar una nueva actividad
   /* public function agregarActividad($idHotel, $diaInicio, $diaFin, $horaInicio, $horaFin, $capacidadMaxima, $ubicacion, $descripcion, $precio) {
        return $this->actividadModel->agregarActividad($idHotel, $diaInicio, $diaFin, $horaInicio, $horaFin, $capacidadMaxima, $ubicacion, $descripcion, $precio);
    }*/

    // Guardar las actividades seleccionadas en la sesión
    public function guardarActividadesSeleccionadas($actividadesSeleccionadas) {
        // Verifica que el array de actividades no esté vacío
        if (!empty($actividadesSeleccionadas) && is_array($actividadesSeleccionadas)) {
    $_SESSION['Reservas']['actividades'] = array_keys($actividadesSeleccionadas);
}

    }
}
?>
