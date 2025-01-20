<?php
// Asegúrate de que la ruta del modelo es correcta
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../modelo/hotel/hotelModel.php';
require_once __DIR__ . '/../../config/Database.php'; 

class ReservaController {
    
    private $reservaModel;
    private $hotelModel;

    public function __construct() {
        // Crear la conexión a la base de datos
        $database = new Database();
        $db = $database->getConnection();

        // Crear una instancia del modelo
        $this->reservaModel = new ReservaModel($db);
        $this->hotelModel = new HotelModel($db);
    }

    public function obtenerPaises() {
        // Llamamos al método obtenerPaises() del modelo
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

    // Verificar si una reserva ya existe
    public function verificarReservaExistente($idReserva) {
        $existe = $this->reservaModel->reservaExistente($idReserva);
        
        if ($existe > 0) {
            echo "La reserva ya existe.";
        } else {
            echo "La reserva no existe.";
        }
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
        return $this->hotelModel->obtenerHotelPorId($hotelId);
    }

    // Obtener detalles de la habitación por su ID
    public function obtenerDetallesHabitacion($habitacionId) {
        return $this->reservaModel->obtenerHabitacionPorId($habitacionId);
    }

    // Obtener métodos de pago disponibles
    public function obtenerMetodosPagoDisponibles() {
        return $this->reservaModel->obtenerMetodosPagoActivos();
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
}
?>
