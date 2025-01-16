<?php
// pagoController.php

// Incluir los modelos necesarios y la configuración de la base de datos
require_once __DIR__ . '/../../modelo/pago/pagoModel.php';
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';
require_once __DIR__ . '/../../config/Database.php';  

session_start();

// Verificar si los datos de la reserva están en la sesión
if (!isset($_SESSION['Reservas'])) {
    echo "Error: No se ha recibido la reserva. Intenta nuevamente.";
    exit;
}

// Verificar si la clase PagoModel está cargada
if (!class_exists('PagoModel')) {
    echo "Error: No se pudo cargar la clase PagoModel.";
    exit;
}

// Recuperar los datos de la reserva desde la sesión
$reserva = $_SESSION['Reservas'];

// Recuperar los datos de la reserva desde la sesión
$reserva = $_SESSION['Reservas'];

// Comprobar si cada campo está presente en la reserva y asignarlo
$habitacionId = isset($reserva['habitacionId']) ? $reserva['habitacionId'] : null;
$clienteId = isset($reserva['clienteId']) ? $reserva['clienteId'] : null;
$hotelId = isset($reserva['hotelId']) ? $reserva['hotelId'] : null;
$checkin = isset($reserva['checkin']) ? $reserva['checkin'] : null;
$checkout = isset($reserva['checkout']) ? $reserva['checkout'] : null;
$guests = isset($reserva['guests']) ? $reserva['guests'] : null;
$paisId = isset($reserva['paisId']) ? $reserva['paisId'] : null;
$actividadId = isset($reserva['actividadId']) ? $reserva['actividadId'] : null;
$metodoPagoId = isset($reserva['metodo_pago']) ? $reserva['metodo_pago'] : null;

// Asignar valores de los precios (puedes ajustarlos según los datos reales)
$precioHabitacion = isset($reserva['precioHabitacion']) ? $reserva['precioHabitacion'] : 0;
$precioActividad = isset($reserva['precioActividad']) ? $reserva['precioActividad'] : 0;
$precioTarifa = isset($reserva['precioTarifa']) ? $reserva['precioTarifa'] : 0;

// Calcular el precio total sumando los precios de la habitación, actividad y tarifa
$precioTotal = $precioHabitacion + $precioActividad + $precioTarifa;

// Asegurarse de que si el Id_Reserva no está en la sesión, se inserte
if (!isset($_SESSION['Reservas']['Id_Reserva'])) {
    // Si no existe el Id_Reserva, insertamos la reserva en la base de datos
    $ReservaModel = new ReservaModel($db);
    $reservaId = $ReservaModel->insertarReserva(
        $hotelId, 
        $clienteId, 
        $checkin, 
        $checkout, 
        $guests, 
        $paisId, 
        $actividadId, 
        $habitacionId, 
        $tarifaId = null, // Si no se tiene valor para tarifaId, pasa null
        $precioHabitacion,
        $precioActividad,
        $precioTarifa,
        $precioTotal // Pasa el precio total calculado aquí
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

// Establecer la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Asegurarse de que si el Id_Reserva no está en la sesión, se inserte
if (!isset($_SESSION['Reservas']['Id_Reserva'])) {
    // Si no existe el Id_Reserva, insertamos la reserva en la base de datos
    $ReservaModel = new ReservaModel($db);
    $reservaId = $ReservaModel->insertarReserva($hotelId, $clienteId, $checkin, $checkout, $guests, $paisId, $actividadId);
    
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

// Si la solicitud es POST, procesar el pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los datos de la tarjeta desde el formulario
    $numeroTarjeta = isset($_POST['numero_tarjeta']) ? $_POST['numero_tarjeta'] : '';
    $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';
    $fechaExpiracion = isset($_POST['fecha_expiracion']) ? $_POST['fecha_expiracion'] : '';

    // Validación simple de los datos de la tarjeta
    if (empty($numeroTarjeta) || empty($cvv) || empty($fechaExpiracion)) {
        echo "Por favor, completa todos los campos de pago.";
        exit;
    }

    // Aquí es donde se simula el procesamiento del pago (en un caso real, se integraría con una API de pago)
    $pagoExitoso = true; // Simulando que el pago fue exitoso

    if ($pagoExitoso) {
        // Guardar el pago en la base de datos
        $PagoModel = new PagoModel($db);
        $fechaPago = date('Y-m-d H:i:s');
        $PagoModel->procesarPago($hotelId, $clienteId, $reservaId, 'Tarjeta', $fechaPago, $metodoPagoId);

        // Redirigir a la página de confirmación
        header("Location: ../../vista/reserva_confirmada.php");
        exit;
    } else {
        echo "Error al procesar el pago.";
    }
    
}
?>
