<?php
class Usuario {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection; // Almacenar la conexión a la base de datos
    }

    // Método para obtener un usuario por su nombre de usuario o DNI
    public function getUserByUsername($username, $dni, $password) {
        $sql = "SELECT Id_Client, Usuari, Password, DNI FROM Clients WHERE Usuari = ? AND DNI = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $username, $dni);  // Los dos parámetros son strings (Usuario y DNI)
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verificar la contraseña con password_verify()
            if (password_verify($password, $user['Password'])) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
}
?>
