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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actividades`
--

LOCK TABLES `Actividades` WRITE;
/*!40000 ALTER TABLE `Actividades` DISABLE KEYS */;
INSERT INTO `Actividades` VALUES (1,4,'2025-01-17','2025-01-23','10:00:00','12:00:00',20,'Sala de conferencias','Conferencia sobre tendencias tecnológicas',50.00,'Actividades para niños'),(2,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la PIsicina'),(3,4,'2025-01-20','2025-01-21','09:00:00','11:00:00',15,'Spa','Sesión de relajación en el spa',70.00,'Masaje reajante'),(4,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la Piscina'),(5,4,'2025-01-20','2025-01-20','09:00:00','12:00:00',20,'Gimnasio','Entrenamiento personal en el gimnasio',40.00,'Entrenamiento Personalizado'),(6,4,'2025-01-21','2025-01-21','10:00:00','12:00:00',25,'Spa','Masaje relajante en el spa',50.00,'Masaje Relajante'),(7,4,'2025-01-22','2025-01-22','18:00:00','20:00:00',50,'Restaurante','Cena temática con música en vivo',70.00,'Cena Temática'),(8,1,'2025-01-10','2025-01-15','10:00:00','12:00:00',20,'Sala de conferencias','Charla sobre innovación tecnológica',55.00,'Innovación y Tecnología'),(9,2,'2025-01-12','2025-01-14','14:00:00','16:00:00',30,'Piscina','Clase de aqua fitness',35.00,'Aqua Fitness'),(10,3,'2025-01-15','2025-01-16','09:00:00','11:00:00',15,'Spa','Sesión de aromaterapia',65.00,'Aromaterapia Relajante'),(11,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la Piscina'),(12,5,'2025-01-20','2025-01-20','09:00:00','12:00:00',20,'Gimnasio','Entrenamiento funcional',45.00,'Entrenamiento Funcional'),(13,6,'2025-01-21','2025-01-21','10:00:00','12:00:00',25,'Spa','Masaje de piedras calientes',75.00,'Masaje con Piedras'),(14,1,'2025-01-22','2025-01-22','18:00:00','20:00:00',50,'Restaurante','Cena gourmet con maridaje',90.00,'Cena Gourmet'),(15,2,'2025-02-10','2025-02-10','16:00:00','18:00:00',40,'Terraza','Cata de vinos con sommelier',85.00,'Cata de Vinos'),(16,3,'2025-02-12','2025-02-13','10:00:00','12:00:00',30,'Sala de eventos','Conferencia sobre sostenibilidad',50.00,'Sostenibilidad Ambiental'),(17,4,'2025-02-14','2025-02-14','20:00:00','22:00:00',60,'Jardín','Noche de cine al aire libre',25.00,'Cine Bajo las Estrellas'),(18,5,'2025-02-15','2025-02-15','08:00:00','10:00:00',20,'Playa','Clase de surf para principiantes',40.00,'Surf para Principiantes'),(19,6,'2025-02-16','2025-02-16','17:00:00','19:00:00',35,'Salón de baile','Clase de salsa y bachata',30.00,'Baile Latino'),(20,1,'2025-02-17','2025-02-17','11:00:00','13:00:00',25,'Spa','Taller de meditación y mindfulness',60.00,'Meditación y Mindfulness'),(21,2,'2025-02-18','2025-02-18','19:00:00','21:00:00',40,'Restaurante','Cena con show en vivo',80.00,'Cena Espectáculo'),(22,3,'2025-02-19','2025-02-19','15:00:00','17:00:00',50,'Piscina','Fiesta en la piscina con DJ',50.00,'Pool Party'),(23,4,'2025-02-20','2025-02-20','09:00:00','11:00:00',30,'Gimnasio','Clase de entrenamiento funcional',35.00,'Full Body Workout'),(24,5,'2025-02-21','2025-02-21','14:00:00','16:00:00',20,'Spa','Masaje tailandés de relajación',70.00,'Masaje Tailandés'),(25,6,'2025-02-22','2025-02-22','18:00:00','20:00:00',60,'Teatro','Obra de teatro interactiva',100.00,'Teatro en Vivo');
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clients`
--

