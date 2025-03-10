<?php
// pagoController.php

require_once __DIR__ . '/../../modelo/pago/pagoModel.php';
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../config/Database.php';  

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos de la reserva están en la sesión
    if (!isset($_SESSION['Reservas'])) {
        echo "Error: No se ha recibido la reserva. Intenta nuevamente.";
        exit;
    }

    $reserva = $_SESSION['Reservas'];
    $habitacionId = $reserva['habitacionId'] ?? null;
    $clienteId = $reserva['clienteId'] ?? null;
    $hotelId = $reserva['hotelId'] ?? null;
    $checkin = $_POST['checkin'] ?? null;
    $checkout = $_POST['checkout'] ?? null;
    $guests = $reserva['guests'] ?? null;
    $paisId = $reserva['paisId'] ?? null;
    $actividadId = $reserva['actividadId'] ?? null;
    $metodoPagoId = $reserva['metodo_pago'] ?? null;

    if (empty($checkin)) {
        echo "Error: No se ha recibido la fecha de Checkin.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    // Asegurarse de que el Id_Reserva no esté duplicado
    if (!isset($_SESSION['Reservas']['Id_Reserva'])) {
        $ReservaModel = new ReservaModel($db);
        $tarifaId = null;   
        $precioHabitacion = 100; // Ajusta según necesidades
        $precioActividad = 50; // Ajusta según necesidades
        $precioTarifa = 20; // Ajusta según necesidades
        $precioServicio = $reserva['precioServicio'] ?? 0;
        $precioTotal = $precioHabitacion + $precioActividad + $precioTarifa + $precioServicio;
        $NumeroPersonas = $guests;

        // Recuperamos el servicioId si está disponible
        $servicioId = $reserva['servicioId'] ?? null;

        $reservaId = $ReservaModel->insertarReserva(
            $hotelId, $clienteId, $checkin, $checkout, $paisId, $actividadId, 
            $habitacionId, $tarifaId, $precioHabitacion, $precioActividad, 
            $precioTarifa, $precioTotal, $NumeroPersonas, 
            $servicioId, $precioServicio, 'Pendiente', null
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

    $pagoExitoso = true; // Simula el pago

    if ($pagoExitoso) {
        $PagoModel = new PagoModel($db);
        $fechaPago = date('Y-m-d H:i:s');
        $PagoModel->procesarPago($hotelId, $clienteId, $reservaId, 'Tarjeta', $fechaPago, $metodoPagoId);

        $ReservaModel = new ReservaModel($db);
        $ReservaModel->actualizarEstadoReserva($reservaId, 'Pagado');

        header("Location: ../../vista/reserva_confirmada.php");
        exit;
    } else {
        echo "Error al procesar el pago.";
    }
}
?>
