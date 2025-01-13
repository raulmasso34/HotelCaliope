<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';

class PaisController {
    private $paisModel;

    public function __construct() {
        $db = new Database();
        $this->paisModel = new PaisModel($db->getConnection());
    }

    // Función para obtener todos los países y pasarlos a la vista
    public function mostrarPaises() {
        $paises = $this->paisModel->obtenerPaises();

        // Si hay países disponibles, los mostramos en la vista
        if (!empty($paises)) {
            return $paises;
        } else {
            echo "No hay países disponibles.";
            return [];
        }
    }
}

// Uso del controlador para obtener países
$paisController = new PaisController();
$paises = $paisController->mostrarPaises();
?>
