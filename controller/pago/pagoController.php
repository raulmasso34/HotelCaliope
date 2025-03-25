<?php
    
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../modelo/pago/pagoModel.php';
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';

class PagoController {
    
    private $db;
    private $pagoModel;
    private $reservaModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pagoModel = new PagoModel($this->db);
        $this->reservaModel = new ReservaModel($this->db);
    }
    
    
    
    public function procesarPagoReserva($datos) {
        try {
            // ✅ 1. Validar datos obligatorios
            $camposObligatorios = ['clienteId', 'habitacionId', 'hotelId', 'checkin', 'checkout', 'guests', 'paisId', 'metodoPagoId'];
            foreach ($camposObligatorios as $campo) {
                if (empty($datos[$campo])) {
                    throw new Exception("Error: El campo '$campo' es obligatorio.");
                }
            }
            
            // ✅ 2. Validar el método de pago
            if (!is_numeric($datos['metodoPagoId'])) {
                throw new Exception("Error: Método de pago inválido.");
            }
            
            // ✅ 3. Calcular el precio total incluyendo servicios y actividades
            $precioTotalServicios = 0;
            if (!empty($datos['servicios']) && is_array($datos['servicios'])) {
                foreach ($datos['servicios'] as $precio) {
                    $precioTotalServicios += floatval($precio);
                }
            }
            
            $datos['precioServicio'] = $precioTotalServicios;
            $datos['precioTotal'] = floatval($datos['precioHabitacion']) + $precioTotalServicios;
            
            // ✅ 4. Insertar la reserva en la base de datos
            $idReserva = $this->reservaModel->insertarReserva(
                $datos['clienteId'],
                $datos['habitacionId'],
                $datos['hotelId'],
                $datos['tarifaId'] ?? null,
                $datos['precioHabitacion'],
                $datos['precioActividad'] ?? 0,
                $datos['precioTarifa'] ?? 0,
                $datos['precioServicio'],
                $datos['precioTotal'],
                $datos['checkin'],
                $datos['checkout'],
                $datos['guests'],
                $datos['paisId']
            );
            
            if (!$idReserva) {
                throw new Exception("Error: No se pudo crear la reserva en la base de datos.");
            }
            
            // ✅ 5. Asociar servicios y actividades
            if (!empty($datos['servicios'])) {
                foreach ($datos['servicios'] as $idServicio => $precio) {
                    if (!$this->reservaModel->asociarServicioAReserva($idReserva, $idServicio)) {
                        throw new Exception("Error al asociar el servicio ID: $idServicio.");
                    }
                }
            }
            
            if (!empty($datos['actividades'])) {
                foreach ($datos['actividades'] as $idActividad => $precio) {
                    $this->reservaModel->asociarActividadAReserva($idReserva, $idActividad, $precio);
                }
            }
            
            // ✅ 6. Procesar el pago
            $pagoExitoso = $this->pagoModel->procesarPago(
                $datos['hotelId'],
                $datos['clienteId'],
                $idReserva,
                "Tarjeta de Crédito",
                date("Y-m-d H:i:s"),
                intval($datos['metodoPagoId'])
            );
            
            if (!$pagoExitoso) {
                throw new Exception("Error al procesar el pago.");
            }
            
            // ✅ 7. Actualizar el estado de la reserva
            $this->pagoModel->actualizarEstadoReserva($idReserva, "Pagado");
            
            return ['success' => true, 'message' => 'Pago y reserva procesados con éxito.', 'idReserva' => $idReserva];
        } catch (Exception $e) {
            error_log("Error en PagoController: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pagoController = new PagoController();
    
    if (!isset($_SESSION['Reservas'])) {
        die(json_encode(['success' => false, 'message' => 'Sesión expirada o datos no encontrados.']));
    }
    
    $reservaSession = $_SESSION['Reservas'];
    
    $datosReserva = array_merge($reservaSession, $_POST);
    
    $resultado = $pagoController->procesarPagoReserva($datosReserva);
    
    if ($resultado['success']) {
        $_SESSION['idReserva'] = $resultado['idReserva'];
        header("Location: http://localhost/HotelCaliope2/vista/reserva_confirmada.php");
        exit();
    } else {
        $_SESSION['error_pago'] = $resultado['message'];
        header("Location: http://localhost/HotelCaliope2/vista/pagos.php");
        exit();
    }
}