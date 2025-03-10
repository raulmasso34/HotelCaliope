<?php
// pagoController.php

// Incluir los modelos necesarios y la configuración de la base de datos
require_once __DIR__ . '/../../modelo/pago/pagoModel.php';
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../config/Database.php';  

session_start();

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los datos de la reserva están en la sesión
    if (!isset($_SESSION['Reservas'])) {
        echo "Error: No se ha recibido la reserva. Intenta nuevamente.";
        exit;
    }

    // Recuperar los datos de la reserva desde la sesión
    $reserva = $_SESSION['Reservas'];

    // Comprobar si cada campo está presente en la reserva y asignarlo
    $habitacionId = $reserva['habitacionId'] ?? null;
    $clienteId = $reserva['clienteId'] ?? null;
    $hotelId = $reserva['hotelId'] ?? null;
    $checkin = $_POST['checkin'] ?? null;
    $checkout = $_POST['checkout'] ?? null;
    $guests = $reserva['guests'] ?? null;
    $paisId = $reserva['paisId'] ?? null;
    $actividadId = $reserva['actividadId'] ?? null;
    $metodoPagoId = $reserva['metodo_pago'] ?? null;

    // Verificar si checkin está recibiendo correctamente
    if (empty($checkin)) {
        echo "Error: No se ha recibido la fecha de Checkin.";
        exit;
    }

    // Establecer la conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Asegurarse de que si el Id_Reserva no está en la sesión, se inserte
    if (!isset($_SESSION['Reservas']['Id_Reserva'])) {
        // Si no existe el Id_Reserva, insertamos la reserva en la base de datos
        $ReservaModel = new ReservaModel($db);
        $tarifaId = null;   
        $precioHabitacion = 100; // Ejemplo, ajusta según tus necesidades
        $precioActividad = 50; // Ejemplo, ajusta según tus necesidades
        $precioTarifa = 20; // Ejemplo, ajusta según tus necesidades
        $precioTotal = $precioHabitacion + $precioActividad + $precioTarifa + $precioServicio;
        $NumeroPersonas = $guests; // O el valor correspondiente

        // Recuperamos el servicioId y precioServicio si están disponibles
        $servicioId = $reserva['servicioId'] ?? null;
        $precioServicio = $reserva['precioServicio'] ?? 0;

        // Insertamos la reserva y obtenemos el ID de la reserva
        $reservaId = $ReservaModel->insertarReserva(
            $hotelId, $clienteId, $checkin, $checkout, $paisId, $actividadId, 
        $habitacionId, $tarifaId, $precioHabitacion, $precioActividad, 
        $precioTarifa, $precioTotal, $NumeroPersonas, 
        $servicioId, $precioServicio, 
        $estado, $fechaCancelacion// Parámetro precioServicio
        );

        if ($reservaId !== null) {
            // Guardamos el Id_Reserva en la sesión
            $_SESSION['Reservas']['Id_Reserva'] = $reservaId;
        } else {
            echo "Error al insertar la reserva.";
            exit;
        }
    } else {
        // Si ya existe, usamos el Id_Reserva de la sesión
        $reservaId = $_SESSION['Reservas']['Id_Reserva'];
    }

    // Procesar el pago
    $numeroTarjeta = $_POST['numero_tarjeta'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
    $fechaExpiracion = $_POST['fecha_expiracion'] ?? '';

    // Validación simple de los datos de la tarjeta
    if (empty($numeroTarjeta) || empty($cvv) || empty($fechaExpiracion)) {
        echo "Por favor, completa todos los campos de pago.";
        exit;
    }

    if (empty($checkin) || !preg_match("/\d{4}-\d{2}-\d{2}/", $checkin)) {
        echo "La fecha de check-in no es válida.";
        exit;
    }

    // Aquí es donde se simula el procesamiento del pago (en un caso real, se integraría con una API de pago)
    $pagoExitoso = true; // Simulando que el pago fue exitoso

    if ($pagoExitoso) {
        // Guardar el pago en la base de datos
        $PagoModel = new PagoModel($db);
        $fechaPago = date('Y-m-d H:i:s');
        $PagoModel->procesarPago($hotelId, $clienteId, $reservaId, 'Tarjeta', $fechaPago, $metodoPagoId);

        // Actualizar el estado de la reserva a "Pagado"
        $ReservaModel = new ReservaModel($db);
        $ReservaModel->actualizarEstadoReserva($reservaId, 'Pagado');

        // Redirigir a la página de confirmación
        header("Location: ../../vista/reserva_confirmada.php");
        exit;
    } else {
        echo "Error al procesar el pago.";
    }
}
?>