LOCK TABLES `Clients` WRITE;
/*!40000 ALTER TABLE `Clients` DISABLE KEYS */;
INSERT INTO `Clients` VALUES (16,'Andrea','Garreta','48210716W','agarreta2@gmail.com',652331123,'Andrea','$2y$10$YCFlgk7mMF8b6mnwDsf2pOYmhuSNH6esxoAIaobyx4wa99yvb.Kbq',NULL,'Esparreguera',8292,NULL),(17,'Andrea','Garreta','48210716W','agarreta2@gmail.com',652331123,'Andrea','$2y$10$Uy.sRH3kWjjG7ZeP9i6U6ucXW9ytSkYFBkoPgl8kH3JdX20NhAzo.',NULL,'Esparreguera',8292,NULL),(18,'Prueba2','prueba','11122234L','aaaa@gmail.com',111222333,'Prueba2','$2y$10$T.AKd1IyIl0YV7BGhsWZAuWMxaQJQZn8lC61wQTDqbvTR3NmN2QEW',NULL,'Madrid',8292,NULL),(19,'admin','admin','11111111A','admin@hotelcaliope.cat',111111,'admin','$2y$10$7dUVdnx.HVIip3XQXbJDbey64js/zFlBFHpGfrrJoidRvihwAQWDy',NULL,'admin',11111,NULL),(20,'Bruno','Ostos','12345678N','prueba@gmail.com',12345623,'prueba','$2y$10$NP90IJqbZtn4Rnet/Uq8NOgURxKmncM6je2KsUnePyHGGXglDU7l.',NULL,'espa',8292,NULL),(21,'Raul','prueba','73628362L','hola@gmail.com',671229963,'Raul2','$2y$10$sohXSw.qynOMPUx4htl/lOFOuHLkZ4Y898JfEPW1FIIOxXxtLPHw.',NULL,'Esparreguera',8292,NULL),(22,'Josep','prueba','8273628L','prueba@gmail.com',725118292,'Josep','$2y$10$mDYFq52t.k9MhqoSC8qyA..S8LLgkWnInRMqxuCNj21C80/n5CpaO',NULL,'Esparreguera',8292,NULL),(23,'Andrea','Fernandez','48518293T','prueba@gmail.com',123332211,'AndreaG','$2y$10$z6AhEhvzzznTXXpaedzyCedf16j2LWO5DLU7LECRuyqU5HUocF38G',NULL,'3',2922,NULL);
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
  `Id_Hotel` int DEFAULT NULL,
  `Id_Pais` int DEFAULT NULL,
  `Descripcion` text,
  `Servicios_Adicionales` text,
  PRIMARY KEY (`Id_Habitaciones`),
  KEY `hotelhabitacion_idx` (`Id_Hotel`),
  KEY `Paishabitacion_idx` (`Id_Pais`),
  KEY `idx_precio` (`Precio`),
  CONSTRAINT `hotelhabitacion` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `Paishabitacion` FOREIGN KEY (`Id_Pais`) REFERENCES `Pais` (`Id_Pais`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Habitaciones`
--

LOCK TABLES `Habitaciones` WRITE;
/*!40000 ALTER TABLE `Habitaciones` DISABLE KEYS */;
INSERT INTO `Habitaciones` VALUES (1,101,'Individual',1,100,1,1,'Habitación individual con una cama.','WiFi gratuito'),(2,102,'Doble',2,999,1,1,'Habitación doble con dos camas.','WiFi gratuito, Desayuno incluido'),(3,201,'Triple',3,200,1,2,'Habitación triple con vista al mar.','WiFi gratuito'),(4,202,'Cuádruple',4,250,1,2,'Habitación cuádruple con balcón.','WiFi gratuito, Desayuno incluido'),(5,301,'Individual',1,110,2,1,'Habitación individual con decoración moderna.','WiFi gratuito'),(6,302,'Doble',2,160,2,1,'Habitación doble con minibar.','WiFi gratuito, Desayuno incluido'),(7,401,'Triple',3,210,3,2,'Habitación triple con vistas a la ciudad.','WiFi gratuito'),(8,402,'Cuádruple',4,260,3,2,'Habitación cuádruple con cocina.','WiFi gratuito, Desayuno incluido'),(9,501,'Individual',1,120,4,1,'Habitación individual con escritorio.','WiFi gratuito'),(10,502,'Doble',2,170,4,1,'Habitación doble con vista al jardín.','WiFi gratuito, Desayuno incluido'),(11,601,'Triple',3,220,5,2,'Habitación triple con jacuzzi.','WiFi gratuito, Desayuno incluido'),(12,602,'Cuádruple',4,280,5,2,'Habitación cuádruple amplia.','WiFi gratuito, Desayuno incluido'),(13,701,'Individual',1,130,6,1,'Habitación individual con balcón.','WiFi gratuito'),(14,702,'Doble',2,190,6,1,'Habitación doble con vistas al jardín.','WiFi gratuito, Desayuno incluido');
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
  CONSTRAINT `idmetodoPago` FOREIGN KEY (`Id_MetodoPago`) REFERENCES `MetodoPago` (`Id_MetodoPago`),
  CONSTRAINT `pagocliente` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clients` (`Id_Client`),
  CONSTRAINT `pagohotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `pagometodo` FOREIGN KEY (`Id_MetodoPago`) REFERENCES `MetodoPago` (`Id_MetodoPago`),
  CONSTRAINT `pagoreserva` FOREIGN KEY (`Id_Reserva`) REFERENCES `Reservas` (`Id_Reserva`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pago`
--

LOCK TABLES `Pago` WRITE;
/*!40000 ALTER TABLE `Pago` DISABLE KEYS */;
INSERT INTO `Pago` VALUES (97,2,NULL,93,'Tarjeta','2025-03-06 19:08:19',1),(98,5,19,94,'Tarjeta','2025-03-06 19:14:00',1),(99,4,19,95,'Tarjeta','2025-03-06 19:50:10',NULL),(100,3,19,96,'Tarjeta','2025-03-10 17:01:07',NULL),(101,2,19,97,'Tarjeta','2025-03-10 17:02:20',NULL),(102,2,19,98,'Tarjeta','2025-03-10 17:30:19',NULL),(103,4,19,99,'Tarjeta','2025-03-10 17:42:11',NULL),(104,2,19,100,'Tarjeta','2025-03-10 17:46:53',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pais`
--

LOCK TABLES `Pais` WRITE;
/*!40000 ALTER TABLE `Pais` DISABLE KEYS */;
INSERT INTO `Pais` VALUES (1,'España'),(2,'USA'),(3,'Afganistán'),(4,'Albania'),(5,'Alemania'),(6,'Andorra'),(7,'Angola'),(8,'Antigua y Barbuda'),(9,'Arabia Saudita'),(10,'Argelia'),(11,'Argentina'),(12,'Armenia'),(13,'Australia'),(14,'Austria'),(15,'Azerbaiyán'),(16,'Bahamas'),(17,'Bangladés'),(18,'Barbados'),(19,'Baréin'),(20,'Bélgica'),(21,'Belice'),(22,'Benín'),(23,'Bielorrusia'),(24,'Birmania'),(25,'Bolivia'),(26,'Bosnia y Herzegovina'),(27,'Botsuana'),(28,'Brasil'),(29,'Brunéi'),(30,'Bulgaria'),(31,'Burkina Faso'),(32,'Burundi'),(33,'Bután'),(34,'Cabo Verde'),(35,'Camboya'),(36,'Camerún'),(37,'Canadá'),(38,'Catar'),(39,'Chad'),(40,'Chile'),(41,'China'),(42,'Chipre'),(43,'Colombia'),(44,'Comoras'),(45,'Corea del Norte'),(46,'Corea del Sur'),(47,'Costa de Marfil'),(48,'Costa Rica'),(49,'Croacia'),(50,'Cuba'),(51,'Dinamarca'),(52,'Dominica'),(53,'Ecuador'),(54,'Egipto'),(55,'El Salvador'),(56,'Emiratos Árabes Unidos'),(57,'Eritrea'),(58,'Eslovaquia'),(59,'Eslovenia'),(60,'Esuatini'),(61,'Estonia'),(62,'Etiopía'),(63,'Filipinas'),(64,'Finlandia'),(65,'Fiyi'),(66,'Francia'),(67,'Gabón'),(68,'Gambia'),(69,'Georgia'),(70,'Ghana'),(71,'Granada'),(72,'Grecia'),(73,'Guatemala'),(74,'Guyana'),(75,'Guinea'),(76,'Guinea-Bisáu'),(77,'Guinea Ecuatorial'),(78,'Haití'),(79,'Honduras'),(80,'Hungría'),(81,'India'),(82,'Indonesia'),(83,'Irak'),(84,'Irán'),(85,'Irlanda'),(86,'Islandia'),(87,'Islas Marshall'),(88,'Islas Salomón'),(89,'Israel'),(90,'Italia'),(91,'Jamaica'),(92,'Japón'),(93,'Jordania'),(94,'Kazajistán'),(95,'Kenia'),(96,'Kirguistán'),(97,'Kiribati'),(98,'Kuwait'),(99,'Laos'),(100,'Lesoto'),(101,'Letonia'),(102,'Líbano'),(103,'Liberia'),(104,'Libia'),(105,'Liechtenstein'),(106,'Lituania'),(107,'Luxemburgo'),(108,'Madagascar'),(109,'Malasia'),(110,'Malaui'),(111,'Maldivas'),(112,'Malí'),(113,'Malta'),(114,'Marruecos'),(115,'Mauricio'),(116,'Mauritania'),(117,'México'),(118,'Micronesia'),(119,'Moldavia'),(120,'Mónaco'),(121,'Mongolia'),(122,'Montenegro'),(123,'Mozambique'),(124,'Namibia'),(125,'Nauru'),(126,'Nepal'),(127,'Nicaragua'),(128,'Níger'),(129,'Nigeria'),(130,'Noruega'),(131,'Nueva Zelanda'),(132,'Omán'),(133,'Países Bajos'),(134,'Pakistán'),(135,'Palaos'),(136,'Panamá'),(137,'Papúa Nueva Guinea'),(138,'Paraguay'),(139,'Perú'),(140,'Polonia'),(141,'Portugal'),(142,'Reino Unido'),(143,'República Centroafricana'),(144,'República Checa'),(145,'República del Congo'),(146,'República Democrática del Congo'),(147,'República Dominicana'),(148,'Ruanda'),(149,'Rumania'),(150,'Rusia'),(151,'Samoa'),(152,'San Cristóbal y Nieves'),(153,'San Marino'),(154,'San Vicente y las Granadinas'),(155,'Santa Lucía'),(156,'Santo Tomé y Príncipe'),(157,'Senegal'),(158,'Serbia'),(159,'Seychelles'),(160,'Sierra Leona'),(161,'Singapur'),(162,'Siria'),(163,'Somalia'),(164,'Sri Lanka'),(165,'Sudáfrica'),(166,'Sudán'),(167,'Sudán del Sur'),(168,'Suecia'),(169,'Suiza'),(170,'Surinam'),(171,'Tailandia'),(172,'Tanzania'),(173,'Tayikistán'),(174,'Timor Oriental'),(175,'Togo'),(176,'Tonga'),(177,'Trinidad y Tobago'),(178,'Túnez'),(179,'Turkmenistán'),(180,'Turquía'),(181,'Tuvalu'),(182,'Ucrania'),(183,'Uganda'),(184,'Uruguay'),(185,'Uzbekistán'),(186,'Vanuatu'),(187,'Vaticano'),(188,'Venezuela'),(189,'Vietnam'),(190,'Yemen'),(191,'Yibuti'),(192,'Zambia'),(193,'Zimbabue');
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
  `Id_Servicio` int DEFAULT NULL,
  `Id_Tarifa` int DEFAULT NULL,
  `Precio_Habitacion` decimal(10,0) DEFAULT NULL,
  `Precio_Actividad` decimal(10,0) DEFAULT NULL,
  `Precio_Tarifa` decimal(10,0) DEFAULT NULL,
  `Precio_Servicio` decimal(10,0) DEFAULT NULL,
  `Precio_Total` decimal(10,0) DEFAULT NULL,
  `Checkin` date NOT NULL,
  `Checkout` date NOT NULL,
  `Numero_Personas` int NOT NULL DEFAULT '1',
  `Id_Pais` varchar(45) DEFAULT NULL,
  `Estado` enum('Por pagar','Pagado','Cancelado') DEFAULT NULL,
  `FechaCancelacion` datetime DEFAULT NULL,
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
  KEY `precioHab_idx` (`Precio_Habitacion`),
  KEY `servicios_idx` (`Id_Servicio`),
  KEY `precioServ_idx` (`Precio_Servicio`),
  CONSTRAINT `actividat` FOREIGN KEY (`Id_Actividad`) REFERENCES `Actividades` (`Id_Actividades`),
  CONSTRAINT `client` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clients` (`Id_Client`),
  CONSTRAINT `fk_habitacion` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`),
  CONSTRAINT `fk_reservas_habitaciones` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `habita` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE,
  CONSTRAINT `hotelreserv` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `precioHab` FOREIGN KEY (`Precio_Habitacion`) REFERENCES `Habitaciones` (`Precio`),
  CONSTRAINT `servicios` FOREIGN KEY (`Id_Servicio`) REFERENCES `Servicio` (`Id_Servicio`),
  CONSTRAINT `tarifas` FOREIGN KEY (`Id_Tarifa`) REFERENCES `Tarifa` (`Id_Tarifa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservas`
--

LOCK TABLES `Reservas` WRITE;
/*!40000 ALTER TABLE `Reservas` DISABLE KEYS */;
INSERT INTO `Reservas` VALUES (93,NULL,NULL,5,2,NULL,NULL,100,0,0,NULL,300,'2025-03-07','2025-03-10',2,'1','Pagado',NULL),(94,19,NULL,11,5,NULL,NULL,100,0,0,NULL,500,'2025-03-14','2025-03-19',2,'2','Pagado',NULL),(95,19,NULL,9,4,NULL,NULL,100,0,0,NULL,300,'2025-03-07','2025-03-10',2,'2','Pagado',NULL),(96,19,NULL,7,3,NULL,NULL,100,0,0,0,200,'2025-03-11','2025-03-13',2,'1','Pagado',NULL),(97,19,NULL,5,2,NULL,NULL,100,0,0,0,200,'2025-03-10','2025-03-12',2,'1','Pagado',NULL),(98,19,NULL,5,2,NULL,NULL,100,0,0,0,300,'2025-03-12','2025-03-15',2,'1','Pagado',NULL),(99,19,NULL,9,4,NULL,NULL,100,0,0,0,200,'2025-03-11','2025-03-13',2,'2','Pagado',NULL),(100,19,NULL,5,2,NULL,NULL,100,0,0,0,300,'2025-03-11','2025-03-14',2,'1','Pagado',NULL);
/*!40000 ALTER TABLE `Reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Servicio`
--

DROP TABLE IF EXISTS `Servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Servicio` (
  `Id_Servicio` int NOT NULL AUTO_INCREMENT,
  `Id_Hotel` int DEFAULT NULL,
  `Servicio` varchar(255) DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`Id_Servicio`),
  KEY `hotel_idx` (`Id_Hotel`),
  CONSTRAINT `fk_servicio_hotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Servicio`
--

LOCK TABLES `Servicio` WRITE;
/*!40000 ALTER TABLE `Servicio` DISABLE KEYS */;
INSERT INTO `Servicio` VALUES (1,1,'Limpieza','Servicio de limpieza diaria de habitaciones',15),(2,1,'Spa','Acceso a la zona de spa y masajes relajantes',50),(3,1,'Parking','Estacionamiento privado para huéspedes',10),(4,1,'Taxi','Servicio de taxi disponible 24/7',5),(5,2,'Limpieza','Servicio de limpieza diaria de habitaciones',12),(6,2,'Spa','Acceso a la zona de spa y tratamientos faciales',55),(7,2,'Parking','Estacionamiento con vigilancia 24 horas',12),(8,2,'Taxi','Transporte al aeropuerto y dentro de la ciudad',7),(9,3,'Limpieza','Limpieza de habitaciones con cambio de sábanas',18),(10,3,'Spa','Circuito termal y masajes relajantes',60),(11,3,'Parking','Estacionamiento cubierto para huéspedes',15),(12,3,'Taxi','Servicio de traslado a zonas turísticas',8),(13,4,'Limpieza','Servicio de limpieza y lavandería',20),(14,4,'Spa','Acceso al spa con sauna y jacuzzi',65),(15,4,'Parking','Aparcamiento privado con seguridad',20),(16,4,'Taxi','Chofer privado bajo demanda',10),(17,5,'Limpieza','Limpieza profunda diaria de habitaciones',22),(18,5,'Spa','Sesiones de spa con tratamientos exclusivos',70),(19,5,'Parking','Estacionamiento gratuito para huéspedes',0),(20,5,'Taxi','Transporte de lujo disponible',15),(21,6,'Limpieza','Servicio de limpieza estándar',10),(22,6,'Spa','Baños termales y masajes',45),(23,6,'Parking','Zona de aparcamiento al aire libre',8),(24,6,'Taxi','Servicio de traslado a cualquier destino',6);
/*!40000 ALTER TABLE `Servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tarifa`
--

DROP TABLE IF EXISTS `Tarifa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tarifa` (
  `Id_Tarifa` int NOT NULL AUTO_INCREMENT,
  `Id_Hotel` int DEFAULT NULL,
  `Id_Habitacion` int DEFAULT NULL,
  `Id_Actividad` int DEFAULT NULL,
  `Id_Servicios` int DEFAULT NULL,
  `Tipo_Habitacion` varchar(45) DEFAULT NULL,
  `Temporada` varchar(45) DEFAULT NULL,
  `Precio` int DEFAULT NULL,
  `Id_Servicio` int NOT NULL,
  PRIMARY KEY (`Id_Tarifa`),
  KEY `TarifaHotel_idx` (`Id_Hotel`),
  KEY `TarifaHabitacion_idx` (`Id_Habitacion`),
  KEY `TarifaActividad_idx` (`Id_Actividad`),
  KEY `TarifaServicios_idx` (`Id_Servicios`),
  KEY `TarifaServicios` (`Id_Servicio`),
  CONSTRAINT `TarifaActividad` FOREIGN KEY (`Id_Actividad`) REFERENCES `Actividades` (`Id_Actividades`),
  CONSTRAINT `TarifaHabitacion` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`),
  CONSTRAINT `TarifaHotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `TarifaServicios` FOREIGN KEY (`Id_Servicio`) REFERENCES `Servicio` (`Id_Servicio`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `Id_TarifaReserva` int NOT NULL AUTO_INCREMENT,
  `Id_Tarifa` int DEFAULT NULL,
  `Id_Servicio` int DEFAULT NULL,
  `Fecha_Contratacion` date DEFAULT NULL,
  `Id_MetodoPago` int DEFAULT NULL,
  PRIMARY KEY (`Id_TarifaReserva`),
  KEY `Ttarifa_idx` (`Id_Tarifa`),
  KEY `TServicio_idx` (`Id_Servicio`),
  KEY `TMetodoPago_idx` (`Id_MetodoPago`)
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

-- Dump completed on 2025-03-10 19:30:35
