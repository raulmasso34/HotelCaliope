<?php
// /controllers/RegistreController.php
require_once __DIR__ . '/../models/RegistreModel.php';

class RegistreController {
    private $db;
    private $registreModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->registreModel = new RegistreModel($this->db);
    }

    public function registrarUsuario($data) {
        // Validación de los datos (puedes añadir más validaciones)
        if (empty($data['Usuari']) || empty($data['password']) || empty($data['correuElectronic'])) {
            return "Todos los campos son obligatorios.";
        }

        // Asignación de datos
        $this->registreModel->nom = $data['Nom'];
        $this->registreModel->cognom = $data['Cognom'];
        $this->registreModel->dni = $data['DNI'];
        $this->registreModel->correuElectronic = $data['CorreuElectronic'];
        $this->registreModel->telefon = $data['Telefon'];
        $this->registreModel->usuari = $data['Usuari'];
        $this->registreModel->password = $data['Password'];
        $this->registreModel->ciudad = $data['Ciudad'];
        $this->registreModel->codigoPostal = $data['CodigoPostal'];

        if ($this->registreModel->registrar()) {
            return "Usuario registrado con éxito.";
        } else {
            return "Error al registrar el usuario.";
        }
    }
}
?>
