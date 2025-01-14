<?php
// Cambié la ruta para que sea la correcta según la ubicación real del archivo
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php'; 
 // Ajusta la ruta si es necesario
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 
class ReservaController {

    private $reservaModel;

    public function __construct() {
        // Inicializa el modelo de reservas
        $this->reservaModel = new ReservaModel();
    }
    public function obtenerPaises() {
        $paises = $this->reservaModel->obtenerPaises(); // Llamar al modelo para obtener los países
        return $paises;
    }
    // Método para crear una reserva
    public function crearReserva() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recuperar los datos del formulario
            $habitacionId = $_POST['habitacionId'];
            $clienteId = $_POST['clienteId'];
            $hotelId = $_POST['hotelId'];
            $checkin = $_POST['checkin'];
            $checkout = $_POST['checkout'];
            $guests = $_POST['guests'];
            $paisId = $_POST['paisId'];

            // Calcular el precio total (Este es un ejemplo, dependiendo de tu lógica de negocio)
            $habitacion = $this->reservaModel->obtenerHabitacionPorId($habitacionId);
            $precioTotal = $habitacion['Precio'] * $guests;

            // Crear la reserva
            $reservaId = $this->reservaModel->agregarReserva($clienteId, $habitacionId, $hotelId, $checkin, $checkout, $guests, $precioTotal);

            if ($reservaId) {
                // Redirigir a la página de confirmación o donde se requiera
                header("Location: ../../vista/confirmacion_reserva.php?id=" . $reservaId);
                exit;
            } else {
                // Mostrar un mensaje de error si no se puede crear la reserva
                echo "Hubo un error al crear la reserva.";
            }
        }
    }
}

// Instanciamos el controlador y ejecutamos la acción
$reservaController = new ReservaController();
$reservaController->crearReserva();
?>
