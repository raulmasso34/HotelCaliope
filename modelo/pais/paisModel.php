<?php

require_once __DIR__ . '/../../config/Database.php'; 

class PaisModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los países
    public function obtenerPaises() {
        $sql = "SELECT * FROM Pais";
        $result = $this->conn->query($sql);

        // Depuración: Verificar si la consulta devuelve resultados
        if ($result) {
            $paises = $result->fetch_all(MYSQLI_ASSOC);
            return $paises;
        } else {
            // Si la consulta falla, muestra el error
            die("Error en la consulta SQL: " . $this->conn->error);
        }
    }
}

?>
