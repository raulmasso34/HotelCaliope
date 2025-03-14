<?php
// Configuración de errores
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
                !empty($datos['actividadId']) ? $datos['actividadId'] : null,
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
    
            if (!$idReserva) {
                throw new Exception("Error al insertar la reserva.");
            }
    
            // ✅ 6. Insertar servicios en la tabla intermedia
            if (!empty($datos['servicios']) && is_array($datos['servicios'])) {
                foreach ($datos['servicios'] as $idServicio => $precio) {
                    $this->reservaModel->asociarServicioAReserva($idReserva, $idServicio);
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

// ✅ Capturar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pagoController = new PagoController();

    $datosReserva = [
        'clienteId' => $_POST['clienteId'] ?? null,
        'actividadId' => $_POST['actividadId'] ?? null,
        'habitacionId' => $_POST['habitacionId'] ?? null,
        'hotelId' => $_POST['hotelId'] ?? null,
        'servicios' => $_POST['servicios'] ?? [],
        'tarifaId' => $_POST['tarifaId'] ?? null,
        'precioHabitacion' => $_POST['precioHabitacion'] ?? 0,
        'precioActividad' => $_POST['precioActividad'] ?? 0,
        'precioTarifa' => $_POST['precioTarifa'] ?? 0,
        'precioServicio' => $_POST['precioServicio'] ?? 0,
        'precioTotal' => $_POST['precioTotal'] ?? 0,
        'checkin' => $_POST['checkin'] ?? null,
        'checkout' => $_POST['checkout'] ?? null,
        'guests' => $_POST['guests'] ?? null,
        'paisId' => $_POST['paisId'] ?? null,
        'metodoPagoId' => isset($_POST['metodoPagoId']) ? intval($_POST['metodoPagoId']) : null
    ];

    // ✅ Ejecutar el proceso de pago y reserva
    $resultado = $pagoController->procesarPagoReserva($datosReserva);

    // ✅ Manejo seguro de errores y redirección
    if ($resultado['success']) {
        header("Location: ../../vista/reserva_confirmada.php");
        
    } else {
        echo "<script>alert('Error: " . $resultado['message'] . "'); window.history.back();</script>";
    }

}
