<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/var/www/html/MCV/config/Database.php';

class Usuario {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection; // Almacenar la conexión a la base de datos
    }

    public function getUserByUsername($username) {
        $sql = "SELECT ID_Usuari, Username, Password, role FROM Usuaris WHERE BINARY Username = ?";
        $stmt = $this->con->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->con->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Método para comprobar si un DNI ya está registrado
    public function checkDNI($dni) {
        $sql = "SELECT * FROM Usuaris WHERE DNI = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Método para comprobar si un nombre de usuario ya está en uso
    public function checkUsername($username) {
        $sql = "SELECT * FROM Usuaris WHERE Username = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Método para registrar un nuevo usuario
    public function registerUser($username, $hashed_password, $role, $id_jugador, $id_entrenador, $dni) {
        $sql = "INSERT INTO Usuaris (Username, `Password`, `role`, ID_Jugadors, ID_Entrenador, DNI) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ssssis", $username, $hashed_password, $role, $id_jugador, $id_entrenador, $dni);

        if ($stmt->execute()) {
            $stmt->close();
            return true;  // Registro exitoso
        } else {
            echo "Error en la consulta SQL: " . $stmt->error;
            $stmt->close();
            return false;  // Error en el registro
        }
    }

    // Método para actualizar el perfil del usuario
    public function updateProfile($userId, $newUsername, $newPassword) {
        if (empty($newPassword)) {
            // Si no hay nueva contraseña, solo actualiza el nombre de usuario
            $sql = "UPDATE Usuaris SET Username = ? WHERE ID_Usuari = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("si", $newUsername, $userId); // "si" para un string y un entero
        } else {
            // Si hay nueva contraseña, actualiza nombre de usuario y contraseña
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE Usuaris SET Username = ?, `Password` = ? WHERE ID_Usuari = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ssi", $newUsername, $hashed_password, $userId); // "ssi" para dos strings y un entero
        }

        // Ejecutar la consulta
        $result = $stmt->execute();
        $stmt->close(); // Cierra la declaración después de ejecutarla
        return $result; // Devuelve el resultado de la ejecución
    }

    // Método para obtener un usuario por su ID
    public function getUserById($userId) {
        $sql = "SELECT ID_Usuari, Username, role FROM Usuaris WHERE ID_Usuari = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }

        $stmt->close(); // Este código no se ejecutará porque `return` termina la función
    }
}
?>
