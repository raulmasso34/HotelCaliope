<?php
session_start();
include '../config/Database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$db = $database->getConnection();
require_once __DIR__ . '/../controller/reserva/reservaController.php';
$reservaController = new ReservaController($db);

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: ../vista/Clientes/login.php');
    exit;
}

// Verifica si se proporciona el ID de la reserva
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

        // Manejo de la cancelación
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservaId'])) {
            $reservaId = $_POST['reservaId'];
            if ($reservaController->cancelar($reservaId)) {
                // Redirigir o mostrar mensaje de éxito
                header('Location: ../vista/Clientes/perfil.php'); // Cambia esta ruta según tu aplicación
                exit();
            } else {
                echo "Error al cancelar la reserva.";
            }
        }

    } else {
        echo "<p>La reserva no se encontró. Por favor, verifica el ID.</p>";
        exit;
    }
} else {
    echo "<p>ID de reserva no proporcionado.</p>";
    exit;
}

// Cerrar conexión
$db->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Reserva</title>
    <link rel="stylesheet" href="../static/css/info_reserva.css"> <!-- Tu CSS debe estar después de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../static/img/favicon_io/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Agregar Font Awesome -->
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">DETALLES DE LA RESERVA</h1>
        <table class="table">
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
                <td>$<?php echo htmlspecialchars(number_format($precio_total_calculado, 2)); ?></td>
            </tr>
            <tr>
                <td>Fecha de Check-in</td>
                <td><?php echo $checkinDate->format('d/m/Y'); ?></td>
            </tr>
            <tr>
                <td>Fecha de Check-out</td>
                <td><?php echo $checkoutDate->format('d/m/Y'); ?></td>
            </tr>
        </table>
        
       
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
            Cancelar reserva
        </button>

        
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered custom-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="cancelModalLabel">
                            <img src="../static/img/logo_blanco.png" alt="Hotel Logo" width="60" class="me-2">
                            Confirmar Cancelación
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar";"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fs-5">¿Estás seguro de que deseas cancelar esta reserva?</p>
                        <p class="text-danger-custom">Esta acción no se puede deshacer.</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, volver</button>
                        <form action="" method="POST" class="d-inline">
                            <input type="hidden" name="reservaId" value="<?= htmlspecialchars($reserva['Id_Reserva']); ?>">
                            <button type="submit" class="btn btn-danger">Sí, cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <a href="../vista/Clientes/perfil.php" class="icono-salida" title="Volver atrás">
            <i class="fas fa-sign-out-alt"></i> <!-- Icono de salida -->
        </a>
    </div>
</body>
</html>
