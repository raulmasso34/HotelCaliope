<?php
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../config/Database.php';

class ReservaController {
    private $reservaModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->reservaModel = new ReservaModel($db);
    }

    public function obtenerPaises() {
        return $this->reservaModel->obtenerPaises();
        
    }

    public function cancelar($id_reserva) {
        return $this->reservaModel->cancelarReserva($id_reserva);
    }
    
    public function obtenerDetalles($id_reserva) {
        return $this->reservaModel->obtenerDetalleReserva($id_reserva);
    }

   /*  public function verDetalleReserva($id_reserva) {
        $reserva = $this->reservaModel->obtenerReservasPorId($id_reserva);

        if ($reserva) {
            $checkinDate = new DateTime($reserva['Checkin']);
            $checkoutDate = new DateTime($reserva['Checkout']);
            $numero_noches = $checkinDate->diff($checkoutDate)->days;

            $precio_total_calculado = $reserva['Precio_Habitacion'] * $numero_noches * $reserva['Numero_Personas'];

            return [
                'reserva' => $reserva,
                'checkin' => $checkinDate,
                'checkout' => $checkoutDate,
                'noches' => $numero_noches,
                'precio_total' => $precio_total_calculado
            ];
        }

        return null;
    } */

    public function calcularPrecioTotal($precioHabitacion, $checkin, $checkout, $numPersonas) {
        $checkinDate = new DateTime($checkin);
        $checkoutDate = new DateTime($checkout);
        $noches = $checkinDate->diff($checkoutDate)->days;

        return $precioHabitacion * $noches * $numPersonas;
    }

    public function insertarReserva($datos) {
        $idCliente = $datos['idCliente'];
        $idActividad = $datos['idActividad'];
        $idHabitacion = $datos['idHabitacion'];
        $idHotel = $datos['idHotel'];
        $idServicio = $datos['idServicio'];
        $idTarifa = $datos['idTarifa'];
        $precioHabitacion = $datos['precioHabitacion'];
        $precioActividad = $datos['precioActividad'];
        $precioTarifa = $datos['precioTarifa'];
        $precioServicio = $datos['precioServicio'];
        $precioTotal = $datos['precioTotal'];
        $checkin = $datos['checkin'];
        $checkout = $datos['checkout'];
        $numeroPersonas = $datos['numeroPersonas'];
        $idPais = $datos['idPais'];

        return $this->reservaModel->insertarReserva($idCliente, $idActividad, $idHabitacion, $idHotel, $idServicio, $idTarifa, $precioHabitacion, $precioActividad, $precioTarifa, $precioServicio, $precioTotal, $checkin, $checkout, $numeroPersonas, $idPais);
    }

    public function obtenerReservaPorId($idReserva) {
        return $this->reservaModel->obtenerReservaPorId($idReserva);
    }

    public function cancelarReserva($idReserva) {
        return $this->reservaModel->cancelarReserva($idReserva);
    }

    public function procesarPago($reservaId, $metodoPagoId, $actividadId, $precioHabitacion, $precioActividad, $precioTotal) {
        return $this->reservaModel->procesarPago($reservaId, $metodoPagoId, $actividadId, $precioHabitacion, $precioActividad, $precioTotal);
    }

    public function actualizarEstadoReserva($idReserva, $nuevoEstado) {
        return $this->reservaModel->actualizarEstadoReserva($idReserva, $nuevoEstado);
    }
}

?>
