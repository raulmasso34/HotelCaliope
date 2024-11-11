<?php
class LoginModel {
    private $con;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($dbConnection) {
        $this->con = $dbConnection; // Almacenar la conexión a la base de datos
    }

    // Método para obtener un usuario por su nombre de usuario o DNI
    public function getUserByUsername($username) {
        // Query SQL para obtener el usuario
        $sql = "SELECT Id_Client, Usuari, Password FROM Clients WHERE Usuari = ?";
        $stmt = $this->con->prepare($sql);
        
        // Vincular parámetros y ejecutar la consulta
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si hay resultados, devolverlos
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retorna los datos del usuario si existe
        } else {
            return null; // Usuario no encontrado
        }
    }

    // Método para verificar la contraseña
    public function verifyPassword($hashedPassword, $password) {
        return password_verify($password, $hashedPassword); // Compara la contraseña cifrada
    }
}
?>
