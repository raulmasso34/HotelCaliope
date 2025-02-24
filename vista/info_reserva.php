<?php
session_start();
include '../config/Database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$db = $database->getConnection();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/Clientes/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id_reserva = intval($_GET['id']); // Sanitiza el parámetro recibido

    // Consulta para obtener los detalles de la reserva
    $sql = "SELECT 
            r.Id_Reserva, 
            c.Nom AS Nombre_Cliente, 
            h.Nombre AS Nombre_Hotel, 
            ha.Tipo AS Tipo_Habitacion, 
            ha.Numero_Habitacion AS Numero_Habitacion, 
            a.Nombre AS Nombre_Actividad, 
            p.Pais AS Nombre_Pais, 
            r.Precio_Habitacion, 
            r.Checkin, 
            r.Checkout, 
            r.Numero_Personas
        FROM Reservas r
        LEFT JOIN Clients c ON r.Id_Cliente = c.Id_Client
        LEFT JOIN Hotel h ON r.Id_Hotel = h.Id_Hotel
        LEFT JOIN Habitaciones ha ON r.Id_Habitacion = ha.Id_Habitaciones
        LEFT JOIN Actividades a ON r.Id_Actividad = a.Id_Actividades
        LEFT JOIN Pais p ON r.Id_Pais = p.Id_Pais
        WHERE r.Id_Reserva = ?";

    $stmt = $db->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $db->error);
    }

    $stmt->bind_param("i", $id_reserva); // Vincula el parámetro
    if (!$stmt->execute()) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    $resultado = $stmt->get_result();

    // Verifica si se encontró la reserva
    if ($resultado->num_rows > 0) {
        $reserva = $resultado->fetch_assoc();
        
        // Calcular el número de noches
        $checkinDate = new DateTime($reserva['Checkin']);
        $checkoutDate = new DateTime($reserva['Checkout']);
        $interval = $checkinDate->diff($checkoutDate);
        $numero_noches = $interval->days; // Total de noches

        // Calcular el precio total basado en el precio de la habitación
        $precio_habitacion = $reserva['Precio_Habitacion'];
        $numero_personas = $reserva['Numero_Personas'];

        // Calcular el precio total multiplicando por el número de noches y el número de personas
        $precio_total_calculado = $precio_habitacion * $numero_noches * $numero_personas;
    } else {
        echo "<p>La reserva no se encontró. Por favor, verifica el ID.</p>";
        exit;
    }
} else {
    echo "<p>ID de reserva no proporcionado.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="../static/css/info_reserva.css">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
</head>
<body>
    <h1>DETALLES DE LA RESERVA</h1>
    <table class="details-table">
        <tr>
            <th>Campo</th>
            <th>Detalle</th>
        </tr>
        <tr>
            <td>Cliente</td>
            <td><?php echo htmlspecialchars($reserva['Nombre_Cliente']); ?></td>
        </tr>
        <tr>
            <td>Hotel</td>
            <td><?php echo htmlspecialchars($reserva['Nombre_Hotel']); ?></td>
        </tr>
        <tr>
            <td>Habitación</td>
            <td><?php echo htmlspecialchars($reserva['Tipo_Habitacion']); ?></td>
        </tr>
        <tr>
            <td>Número de Habitación</td>
            <td><?php echo htmlspecialchars($reserva['Numero_Habitacion']); ?></td>
        </tr>
        <tr>
            <td>Actividad</td>
            <td><?php echo htmlspecialchars($reserva['Nombre_Actividad'] ?? 'N/A'); ?></td>
        </tr>
        <tr>
            <td>País</td>
            <td><?php echo htmlspecialchars($reserva['Nombre_Pais'] ?? 'N/A'); ?></td>
        </tr>
        <tr>
            <td>Precio Total</td>
            <td>$<?php echo htmlspecialchars(number_format($precio_total_calculado, 2)); ?></td> <!-- Formatear a 2 decimales -->
        </tr>
        <!-- Mostrar la fecha de Check-in -->
        <tr>
            <td>Fecha de Check-in</td>
            <td>
                <?php
                // Verificar si la fecha de Check-in está disponible y formatearla
                echo $checkinDate->format('d/m/Y');
                ?>
            </td>
        </tr>
        <!-- Mostrar la fecha de Check-out -->
        <tr>
            <td>Fecha de Check-out</td>
            <td>
                <?php
                // Verificar si la fecha de Check-out está disponible y formatearla
                echo $checkoutDate->format('d/m/Y');
                ?>
            </td>
        </tr>
    </table>
    
    <a href="../vista/Clientes/perfil.php">Volver atrás</a>
</body>
</html>

<?php
// Cerrar conexión
$db->close();
?>
