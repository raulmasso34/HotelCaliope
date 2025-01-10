// resultados.php
<?php
if (isset($habitacionesDisponibles) && isset($hotelesDisponibles)) {
    echo "<h2>Hoteles Disponibles</h2>";
    foreach ($hotelesDisponibles as $hotel) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($hotel['Nombre']) . "</h3>";
        echo "<p>Dirección: " . htmlspecialchars($hotel['Direccion']) . "</p>";
        echo "</div>";
    }

    echo "<h2>Habitaciones Disponibles</h2>";
    foreach ($habitacionesDisponibles as $habitacion) {
        echo "<div>";
        echo "<h4>Habitación: " . htmlspecialchars($habitacion['Numero_Habitacion']) . " - " . htmlspecialchars($habitacion['Tipo']) . "</h4>";
        echo "<p>Capacidad: " . $habitacion['Capacidad'] . " personas</p>";
        echo "<p>Precio: $" . $habitacion['Precio'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No se encontraron resultados para tu búsqueda.</p>";
}
?>
