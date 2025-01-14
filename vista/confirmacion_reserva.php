<?php
// Verificar que el ID de la reserva se pasa en la URL
if (isset($_GET['id'])) {
    $reservaId = $_GET['id'];  // Recupera el ID de la URL
    // Usar el ID para obtener detalles de la reserva, etc.
} else {
    echo "No se recibió el ID de la reserva.";
}

if (isset($_GET['reservaId'])) {
    $reservaId = $_GET['reservaId'];

    // Obtener los detalles de la reserva desde la base de datos
    require_once __DIR__ . '/../../modelo/reservas/reservaModel.php';
    $reservaModel = new ReservaModel();
    $reservaDetails = $reservaModel->obtenerReservaPorId($reservaId);

    if ($reservaDetails) {
        // Mostrar los detalles de la reserva
        echo "Reserva confirmada con éxito. Detalles:<br>";
        echo "ID Reserva: " . $reservaDetails['Id_Reserva'] . "<br>";
        echo "Cliente: " . $reservaDetails['Id_Cliente'] . "<br>";
        echo "Hotel: " . $reservaDetails['Id_Hotel'] . "<br>";
        echo "Habitación: " . $reservaDetails['Id_Habitacion'] . "<br>";
        echo "Check-in: " . $reservaDetails['Checkin'] . "<br>";
        echo "Check-out: " . $reservaDetails['Checkout'] . "<br>";
        echo "Número de personas: " . $reservaDetails['Numero_Personas'] . "<br>";
        echo "Precio total: " . $reservaDetails['Precio_Total'] . "<br>";
    } else {
        echo "No se encontró la reserva.";
    }
} else {
    echo "No se recibió el ID de reserva.";
}
?>
