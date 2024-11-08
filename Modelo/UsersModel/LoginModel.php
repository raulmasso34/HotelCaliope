<?php
class Usuario {
    private $conn;
    private $table_name = "users"; // Nombre de la tabla de usuarios

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Método para obtener un usuario por su nombre de usuario o DNI
    public function getUserByUsernameOrDni($username, $dni) {
        // Crear la consulta SQL
        $query = "SELECT * FROM " . $this->table_name . " WHERE Usuari = :username OR DNI = :dni LIMIT 1";
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);

        // Vincular los parámetros
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':dni', $dni);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el usuario
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    }
}
?>
