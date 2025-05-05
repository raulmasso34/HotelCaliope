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
    <title>Detalles de Reserva - Luxury Stays</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/info_reserva.css">
</head>
<body>
    <!-- Header Exclusivo -->
    <header class="reserva-header">
        <nav class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <a href="/" class="brand-logo">
                    <img src="../static/img/logo_blanco.png" alt="Luxury Stays" width="120">
                </a>
                <div class="header-actions">
                    <a href="Clientes/perfil.php" class="btn btn-icon">
                        <i class="fas fa-user-circle me-2"></i>Mi Perfil
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="reserva-main">
        <div class="container">
            <div class="reserva-card">
                <div class="reserva-header-card">
                    <h1><i class="fas fa-concierge-bell me-3"></i>Detalles de tu Reserva</h1>
                    <div class="reserva-status">
                        <span class="status-badge confirmed"><i class="fas fa-check-circle me-2"></i>Confirmada</span>
                    </div>
                </div>

                <!-- Sección de Detalles -->
                <div class="reserva-grid">
                    <!-- Columna Izquierda -->
                    <div class="reserva-section">
                        <h2 class="section-title"><i class="fas fa-user-tie me-3"></i>Información del Cliente</h2>
                        <div class="detail-item">
                            <span class="detail-label">Nombre:</span>
                            <span class="detail-value"><?= htmlspecialchars($reserva['Nombre_Cliente']) ?></span>
                        </div>
                        
                        <h2 class="section-title mt-5"><i class="fas fa-hotel me-3"></i>Detalles del Alojamiento</h2>
                        <div class="detail-item">
                            <span class="detail-label">Hotel:</span>
                            <span class="detail-value"><?= htmlspecialchars($reserva['Nombre_Hotel']) ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Habitación:</span>
                            <span class="detail-value"><?= htmlspecialchars($reserva['Tipo_Habitacion']) ?> (Nº <?= htmlspecialchars($reserva['Numero_Habitacion']) ?>)</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ubicación:</span>
                            <span class="detail-value"><?= htmlspecialchars($reserva['Nombre_Pais']) ?></span>
                        </div>
                    </div>

                    <!-- Columna Derecha -->
                    <div class="reserva-section">
                        <h2 class="section-title"><i class="fas fa-receipt me-3"></i>Detalles de Pago</h2>
                        <div class="detail-item">
                            <span class="detail-label">Fecha Check-in:</span>
                            <span class="detail-value"><?= $checkinDate->format('d/m/Y') ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fecha Check-out:</span>
                            <span class="detail-value"><?= $checkoutDate->format('d/m/Y') ?></span>
                        </div>
                        <div class="price-breakdown">
                            <div class="detail-item">
                                <span class="detail-label">Tarifa Base:</span>
                                <span class="detail-value">$<?= number_format($precio_calculado, 2) ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Servicios:</span>
                                <span class="detail-value">+ $<?= number_format($reserva['Precio_Servicio'], 2) ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Actividades:</span>
                                <span class="detail-value">+ $<?= number_format($reserva['Precio_Actividad'], 2) ?></span>
                            </div>
                            <div class="detail-item total">
                                <span class="detail-label">Total:</span>
                                <span class="detail-value">$<?= number_format($reserva['Precio_Total'], 2) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="reserva-actions">
                    <button class="btn btn-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        <i class="fas fa-times-circle me-2"></i>Cancelar Reserva
                    </button>
                    <a href="Clientes/perfil.php" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Perfil
                    </a>
                </div>
            </div>
        </div>
    </main>

  

    <!-- Modal Cancelación -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Confirmar Cancelación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas cancelar esta reserva? Esta acción no se puede deshacer.</p>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atención:</strong> Si cancelas con menos de 24 horas de antelación, podrían aplicarse cargos por cancelación tardía.
                    </div>
                    <input type="hidden" name="reservaId" value="<?php echo $id_reserva; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>No, volver
                    </button>
                    <button type="submit" class="btn btn-danger" name="cancelarReserva">
                        <i class="fas fa-trash-alt me-2"></i>Sí, cancelar reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="reserva-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <img src="../static/img/logo_blanco.png" alt="Luxury Stays" width="100">
                    <p class="tagline">Experiencias de lujo desde 2010</p>
                </div>
                <div class="footer-contact">
                    <h4>Contacto</h4>
                    <p><i class="fas fa-phone me-2"></i>+34 910 234 567</p>
                    <p><i class="fas fa-envelope me-2"></i>reservas@luxurystays.com</p>
                </div>
            </div>
            <div class="footer-copyright">
                <p>© 2024 Luxury Stays. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>