-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: HotelCaliope
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.23.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Actividades`
--

DROP TABLE IF EXISTS `Actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Actividades` (
  `Id_Actividades` int NOT NULL AUTO_INCREMENT,
  `Id_Hotel` int DEFAULT NULL,
  `Dia_Inicio` date DEFAULT NULL,
  `Dia_Fin` date DEFAULT NULL,
  `Hora_Inicio` time DEFAULT NULL,
  `Hora_Fin` time DEFAULT NULL,
  `Capacidad_Maxima` int DEFAULT NULL,
  `Ubicacion` varchar(255) DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`Id_Actividades`),
  KEY `hotelactividad_idx` (`Id_Hotel`),
  CONSTRAINT `hotelactividad` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actividades`
--

LOCK TABLES `Actividades` WRITE;
/*!40000 ALTER TABLE `Actividades` DISABLE KEYS */;
INSERT INTO `Actividades` VALUES (1,4,'2025-01-17','2025-01-23','10:00:00','12:00:00',20,'Sala de conferencias','Conferencia sobre tendencias tecnológicas',50.00,'Actividades para niños'),(2,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la PIsicina'),(3,4,'2025-01-20','2025-01-21','09:00:00','11:00:00',15,'Spa','Sesión de relajación en el spa',70.00,'Masaje reajante'),(4,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la Piscina'),(5,4,'2025-01-20','2025-01-20','09:00:00','12:00:00',20,'Gimnasio','Entrenamiento personal en el gimnasio',40.00,'Entrenamiento Personalizado'),(6,4,'2025-01-21','2025-01-21','10:00:00','12:00:00',25,'Spa','Masaje relajante en el spa',50.00,'Masaje Relajante'),(7,4,'2025-01-22','2025-01-22','18:00:00','20:00:00',50,'Restaurante','Cena temática con música en vivo',70.00,'Cena Temática');
/*!40000 ALTER TABLE `Actividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Administrador`
--

DROP TABLE IF EXISTS `Administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Administrador` (
  `Id_Administrador` int NOT NULL AUTO_INCREMENT,
  `Usuari` char(255) DEFAULT NULL,
  `Password` char(255) DEFAULT NULL,
  `Paraula_verificacio` char(10) DEFAULT NULL,
  PRIMARY KEY (`Id_Administrador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Administrador`
--

LOCK TABLES `Administrador` WRITE;
/*!40000 ALTER TABLE `Administrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `Administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Clients`
--

DROP TABLE IF EXISTS `Clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Clients` (
  `Id_Client` int NOT NULL AUTO_INCREMENT,
  `Nom` char(15) DEFAULT NULL,
  `Cognom` varchar(45) DEFAULT NULL,
  `DNI` char(9) DEFAULT NULL,
  `CorreuElectronic` varchar(255) DEFAULT NULL,
  `Telefon` int DEFAULT NULL,
  `Usuari` char(20) DEFAULT NULL,
  `Password` char(255) DEFAULT NULL,
  `Id_Pais` int DEFAULT NULL,
  `Ciudad` varchar(45) DEFAULT NULL,
  `CodigoPostal` int DEFAULT NULL,
  `Id_Pago` int DEFAULT NULL,
  PRIMARY KEY (`Id_Client`),
  KEY `paisclient_idx` (`Id_Pais`),
  KEY `pagoClient_idx` (`Id_Pago`),
  CONSTRAINT `pagoClient` FOREIGN KEY (`Id_Pago`) REFERENCES `Pago` (`Id_Pago`),
  CONSTRAINT `paisclient` FOREIGN KEY (`Id_Pais`) REFERENCES `Pais` (`Id_Pais`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clients`
--

LOCK TABLES `Clients` WRITE;
/*!40000 ALTER TABLE `Clients` DISABLE KEYS */;
INSERT INTO `Clients` VALUES (16,'Andrea','Garreta','48210716W','agarreta2@gmail.com',652331123,'Andrea','$2y$10$YCFlgk7mMF8b6mnwDsf2pOYmhuSNH6esxoAIaobyx4wa99yvb.Kbq',NULL,'Esparreguera',8292,NULL),(17,'Andrea','Garreta','48210716W','agarreta2@gmail.com',652331123,'Andrea','$2y$10$Uy.sRH3kWjjG7ZeP9i6U6ucXW9ytSkYFBkoPgl8kH3JdX20NhAzo.',NULL,'Esparreguera',8292,NULL),(18,'Prueba2','prueba','11122234L','aaaa@gmail.com',111222333,'Prueba2','$2y$10$T.AKd1IyIl0YV7BGhsWZAuWMxaQJQZn8lC61wQTDqbvTR3NmN2QEW',NULL,'Madrid',8292,NULL),(19,'admin','admin','11111111A','admin@hotelcaliope.cat',111111,'admin','$2y$10$7dUVdnx.HVIip3XQXbJDbey64js/zFlBFHpGfrrJoidRvihwAQWDy',NULL,'admin',11111,NULL),(20,'Bruno','Ostos','12345678N','prueba@gmail.com',12345623,'prueba','$2y$10$NP90IJqbZtn4Rnet/Uq8NOgURxKmncM6je2KsUnePyHGGXglDU7l.',NULL,'espa',8292,NULL);
/*!40000 ALTER TABLE `Clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Habitaciones`
--

DROP TABLE IF EXISTS `Habitaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Habitaciones` (
  `Id_Habitaciones` int NOT NULL AUTO_INCREMENT,
  `Numero_Habitacion` int DEFAULT NULL,
  `Tipo` varchar(45) DEFAULT NULL,
  `Capacidad` int DEFAULT NULL,
  `Precio` decimal(10,0) DEFAULT NULL,
  `Disponibilidad` tinyint DEFAULT NULL,
  `Id_Hotel` int DEFAULT NULL,
  `Id_Pais` int DEFAULT NULL,
  `Fecha_Disponibilidad_Inicio` date DEFAULT NULL,
  `Fecha_Disponibilidad_Fin` date DEFAULT NULL,
  `Descripcion` text,
  `Estado` enum('Disponible','Reservada','En Mantenimiento') DEFAULT 'Disponible',
  `Servicios_Adicionales` text,
  PRIMARY KEY (`Id_Habitaciones`),
  KEY `hotelhabitacion_idx` (`Id_Hotel`),
  KEY `Paishabitacion_idx` (`Id_Pais`),
  CONSTRAINT `hotelhabitacion` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `Paishabitacion` FOREIGN KEY (`Id_Pais`) REFERENCES `Pais` (`Id_Pais`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Habitaciones`
--

LOCK TABLES `Habitaciones` WRITE;
/*!40000 ALTER TABLE `Habitaciones` DISABLE KEYS */;
INSERT INTO `Habitaciones` VALUES (21,101,'Individual',1,120,0,1,1,'2025-02-21','2025-02-26','Habitación individual con cama pequeña','Reservada','WiFi, Aire acondicionado'),(22,102,'Doble',2,150,1,1,1,NULL,NULL,'Habitación doble con cama grande','Disponible','WiFi, Aire acondicionado, TV'),(23,103,'Triple',3,200,0,1,1,'2025-01-30','2025-02-06','Habitación triple con tres camas','Reservada','WiFi, Aire acondicionado, TV, Mini bar'),(24,104,'Cuádruple',4,250,1,1,1,NULL,NULL,'Habitación cuádruple con cuatro camas','Disponible','WiFi, Aire acondicionado, TV, Caja fuerte'),(25,105,'Individual',1,120,1,2,1,NULL,NULL,'Habitación individual con cama pequeña','Disponible','WiFi, Aire acondicionado'),(26,106,'Doble',2,160,1,2,1,NULL,NULL,'Habitación doble con cama grande','Disponible','WiFi, Aire acondicionado, TV, Caja fuerte'),(27,107,'Triple',3,180,1,2,1,NULL,NULL,'Habitación triple con tres camas','Disponible','WiFi, Aire acondicionado, TV'),(28,108,'Cuádruple',4,220,1,2,1,NULL,NULL,'Habitación cuádruple con cuatro camas','Disponible','WiFi, Aire acondicionado, TV, Mini bar'),(29,109,'Individual',1,100,0,3,2,'2025-01-29','2025-01-31','Habitación individual económica','Reservada','WiFi, Ventilador'),(30,110,'Doble',2,140,1,3,2,NULL,NULL,'Habitación doble económica','Disponible','WiFi, Ventilador, TV'),(31,111,'Triple',3,190,1,3,2,NULL,NULL,'Habitación triple económica','Disponible','WiFi, Ventilador, TV'),(32,112,'Cuádruple',4,230,0,3,2,'2025-02-06','2025-02-10','Habitación cuádruple económica','Reservada','WiFi, Ventilador, TV, Caja fuerte'),(33,113,'Individual',1,130,0,4,1,'2025-01-31','2025-02-10','Habitación individual con cama doble','Reservada','WiFi, Aire acondicionado, TV'),(34,114,'Doble',2,170,1,4,1,NULL,NULL,'Habitación doble con cama king','Disponible','WiFi, Aire acondicionado, TV, Mini bar'),(35,115,'Triple',3,210,1,4,1,NULL,NULL,'Habitación triple con camas individuales','Disponible','WiFi, Aire acondicionado, TV, Caja fuerte'),(36,116,'Cuádruple',4,240,1,4,1,NULL,NULL,'Habitación cuádruple con dos camas dobles','Disponible','WiFi, Aire acondicionado, TV, Mini bar'),(37,117,'Individual',1,110,1,5,1,NULL,NULL,'Habitación individual con cama grande','Disponible','WiFi, Aire acondicionado'),(38,118,'Doble',2,155,0,5,1,'2025-01-28','2025-01-31','Habitación doble con dos camas individuales','Reservada','WiFi, Aire acondicionado, TV'),(39,119,'Triple',3,200,0,5,1,'2025-01-31','2025-02-04','Habitación triple con una cama doble y una individual','Reservada','WiFi, Aire acondicionado, TV, Mini bar'),(40,120,'Cuádruple',4,260,0,5,1,'2025-02-10','2025-02-13','Habitación cuádruple con cuatro camas individuales','Reservada','WiFi, Aire acondicionado, TV, Caja fuerte');
/*!40000 ALTER TABLE `Habitaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hotel`
--

DROP TABLE IF EXISTS `Hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Hotel` (
  `Id_Hotel` int NOT NULL AUTO_INCREMENT,
  `Nombre` char(45) DEFAULT NULL,
  `CorreoElectronico` varchar(255) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `CodigoPostal` int DEFAULT NULL,
  `Id_Pais` int DEFAULT NULL,
  `Ciudad` varchar(45) DEFAULT NULL,
  `Estrellas` int DEFAULT NULL,
  PRIMARY KEY (`Id_Hotel`),
  KEY `paishotel_idx` (`Id_Pais`),
  CONSTRAINT `paishotel` FOREIGN KEY (`Id_Pais`) REFERENCES `Pais` (`Id_Pais`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hotel`
--

LOCK TABLES `Hotel` WRITE;
/*!40000 ALTER TABLE `Hotel` DISABLE KEYS */;
INSERT INTO `Hotel` VALUES (1,'Hotel Caliope Galicia','galicia@hotelcaliope.com','+34 987 654 321','Avenida de la Costa, 123',15700,1,'Santiago de Compostela',5),(2,'Hotel Caliope Tossa de Mar','tossademar@hotelcaliope.com','+34 972 34 56 78','Carrer del Mar, 456',17320,1,'Tossa de Mar',5),(3,'Hotel Caliope Pirineos','pirineos@hotelcaliope.com','+34 974 32 44 56','Carrer de la Muntanya, 789',22600,1,'Benasque',5),(4,'Hotel Caliope Florida','florida@hotelcaliope.com','+1 305 123 4567','1234 Ocean Drive',33139,2,'Miami',5),(5,'Hotel Caliope California','california@hotelcaliope.com','+1 415 987 6543','4567 Sunset Boulevard',94110,2,'San Francisco',5),(6,'Hotel Caliope Nueva York','newyork@hotelcaliope.com','+1 212 123 9876','789 Broadway Street',10001,2,'New York',5);
/*!40000 ALTER TABLE `Hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MetodoPago`
--

DROP TABLE IF EXISTS `MetodoPago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MetodoPago` (
  `Id_MetodoPago` int NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(255) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`Id_MetodoPago`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MetodoPago`
--

LOCK TABLES `MetodoPago` WRITE;
/*!40000 ALTER TABLE `MetodoPago` DISABLE KEYS */;
INSERT INTO `MetodoPago` VALUES (1,'Tarjeta de Crédito','Pago a través de tarjeta de crédito o débito',1),(2,'PayPal','Pago utilizando cuenta de PayPal',1),(11,'Transferencia Bancaria','Pago mediante transferencia desde una cuenta bancaria',1);
/*!40000 ALTER TABLE `MetodoPago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ofertas`
--

DROP TABLE IF EXISTS `Ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ofertas` (
  `Id_Oferta` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Tipo` varchar(45) DEFAULT NULL,
  `Dia_Inicio` date DEFAULT NULL,
  `Dia_Fin` date DEFAULT NULL,
  `Precio_Original` decimal(10,0) DEFAULT NULL,
  `Precio_Oferta` decimal(10,0) DEFAULT NULL,
  `Estado` tinyint DEFAULT NULL,
  `Id_Hotel` int DEFAULT NULL,
  `Id_Habitacion` int DEFAULT NULL,
  `Id_Actividad` int DEFAULT NULL,
  PRIMARY KEY (`Id_Oferta`),
  KEY `ofertahotel_idx` (`Id_Hotel`),
  KEY `ofertaactividad_idx` (`Id_Actividad`),
  KEY `ofertahabitacion_idx` (`Id_Habitacion`),
  CONSTRAINT `ofertaactividad` FOREIGN KEY (`Id_Actividad`) REFERENCES `Actividades` (`Id_Actividades`),
  CONSTRAINT `ofertahabitacion` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`),
  CONSTRAINT `ofertahotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ofertas`
--

LOCK TABLES `Ofertas` WRITE;
/*!40000 ALTER TABLE `Ofertas` DISABLE KEYS */;
/*!40000 ALTER TABLE `Ofertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pago`
--

DROP TABLE IF EXISTS `Pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pago` (
  `Id_Pago` int NOT NULL AUTO_INCREMENT,
  `Id_Hotel` int DEFAULT NULL,
  `Id_Cliente` int DEFAULT NULL,
  `Id_Reserva` int DEFAULT NULL,
  `MetodoPago` varchar(255) NOT NULL,
  `Fecha_Pago` datetime NOT NULL,
  `Id_MetodoPago` int DEFAULT NULL,
  PRIMARY KEY (`Id_Pago`),
  KEY `pagohotel_idx` (`Id_Hotel`),
  KEY `pagocliente_idx` (`Id_Cliente`),
  KEY `pagoreserva_idx` (`Id_Reserva`),
  KEY `pagometodo_idx` (`Id_MetodoPago`),
  CONSTRAINT `FK_Id_MetodoPago` FOREIGN KEY (`Id_MetodoPago`) REFERENCES `MetodoPago` (`Id_MetodoPago`),
  CONSTRAINT `fk_pago_reservas` FOREIGN KEY (`Id_Reserva`) REFERENCES `Reservas` (`Id_Reserva`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pagocliente` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clients` (`Id_Client`),
  CONSTRAINT `pagohotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `pagometodo` FOREIGN KEY (`Id_MetodoPago`) REFERENCES `MetodoPago` (`Id_MetodoPago`),
  CONSTRAINT `pagoreserva` FOREIGN KEY (`Id_Reserva`) REFERENCES `Reservas` (`Id_Reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pago`
--

LOCK TABLES `Pago` WRITE;
/*!40000 ALTER TABLE `Pago` DISABLE KEYS */;
INSERT INTO `Pago` VALUES (55,1,16,39,'Tarjeta','2025-02-07 17:19:29',NULL);
/*!40000 ALTER TABLE `Pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pais`
--

DROP TABLE IF EXISTS `Pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Pais` (
  `Id_Pais` int NOT NULL AUTO_INCREMENT,
  `Pais` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id_Pais`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pais`
--

LOCK TABLES `Pais` WRITE;
/*!40000 ALTER TABLE `Pais` DISABLE KEYS */;
INSERT INTO `Pais` VALUES (1,'España'),(2,'USA'),(3,'Portugal');
/*!40000 ALTER TABLE `Pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservas`
--

DROP TABLE IF EXISTS `Reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reservas` (
  `Id_Reserva` int NOT NULL AUTO_INCREMENT,
  `Id_Cliente` int DEFAULT NULL,
  `Id_Actividad` int DEFAULT NULL,
  `Id_Habitacion` int DEFAULT NULL,
  `Id_Hotel` int DEFAULT NULL,
  `Id_Tarifa` int DEFAULT NULL,
  `Precio_Habitacion` decimal(10,0) DEFAULT NULL,
  `Precio_Actividad` decimal(10,0) DEFAULT NULL,
  `Precio_Tarifa` decimal(10,0) DEFAULT NULL,
  `Precio_Total` decimal(10,0) DEFAULT NULL,
  `Checkin` date NOT NULL,
  `Checkout` date NOT NULL,
  `Numero_Personas` int NOT NULL DEFAULT '1',
  `Id_Pais` varchar(45) DEFAULT NULL,
  `Estado` enum('Por pagar','Pagado','Cancelado') DEFAULT NULL,
  PRIMARY KEY (`Id_Reserva`),
  KEY `reservacliente_idx` (`Id_Cliente`),
  KEY `reservaactividad_idx` (`Id_Actividad`),
  KEY `reservahabitacion_idx` (`Id_Habitacion`),
  KEY `reservahotel_idx` (`Id_Hotel`),
  KEY `reservaclient_idx` (`Id_Cliente`),
  KEY `actividad_idx` (`Id_Actividad`),
  KEY `reservahabita_idx` (`Id_Habitacion`),
  KEY `hotel_idx` (`Id_Hotel`),
  KEY `reservatarifa_idx` (`Id_Tarifa`),
  KEY `hotelreserv_idx` (`Id_Hotel`),
  KEY `client_idx` (`Id_Cliente`),
  KEY `habita_idx` (`Id_Habitacion`),
  KEY `tarifas_idx` (`Id_Tarifa`),
  KEY `actividat_idx` (`Id_Actividad`),
  CONSTRAINT `actividat` FOREIGN KEY (`Id_Actividad`) REFERENCES `Actividades` (`Id_Actividades`),
  CONSTRAINT `client` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clients` (`Id_Client`),
  CONSTRAINT `fk_reservas_habitaciones` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `habita` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE,
  CONSTRAINT `hotelreserv` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `tarifas` FOREIGN KEY (`Id_Tarifa`) REFERENCES `Tarifa` (`Id_Tarifa`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservas`
--

LOCK TABLES `Reservas` WRITE;
/*!40000 ALTER TABLE `Reservas` DISABLE KEYS */;
INSERT INTO `Reservas` VALUES (39,16,NULL,21,1,NULL,100,0,20,120,'2025-02-21','2025-02-26',13,'1',NULL);
/*!40000 ALTER TABLE `Reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Servicio`
--

DROP TABLE IF EXISTS `Servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Servicio` (
  `Id_Servicio` int NOT NULL,
  `Id_Hotel` int DEFAULT NULL,
  `Servicio` varchar(255) DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`Id_Servicio`),
  KEY `hotel_idx` (`Id_Hotel`),
  CONSTRAINT `fk_servicio_hotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Servicio`
--

LOCK TABLES `Servicio` WRITE;
/*!40000 ALTER TABLE `Servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `Servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tarifa`
--

DROP TABLE IF EXISTS `Tarifa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tarifa` (
  `Id_Tarifa` int NOT NULL,
  `Id_Hotel` int DEFAULT NULL,
  `Id_Habitacion` int DEFAULT NULL,
  `Id_Actividad` int DEFAULT NULL,
  `Id_Servicios` int DEFAULT NULL,
  `Tipo_Habitacion` varchar(45) DEFAULT NULL,
  `Temporada` varchar(45) DEFAULT NULL,
  `Precio` int DEFAULT NULL,
  PRIMARY KEY (`Id_Tarifa`),
  KEY `TarifaHotel_idx` (`Id_Hotel`),
  KEY `TarifaHabitacion_idx` (`Id_Habitacion`),
  KEY `TarifaActividad_idx` (`Id_Actividad`),
  KEY `TarifaServicios_idx` (`Id_Servicios`),
  CONSTRAINT `TarifaActividad` FOREIGN KEY (`Id_Actividad`) REFERENCES `Actividades` (`Id_Actividades`),
  CONSTRAINT `TarifaHabitacion` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`),
  CONSTRAINT `TarifaHotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `TarifaServicios` FOREIGN KEY (`Id_Servicios`) REFERENCES `Servicio` (`Id_Servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tarifa`
--

LOCK TABLES `Tarifa` WRITE;
/*!40000 ALTER TABLE `Tarifa` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tarifa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TarifaReserva`
--

DROP TABLE IF EXISTS `TarifaReserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `TarifaReserva` (
  `Id_TarifaReserva` int NOT NULL,
  `Id_Tarifa` int DEFAULT NULL,
  `Id_Servicio` int DEFAULT NULL,
  `Fecha_Contratacion` date DEFAULT NULL,
  `Id_MetodoPago` int DEFAULT NULL,
  PRIMARY KEY (`Id_TarifaReserva`),
  KEY `Ttarifa_idx` (`Id_Tarifa`),
  KEY `TServicio_idx` (`Id_Servicio`),
  KEY `TMetodoPago_idx` (`Id_MetodoPago`),
  CONSTRAINT `TServicio` FOREIGN KEY (`Id_Servicio`) REFERENCES `Servicio` (`Id_Servicio`),
  CONSTRAINT `Ttarifa` FOREIGN KEY (`Id_Tarifa`) REFERENCES `Tarifa` (`Id_Tarifa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TarifaReserva`
--

LOCK TABLES `TarifaReserva` WRITE;
/*!40000 ALTER TABLE `TarifaReserva` DISABLE KEYS */;
/*!40000 ALTER TABLE `TarifaReserva` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-17 18:41:22