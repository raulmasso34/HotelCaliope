<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../modelo/actividad/actividadModel.php';
require_once __DIR__ . '/../../modelo/metodopago/metodoPagoModel.php'; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ReservaController {

    private $reservaModel;
    private $hotelModel;
    private $actividadModel;
    private $metodoPagoModel;

    public function __construct() {
        // Crear una instancia de la base de datos y obtener la conexión
        $database = new Database();
        $db = $database->getConnection();

        // Pasar la conexión a cada modelo
        $this->reservaModel = new ReservaModel($db);
        $this->hotelModel = new HotelModel($db);  // Pasamos $db a HotelModel
        $this->actividadModel = new ActividadModel($db);
        $this->metodoPagoModel = new MetodoPagoModel($db);
    }

    // Método para mostrar la página de confirmación de reserva
    public function mostrarConfirmacionReserva($reservaId) {
        if (empty($reservaId)) {
            echo "Error: No se ha proporcionado el ID de la reserva.";
            exit;
        }

        // Obtener los detalles de la reserva
        $reserva = $this->reservaModel->obtenerReservaPorId($reservaId);
        if (!$reserva) {
            echo "Error: No se encontró la reserva.";
            exit;
        }

        // Obtener detalles del hotel
        $hotel = $this->hotelModel->obtenerHotelPorId($reserva['Id_Hotel']);
        if (!$hotel) {
            echo "Error: No se encontró el hotel relacionado con la reserva.";
            exit;
        }

        // Obtener actividades disponibles en ese hotel
        $actividades = $this->actividadModel->obtenerActividadesPorHotel($reserva['Id_Hotel']);
        if (!$actividades) {
            echo "Error: No se encontraron actividades para este hotel.";
            exit;
        }

        // Obtener los métodos de pago registrados para el cliente
        $metodosPago = $this->metodoPagoModel->obtenerMetodosPagoPorCliente($reserva['Id_Cliente']);
        if (!$metodosPago) {
            echo "Error: No se encontraron métodos de pago para este cliente.";
            exit;
        }

        // Incluir la vista de confirmación de reserva
        include_once __DIR__ . '/../../vista/confirmacion_reserva.php';
    }

    // Método para procesar la reserva y el pago
    public function procesarReservaPago() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validación de existencia de los datos antes de usarlos
            $reservaId = isset($_POST['reservaId']) ? $_POST['reservaId'] : null;
            $metodoPagoId = isset($_POST['metodo_pago']) ? $_POST['metodo_pago'] : null;
            $actividadId = isset($_POST['actividad']) ? $_POST['actividad'] : null;
    
            // Verificar si los datos están completos
            if (!$reservaId || !$metodoPagoId || !$actividadId) {
                echo "Faltan algunos datos necesarios. Por favor, completa todos los campos.";
                return;
            }

            // Procesar el pago y actualizar la reserva
            $exito = $this->reservaModel->procesarPago($reservaId, $metodoPagoId, $actividadId);
            if ($exito) {
                echo "Reserva confirmada y pagada exitosamente.";
            } else {
                echo "Error al procesar el pago. Intenta nuevamente.";
            }
        }
    }

    // Método para obtener los países
    public function obtenerPaises() {
        return $this->reservaModel->obtenerPaises();  // Llamamos al modelo de reservas para obtener los países
    }
}

// Instanciamos el controlador y ejecutamos la acción
$reservaController = new ReservaController();

// Si la acción es mostrar confirmación, pasamos el ID de la reserva
if (isset($_GET['id'])) {
    $reservaController->mostrarConfirmacionReserva($_GET['id']);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesar la reserva y el pago si es POST
    $reservaController->procesarReservaPago();
} else {
    // Si se llama a obtenerPaises, mostramos los países
    $paises = $reservaController->obtenerPaises();
    // Aquí puedes incluir la vista para mostrar los países o simplemente mostrarlos
}
?>
