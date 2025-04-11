<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Hotel Calíope</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/static/css/common-css.css">
</head>
<body>
    <header class="booking-header">
        <div class="header-container">
            <!-- Logo -->
            <a href="/HotelCaliope2/index.php" class="brand-logo">
                <img src="../static/img/logo.png" alt="Logo Hotel Calíope" width="150">
            </a>
            
            <!-- Progreso de Reserva -->
            <div class="booking-progress">
                <div class="progress-step <?php echo ($currentStep >= 1) ? 'completed' : ''; ?>">
                    <span>1</span>
                    <p>Hotel</p>
                </div>
                <div class="progress-step <?php echo ($currentStep >= 2) ? 'completed' : ''; ?>">
                    <span>2</span>
                    <p>Habitación</p>
                </div>
                <div class="progress-step <?php echo ($currentStep >= 3) ? 'completed' : ''; ?>">
                    <span>3</span>
                    <p>Extra</p>
                </div>
                <div class="progress-step <?php echo ($currentStep >= 4) ? 'completed' : ''; ?>">
                    <span>4</span>
                    <p>Pago</p>
                </div>
                <div class="progress-step <?php echo ($currentStep >= 5) ? 'completed' : ''; ?>">
                    <span>5</span>
                    <p>Confirmarción</p>
                </div>
            </div>
            
            <!-- Asistencia -->
            <div class="header-assistance">
                <a href="tel:+123456789" class="assistance-link">
                    <i class="fas fa-headset"></i>
                    <span>Asistencia</span>
                </a>
                <div class="secure-badge">
                    <i class="fas fa-lock"></i>
                    <span>Seguro</span>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">