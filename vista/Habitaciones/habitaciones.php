<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
    <head>

        <!--ESTILOS-->
        <link rel="stylesheet" href="../../static/css/ofertas.css">

        <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Old+Standard+TT:ital,wght@0,400;0,700;1,400&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Mate+SC&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Oswald:wght@200..700&family=Patrick+Hand&family=Permanent+Marker&family=Rancho&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../static/css/style.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
        <title>Document</title>
    </head>
    <body>
        <header class="main-header">
            <div class="carousel">
                <img class="carousel-background" src="../../static/img/habitaciones/hab1.jpg" alt="Fondo 1">
                <img class="carousel-background" src="../../static/img/habitaciones/hab3.jpg" alt="Fondo 2">
                <img class="carousel-background" src="../../static/img/habitaciones/hab2.jpg" alt="Fondo 3">
            </div>
        
            <section class="main-up">
                <div class="main-up-left">
                   <a href="../index.php"><img src="../../static/img/logo.png" alt="Imagen secundaria"></a> 
                </div>
                <div class="main-up-right">
                    <div class="links">
                        <a href="#">Sobre nosotros</a>
                        <a href="#">Servicios</a>
                        <div class="dropdown">
                            <a href="#" class="dropbtn">Hoteles</a>
                            <div class="dropdown-content">
                                <div class="dropdown-section">
                                    <h4>Europa</h4>
                                    <a href="../vista/ciudades/Europa/Galicia.php">Galicia</a>
                                    <a href="#">Tossa de Mar</a>
                                    <a href="#">Pirineos</a>
                                </div>
                                <div class="dropdown-section">
                                    <h4>USA</h4>
                                    <a href="#">Florida</a>
                                    <a href="#">California</a>
                                    <a href="#">Nueva York</a>
                                </div>
                            </div>
                        </div>
                    <a href="../ofertas/ofertas.php">Ofertas</a>
                </div>
            

            </section>
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
                    
                    <div class="formulario">
                        <form action="" method="post">
                            <label for="checkin">Fecha de Llegada:</label>
                            <input type="date" id="checkin" name="checkin" required>
                            <label for="checkout">Fecha de Salida:</label>
                            <input type="date" id="checkout" name="checkout" required>
                            <label for="tipo_habitacion">Tipo de Habitación:</label>
                            <select id="tipo_habitacion" name="tipo_habitacion" required>
                                <option value="sencilla">Sencilla</option>
                                <option value="doble">Doble</option>
                                <option value="suite">Suite</option>
                            </select>
                            <button type="submit">Reservar Ahora</button>
                        </form>
                    </div>
                </div>
        
            
            </section>
        </header>
    </body>
</html>