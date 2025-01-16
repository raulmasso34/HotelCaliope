<?php
// MetodoPagoModel.php

require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta a Database.php sea correcta

class MetodoPagoModel {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todos los métodos de pago disponibles
    public function obtenerMetodosPago() {
        $sql = "SELECT * FROM MetodoPago WHERE Activo = 1";  // Solo métodos de pago activos
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);  // Devuelve todos los métodos de pago disponibles como un array
    }

    public function obtenerMetodosPagoPorCliente($clienteId) {
        $sql = "SELECT * FROM MetodoPago WHERE Id_Cliente = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $clienteId);  // Parametro cliente
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);  // Devuelve los métodos de pago asociados al cliente
    }
    

    // Obtener un método de pago por su ID
    public function obtenerMetodoPagoPorId($metodoPagoId) {
        $sql = "SELECT * FROM MetodoPago WHERE Id_MetodoPago = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $metodoPagoId); // Bind del parámetro para evitar SQL injection
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();  // Devuelve los detalles del método de pago
    }

    // Agregar un nuevo método de pago (Si es necesario)
    public function agregarMetodoPago($tipo, $descripcion, $activo) {
        $sql = "INSERT INTO MetodoPago (Tipo, Descripcion, Activo) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $tipo, $descripcion, $activo); // Bind de los parámetros

        return $stmt->execute();  // Retorna true si la inserción fue exitosa
    }

    // Actualizar un método de pago
    public function actualizarMetodoPago($idMetodoPago, $tipo, $descripcion, $activo) {
        $sql = "UPDATE MetodoPago SET Tipo = ?, Descripcion = ?, Activo = ? WHERE Id_MetodoPago = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssii", $tipo, $descripcion, $activo, $idMetodoPago); // Bind de los parámetros

        return $stmt->execute();  // Retorna true si la actualización fue exitosa
    }

    // Desactivar un método de pago
    public function desactivarMetodoPago($idMetodoPago) {
        $sql = "UPDATE MetodoPago SET Activo = 0 WHERE Id_MetodoPago = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idMetodoPago); // Bind del parámetro

        return $stmt->execute();  // Retorna true si la desactivación fue exitosa
    }
}
?>
