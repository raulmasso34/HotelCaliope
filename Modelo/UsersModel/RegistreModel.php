<?php
require_once __DIR__ . '/../../Configuracion/Database.php';


class RegistreModel {
    private $conn;
    public $nom;
    public $cognom;
    public $dni;
    public $correuElectronic;
    public $telefon;
    public $usuari;
    public $password;
    public $ciudad;
    public $codigoPostal;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {
        // Usamos los placeholders ? para mysqli
        $sql = "INSERT INTO Clients (Nom, Cognom, DNI, CorreuElectronic, Telefon, Usuari, Password, Ciudad, CodigoPostal)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        // Bind de parámetros
        $stmt->bind_param("sssssssss", 
            $this->nom, 
            $this->cognom, 
            $this->dni, 
            $this->correuElectronic, 
            $this->telefon, 
            $this->usuari, 
            password_hash($this->password, PASSWORD_BCRYPT), // Encriptamos la contraseña
            $this->ciudad, 
            $this->codigoPostal
        );

        return $stmt->execute(); // Devuelve true si la ejecución es exitosa
    }
}
?>
