<?php
require_once __DIR__ . '/../../config/Database.php';
class histClientModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getClientById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Clients WHERE Id_Cliente = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateClient($id, $nombre, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE Clients SET Usuari = ?, Password = ? WHERE Id_Cliente = ?");
        $stmt->bind_param("ssi", $nombre, $hashedPassword, $id);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->conn->close();
    }
}