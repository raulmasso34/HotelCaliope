<?php
class Client {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection; // Almacenar la conexión a la base de datos
    }

    // Método para obtener un cliente por su ID
    public function getClientById($idClient) {
        $sql = "SELECT Id_Client, Nom, Cognom, DNI, CorreuElectronic, Telefon, Usuari, Password, Id_Pais FROM Clients WHERE Id_Client = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $idClient);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    // Método para registrar un nuevo cliente
    public function registerClient($nom, $cognom, $dni, $correuElectronic, $telefon, $usuari, $hashed_password, $idPais) {
        $sql = "INSERT INTO Clients (Nom, Cognom, DNI, CorreuElectronic, Telefon, Usuari, Password, Id_Pais) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sssssissi", $nom, $cognom, $dni, $correuElectronic, $telefon, $usuari, $hashed_password, $idPais);

        if ($stmt->execute()) {
            return true; // Registro exitoso
        } else {
            throw new Exception("Error en la consulta SQL: " . $stmt->error);
        }
    }

    // Método para actualizar el perfil del cliente
    public function updateClient($idClient, $nom, $cognom, $dni, $correuElectronic, $telefon, $usuari, $newPassword = null) {
        if ($newPassword) {
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE Clients SET Nom = ?, Cognom = ?, DNI = ?, CorreuElectronic = ?, Telefon = ?, Usuari = ?, Password = ? WHERE Id_Client = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sssssisi", $nom, $cognom, $dni, $correuElectronic, $telefon, $usuari, $hashed_password, $idClient);
        } else {
            $sql = "UPDATE Clients SET Nom = ?, Cognom = ?, DNI = ?, CorreuElectronic = ?, Telefon = ?, Usuari = ? WHERE Id_Client = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ssssssi", $nom, $cognom, $dni, $correuElectronic, $telefon, $usuari, $idClient);
        }

        return $stmt->execute(); // Devuelve el resultado de la ejecución
    }

    // Método para eliminar un cliente
    public function deleteClient($idClient) {
        $sql = "DELETE FROM Clients WHERE Id_Client = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $idClient);
        return $stmt->execute(); // Devuelve el resultado de la ejecución
    }

    // Método para comprobar si un DNI ya está registrado
    public function checkDNI($dni) {
        $sql = "SELECT * FROM Clients WHERE DNI = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0; // Retorna verdadero si el DNI ya existe
    }

    // Método para comprobar si un nombre de usuario ya está en uso
    public function checkUsername($usuari) {
        $sql = "SELECT * FROM Clients WHERE Usuari = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $usuari);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0; // Retorna verdadero si el nombre de usuario ya existe
    }
}
?>
