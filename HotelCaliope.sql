-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: HotelCaliope
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.24.04.2

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
  PRIMARY KEY (`Id_Actividades`),
  KEY `hotelactividad_idx` (`Id_Hotel`),
  CONSTRAINT `hotelactividad` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actividades`
--

LOCK TABLES `Actividades` WRITE;
/*!40000 ALTER TABLE `Actividades` DISABLE KEYS */;
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
  PRIMARY KEY (`Id_Client`),
  KEY `paisclient_idx` (`Id_Pais`),
  CONSTRAINT `paisclient` FOREIGN KEY (`Id_Pais`) REFERENCES `Pais` (`Id_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clients`
--

LOCK TABLES `Clients` WRITE;
/*!40000 ALTER TABLE `Clients` DISABLE KEYS */;
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
  PRIMARY KEY (`Id_Habitaciones`),
  KEY `hotelhabitacion_idx` (`Id_Hotel`),
  CONSTRAINT `hotelhabitacion` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Habitaciones`
--

LOCK TABLES `Habitaciones` WRITE;
/*!40000 ALTER TABLE `Habitaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `Habitaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hotel`
--

DROP TABLE IF EXISTS `Hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Hotel` (
  `Id_Hotel` int NOT NULL,
  `Nombre` char(45) DEFAULT NULL,
  `CorreoElectronico` varchar(255) DEFAULT NULL,
  `Telefono` int DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `CodigoPostal` int DEFAULT NULL,
  `Id_Pais` int DEFAULT NULL,
  `Ciudad` varchar(45) DEFAULT NULL,
  `Estrellas` int DEFAULT NULL,
  PRIMARY KEY (`Id_Hotel`),
  KEY `paishotel_idx` (`Id_Pais`),
  CONSTRAINT `paishotel` FOREIGN KEY (`Id_Pais`) REFERENCES `Pais` (`Id_Pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hotel`
--

LOCK TABLES `Hotel` WRITE;
/*!40000 ALTER TABLE `Hotel` DISABLE KEYS */;
/*!40000 ALTER TABLE `Hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MetodoPago`
--

DROP TABLE IF EXISTS `MetodoPago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `MetodoPago` (
  `Id_MetodoPago` int NOT NULL,
  `Titular` varchar(255) DEFAULT NULL,
  `Num_Tarjeta` int DEFAULT NULL,
  `Fecha_Caducidad` date DEFAULT NULL,
  `CVC` int DEFAULT NULL,
  `Fecha_Registro` date DEFAULT NULL,
  PRIMARY KEY (`Id_MetodoPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MetodoPago`
--

LOCK TABLES `MetodoPago` WRITE;
/*!40000 ALTER TABLE `MetodoPago` DISABLE KEYS */;
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
  CONSTRAINT `ofertahotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`)
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
  `FormaPago` tinyint DEFAULT NULL,
  `Fecha_Pago` date DEFAULT NULL,
  `Id_MetodoPago` int DEFAULT NULL,
  PRIMARY KEY (`Id_Pago`),
  KEY `pagohotel_idx` (`Id_Hotel`),
  KEY `pagocliente_idx` (`Id_Cliente`),
  KEY `pagoreserva_idx` (`Id_Reserva`),
  KEY `pagometodo_idx` (`Id_MetodoPago`),
  CONSTRAINT `pagocliente` FOREIGN KEY (`Id_Cliente`) REFERENCES `Clients` (`Id_Client`),
  CONSTRAINT `pagohotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`),
  CONSTRAINT `pagometodo` FOREIGN KEY (`Id_MetodoPago`) REFERENCES `MetodoPago` (`Id_MetodoPago`),
  CONSTRAINT `pagoreserva` FOREIGN KEY (`Id_Reserva`) REFERENCES `Reservas` (`Id_Reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pago`
--

LOCK TABLES `Pago` WRITE;
/*!40000 ALTER TABLE `Pago` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pais`
--

LOCK TABLES `Pais` WRITE;
/*!40000 ALTER TABLE `Pais` DISABLE KEYS */;
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
  CONSTRAINT `habita` FOREIGN KEY (`Id_Habitacion`) REFERENCES `Habitaciones` (`Id_Habitaciones`),
  CONSTRAINT `hotelreserv` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`),
  CONSTRAINT `tarifas` FOREIGN KEY (`Id_Tarifa`) REFERENCES `Tarifa` (`Id_Tarifa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservas`
--

LOCK TABLES `Reservas` WRITE;
/*!40000 ALTER TABLE `Reservas` DISABLE KEYS */;
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
  CONSTRAINT `hotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`)
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
  CONSTRAINT `TarifaHotel` FOREIGN KEY (`Id_Hotel`) REFERENCES `Hotel` (`Id_Hotel`),
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
  CONSTRAINT `TMetodoPago` FOREIGN KEY (`Id_MetodoPago`) REFERENCES `MetodoPago` (`Id_MetodoPago`),
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

-- Dump completed on 2024-11-07 19:00:17
