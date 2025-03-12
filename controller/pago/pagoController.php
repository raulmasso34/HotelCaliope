<?php
// pagoController.php

require_once __DIR__ . '/../../modelo/pago/pagoModel.php';
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../config/Database.php';  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos de la reserva están en la sesión
    if (!isset($_SESSION['Reservas'])) {
        echo "Error: No se ha recibido la reserva. Intenta nuevamente.";
        exit;
    }

    $reserva = $_SESSION['Reservas'];
    
    // Recuperar datos de la reserva
    $habitacionId = $reserva['habitacionId'] ?? null;
    $clienteId = $reserva['clienteId'] ?? null;
    $hotelId = $reserva['hotelId'] ?? null;
    $checkin = $_POST['checkin'] ?? null;
    $checkout = $_POST['checkout'] ?? null;
    $guests = $reserva['guests'] ?? null;
    $paisId = $reserva['paisId'] ?? null;
    $actividadId = $reserva['actividadId'] ?? null;
    $metodoPagoId = $_POST['metodoPagoId'] ?? 'Tarjeta'; // Método de pago
    $estadoReserva = "Pendiente";

    if (empty($checkin) || empty($checkout)) {
        echo "Error: No se han recibido las fechas de Check-in o Check-out.";
        exit;
    }

    // Establecer la conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();
    $ReservaModel = new ReservaModel($db);

    // Recuperar los precios de la habitación y la actividad desde el modelo
    $precioHabitacion = $ReservaModel->obtenerPrecioHabitacion($habitacionId);
    $precioActividad = $ReservaModel->obtenerPrecioActividad($actividadId);

    // Recuperar los servicios seleccionados de la sesión
    $serviciosSeleccionados = $_SESSION['Reservas']['servicios'] ?? [];
    $totalServicios = $_SESSION['Reservas']['totalServicios'] ?? 0;
    $precioTarifa = 0; // O agregar lógica para obtener tarifas adicionales si es necesario
    
    // Calcular el precio total
    $precioTotal = $precioHabitacion + $precioActividad + $precioTarifa + $totalServicios;

    // Insertar la reserva solo si aún no existe
    if (!isset($_SESSION['Reservas']['Id_Reserva'])) {
        $reservaId = $ReservaModel->insertarReserva(
            $hotelId, 
            $clienteId, 
            $checkin, 
            $checkout, 
            $paisId, 
            $actividadId, 
            $habitacionId, 
            $tarifaId, 
            $precioHabitacion, 
            $precioServicios,
            $precioActividad, 
            $precioTarifa, 
            $precioTotal, 
            $guests
        );

        if ($reservaId !== null) {
            $_SESSION['Reservas']['Id_Reserva'] = $reservaId;
        } else {
            echo "Error al insertar la reserva.";
            exit;
        }
    } else {
        $reservaId = $_SESSION['Reservas']['Id_Reserva'];
    }

   
    // Procesar el pago
    $numeroTarjeta = $_POST['numero_tarjeta'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $fechaExpiracion = $_POST['fecha_expiracion'] ?? '';

    if (empty($numeroTarjeta) || empty($cvv) || empty($fechaExpiracion)) {
        echo "Por favor, completa todos los campos de pago.";
        exit;
    }

    // Simular pago exitoso
    $pagoExitoso = true;

    if ($pagoExitoso) {
        $PagoModel = new PagoModel($db);
        $fechaPago = date('Y-m-d H:i:s');
        $PagoModel->procesarPago($hotelId, $clienteId, $reservaId, 'Tarjeta', $fechaPago, $metodoPagoId);

        // Marcar la reserva como pagada
        $ReservaModel->actualizarEstadoReserva($reservaId, 'Pagado');

        header("Location: ../../vista/reserva_confirmada.php");
        exit;
    } else {
        echo "Error al procesar el pago.";
    }
}

?>
