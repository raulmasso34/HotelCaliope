<?php
session_start();

// Verificar si los datos necesarios están presentes
if (isset($_SESSION['location'], $_SESSION['checkin'], $_SESSION['checkout'], $_SESSION['guests'], $_SESSION['habitacion_id'])) {
    // Aquí deberías procesar la reserva, por ejemplo, guardar la reserva en la base de datos
    $clienteId = $_SESSION['usuario_id']; // Obtén el ID del usuario desde la sesión
    $location = $_SESSION['location'];
    $checkin = $_SESSION['checkin'];
    $checkout = $_SESSION['checkout'];
    $guests = $_SESSION['guests'];
    $habitacion_id = $_SESSION['habitacion_id'];

    // Aquí agregas el método para crear la reserva, por ejemplo:
    $reserva = new ReservaModel();
    $resultado = $reserva->crearReserva($clienteId, $location, $checkin, $checkout, $guests, $habitacion_id);

    if ($resultado) {
        // Redirigir a una página de confirmación
        header("Location: confirmacion_reserva.php");
        exit();
    } else {
        // Si algo sale mal, redirigir a una página de error
        header("Location: error_reserva.php");
        exit();
    }
} else {
    // Si los datos de sesión no están completos, redirigir al usuario
    header("Location: index.php");
    exit();
}
