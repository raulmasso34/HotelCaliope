<?php
session_start();
require_once __DIR__ . '/../controller/reserva/reservaController.php';

// Crear una instancia del controlador
$reservaController = new ReservaController();

// Obtener los países desde la base de datos
$paises = $reservaController->obtenerPaises();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="main-center">
    <div class="center-up">
        <div class="center-up-up">
        <span style="font-size: 20px;  color: rgb(230, 182, 11);">
        <i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star "></i>
        </span>
       
        </div>
        <div class="center-up-down">
            <h5>Lorem ipsum dolor sit amet.</h5>
            <H1>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere, minima.</H1>
        </div>
    </div>
    <div class="center-down">
    <div class="form-reservas">
        <div class="reservation-form">
            <form action="../controller/reserva/reservaController.php" method="post">
                <!-- Campo de selección de lugar -->
                <div class="form-group">
                    <label for="location">Lugar</label>
                    <select id="location" name="location" required>
                        <?php foreach ($paises as $pais): ?>
                            <option value="<?php echo $pais['Id_Pais']; ?>"><?php echo $pais['Pais']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Campo de fecha de check-in -->
                <div class="form-group">
                    <label for="checkin">Fecha de Check-in</label>
                    <input type="date" id="checkin" name="checkin" required>
                </div>

                <!-- Campo de fecha de check-out -->
                <div class="form-group">
                    <label for="checkout">Fecha de Check-out</label>
                    <input type="date" id="checkout" name="checkout" required>
                </div>

                <!-- Campo de número de personas -->
                <div class="form-group">
                    <label for="guests">Número de Personas</label>
                    <input type="number" id="guests" name="guests" min="1" required>
                </div>


                <!-- Botón para enviar el formulario -->
                <button type="submit">Reservar</button>
            </form>
        </div>
    </div>

  
</section>
</body>
</html>

