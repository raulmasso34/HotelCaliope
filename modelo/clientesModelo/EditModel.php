<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '../../../config/Database.php';

class EditModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener información del cliente por ID
    public function getClientById($clientId) {
        $query = "SELECT Id_Client, Usuari, Password, CorreuElectronic FROM Clients WHERE Id_Client = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Actualizar usuario y/o contraseña
    public function updateUserCredentials($clientId, $newUsername, $newPassword = null) {
        // Si solo actualizamos el nombre de usuario
        if ($newPassword === null) {
            $query = "UPDATE Clients SET Usuari = ? WHERE Id_Client = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $newUsername, $clientId);
        } else {
            // Si actualizamos tanto el nombre de usuario como la contraseña
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE Clients SET Usuari = ?, Password = ? WHERE Id_Client = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $newUsername, $hashedPassword, $clientId);
        }
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Verificar si el nombre de usuario ya existe (excluyendo al usuario actual)
    public function isUsernameAvailable($username, $currentClientId) {
        $query = "SELECT COUNT(*) as count FROM Clients WHERE Usuari = ? AND Id_Client != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $username, $currentClientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // Si count es 0, el nombre de usuario está disponible
        return ($row['count'] == 0);
    }

    // Obtener historial de cambios para un cliente
    public function getClientHistory($clientId) {
        $query = "SELECT * FROM histClientes WHERE Id_Cliente = ? ORDER BY FechaModificacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        
        return $history;
    }
}
?>