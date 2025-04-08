<?php
require_once __DIR__ . '/../../config/Database.php';

class ClientModel {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerNombreCliente($clienteId) {
        // Ejemplo de consulta para obtener el nombre del cliente
        $sql = "SELECT Nom FROM Clients WHERE Id_Client = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $clienteId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['Nom'];
        }
        
        return null;  // Si no encuentra al cliente, retorna null
    }
}
?>
