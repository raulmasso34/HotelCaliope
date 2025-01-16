<?php
// MetodoPagoController.php

require_once __DIR__ . '/../../modelo/metodopago/metodoPagoModel.php';  // Asegúrate de que la ruta al modelo es correcta
require_once __DIR__ . '/../../config/Database.php';

class MetodoPagoController {

    private $metodoPagoModel;

    public function __construct() {
        // Crear una instancia de la base de datos y obtener la conexión
        $database = new Database();
        $db = $database->getConnection();

        // Pasar la conexión al modelo
        $this->metodoPagoModel = new MetodoPagoModel($db);
    }

    // Método para obtener todos los métodos de pago disponibles
    public function mostrarMetodosPago() {
        // Obtener los métodos de pago activos desde el modelo
        $metodosPago = $this->metodoPagoModel->obtenerMetodosPago();

        // Si no hay métodos de pago, mostrar un mensaje
        if (empty($metodosPago)) {
            echo "No hay métodos de pago disponibles.";
            exit;
        }

        // Incluir la vista para mostrar los métodos de pago
        include_once __DIR__ . '/../../vista/metodopago/lista_metodos_pago.php';  // Ruta a la vista que mostrará los métodos de pago
    }

    // Método para obtener los métodos de pago de un cliente específico
    public function mostrarMetodosPagoPorCliente($clienteId) {
        // Obtener los métodos de pago asociados al cliente desde el modelo
        $metodosPago = $this->metodoPagoModel->obtenerMetodosPagoPorCliente($clienteId);

        // Si no se encuentran métodos de pago para el cliente
        if (empty($metodosPago)) {
            echo "No se encontraron métodos de pago para este cliente.";
            exit;
        }

        // Incluir la vista para mostrar los métodos de pago específicos del cliente
        include_once __DIR__ . '/../../vista/metodopago/lista_metodos_pago_cliente.php';  // Ruta a la vista para mostrar los métodos
    }

    // Método para procesar el pago
    public function procesarPago($reservaId, $metodoPagoId, $precioTotal) {
        // Aquí podrías añadir lógica de procesamiento de pago (validaciones, pago real, etc.)
        // Por ejemplo, verificar el método de pago seleccionado y procesar el pago

        // Verificar si el método de pago existe
        $metodoPago = $this->metodoPagoModel->obtenerMetodoPagoPorId($metodoPagoId);

        if (!$metodoPago) {
            echo "Error: Método de pago no válido.";
            exit;
        }

        // Aquí deberías agregar la lógica de procesamiento real del pago
        // Si el pago es exitoso, proceder con el siguiente paso (guardar la transacción, redirigir al usuario, etc.)

        // Para este ejemplo, simplemente simula que el pago fue exitoso
        echo "Pago procesado exitosamente con el método: " . $metodoPago['Tipo'];
        
        // Luego de procesar el pago, podrías redirigir a una página de confirmación o realizar otros pasos
        header("Location: ../../vista/confirmacion_pago.php?id=$reservaId");
        exit;
    }
}

// Instanciamos el controlador y ejecutamos la acción
$metodoPagoController = new MetodoPagoController();

// Dependiendo de la acción que se requiera
if (isset($_GET['clienteId'])) {
    // Mostrar los métodos de pago de un cliente específico
    $metodoPagoController->mostrarMetodosPagoPorCliente($_GET['clienteId']);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservaId']) && isset($_POST['metodo_pago'])) {
    // Procesar el pago cuando se envíe el formulario
    $reservaId = $_POST['reservaId'];
    $metodoPagoId = $_POST['metodo_pago'];
    $precioTotal = $_POST['precioTotal'];

    // Procesar el pago
    $metodoPagoController->procesarPago($reservaId, $metodoPagoId, $precioTotal);
} else {
    // Si no hay parámetros, mostrar todos los métodos de pago
    $metodoPagoController->mostrarMetodosPago();
}
?>
