<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../Modelo/UsersModel/RegistreModel.php';

echo "Llegué al controlador correctamente.";

class RegistreController {
    private $db;
    private $registreModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->registreModel = new RegistreModel($this->db);
    }

    public function registrarUsuario($data) {
        // Validación de los datos
        if (empty($data['Usuari']) || empty($data['Password']) || empty($data['CorreuElectronic'])) {
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

// Controlador invocado al recibir una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'Nom' => $_POST['Nom'] ?? '',
        'Cognom' => $_POST['Cognom'] ?? '',
        'DNI' => $_POST['DNI'] ?? '',
        'CorreuElectronic' => $_POST['CorreuElectronic'] ?? '',
        'Telefon' => $_POST['Telefon'] ?? '',
        'Usuari' => $_POST['Usuari'] ?? '',
        'Password' => $_POST['Password'] ?? '',
        'Ciudad' => $_POST['Ciudad'] ?? '',
        'CodigoPostal' => $_POST['CodigoPostal'] ?? ''
    ];

    $controller = new RegistreController();
    $resultado = $controller->registrarUsuario($data);

    echo $resultado; // Muestra el resultado del registro
}
?>
