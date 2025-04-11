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

// ✅ Proceso de cancelación por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservaId'])) {
    $reservaId = intval($_POST['reservaId']);
    if ($reservaController->cancelar($reservaId)) {
        header('Location: Clientes/perfil.php?cancelada=1');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al cancelar la reserva.</div>";
    }
}

// ✅ Verificación de ID
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

    <!-- Botón para cancelar -->
    <h2>Cancelar Reserva</h2>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
        Cancelar reserva
    </button>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">¿Estás seguro?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            Esta acción eliminará tu reserva permanentemente.
          </div>
          <div class="modal-footer">
            <form method="POST">
                <input type="hidden" name="reservaId" value="<?= htmlspecialchars($reserva['Id_Reserva']) ?>">
                <button type="submit" class="btn btn-danger">Sí, cancelar</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
          </div>
        </div>
      </div>
    </div>

    <a href="Clientes/perfil.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<!-- Bootstrap JS (modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
