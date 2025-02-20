# HotelCaliope
Realización de una pagina web para un hotel ficticio

Para que la base de datos tenga conexion, se tiene que llmar igual que como indica el codigo, en este caso HotelCaliope

private $dbname = "HotelCaliope"

Para comprobar que la conexion a la base de datos funciona correctamente, tienes que ir a tu localhost y abrir sirectamente el archivo:

         test_conexion.php

-------------------------------------- FALTA / MODIFICAR ------------------------------------------------------

- Hay que poner carrusel de fotos en el header y la parte de reserva
- Hay que modificar para que puedan elegir cuantas perosnas van y el tipo(niño,adulto...)
- En la parte de descripcion de index.php, añadir carrusel con fotos de distintos lugares.✅
- Poner en para buscar habitacions lo siguiente: fecha llegada, fecha salida, ciudad,tipo(elegir entre habitacion y actividad).(si el usuario elige habitacion le       aparecera el tipo de habitacion, si elige actividad le tiene que salir cuantas personas son).

- POLTICAS DE PRIVACIDAD 









---------------------------------------LINKS UTILES----------------------------------
https://www.html6.es
https://fontawesome.com --> ICONOS

---------------------------------------IMPORTANTE-------------------------------------

- Los width son de 80% y margin auto, para que sea todo igual.
- Los SCRIPTS ponerlos abajo del codigo, si no NO FUNCIONA!


Comando para arreglar lo del commit

git pull --tags origin main --no-rebase





------------------------------------------------MYSQL-----------------------------------------
CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_reservas`()
BEGIN
    DELETE FROM Reservas WHERE Checkout < NOW();
END
