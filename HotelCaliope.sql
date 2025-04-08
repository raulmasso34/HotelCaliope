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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actividades`
--

LOCK TABLES `Actividades` WRITE;
/*!40000 ALTER TABLE `Actividades` DISABLE KEYS */;
INSERT INTO `Actividades` VALUES (1,4,'2025-01-17','2025-01-23','10:00:00','12:00:00',20,'Sala de conferencias','Conferencia sobre tendencias tecnológicas',50.00,'Actividades para niños'),(2,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la PIsicina'),(3,4,'2025-01-20','2025-01-21','09:00:00','11:00:00',15,'Spa','Sesión de relajación en el spa',70.00,'Masaje reajante'),(4,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la Piscina'),(5,4,'2025-01-20','2025-01-20','09:00:00','12:00:00',20,'Gimnasio','Entrenamiento personal en el gimnasio',40.00,'Entrenamiento Personalizado'),(6,4,'2025-01-21','2025-01-21','10:00:00','12:00:00',25,'Spa','Masaje relajante en el spa',50.00,'Masaje Relajante'),(7,4,'2025-01-22','2025-01-22','18:00:00','20:00:00',50,'Restaurante','Cena temática con música en vivo',70.00,'Cena Temática'),(8,1,'2025-01-10','2025-01-15','10:00:00','12:00:00',20,'Sala de conferencias','Charla sobre innovación tecnológica',55.00,'Innovación y Tecnología'),(9,2,'2025-01-12','2025-01-14','14:00:00','16:00:00',30,'Piscina','Clase de aqua fitness',35.00,'Aqua Fitness'),(10,3,'2025-01-15','2025-01-16','09:00:00','11:00:00',15,'Spa','Sesión de aromaterapia',65.00,'Aromaterapia Relajante'),(11,4,'2025-01-18','2025-01-19','14:00:00','16:00:00',30,'Piscina','Clase de yoga en la piscina',30.00,'Yoga en la Piscina'),(12,5,'2025-01-20','2025-01-20','09:00:00','12:00:00',20,'Gimnasio','Entrenamiento funcional',45.00,'Entrenamiento Funcional'),(13,6,'2025-01-21','2025-01-21','10:00:00','12:00:00',25,'Spa','Masaje de piedras calientes',75.00,'Masaje con Piedras'),(14,1,'2025-01-22','2025-01-22','18:00:00','20:00:00',50,'Restaurante','Cena gourmet con maridaje',90.00,'Cena Gourmet'),(15,2,'2025-02-10','2025-02-10','16:00:00','18:00:00',40,'Terraza','Cata de vinos con sommelier',85.00,'Cata de Vinos'),(16,3,'2025-02-12','2025-02-13','10:00:00','12:00:00',30,'Sala de eventos','Conferencia sobre sostenibilidad',50.00,'Sostenibilidad Ambiental'),(17,4,'2025-02-14','2025-02-14','20:00:00','22:00:00',60,'Jardín','Noche de cine al aire libre',25.00,'Cine Bajo las Estrellas'),(18,5,'2025-02-15','2025-02-15','08:00:00','10:00:00',20,'Playa','Clase de surf para principiantes',40.00,'Surf para Principiantes'),(19,6,'2025-02-16','2025-02-16','17:00:00','19:00:00',35,'Salón de baile','Clase de salsa y bachata',30.00,'Baile Latino'),(20,1,'2025-02-17','2025-02-17','11:00:00','13:00:00',25,'Spa','Taller de meditación y mindfulness',60.00,'Meditación y Mindfulness'),(21,2,'2025-02-18','2025-02-18','19:00:00','21:00:00',40,'Restaurante','Cena con show en vivo',80.00,'Cena Espectáculo'),(22,3,'2025-02-19','2025-02-19','15:00:00','17:00:00',50,'Piscina','Fiesta en la piscina con DJ',50.00,'Pool Party'),(23,4,'2025-02-20','2025-02-20','09:00:00','11:00:00',30,'Gimnasio','Clase de entrenamiento funcional',35.00,'Full Body Workout'),(24,5,'2025-02-21','2025-02-21','14:00:00','16:00:00',20,'Spa','Masaje tailandés de relajación',70.00,'Masaje Tailandés'),(25,6,'2025-02-22','2025-02-22','18:00:00','20:00:00',60,'Teatro','Obra de teatro interactiva',100.00,'Teatro en Vivo'),(26,1,'2025-03-05','2025-03-07','09:00:00','11:00:00',20,'Playa Principal','Tour en kayak por la costa',30.00,'Kayak en la Playa'),(27,2,'2025-03-10','2025-03-12','14:00:00','16:00:00',15,'Montañas Verdes','Senderismo con guía experto',25.00,'Ruta de Senderismo'),(28,3,'2025-03-15','2025-03-16','18:00:00','20:00:00',25,'Hotel Rooftop','Cena romántica con música en vivo',50.00,'Cena Especial'),(29,4,'2025-03-20','2025-03-21','17:00:00','19:00:00',30,'Piscina Principal','Clases de natación para niños',15.00,'Natación Infantil'),(30,5,'2025-03-25','2025-03-26','10:00:00','12:00:00',12,'Reserva Natural','Paseo en bicicleta por la naturaleza',35.00,'Ciclismo en la Naturaleza'),(31,6,'2025-03-28','2025-03-29','20:00:00','22:00:00',40,'Salón de Eventos','Espectáculo de magia',20.00,'Show de Magia'),(32,1,'2025-04-03','2025-04-04','08:00:00','10:00:00',18,'Centro Cultural','Clase de cocina local',40.00,'Cocina Tradicional'),(33,2,'2025-04-08','2025-04-10','17:00:00','19:00:00',30,'Salón de Eventos','Noche de música en vivo',20.00,'Concierto en Vivo'),(34,3,'2025-04-12','2025-04-13','15:00:00','17:00:00',15,'Spa del Hotel','Masaje relajante con aromaterapia',60.00,'Masaje Spa'),(35,4,'2025-04-18','2025-04-19','14:00:00','16:00:00',10,'Playa Privada','Clases de surf para principiantes',45.00,'Clases de Surf'),(36,5,'2025-04-22','2025-04-23','09:00:00','11:00:00',20,'Montaña del Hotel','Excursión con vista panorámica',25.00,'Excursión Panorámica'),(37,6,'2025-04-28','2025-04-29','19:00:00','21:00:00',35,'Salón de Conferencias','Taller de fotografía profesional',50.00,'Taller de Fotografía'),(38,1,'2025-05-01','2025-05-02','07:00:00','09:00:00',10,'Playa Principal','Yoga al amanecer',20.00,'Yoga en la Playa'),(39,2,'2025-05-05','2025-05-06','10:00:00','12:00:00',15,'Terraza del Hotel','Taller de coctelería',35.00,'Mixología & Cocteles'),(40,3,'2025-05-09','2025-05-10','16:00:00','18:00:00',25,'Piscina Principal','Competencia de clavados',15.00,'Concurso de Clavados'),(41,4,'2025-05-14','2025-05-15','12:00:00','14:00:00',20,'Salón de Baile','Clase de baile latino',30.00,'Baile Latino'),(42,5,'2025-05-18','2025-05-19','11:00:00','13:00:00',18,'Reserva Natural','Fotografía de vida silvestre',40.00,'Fotografía Natural'),(43,6,'2025-05-22','2025-05-23','21:00:00','23:00:00',50,'Teatro del Hotel','Cine bajo las estrellas',10.00,'Cine al Aire Libre'),(44,1,'2025-03-02','2025-03-02','09:00:00','10:30:00',15,'Jardín Botánico','Taller de meditación guiada',25.00,'Meditación al Aire Libre'),(45,1,'2025-03-08','2025-03-08','14:00:00','16:00:00',12,'Playa Exclusiva','Clase de paddle surf',30.00,'Paddle Surf'),(46,1,'2025-03-15','2025-03-15','18:00:00','20:00:00',25,'Terraza del Hotel','Cine al aire libre con bebidas',15.00,'Cine Nocturno'),(47,1,'2025-03-25','2025-03-25','20:00:00','22:00:00',30,'Salón de Eventos','Espectáculo de danza regional',20.00,'Danza Folklórica'),(48,2,'2025-03-03','2025-03-03','07:00:00','08:30:00',10,'Piscina del Hotel','Clase de aquagym',20.00,'Aquagym'),(49,2,'2025-03-10','2025-03-10','09:00:00','11:00:00',18,'Parque Natural','Avistamiento de aves con guía',40.00,'Tour de Aves'),(50,2,'2025-03-18','2025-03-18','15:00:00','17:00:00',25,'Salón VIP','Cata de café especialidad',35.00,'Cata de Café'),(51,2,'2025-03-28','2025-03-28','19:00:00','21:00:00',30,'Salón de Eventos','Noche de tango y jazz',25.00,'Noche de Tango'),(52,3,'2025-03-05','2025-03-05','10:00:00','12:00:00',15,'Montaña del Hotel','Ruta de senderismo',30.00,'Senderismo en la Montaña'),(53,3,'2025-03-12','2025-03-12','16:00:00','18:00:00',20,'Sala de Yoga','Clase de yoga relajante',25.00,'Yoga Relax'),(54,3,'2025-03-20','2025-03-20','14:00:00','16:00:00',12,'Cocina del Hotel','Taller de cocina internacional',45.00,'Cocina Internacional'),(55,3,'2025-03-30','2025-03-30','19:00:00','21:00:00',30,'Jardines del Hotel','Cena con música en vivo',60.00,'Cena Romántica'),(56,4,'2025-03-06','2025-03-06','08:30:00','10:00:00',12,'Playa del Hotel','Clase de surf',35.00,'Surf Básico'),(57,4,'2025-03-14','2025-03-14','11:00:00','13:00:00',15,'Salón de Eventos','Cata de té premium',30.00,'Cata de Té'),(58,4,'2025-03-22','2025-03-22','16:00:00','18:00:00',20,'Piscina del Hotel','Fiesta en la piscina con DJ',50.00,'Pool Party'),(59,4,'2025-03-31','2025-03-31','21:00:00','23:00:00',40,'Teatro del Hotel','Obra de teatro exclusiva',55.00,'Teatro Nocturno'),(60,5,'2025-03-07','2025-03-07','09:30:00','11:30:00',20,'Parque Natural','Excursión en bicicleta',45.00,'Ciclismo de Montaña'),(61,5,'2025-03-16','2025-03-16','12:00:00','14:00:00',10,'Salón de Arte','Taller de pintura al óleo',40.00,'Pintura Artística'),(62,5,'2025-03-24','2025-03-24','15:00:00','17:30:00',18,'Jardín del Hotel','Cata de chocolates gourmet',35.00,'Cata de Chocolates'),(63,5,'2025-03-29','2025-03-29','19:30:00','22:00:00',50,'Azotea del Hotel','Fiesta de cócteles y jazz',70.00,'Noche de Jazz'),(64,6,'2025-03-09','2025-03-09','07:00:00','09:00:00',12,'Gimnasio del Hotel','Entrenamiento funcional intensivo',20.00,'Entrenamiento Funcional'),(65,6,'2025-03-17','2025-03-17','09:30:00','11:30:00',15,'Playa Privada','Paseo en kayak',25.00,'Kayak en la Playa'),(66,6,'2025-03-26','2025-03-26','14:00:00','16:00:00',20,'Centro Cultural','Exposición de arte local',10.00,'Exposición de Arte'),(67,6,'2025-03-27','2025-03-27','18:00:00','20:00:00',30,'Jardines del Hotel','Cena con chef invitado',80.00,'Cena Gourmet');
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
-- Table structure for table `Continentes`
--

DROP TABLE IF EXISTS `Continentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Continentes` (
  `Id_Continente` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Directorio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Continente`),
  UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Continentes`
--

LOCK TABLES `Continentes` WRITE;
/*!40000 ALTER TABLE `Continentes` DISABLE KEYS */;
INSERT INTO `Continentes` VALUES (1,'Europa','europa'),(2,'África','africa'),(3,'Asia','asia'),(4,'Sudamérica','sudamerica'),(5,'Oceanía','oceania'),(6,'Antártida','antartida'),(7,'América del Norte','norteamerica');
/*!40000 ALTER TABLE `Continentes` ENABLE KEYS */;
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
  `Precio` decimal(10,0) NOT NULL DEFAULT '100',
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
  `Descripcion` varchar(500) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
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
INSERT INTO `Hotel` VALUES (1,'Hotel Caliope Galicia','galicia@hotelcaliope.com','+34 987 654 321','Avenida de la Costa, 123',15700,1,'Santiago de Compostela',5,'Ubicado en las Rías Baixas, combina tradición gallega con lujo moderno. Actividades: rutas de senderismo costero y tours culturales por Santiago de Compostela.','img/europa/galicia1.jpg'),(2,'Hotel Caliope Tossa de Mar','tossademar@hotelcaliope.com','+34 972 34 56 78','Carrer del Mar, 456',17320,1,'Tossa de Mar',5,'Enclavado en la Costa Brava, ofrece vistas al Mediterráneo. Actividades: snorkel en calas cristalinas y visitas al castillo medieval de Villa Vella.','img/europa/tossa1.jpg'),(3,'Hotel Caliope Pirineos','pirineos@hotelcaliope.com','+34 974 32 44 56','Carrer de la Muntanya, 789',22600,1,'Benasque',5,'Refugio alpino con acceso a pistas de esquí. Actividades: excursiones guiadas al Aneto y relax en spa con aguas termales naturales.',NULL),(4,'Hotel Caliope Florida','florida@hotelcaliope.com','+1 305 123 4567','1234 Ocean Drive',33139,2,'Miami',5,'En pleno Art Deco District de Miami. Actividades: paseos en yate por Biscayne Bay y clases de salsa en terraza al atardecer.',NULL),(5,'Hotel Caliope California','california@hotelcaliope.com','+1 415 987 6543','4567 Sunset Boulevard',94110,2,'San Francisco',5,'Moderno hotel cerca del Golden Gate. Actividades: tours en bicicleta por Sausalito y catas de vino en Napa Valley.',NULL),(6,'Hotel Caliope Nueva York','newyork@hotelcaliope.com','+1 212 123 9876','789 Broadway Street',10001,2,'New York',5,'Icono urbano junto a Central Park. Actividades: rutas de street art en Brooklyn y cruceros nocturnos con vistas a la Estatua de la Libertad.',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pago`
--

