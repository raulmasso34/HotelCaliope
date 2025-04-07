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
            if (!is_numeric($datos['metodoPagoId']) || $datos['metodoPagoId'] < 1 || $datos['metodoPagoId'] > 3) {
                throw new Exception("Error: Método de pago inválido.");
            }

            // ✅ 3. Verificar `precioHabitacion` y asignar un valor seguro
            if (!isset($datos['precioHabitacion']) && isset($datos['Precio_Habitacion'])) {
                $datos['precioHabitacion'] = $datos['Precio_Habitacion'];
            }

            if (!isset($datos['precioHabitacion'])) {
                throw new Exception("Error: No se ha recibido el precio de la habitación.");
            }

            $precioHabitacion = floatval($datos['precioHabitacion']);
            $precioTotalServicios = 0;
            $precioTotalActividad = 0;

            if (!empty($datos['servicios']) && is_array($datos['servicios'])) {
                foreach ($datos['servicios'] as $precio) {
                    $precioTotalServicios += floatval($precio);
                }
            }

            if (!empty($datos['actividades']) && is_array($datos['actividades'])) {
                foreach ($datos['actividades'] as $precio) {
                    $precioTotalActividad += floatval($precio);
                }
            }

            // Actualizar los precios en los datos de la reserva
            $datos['precioServicio'] = $precioTotalServicios;
            $datos['precioActividad'] = $precioTotalActividad;
            $datos['precioTotal'] = $precioHabitacion + $precioTotalServicios + $precioTotalActividad;

            // ✅ 4. Insertar la reserva en la base de datos
            $idReserva = $this->reservaModel->insertarReserva(
                $datos['clienteId'],
                $datos['habitacionId'],
                $datos['hotelId'],
                $datos['tarifaId'] ?? null,
                $precioHabitacion,
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

                    // In your PagoController class, replace the activities section with this:
            if (!empty($datos['actividades'])) {
                foreach ($datos['actividades'] as $idActividad => $precio) {
                    // Add debugging to see what values are being processed
                    error_log("Asociando actividad - ID: '$idActividad', Precio: '$precio'");
                    
                    // Validar que el ID de actividad sea válido
                    if (empty($idActividad) || !is_numeric($idActividad)) {
                        error_log("ID de actividad inválido: " . var_export($idActividad, true));
                        throw new Exception("Error: ID de actividad inválido o vacío.");
                    }
                    
                    // Intentar asociar la actividad
                    if (!$this->reservaModel->asociarActividadAReserva($idReserva, $idActividad, $precio)) {
                        throw new Exception("Error al asociar la actividad ID: " . $idActividad);
                    }
                }
            }
            

            // ✅ 6. Procesar el pago
            $metodoPago = match ($datos['metodoPagoId']) {
                1 => 'Tarjeta de Crédito',
                2 => 'PayPal',
                3 => 'Transferencia Bancaria',
                default => 'Método no válido',
            };

            $pagoExitoso = $this->pagoModel->procesarPago(
                $datos['hotelId'],
                $datos['clienteId'],
                $idReserva,
                $metodoPago,
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
    
    // Verificar si la sesión de reserva existe
    if (!isset($_SESSION['Reservas'])) {
        die(json_encode(['success' => false, 'message' => 'Sesión expirada o datos no encontrados.']));
    }

    $reservaSession = $_SESSION['Reservas'];

    // Guardar las actividades y servicios seleccionados en la sesión
    $_SESSION['Reservas']['actividades'] = $_POST['actividades'] ?? [];
    $_SESSION['Reservas']['servicios'] = $_POST['servicios'] ?? [];

    // Combinamos los datos de la reserva y los del POST
    $datosReserva = array_merge($reservaSession, $_POST);

    // ✅ Verificar si `precioHabitacion` está en la sesión o en el POST antes de procesar el pago
    if (!isset($datosReserva['precioHabitacion']) && isset($datosReserva['Precio_Habitacion'])) {
        $datosReserva['precioHabitacion'] = $datosReserva['Precio_Habitacion'];
    }

    if (!isset($datosReserva['precioHabitacion'])) {
        error_log("Error: precioHabitacion no está definido en la sesión ni en POST");

        // 🔍 Depurar: Imprimir el contenido de la sesión y del POST
        error_log("Contenido de \$_SESSION['Reservas']: " . print_r($_SESSION['Reservas'], true));
        error_log("Contenido de \$_POST: " . print_r($_POST, true));

        die(json_encode(['success' => false, 'message' => 'Error: No se ha recibido el precio de la habitación.']));
    }

    // Procesar el pago
    $resultado = $pagoController->procesarPagoReserva($datosReserva);

    if ($resultado['success']) {
        $_SESSION['idReserva'] = $resultado['idReserva'];
        
        // Verificar si el formulario de pago fue enviado
        if (isset($_POST['pago_enviado'])) {
            // Si el pago ya fue procesado, redirigir a la página de confirmación
            header("Location: ../../vista/reserva_confirmada.php?idReserva=" . $resultado['idReserva']);
            exit();
        } else {
            // Si es la primera vez (reserva exitosa pero sin pago), redirigir a pagos
            header("Location: ../vista/pagos.php?idReserva=" . $resultado['idReserva']);
            exit();
        }
    } else {
        die(json_encode($resultado));
    }
    
}

