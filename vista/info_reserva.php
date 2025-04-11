<?php
session_start();
require_once '../config/Database.php';
require_once __DIR__ . '/../controller/reserva/reservaController.php';

$database = new Database();
$db = $database->getConnection();
$reservaController = new ReservaController($db);

if (!isset($_SESSION['user_id'])) {
    header('Location: Clientes/login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "<p>ID de reserva no proporcionado.</p>";
    exit;
}

$id_reserva = intval($_GET['id']);
$reserva = $reservaController->obtenerDetalles($id_reserva);

if (!$reserva) {
    echo "<p>La reserva no se encontró.</p>";
    exit;
}

$precio_calculado = $reservaController->calcularPrecioTotal(
    $reserva['Precio_Habitacion'],
    $reserva['Checkin'],
    $reserva['Checkout'],
    $reserva['Numero_Personas']
);

$checkinDate = new DateTime($reserva['Checkin']);
$checkoutDate = new DateTime($reserva['Checkout']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="../static/css/info_reserva.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">DETALLES DE LA RESERVA</h1>
    <table class="table">
        <tr><th>Campo</th><th>Detalle</th></tr>
        <tr><td>Cliente</td><td><?= htmlspecialchars($reserva['Nombre_Cliente']) ?></td></tr>
        <tr><td>Hotel</td><td><?= htmlspecialchars($reserva['Nombre_Hotel']) ?></td></tr>
        <tr><td>Habitación</td><td><?= htmlspecialchars($reserva['Tipo_Habitacion']) ?></td></tr>
        <tr><td>Nº Habitación</td><td><?= htmlspecialchars($reserva['Numero_Habitacion']) ?></td></tr>
        <tr><td>País</td><td><?= htmlspecialchars($reserva['Nombre_Pais']) ?></td></tr>
        <tr><td>Precio Actividad</td><td>$<?= number_format($reserva['Precio_Actividad'], 2) ?></td></tr>
        <tr><td>Precio Servicio</td><td>$<?= number_format($reserva['Precio_Servicio'], 2) ?></td></tr>
        <tr><td>Precio Total Sin Servicios o Actividades Adicionales</td><td>$<?= number_format($precio_calculado, 2) ?></td></tr>
        <tr><td>Precio Total</td><td>$<?= number_format($reserva['Precio_Total'], 2) ?></td></tr>
        <tr><td>Check-in</td><td><?= $checkinDate->format('d/m/Y') ?></td></tr>
        <tr><td>Check-out</td><td><?= $checkoutDate->format('d/m/Y') ?></td></tr>
    </table>

    <a href="Clientes/perfil.php" class="btn btn-secondary">Volver</a>
</div>
</body>
</html>
