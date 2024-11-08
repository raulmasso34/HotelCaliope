<?php
class Usuario {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection; // Almacenar la conexión a la base de datos
    }

    // Método para obtener un usuario por su nombre de usuario o DNI
    public function getUserByUsername($username, $dni) {
        $sql = "SELECT ID_Usuari, Username, Password, DNI FROM Clients WHERE BINARY Username = ? AND DNI = ?";
        $stmt = $this->con->prepare($sql);

        $stmt->bind_param("si", $username, $dni);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>
