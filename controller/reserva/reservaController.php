<?php
require_once __DIR__ . '/../../config/Database.php';  // Asegúrate de que la ruta sea correcta
require_once __DIR__ . '/../../modelo/reservas/ReservaModel.php';  // Asegúrate de que la ruta sea correcta

session_start();
$db = new Database();
$conn = $db->getConnection();
$reservaModel = new ReservaModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteId = $_SESSION['user_id'];
    $habitacionId = $_POST['habitacion_id'];  // Puedes generar dinámicamente desde las disponibles
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $precioTotal = $_POST['precio_total'];  // Calculado según lógica previa

    if ($reservaModel->crearReserva($clienteId, $habitacionId, $checkin, $checkout, $precioTotal)) {
        echo "Reserva realizada con éxito.";
    } else {
        echo "Error al realizar la reserva.";
    }
}

$conn->close();
?>
