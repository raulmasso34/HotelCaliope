<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="../static/css/reserva.css"> <!-- Vinculamos el archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Reserva Confirmada</h1>

        <?php
        // Capturar los datos enviados
        $location = $_POST['location'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $guests = $_POST['guests'];
        $activity = $_POST['activity'];
        $room = $_POST['room'];
        $hotel = $_POST['hotel'];
        $rate = $_POST['rate'];
        $payment = $_POST['payment'];

        // Precios (esto debe ser dinámico, pero lo pongo de ejemplo aquí)
        $actividades = [
            1 => ['Nombre' => 'Excursión a la montaña', 'Precio' => 50],
            2 => ['Nombre' => 'Noche cultural', 'Precio' => 30],
            3 => ['Nombre' => 'Paseo en bote', 'Precio' => 40]
        ];
        $habitaciones = [
            1 => ['Nombre' => 'Habitación Doble', 'Precio' => 100],
            2 => ['Nombre' => 'Habitación Individual', 'Precio' => 70],
            3 => ['Nombre' => 'Habitación Familiar', 'Precio' => 120]
        ];
        $hoteles = [
            1 => ['Nombre' => 'Hotel Mar Azul', 'Precio' => 150],
            2 => ['Nombre' => 'Hotel Sol y Mar', 'Precio' => 180],
            3 => ['Nombre' => 'Hotel Luna', 'Precio' => 200]
        ];
        $tarifas = [
            1 => ['Nombre' => 'Tarifa Básica', 'Precio' => 50],
            2 => ['Nombre' => 'Tarifa Premium', 'Precio' => 80],
            3 => ['Nombre' => 'Tarifa VIP', 'Precio' => 120]
        ];

        // Calcular precios
        $precioActividad = $actividades[$activity]['Precio'];
        $precioHabitacion = $habitaciones[$room]['Precio'];
        $precioHotel = $hoteles[$hotel]['Precio'];
        $precioTarifa = $tarifas[$rate]['Precio'];

        $precioTotal = $precioActividad + $precioHabitacion + $precioHotel + $precioTarifa;
        ?>

        <div class="details">
            <!-- Mostrar los detalles de la reserva -->
            <div class="detail-item">
                <strong>Lugar:</strong> <?php echo $location; ?>
            </div>
            <div class="detail-item">
                <strong>Fecha de Check-in:</strong> <?php echo $checkin; ?>
            </div>
            <div class="detail-item">
                <strong>Fecha de Check-out:</strong> <?php echo $checkout; ?>
            </div>
            <div class="detail-item">
                <strong>Número de Personas:</strong> <?php echo $guests; ?>
            </div>

            <!-- Mostrar los detalles de la actividad seleccionada -->
            <div class="detail-item">
                <strong>Actividad:</strong> <?php echo $actividades[$activity]['Nombre']; ?> - $<?php echo $precioActividad; ?>
            </div>

            <!-- Mostrar los detalles de la habitación seleccionada -->
            <div class="detail-item">
                <strong>Habitación:</strong> <?php echo $habitaciones[$room]['Nombre']; ?> - $<?php echo $precioHabitacion; ?>
            </div>

            <!-- Mostrar los detalles del hotel seleccionado -->
            <div class="detail-item">
                <strong>Hotel:</strong> <?php echo $hoteles[$hotel]['Nombre']; ?> - $<?php echo $precioHotel; ?>
            </div>

            <!-- Mostrar los detalles de la tarifa seleccionada -->
            <div class="detail-item">
                <strong>Tarifa:</strong> <?php echo $tarifas[$rate]['Nombre']; ?> - $<?php echo $precioTarifa; ?>
            </div>

            <!-- Mostrar el precio total -->
            <div class="detail-item total-price">
                <strong>Precio Total:</strong> $<?php echo $precioTotal; ?>
            </div>

            <!-- Mostrar el método de pago -->
            <div class="detail-item">
                <strong>Método de Pago:</strong> <?php echo $payment; ?>
            </div>

            <div class="confirmation-message">
                <p>¡Gracias por su reserva! Te esperamos pronto.</p>
            </div>
        </div>
    </div>
</body>
</html>