LOCK TABLES `Pago` WRITE;
/*!40000 ALTER TABLE `Pago` DISABLE KEYS */;
INSERT INTO `Pago` VALUES (167,1,19,196,'Tarjeta de Crédito','2025-03-13 20:05:13',1),(168,2,19,197,'Tarjeta de Crédito','2025-03-13 20:06:52',1),(169,2,19,198,'Tarjeta de Crédito','2025-03-13 20:12:49',1),(181,4,19,211,'Tarjeta de Crédito','2025-03-19 19:33:16',1),(185,1,19,212,'Tarjeta de Crédito','2025-03-19 19:44:46',1),(187,1,19,214,'Tarjeta de Crédito','2025-03-19 20:07:49',1);
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
  `Id_Continente` int NOT NULL,
  PRIMARY KEY (`Id_Pais`),
  KEY `fk_Pais_1_idx` (`Id_Continente`),
  CONSTRAINT `fk_Pais_1` FOREIGN KEY (`Id_Continente`) REFERENCES `Continentes` (`Id_Continente`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pais`
--

LOCK TABLES `Pais` WRITE;
/*!40000 ALTER TABLE `Pais` DISABLE KEYS */;
INSERT INTO `Pais` VALUES (1,'España',1),(2,'USA',7),(3,'Afganistán',3),(4,'Albania',1),(5,'Alemania',1),(6,'Andorra',1),(7,'Angola',2),(8,'Antigua y Barbuda',7),(9,'Arabia Saudita',3),(10,'Argelia',2),(11,'Argentina',4),(12,'Armenia',3),(13,'Australia',5),(14,'Austria',1),(15,'Azerbaiyán',3),(16,'Bahamas',7),(17,'Bangladés',3),(18,'Barbados',7),(19,'Baréin',3),(20,'Bélgica',1),(21,'Belice',7),(22,'Benín',2),(23,'Bielorrusia',1),(24,'Birmania',3),(25,'Bolivia',4),(26,'Bosnia y Herzegovina',1),(27,'Botsuana',2),(28,'Brasil',4),(29,'Brunéi',3),(30,'Bulgaria',1),(31,'Burkina Faso',2),(32,'Burundi',2),(33,'Bután',3),(34,'Cabo Verde',2),(35,'Camboya',3),(36,'Camerún',2),(37,'Canadá',7),(38,'Catar',3),(39,'Chad',2),(40,'Chile',4),(41,'China',3),(42,'Chipre',3),(43,'Colombia',4),(44,'Comoras',2),(45,'Corea del Norte',3),(46,'Corea del Sur',3),(47,'Costa de Marfil',2),(48,'Costa Rica',7),(49,'Croacia',1),(50,'Cuba',7),(51,'Dinamarca',1),(52,'Dominica',7),(53,'Ecuador',4),(54,'Egipto',2),(55,'El Salvador',7),(56,'Emiratos Árabes Unidos',3),(57,'Eritrea',2),(58,'Eslovaquia',1),(59,'Eslovenia',1),(60,'Esuatini',2),(61,'Estonia',1),(62,'Etiopía',2),(63,'Filipinas',3),(64,'Finlandia',1),(65,'Fiyi',5),(66,'Francia',1),(67,'Gabón',2),(68,'Gambia',2),(69,'Georgia',3),(70,'Ghana',2),(71,'Granada',7),(72,'Grecia',1),(73,'Guatemala',7),(74,'Guyana',4),(75,'Guinea',2),(76,'Guinea-Bisáu',2),(77,'Guinea Ecuatorial',2),(78,'Haití',7),(79,'Honduras',7),(80,'Hungría',1),(81,'India',3),(82,'Indonesia',3),(83,'Irak',3),(84,'Irán',3),(85,'Irlanda',1),(86,'Islandia',1),(87,'Islas Marshall',5),(88,'Islas Salomón',5),(89,'Israel',3),(90,'Italia',1),(91,'Jamaica',7),(92,'Japón',3),(93,'Jordania',3),(94,'Kazajistán',3),(95,'Kenia',2),(96,'Kirguistán',3),(97,'Kiribati',5),(98,'Kuwait',3),(99,'Laos',3),(100,'Lesoto',2),(101,'Letonia',1),(102,'Líbano',3),(103,'Liberia',2),(104,'Libia',2),(105,'Liechtenstein',1),(106,'Lituania',1),(107,'Luxemburgo',1),(108,'Madagascar',2),(109,'Malasia',3),(110,'Malaui',2),(111,'Maldivas',3),(112,'Malí',2),(113,'Malta',1),(114,'Marruecos',2),(115,'Mauricio',2),(116,'Mauritania',2),(117,'México',7),(118,'Micronesia',5),(119,'Moldavia',1),(120,'Mónaco',1),(121,'Mongolia',3),(122,'Montenegro',1),(123,'Mozambique',2),(124,'Namibia',2),(125,'Nauru',5),(126,'Nepal',3),(127,'Nicaragua',7),(128,'Níger',2),(129,'Nigeria',2),(130,'Noruega',1),(131,'Nueva Zelanda',5),(132,'Omán',3),(133,'Países Bajos',1),(134,'Pakistán',3),(135,'Palaos',5),(136,'Panamá',7),(137,'Papúa Nueva Guinea',5),(138,'Paraguay',4),(139,'Perú',4),(140,'Polonia',1),(141,'Portugal',1),(142,'Reino Unido',1),(143,'República Centroafricana',2),(144,'República Checa',1),(145,'República del Congo',2),(146,'República Democrática del Congo',2),(147,'República Dominicana',7),(148,'Ruanda',2),(149,'Rumania',1),(150,'Rusia',1),(151,'Samoa',5),(152,'San Cristóbal y Nieves',7),(153,'San Marino',1),(154,'San Vicente y las Granadinas',7),(155,'Santa Lucía',7),(156,'Santo Tomé y Príncipe',2),(157,'Senegal',2),(158,'Serbia',1),(159,'Seychelles',2),(160,'Sierra Leona',2),(161,'Singapur',3),(162,'Siria',3),(163,'Somalia',2),(164,'Sri Lanka',3),(165,'Sudáfrica',2),(166,'Sudán',2),(167,'Sudán del Sur',2),(168,'Suecia',1),(169,'Suiza',1),(170,'Surinam',4),(171,'Tailandia',3),(172,'Tanzania',2),(173,'Tayikistán',3),(174,'Timor Oriental',3),(175,'Togo',2),(176,'Tonga',5),(177,'Trinidad y Tobago',4),(178,'Túnez',2),(179,'Turkmenistán',3),(180,'Turquía',3),(181,'Tuvalu',5),(182,'Ucrania',1),(183,'Uganda',2),(184,'Uruguay',4),(185,'Uzbekistán',3),(186,'Vanuatu',5),(187,'Vaticano',1),(188,'Venezuela',4),(189,'Vietnam',3),(190,'Yemen',3),(191,'Yibuti',2),(192,'Zambia',2),(193,'Zimbabue',2);
/*!40000 ALTER TABLE `Pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reserva_Servicio`
--

DROP TABLE IF EXISTS `Reserva_Servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reserva_Servicio` (
  `Id_Reserva` int NOT NULL,
  `Id_Servicio` int NOT NULL,
  PRIMARY KEY (`Id_Reserva`,`Id_Servicio`),
  KEY `Id_Servicio` (`Id_Servicio`),
  CONSTRAINT `Reserva_Servicio_ibfk_1` FOREIGN KEY (`Id_Reserva`) REFERENCES `Reservas` (`Id_Reserva`) ON DELETE CASCADE,
  CONSTRAINT `Reserva_Servicio_ibfk_2` FOREIGN KEY (`Id_Servicio`) REFERENCES `Servicio` (`Id_Servicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reserva_Servicio`
--

LOCK TABLES `Reserva_Servicio` WRITE;
/*!40000 ALTER TABLE `Reserva_Servicio` DISABLE KEYS */;
INSERT INTO `Reserva_Servicio` VALUES (196,1),(197,5),(198,5),(211,15);
/*!40000 ALTER TABLE `Reserva_Servicio` ENABLE KEYS */;
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
  `EstadoLlegada` enum('Llego','No llego') DEFAULT 'No llego',
  PRIMARY KEY (`Id_Reserva`),
  KEY `reservacliente_idx` (`Id_Cliente`),
  KEY `reservahabitacion_idx` (`Id_Habitacion`),
  KEY `reservahotel_idx` (`Id_Hotel`),
  KEY `reservaclient_idx` (`Id_Cliente`),
  KEY `reservahabita_idx` (`Id_Habitacion`),
  KEY `hotel_idx` (`Id_Hotel`),
  KEY `reservatarifa_idx` (`Id_Tarifa`),
  KEY `hotelreserv_idx` (`Id_Hotel`),
  KEY `client_idx` (`Id_Cliente`),
  KEY `habita_idx` (`Id_Habitacion`),
  KEY `tarifas_idx` (`Id_Tarifa`),
  KEY `precioHab_idx` (`Precio_Habitacion`),
  KEY `servicios_idx` (`Id_Servicio`),
  KEY `precioServ_idx` (`Precio_Servicio`),
  CONSTRAINT `client` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clients` (`Id_Client`) ON DELETE CASCADE,
  CONSTRAINT `fk_habitacion` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE,
  CONSTRAINT `fk_reservas_habitaciones` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE,
  CONSTRAINT `habita` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`) ON DELETE CASCADE,
  CONSTRAINT `hotelreserv` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`) ON DELETE CASCADE,
  CONSTRAINT `servicios` FOREIGN KEY (`Id_Servicio`) REFERENCES `Servicio` (`Id_Servicio`) ON DELETE CASCADE,
  CONSTRAINT `tarifas` FOREIGN KEY (`Id_Tarifa`) REFERENCES `Tarifa` (`Id_Tarifa`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservas`
--

LOCK TABLES `Reservas` WRITE;
/*!40000 ALTER TABLE `Reservas` DISABLE KEYS */;
INSERT INTO `Reservas` VALUES (196,19,1,1,NULL,NULL,100,0,0,0,200,'2025-04-02','2025-04-04',2,'1','Pagado',NULL,'No llego'),(197,19,5,2,NULL,NULL,110,0,0,0,220,'2025-04-04','2025-04-06',2,'1','Pagado',NULL,'No llego'),(198,19,5,2,NULL,NULL,110,0,0,12,232,'2025-04-08','2025-04-10',2,'1','Pagado',NULL,'No llego'),(211,19,9,4,NULL,NULL,120,0,0,20,260,'2025-03-28','2025-03-30',2,'2','Pagado',NULL,'No llego'),(212,19,2,1,NULL,NULL,999,0,0,0,2997,'2025-04-04','2025-04-07',2,'1','Pagado',NULL,'No llego'),(214,19,1,1,NULL,NULL,100,0,0,0,700,'2025-03-21','2025-03-28',2,'1','Pagado',NULL,'No llego');
/*!40000 ALTER TABLE `Reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservas_Actividades`
--

DROP TABLE IF EXISTS `Reservas_Actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reservas_Actividades` (
  `Id_Reserva` int NOT NULL,
  `Id_Actividad` int NOT NULL,
  `Precio_Actividad` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Id_Reserva`,`Id_Actividad`),
  KEY `fk_reservas_actividades_actividad` (`Id_Actividad`),
  CONSTRAINT `fk_reservas_actividades_actividad` FOREIGN KEY (`Id_Actividad`) REFERENCES `Actividades` (`Id_Actividades`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reservas_actividades_reserva` FOREIGN KEY (`Id_Reserva`) REFERENCES `Reservas` (`Id_Reserva`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservas_Actividades`
--

LOCK TABLES `Reservas_Actividades` WRITE;
/*!40000 ALTER TABLE `Reservas_Actividades` DISABLE KEYS */;
INSERT INTO `Reservas_Actividades` VALUES (211,58,50.00);
/*!40000 ALTER TABLE `Reservas_Actividades` ENABLE KEYS */;
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
  `Precio` decimal(10,2) NOT NULL DEFAULT '10.00',
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
INSERT INTO `Servicio` VALUES (1,1,'Limpieza','Servicio de limpieza diaria de habitaciones',15.00),(2,1,'Spa','Acceso a la zona de spa y masajes relajantes',50.00),(3,1,'Parking','Estacionamiento privado para huéspedes',10.00),(4,1,'Taxi','Servicio de taxi disponible 24/7',5.00),(5,2,'Limpieza','Servicio de limpieza diaria de habitaciones',12.00),(6,2,'Spa','Acceso a la zona de spa y tratamientos faciales',55.00),(7,2,'Parking','Estacionamiento con vigilancia 24 horas',12.00),(8,2,'Taxi','Transporte al aeropuerto y dentro de la ciudad',7.00),(9,3,'Limpieza','Limpieza de habitaciones con cambio de sábanas',18.00),(10,3,'Spa','Circuito termal y masajes relajantes',60.00),(11,3,'Parking','Estacionamiento cubierto para huéspedes',15.00),(12,3,'Taxi','Servicio de traslado a zonas turísticas',8.00),(13,4,'Limpieza','Servicio de limpieza y lavandería',20.00),(14,4,'Spa','Acceso al spa con sauna y jacuzzi',65.00),(15,4,'Parking','Aparcamiento privado con seguridad',20.00),(16,4,'Taxi','Chofer privado bajo demanda',10.00),(17,5,'Limpieza','Limpieza profunda diaria de habitaciones',22.00),(18,5,'Spa','Sesiones de spa con tratamientos exclusivos',70.00),(19,5,'Parking','Estacionamiento gratuito para huéspedes',10.00),(20,5,'Taxi','Transporte de lujo disponible',15.00),(21,6,'Limpieza','Servicio de limpieza estándar',10.00),(22,6,'Spa','Baños termales y masajes',45.00),(23,6,'Parking','Zona de aparcamiento al aire libre',8.00),(24,6,'Taxi','Servicio de traslado a cualquier destino',6.00);
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

-- Dump completed on 2025-03-25 17:16:59