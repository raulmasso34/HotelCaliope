<?php
require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta sea correcta

class LoginModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;  // Establecer la conexión a la base de datos
    }

    public function authenticate($username, $password, $dni) {
        // Mostrar los valores recibidos para asegurarnos que son correctos
        echo "Username: " . $username . "<br>";
        echo "DNI: " . $dni . "<br>";
        echo "Password: " . $password . "<br>";

        // Consulta para obtener el usuario por su nombre de usuario y DNI
        $sql = "SELECT * FROM Clients WHERE Usuari = ? AND DNI = ?";  // Se añade la verificación del DNI

        // Preparar la consulta
        if ($stmt = $this->conn->prepare($sql)) {
            // Asociar los parámetros de la consulta
            $stmt->bind_param("ss", $username, $dni);  // Ambos parámetros son cadenas (s = string)
            $stmt->execute();  // Ejecutar la consulta
    
            // Obtener los resultados
            $result = $stmt->get_result();
    
            // Si encontramos el usuario
            if ($user = $result->fetch_assoc()) {
                var_dump($user);  // Para ver los datos recuperados de la base de datos

                // Verificar la contraseña usando password_verify
                if (password_verify($password, $user['Password'])) {
                    return $user;  // Usuario autenticado correctamente
                } else {
                    echo "Contraseña incorrecta. El hash guardado es: " . $user['Password'];  // Mostrar el hash guardado para depuración
                }
            } else {
                echo "Usuario no encontrado.";  // Mostrar mensaje si el usuario no existe
            }
        } else {
            echo "Error al preparar la consulta SQL.";  // Si la preparación de la consulta falla
        }
    
        return false;  // Si no se encontró el usuario, el DNI no coincide o la contraseña no es válida
    }
}
?>
