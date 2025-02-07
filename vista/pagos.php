<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../controller/reserva/reservaController.php';
$reservaController = new ReservaController();

// Verificar si la reserva está en la sesión
if (isset($_SESSION['Reservas'])) {
    $reserva = $_SESSION['Reservas'];

    // Recuperar los datos de la reserva
    $habitacionId = $reserva['habitacionId'] ?? 'No disponible';
    $clienteId = $reserva['clienteId'] ?? 'No disponible';
    $hotelId = $reserva['hotelId'] ?? 'No disponible';
    $checkin = $reserva['checkin'] ?? 'No disponible';
    $checkout = $reserva['checkout'] ?? 'No disponible';
    $guests = $reserva['guests'] ?? 'No disponible';
} else {
    echo "Error: No se ha recibido la reserva en la sesión.";
    exit;
}

$hotelDetails = $reservaController->obtenerDetallesHotel($hotelId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagar Reserva</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/css/pagos.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <style>
        body.overlay::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            z-index: 999;
        }
        .custom-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.98);
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
            border-radius: 15px;
            text-align: center;
            z-index: 1000;
            display: none;
            width: 400px;
        }
        .custom-alert h2 {
            color: #0056b3;
            font-weight: bold;
            font-size: 26px;
        }
        .custom-alert p {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }
        .custom-alert button {
            padding: 14px 30px;
            border: none;
            background: #0056b3;
            color: white;
            font-size: 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        .custom-alert button:hover {
            background: #003f80;
        }
    </style>
    <script>
        function mostrarAlerta() {
            document.getElementById('alerta').style.display = 'block';
            document.body.classList.add('overlay');
        }
        function cerrarAlerta() {
            document.getElementById('alerta').style.display = 'none';
            document.body.classList.remove('overlay');
            window.location.href = '../vista/reserva_confirmada.php';
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-7 border-0">
            <h1 class="text-center">Pagar Reserva</h1>
            <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotelDetails['Nombre']); ?></p>
            <p><strong>Habitación:</strong> <?php echo htmlspecialchars($habitacionId); ?></p>
            <p><strong>Check-in:</strong> <?php echo htmlspecialchars($checkin); ?></p>
            <p><strong>Check-out:</strong> <?php echo htmlspecialchars($checkout); ?></p>
            <p><strong>Personas:</strong> <?php echo htmlspecialchars($guests); ?></p>
            
            <form action="../controller/pago/pagoController.php" method="POST" onsubmit="event.preventDefault(); mostrarAlerta();">
                <div class="mb-3">
                    <label for="numero_tarjeta" class="form-label">Número de Tarjeta:</label>
                    <input type="text" name="numero_tarjeta" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV:</label>
                    <input type="text" name="cvv" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_expiracion" class="form-label">Fecha de Expiración:</label>
                    <input type="month" name="fecha_expiracion" class="form-control" required>
                </div>

                <input type="hidden" name="habitacionId" value="<?php echo htmlspecialchars($habitacionId); ?>">
                <input type="hidden" name="clienteId" value="<?php echo htmlspecialchars($clienteId); ?>">
                <input type="hidden" name="hotelId" value="<?php echo htmlspecialchars($hotelId); ?>">
                <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
                <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
                <input type="hidden" name="guests" value="<?php echo htmlspecialchars($guests); ?>">

                <button type="submit" class="btn btn-primary w-100">Confirmar y Pagar</button>
            </form>
        </div>
    </div>

    <div id="alerta" class="custom-alert">
        <h2>¡Pago Exitoso!</h2>
        <p>Tu reserva ha sido confirmada. Redirigiendo...</p>
        <button onclick="cerrarAlerta()">Aceptar</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
