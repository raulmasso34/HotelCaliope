<?php
class Database {
    private $servername = "localhost"; // Servidor MySQL
    private $username = "root"; // Nombre de usuario de la base de datos
   private $password = "P@ssw0rd";

   //private $password = "password";  // Cambia esto según tu configuración
    private $dbname = "HotelCaliope"; // Cambia esto según tu base de datos
    public $connection;

    public function getConnection() {
        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        // Verificar conexión
        if ($this->connection->connect_error) {
            die("Conexión fallida: " . $this->connection->connect_error);
        }
        
        return $this->connection;
    }

    // Método para cerrar la conexión
    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close(); // Cierra la conexión
        }
    }
}
?>
