

<?php
class LoginModel {
    private $con;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($dbConnection) {
        $this->con = $dbConnection; // Almacenar la conexión a la base de datos
    }

    // Método para obtener un usuario por su nombre de usuario o DNI
    public function getUserByUsername($username, $password, $dni) {
        // Query SQL para obtener el usuario
        $sql = "SELECT Id_Client, Usuari, Password, DNI FROM Clients WHERE Usuari = ? AND DNI = ?";
        $stmt = $this->con->prepare($sql);
        
        // Vincular parámetros y ejecutar la consulta
        $stmt->bind_param("ss", $username, $dni);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si hay resultados, verificar las credenciales
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Compara la contraseña
            if ($user['Password'] === $password) {
                return $user; // Retorna los datos del usuario si la contraseña es correcta
            } else {
                return null; // Contraseña incorrecta
            }
        } else {
            return null; // Usuario no encontrado
        }
    }
}
?>
