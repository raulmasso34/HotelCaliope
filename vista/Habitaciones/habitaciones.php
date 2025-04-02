<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../controller/habitacion/habitacionController.php';

$database = new Database();
$conn = $database->getConnection();
$controller = new HabitacionController($conn);

$habitaciones = $controller->obtenerHabitaciones();
if (!is_array($habitaciones)) {
    exit("Error al cargar las habitaciones");
}

$continentes = [
    1 => 'Europa',
    2 => 'América del Norte',
    3 => 'Sudamérica',
    4 => 'Asia',
    5 => 'África',
    6 => 'Oceanía',
    7 => 'Antártida'
];

$habitaciones_por_continente = [];
foreach ($habitaciones as $habitacion) {
    $continente = $continentes[$habitacion['Id_Continente']] ?? 'Desconocido';
    $habitaciones_por_continente[$continente][] = $habitacion;
}

$baseWebPath = '../../static';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Habitaciones - Hotel Calíope</title>
    <link rel="stylesheet" href="../../static/css/galeria.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/header.css">
    <link rel="stylesheet" href="../../static/css/GENERAL/footer.css">
</head>
<body>
    <header>
        <h1>Galería de Habitaciones</h1>
    </header>

    <div class="gallery-container">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">Todas las Habitaciones</button>
            <?php foreach ($habitaciones_por_continente as $continente => $habitaciones) : ?>
                <button class="filter-btn" data-filter="<?= strtolower(str_replace(' ', '', $continente)) ?>">
                    <?= htmlspecialchars($continente) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="gallery-grid">
            <?php foreach ($habitaciones_por_continente as $continente => $habitaciones) : ?>
                <div class="gallery-section <?= strtolower(str_replace(' ', '', $continente)) ?>">
                    <h2>Habitaciones en <?= htmlspecialchars($continente) ?></h2>
                    <div class="hotel-cards">
                        <?php foreach ($habitaciones as $habitacion) : ?>
                            <div class="hotel-card">
                                <img src="<?= $baseWebPath ?>/img/habitaciones/<?= htmlspecialchars($habitacion['Numero_Habitacion']) ?>.jpg" 
                                    alt="Habitación <?= htmlspecialchars($habitacion['Numero_Habitacion']) ?>">
                                <div class="hotel-info">
                                    <h3>Habitación <?= htmlspecialchars($habitacion['Numero_Habitacion']) ?></h3>
                                    <p>Tipo: <?= htmlspecialchars($habitacion['Tipo']) ?></p>
                                    <p>Capacidad: <?= htmlspecialchars($habitacion['Capacidad']) ?> personas</p>
                                    <p>Precio: $<?= htmlspecialchars($habitacion['Precio']) ?></p>
                                    <p><?= htmlspecialchars($habitacion['Descripcion']) ?></p>
                                    <a href="#" class="view-more">Ver detalles</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Hotel Calíope. Todos los derechos reservados.</p>
    </footer>
    <script src="../../static/js/galeria.js"></script>
</body>
</html>
