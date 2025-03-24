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

            
            // ✅ 1. Validar los datos obligatorios
            if (empty($datos['clienteId']) || empty($datos['habitacionId']) || empty($datos['hotelId']) || empty($datos['checkin']) || empty($datos['checkout']) || empty($datos['guests']) || empty($datos['paisId'])) {
                throw new Exception("Error: Datos de la reserva incompletos.");
            }
    
            // ✅ 2. Validar el método de pago
            if (empty($datos['metodoPagoId']) || !is_numeric($datos['metodoPagoId'])) {
                throw new Exception("Error: Método de pago inválido.");
            }
    
            // ✅ 3. Calcular precio de los servicios
            $precioTotalServicios = 0;
            if (!empty($datos['servicios']) && is_array($datos['servicios'])) {
                foreach ($datos['servicios'] as $idServicio => $precio) {
                    $precioTotalServicios += floatval($precio);
                }
            }
    
            // ✅ 4. Recalcular el precio total
            $datos['precioServicio'] = $precioTotalServicios;
            $datos['precioTotal'] = floatval($datos['precioHabitacion']) + $precioTotalServicios;
    
            // ✅ Verificar cálculo antes de seguir
         
    
            // ✅ 5. Insertar la reserva en la base de datos
            $idReserva = $this->reservaModel->insertarReserva(
                $datos['clienteId'],
                $datos['habitacionId'],
                $datos['hotelId'],
                !empty($datos['tarifaId']) ? $datos['tarifaId'] : null,
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
    
          
    
            // ✅ 6. Insertar servicios en la tabla intermedia
            if (!empty($datos['servicios']) && is_array($datos['servicios'])) {
                foreach ($datos['servicios'] as $idServicio => $precio) {
                    if (!$this->reservaModel->asociarServicioAReserva($idReserva, $idServicio)) {
                        throw new Exception("Error al asociar el servicio ID: $idServicio.");
                    }
                }
            }
            
            // ✅ Insertar actividades en la tabla intermedia
            if (!empty($datos['actividades']) && is_array($datos['actividades'])) {
                foreach ($datos['actividades'] as $idActividad => $precio) {
                    $this->reservaModel->asociarActividadAReserva($idReserva, $idActividad, $precio);
                }
            }

    
            // ✅ 7. Procesar el pago
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
    
            // ✅ 8. Actualizar el estado de la reserva
            $this->pagoModel->actualizarEstadoReserva($idReserva, "Pagado");
    
            return ['success' => true, 'message' => 'Pago y reserva procesados con éxito.'];
        } catch (Exception $e) {
            error_log("Error en PagoController: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
}
// ✅ Capturar datos de la SESIÓN y POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pagoController = new PagoController();

    // 1. Obtener datos de la sesión
    if (!isset($_SESSION['Reservas'])) {
        die(json_encode(['success' => false, 'message' => 'Sesión expirada o datos no encontrados.']));
    }
    $reservaSession = $_SESSION['Reservas'];

    // 2. Construir $datosReserva combinando sesión y POST
    $datosReserva = [
        'clienteId'        => $reservaSession['clienteId'] ?? null,
        'habitacionId'     => $reservaSession['habitacionId'] ?? null,
        'hotelId'          => $reservaSession['hotelId'] ?? null,
        'checkin'          => $reservaSession['checkin'] ?? null,
        'checkout'         => $reservaSession['checkout'] ?? null,
        'guests'           => $reservaSession['guests'] ?? null,
        'paisId'           => $reservaSession['paisId'] ?? null,
        'metodoPagoId'     => $reservaSession['metodoPagoId'] ?? null,
        'precioHabitacion' => $reservaSession['precioHabitacion'] ?? 0,
        'servicios'        => [],
        'actividades'      => []
    ];

    // 3. Procesar servicios y actividades (con precios)
    if (!empty($_SESSION['Reservas']['servicios'])) {
        foreach ($_SESSION['Reservas']['servicios'] as $id => $servicioStr) {
            list($idServicio, $precio) = explode('|', $servicioStr);
            $datosReserva['servicios'][$idServicio] = floatval($precio);
        }
    }

    if (!empty($_SESSION['Reservas']['actividades'])) {
        foreach ($_SESSION['Reservas']['actividades'] as $id => $actividadStr) {
            list($idActividad, $precio) = explode('|', $actividadStr);
            $datosReserva['actividades'][$idActividad] = floatval($precio);
        }
    }

    // 4. Validar datos críticos
    $camposRequeridos = ['clienteId', 'habitacionId', 'hotelId', 'checkin', 'checkout', 'guests', 'paisId'];
    foreach ($camposRequeridos as $campo) {
        if (empty($datosReserva[$campo])) {
            die(json_encode(['success' => false, 'message' => "Campo requerido faltante: $campo"]));
        }
    }

    // 5. Ejecutar el proceso
    $resultado = $pagoController->procesarPagoReserva($datosReserva);

    // 6. Manejar respuesta
    // Dentro de tu controlador (pagoController.php)
    if ($resultado['success']) {
        unset($_SESSION['Reservas']);
        header("Location: ../../vista/reserva_confirmada.php");
        exit();
    } else {
        // Guardar el error en sesión y recargar pagos.php
        $_SESSION['error_pago'] = $resultado['message'];
        header("Location: http://localhost/HotelCaliope/HotelCaliope-2/vista/pagos.php");
        exit();
    }
}