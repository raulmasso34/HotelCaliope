<?php
// MetodoPagoController.php

require_once __DIR__ . '/../../modelo/metodopago/metodoPagoModel.php';  // Asegúrate de que la ruta al modelo es correcta
require_once __DIR__ . '/../../config/Database.php';

class MetodoPagoController {
    private $metodoPagoModel;

    public function __construct() {
        $this->metodoPagoModel = new MetodoPagoModel();
    }

    // Obtener todos los métodos de pago disponibles
    public function obtenerMetodosPago() {
        return $this->metodoPagoModel->obtenerMetodosPago();
    }

    // Obtener los métodos de pago asociados a un cliente
    public function obtenerMetodosPagoPorCliente($clienteId) {
        return $this->metodoPagoModel->obtenerMetodosPagoPorCliente($clienteId);
    }

    // Obtener un método de pago por su ID
    public function obtenerMetodoPagoPorId($metodoPagoId) {
        return $this->metodoPagoModel->obtenerMetodoPagoPorId($metodoPagoId);
    }

    // Agregar un nuevo método de pago
    public function agregarMetodoPago($tipo, $descripcion, $activo) {
        return $this->metodoPagoModel->agregarMetodoPago($tipo, $descripcion, $activo);
    }

    // Actualizar un método de pago existente
    public function actualizarMetodoPago($idMetodoPago, $tipo, $descripcion, $activo) {
        return $this->metodoPagoModel->actualizarMetodoPago($idMetodoPago, $tipo, $descripcion, $activo);
    }

    // Desactivar un método de pago
    public function desactivarMetodoPago($idMetodoPago) {
        return $this->metodoPagoModel->desactivarMetodoPago($idMetodoPago);
    }
}
?>

