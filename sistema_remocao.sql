-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: sistema_remocao
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chamado`
--

DROP TABLE IF EXISTS `chamado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chamado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chamado` varchar(100) NOT NULL,
  `habilitada` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chamado`
--

LOCK TABLES `chamado` WRITE;
/*!40000 ALTER TABLE `chamado` DISABLE KEYS */;
INSERT INTO `chamado` VALUES (1,'Transplante de cornea',1),(2,'Obito',1),(3,'cirurgia',1);
/*!40000 ALTER TABLE `chamado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `condutor`
--

DROP TABLE IF EXISTS `condutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `condutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `unidade` varchar(100) DEFAULT NULL,
  `habilitada` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condutor`
--

LOCK TABLES `condutor` WRITE;
/*!40000 ALTER TABLE `condutor` DISABLE KEYS */;
INSERT INTO `condutor` VALUES (1,'João da Silva','123.456.789-00','1985-04-12','joao@email.com','71999990000','71999990000','Rua A, 123','HUPES',1),(2,'RAFAEL OLIVEIRA SANTOS','016.388.345-98','1990-08-25','rafaelewe@gmail.com','85987655363','6546541564658','Rua Santo Alberto Magno, 580','hupes',1);
/*!40000 ALTER TABLE `condutor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enfermagem`
--

DROP TABLE IF EXISTS `enfermagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enfermagem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `coren` varchar(20) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `unidade` varchar(100) DEFAULT NULL,
  `habilitada` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enfermagem`
--

LOCK TABLES `enfermagem` WRITE;
/*!40000 ALTER TABLE `enfermagem` DISABLE KEYS */;
INSERT INTO `enfermagem` VALUES (1,'Maria Souza','987.654.321-00','123456-BA','1990-08-25','maria@email.com','71988887777','71988887777','Rua B, 456','HUPES',1),(2,'MAXWELL SOTHERO COELHO LOPES','362.095.718-59','65456456','1990-08-25','agilizarastreamento@gmail.com','85989034799','6546541564658','Rua Santo Alberto Magno, 580, ','hupes',1),(3,'marilucia coelho lopes','362.095.718-59','656','1990-08-25','falecomduia1@gmail.com','85989034799','6546541564658','Rua Santo Alberto Magno, 580, ','hupes',1),(4,'RAFAEL OLIVEIRA SANTOS','016.388.345-98','65456456','1990-08-25','rafaelewe@gmail.com','85987655363','','','hupes',1);
/*!40000 ALTER TABLE `enfermagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fase`
--

DROP TABLE IF EXISTS `fase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `habilitada` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fase`
--

LOCK TABLES `fase` WRITE;
/*!40000 ALTER TABLE `fase` DISABLE KEYS */;
INSERT INTO `fase` VALUES (1,'Solicitado','#0ed4fb',1),(2,'Aguardando','#fbf309',1),(3,'Finalizado','#4de40c',1),(4,'cancelado','#ec1809',1);
/*!40000 ALTER TABLE `fase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planilha_hupes`
--

DROP TABLE IF EXISTS `planilha_hupes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planilha_hupes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `TIPO` varchar(255) DEFAULT NULL,
  `SERVICO` varchar(255) DEFAULT NULL,
  `CHAMADO` varchar(255) DEFAULT NULL,
  `ORIGEM` varchar(255) DEFAULT NULL,
  `DESTINO` varchar(255) DEFAULT NULL,
  `PRONTUARIO` varchar(255) DEFAULT NULL,
  `NOME_PACIENTE` varchar(255) DEFAULT NULL,
  `CONDUTOR` varchar(255) DEFAULT NULL,
  `ENFERMAGEM` varchar(255) DEFAULT NULL,
  `KM` varchar(255) DEFAULT NULL,
  `SAÍDA` varchar(255) DEFAULT NULL,
  `CHEGADA` varchar(255) DEFAULT NULL,
  `TEMPO_TOTAL` varchar(255) DEFAULT NULL,
  `VALOR_UNIT` varchar(255) DEFAULT NULL,
  `VALOR_TOTAL` varchar(255) DEFAULT NULL,
  `OCORRENCIAS` varchar(255) DEFAULT NULL,
  `FASE` varchar(255) DEFAULT NULL,
  `USUARIO` varchar(255) DEFAULT NULL,
  `data_remocao` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planilha_hupes`
--

LOCK TABLES `planilha_hupes` WRITE;
/*!40000 ALTER TABLE `planilha_hupes` DISABLE KEYS */;
INSERT INTO `planilha_hupes` VALUES (40,'Básica','Exames','Transplante de cornea','hupes','hge','3123213','roberto carlos oioioio','João da Silva','marilucia coelho lopes','124454','23:06','','1:00','100','1000','','Aguardando','luciano','2025-04-12'),(42,'Urgência','Hemodialise','cirurgia','santana do agreste','salvador','53243423','RODRIGO RODRIGO','RAFAEL OLIVEIRA SANTOS','Maria Souza','4523434','01:03','','','100','1000','','Aguardando','admin','2025-04-13');
/*!40000 ALTER TABLE `planilha_hupes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servico`
--

DROP TABLE IF EXISTS `servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `servico` varchar(100) NOT NULL,
  `habilitada` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servico`
--

LOCK TABLES `servico` WRITE;
/*!40000 ALTER TABLE `servico` DISABLE KEYS */;
INSERT INTO `servico` VALUES (1,'Internação',1),(2,'Alta',1),(3,'Exames',1),(4,'Hemodialise',1),(5,'Obito',1);
/*!40000 ALTER TABLE `servico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo`
--

DROP TABLE IF EXISTS `tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) NOT NULL,
  `habilitada` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo`
--

LOCK TABLES `tipo` WRITE;
/*!40000 ALTER TABLE `tipo` DISABLE KEYS */;
INSERT INTO `tipo` VALUES (1,'Básica',1),(2,'Urgência',1),(3,'Emergência',1),(4,'teste',1),(5,'Rotina',1);
/*!40000 ALTER TABLE `tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (2,'Maxwell Sothero','localizameucarro@gmail.com','admin','$2y$10$vhs2YhoUO0.bDZ8rAzVKZ.mPMbGEfr6TayO2Y.sgm59wxzWzf9N92',1),(3,'LUCIANO XAVIER','rafaelewe@gmail.com','luciano','$2y$10$wDQK7QSBvUpJZ6nPvR6jE.XrKjQ8ybC1S86oFbBH7nNuJMFpjl9hu',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-13  1:16:44
