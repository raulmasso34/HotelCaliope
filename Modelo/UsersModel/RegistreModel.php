<?php
// /models/RegistreModel.php
require_once __DIR__ . '/../config/database.php';

class RegistreModel {
    private $conn;
    private $table_name = "cliente";

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
        $query = "INSERT INTO " . $this->table_name . " (Nom, Cognom, DNI, CorreuElectronic, Telefon, Usuari, Password, Ciudad, CodigoPostal)
                  VALUES (:nom, :cognom, :dni, :correuElectronic, :telefon, :usuari, :password, :ciudad, :codigoPostal)";
        
        $stmt = $this->conn->prepare($query);

        // Hash de la contraseña
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":cognom", $this->cognom);
        $stmt->bindParam(":dni", $this->dni);
        $stmt->bindParam(":correuElectronic", $this->correuElectronic);
        $stmt->bindParam(":telefon", $this->telefon);
        $stmt->bindParam(":usuari", $this->usuari);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":ciudad", $this->ciudad);
        $stmt->bindParam(":codigoPostal", $this->codigoPostal);

        return $stmt->execute();
    }
}
?>
