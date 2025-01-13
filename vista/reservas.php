<?php
session_start();
?>

<h1>Confirmar tu Reserva</h1>
<p>Lugar: <?php echo $_SESSION['location']; ?></p>
<p>Fecha de Check-in: <?php echo $_SESSION['checkin']; ?></p>
<p>Fecha de Check-out: <?php echo $_SESSION['checkout']; ?></p>
<p>Número de Personas: <?php echo $_SESSION['guests']; ?></p>

<form action="../controller/reserva/reservaController.php" method="post">
    <label for="pago">Método de pago:</label>
    <select id="pago" name="pago" required>
        <option value="tarjeta">Tarjeta de crédito</option>
        <option value="paypal">PayPal</option>
        <option value="transferencia">Transferencia bancaria</option>
    </select>
    <button type="submit">Confirmar Reserva</button>
</form>
