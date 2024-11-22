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
        // Cambia la tabla 'cliente' a 'Clients'
        $sql = "INSERT INTO Clients (Nom, Cognom, DNI, CorreuElectronic, Telefon, Usuari, Password, Ciudad, CodigoPostal)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        // Encriptamos la contraseña y asignamos a una variable para evitar el "Notice"
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        // Bind de parámetros
        $stmt->bind_param("sssssssss", 
            $this->nom, 
            $this->cognom, 
            $this->dni, 
            $this->correuElectronic, 
            $this->telefon, 
            $this->usuari, 
            $hashedPassword, // Usamos la variable $hashedPassword
            $this->ciudad, 
            $this->codigoPostal
        );

        return $stmt->execute(); // Devuelve true si la ejecución es exitosa
    }
}
?>
