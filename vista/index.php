<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/b8a838b99b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;1,600&family=Luxurious+Roman&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Patrick+Hand&family=Permanent+Marker&family=Shadows+Into+Light&family=Staatliches&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/style.css">
    <title>Document</title>
</head>
<body>
    <header class="main-header">
        <img class="main-header-img" src="../static/img/florida/florida2 .jpg" alt="Fondo de California">
        <section class="main-up">
            <div class="main-up-left">
                <img src="../static/img/logo.png" alt="Imagen secundaria">
            </div>
            <div class="main-up-right">
                <div class="links">
                    <a href="#">Sobre nosotros</a>
                    <a href="#">Servicios</a>
                    <a href="#">Hoteles</a>
                </div>
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
                <h1>Haz tu reserva!</h1>
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


    <footer class="main-footer">

    </footer>
    <!-----------------------------------SCRIPTS---------------------------->
    <script src="../static/js/main.js"></script>
</body>
</html>