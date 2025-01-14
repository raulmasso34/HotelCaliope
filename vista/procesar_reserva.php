<?php
session_start();
include '../config/Database.php';
$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $habitacionId = $_POST['habitacionId'];
    $clienteId = $_POST['clienteId'];
    $hotelId = $_POST['hotelId'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = $_POST['guests'];
    $paisId = $_POST['paisId'];
    $metodoPago = $_POST['metodo_pago'];
    $actividades = $_POST['actividades'] ?? [];

    // Calcular precio total
    $precioHabitacion = 100;  // Precio de ejemplo
    $precioActividades = array_sum(array_map(fn($id) => match ($id) {
        1 => 30, 2 => 50, 3 => 20, default => 0
    }, $actividades));
    $precioTotal = $precioHabitacion + $precioActividades;

    $query = $db->prepare("INSERT INTO Reservas (Id_Cliente, Id_Habitacion, Id_Hotel, Checkin, Checkout, Precio_Total, Numero_Personas, Id_Pais)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param("iiissdis", $clienteId, $habitacionId, $hotelId, $checkin, $checkout, $precioTotal, $guests, $paisId);

    if ($query->execute()) {
        echo "Reserva confirmada con éxito.";
    } else {
        echo "Error al procesar la reserva.";
    }

    $database->closeConnection();
}
?>
