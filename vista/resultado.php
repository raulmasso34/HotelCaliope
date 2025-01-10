<?php
// Mostrar los resultados (hoteles y habitaciones)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la Reserva</title>
</head>
<body>
    <h1>Resultados de tu Reserva</h1>

    <h2>Hoteles Disponibles</h2>
    <?php if (count($hotelesDisponibles) > 0): ?>
        <ul>
            <?php foreach ($hotelesDisponibles as $hotel): ?>
                <li>
                    <?php echo htmlspecialchars($hotel['Nombre']); ?> - 
                    <?php echo htmlspecialchars($hotel['Ciudad']); ?>, 
                    <?php echo htmlspecialchars($hotel['Estrellas']); ?> estrellas
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay hoteles disponibles para las fechas y filtros seleccionados.</p>
    <?php endif; ?>

    <h2>Habitaciones Disponibles</h2>
    <?php if (count($habitacionesDisponibles) > 0): ?>
        <ul>
            <?php foreach ($habitacionesDisponibles as $habitacion): ?>
                <li>
                    Habitación <?php echo htmlspecialchars($habitacion['Numero_Habitacion']); ?> - 
                    Tipo: <?php echo htmlspecialchars($habitacion['Tipo']); ?> - 
                    Capacidad: <?php echo htmlspecialchars($habitacion['Capacidad']); ?> personas - 
                    Precio: $<?php echo htmlspecialchars($habitacion['Precio']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay habitaciones disponibles con los filtros seleccionados.</p>
    <?php endif; ?>
</body>
</html>
