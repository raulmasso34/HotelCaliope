<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../modelo/pais/paisModel.php';
require_once __DIR__ . '/../../config/Database.php'; 

class ReservaController {

    private $reservaModel;
    private $hotelModel;
    private $paisModel;


    public function __construct() {
        // Crear la conexión a la base de datos
        $database = new Database();
        $db = $database->getConnection();

        // Crear una instancia del modelo
        $this->reservaModel = new ReservaModel($db);
        $this->hotelModel = new HotelModel($db);
        $this->paisModel = new PaisesModel($db);
    }

    public function obtenerPaises() {
        return $this->reservaModel->obtenerPaises();
    }

    public function obtenerHotelesPorPais($location) {
        return $this->hotelModel->obtenerHotelesPorPais($location);
    }

    // Crear una nueva reserva
    public function crearReserva($hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId, $habitacionId = null, $tarifaId = null, $precioHabitacion = null, $precioActividad = null, $precioTarifa = null, $precioTotal = null) {
        $reservaId = $this->reservaModel->insertarReserva($hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId, $habitacionId, $tarifaId, $precioHabitacion, $precioActividad, $precioTarifa, $precioTotal);

        if ($reservaId) {
            echo "Reserva creada con éxito. ID: " . $reservaId;
        } else {
            echo "Error al crear la reserva.";
        }
    }

    // Obtener una reserva por su ID
    public function obtenerReserva($reservaId) {
        $reserva = $this->reservaModel->obtenerReservaPorId($reservaId);

        if ($reserva) {
            echo "Reserva encontrada: " . json_encode($reserva);
        } else {
            echo "Reserva no encontrada.";
        }
    }

    // Procesar un pago
    public function procesarPago($reservaId, $metodoPagoId, $actividadId, $precioHabitacion, $precioActividad, $precioTotal) {
        $resultadoPago = $this->reservaModel->procesarPago($reservaId, $metodoPagoId, $actividadId, $precioHabitacion, $precioActividad, $precioTotal);

        if ($resultadoPago) {
            echo "Pago procesado con éxito.";
        } else {
            echo "Error al procesar el pago.";
        }
    }

    // Obtener habitaciones por hotel
    public function obtenerHabitacionesPorHotel($hotelId) {
        // Aquí estamos delegando la responsabilidad de obtener las habitaciones al modelo
        return $this->hotelModel->obtenerHabitaciones($hotelId);
    }
    
    // Verificar si una reserva ya existe
    public function verificarReservaExistente($idReserva) {
        $existe = $this->reservaModel->reservaExistente($idReserva);

        if ($existe > 0) {
            echo "La reserva ya existe.";
        } else {
            echo "La reserva no existe.";
        }
    }
    public function obtenerActividadesPorHotel($hotelId) {
        // Llamamos al método del modelo para obtener las actividades
        return $this->reservaModel->obtenerActividades($hotelId);
    }

    // Obtener el precio de una habitación
    public function obtenerPrecioHabitacion($habitacionId) {
        $precio = $this->reservaModel->obtenerPrecioHabitacion($habitacionId);

        if ($precio > 0) {
            echo "Precio de la habitación: $" . $precio;
        } else {
            echo "Error al obtener el precio de la habitación.";
        }
    }

    // Obtener actividades disponibles para un hotel
    public function obtenerActividades($idHotel) {
        $actividades = $this->reservaModel->obtenerActividadesPorHotel($idHotel);

        if ($actividades) {
            echo "Actividades disponibles: " . json_encode($actividades);
        } else {
            echo "No hay actividades disponibles.";
        }
    }

    public function showReservationDetails($reservationId) {
        $reservation = $this->reservaModel->getReservationDetails($reservationId);
    
        if ($reservation) {
            // Extraer las variables del array y pasarla a la vista
            extract($reservation);
            include '../vista/info_reserva.php';  // Usa la ruta correcta
        } else {
            echo "No se ha encontrado la reserva.";
        }
    }
    

    // Obtener métodos de pago de un cliente
    public function obtenerMetodosPago($idCliente) {
        $metodosPago = $this->reservaModel->obtenerMetodosPagoPorCliente($idCliente);

        if ($metodosPago) {
            echo "Métodos de pago disponibles: " . json_encode($metodosPago);
        } else {
            echo "No hay métodos de pago disponibles para este cliente.";
        }
    }

    // Obtener detalles del hotel por su ID
    public function obtenerDetallesHotel($hotelId) {
        // Usar el método obtenerDetallesHotel del modelo HotelModel para obtener todos los detalles
        $hotelDetails = $this->hotelModel->obtenerDetallesHotel($hotelId);
        
        if ($hotelDetails) {
            return $hotelDetails; // Devuelve todos los detalles del hotel
        } else {
            return null; // Si no se encuentra el hotel
        }
    }
    public function obtenerHabitaciones() {
        return $this-> reservaModel->obtenerHabitaciones();
    }
    
    // Obtener detalles de la habitación por su ID
    public function obtenerDetallesHabitacion($habitacionId) {
        return $this->reservaModel->obtenerHabitacionPorId($habitacionId);
    }

    // Obtener métodos de pago disponibles
    public function obtenerMetodosPagoDisponibles() {
        return $this->reservaModel->obtenerMetodosPagoDisponibles();
    }

    // Consolidar detalles de la reserva para mostrar la confirmación
    public function obtenerDetallesReserva($hotelId, $habitacionId) {
        $detallesHotel = $this->obtenerDetallesHotel($hotelId);
        $detallesHabitacion = $this->obtenerDetallesHabitacion($habitacionId);
        $metodosPago = $this->obtenerMetodosPagoDisponibles();

        return [
            'hotel' => $detallesHotel,
            'habitacion' => $detallesHabitacion,
            'metodosPago' => $metodosPago
        ];
    }

    public function obtenerNombrePais($paisId) {
        return $this->paisModel->obtenerNombrePais($paisId);
    }
    public function cancelar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservaId'])) {
            $reservaId = (int)$_POST['reservaId'];
            if ($this->reservaModel->cancelarReserva($reservaId)) {
                header("Location: ../vista/Clientes/perfil.php");
                exit; 
            } else {
                echo "Error al cancelar la reserva.";
            }
        }
    }

    
    



   

    
    
}
?>
