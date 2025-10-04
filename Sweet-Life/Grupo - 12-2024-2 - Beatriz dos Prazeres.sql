CREATE DATABASE  IF NOT EXISTS `mydb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `mydb`;
-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: mydb
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cadastrados`
--

DROP TABLE IF EXISTS `cadastrados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cadastrados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `dataNasc` varchar(12) NOT NULL,
  `nomeMat` varchar(80) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cel` varchar(20) NOT NULL,
  `tel` varchar(18) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `bairro` varchar(20) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `comp` varchar(45) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `perfil` enum('master','comum') NOT NULL DEFAULT 'comum',
  `username` varchar(6) NOT NULL,
  `password` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadastrados`
--

LOCK TABLES `cadastrados` WRITE;
/*!40000 ALTER TABLE `cadastrados` DISABLE KEYS */;
INSERT INTO `cadastrados` VALUES (23,'','','','','','','','','','','','','','','root',''),(24,'','','','','','','','','','','','','','','root',''),(30,'Maya Gonçalves da Silva','2018-01-01','Beatriz dos Prazeres','111.111.111-11','biateste@gmail.com','+55 (21)983219013','+55 (21)983219013','21021080','Rua Santa Engrácia','Penha','Ri','apto 301','Feminino','comum','Mayaaa','$2y$10$Y'),(34,'Beatriz dos Prazeres Gonçalves Fazenda da Silva','2006-02-06','Deolinda dos Prazeres','123.456.789-10','beatrizgoncalves@gmail.com','+55 (21)983219013','+55 (21)38677384','21021080','Rua Santa Engrácia','Penha','Ri','apto 301','Feminino','master','bia123','B1234567');
/*!40000 ALTER TABLE `cadastrados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_pedidos`
--

DROP TABLE IF EXISTS `itens_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itens_pedidos` (
  `id_itens_pedidos` int(11) NOT NULL AUTO_INCREMENT,
  `quantidade` int(11) NOT NULL,
  `valor_unitario` decimal(10,0) NOT NULL,
  `produtos_id_produtos` int(11) NOT NULL,
  `pedidos_id_pedidos` int(11) NOT NULL,
  `pedidos_cadastrados_id` int(11) NOT NULL,
  PRIMARY KEY (`id_itens_pedidos`,`produtos_id_produtos`,`pedidos_id_pedidos`,`pedidos_cadastrados_id`),
  KEY `fk_itens_pedidos_produtos1_idx` (`produtos_id_produtos`),
  KEY `fk_itens_pedidos_pedidos1_idx` (`pedidos_id_pedidos`,`pedidos_cadastrados_id`),
  CONSTRAINT `fk_itens_pedidos_pedidos1` FOREIGN KEY (`pedidos_id_pedidos`, `pedidos_cadastrados_id`) REFERENCES `pedidos` (`id_pedidos`, `cadastrados_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_itens_pedidos_produtos1` FOREIGN KEY (`produtos_id_produtos`) REFERENCES `produtos` (`id_produtos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_pedidos`
--

LOCK TABLES `itens_pedidos` WRITE;
/*!40000 ALTER TABLE `itens_pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `itens_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `cadastrados_id` int(11) NOT NULL,
  `datahora` datetime NOT NULL,
  `pergunta` varchar(45) NOT NULL,
  `resposta` varchar(50) NOT NULL,
  `resultado` varchar(3) NOT NULL,
  PRIMARY KEY (`id_log`,`cadastrados_id`),
  KEY `fk_log_cadastrados_idx` (`cadastrados_id`),
  CONSTRAINT `fk_log_cadastrados` FOREIGN KEY (`cadastrados_id`) REFERENCES `cadastrados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (13,30,'2024-11-17 20:53:06','dataNasc','2018-01-01','sim'),(15,34,'2024-11-17 22:37:09','nomeMat','deolinda dos prazeres','não'),(16,34,'2024-11-17 22:37:15','nomeMat','deolinda dos prazeres','não'),(17,34,'2024-11-17 22:42:59','cep','2006-02-06','não'),(18,34,'2024-11-17 22:43:03','nomeMat','21021080','não'),(19,34,'2024-11-17 22:43:08','nomeMat','deolinda dos prazeres','sim'),(20,34,'2024-11-17 22:49:56','nomeMat','2006-02-06','não'),(21,34,'2024-11-17 22:50:05','cep','deolinda dos prazeres','não'),(22,34,'2024-11-17 22:50:09','cep','21021080','sim'),(23,34,'2024-11-17 22:52:15','dataNasc','2006-02-06','não'),(24,34,'2024-11-17 22:54:30','cep','deolinda dos prazeres','não'),(25,34,'2024-11-17 22:54:34','cep','21021080','sim'),(26,34,'2024-11-17 23:03:31','dataNasc','2006-02-06','sim'),(27,30,'2024-11-17 23:04:11','dataNasc','2018-01-01','sim'),(28,34,'2024-11-17 23:07:56','cep','deolinda dos prazeres','não'),(29,34,'2024-11-17 23:07:59','dataNasc','21021080','não'),(30,34,'2024-11-17 23:08:52','nomeMat','deolinda dos prazeres','sim'),(31,30,'2024-11-17 23:09:47','cep','2018-01-01','não'),(32,30,'2024-11-17 23:09:53','cep','21021080','sim'),(33,34,'2024-11-18 18:47:09','dataNasc','2006-02-06','sim'),(35,34,'2024-11-18 20:44:34','dataNasc','2006-02-06','não'),(36,34,'2024-11-18 20:44:45','dataNasc','2006-02-06','sim');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `id_pedidos` int(11) NOT NULL AUTO_INCREMENT,
  `cadastrados_id` int(11) NOT NULL,
  `datahora` datetime NOT NULL,
  `total` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id_pedidos`,`cadastrados_id`),
  KEY `fk_pedidos_cadastrados1_idx` (`cadastrados_id`),
  CONSTRAINT `fk_pedidos_cadastrados1` FOREIGN KEY (`cadastrados_id`) REFERENCES `cadastrados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos` (
  `id_produtos` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) NOT NULL,
  PRIMARY KEY (`id_produtos`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,'Suco de Uva Integral Sweet Life 500ml','Feito com uvas frescas, nosso suco oferece uma explosão de sabor intenso, capturando a essência vibrante da fruta em sua forma mais pura',14.99,50),(3,'Suco de Morango Integral Sweet Life 500ml','Feito com morangos frescos, nosso suco oferece um deleite doce e refrescante, capturando a essência pura da fruta em cada gole\r\n\r\n',21.99,40),(4,'Suco de Laranja Integral Sweet Life 500ml','Feito com laranjas suculentas, nosso suco é um mix de frescor e vitamina C, capturando a essência revigorante da fruta em sua forma mais pura',15.99,46),(13,'Suco de Maçã Integral Sweet Life 500ml','Produzido com maçãs frescas, nosso suco oferece um sabor doce e revigorante, capturando a verdadeira essência da fruta em cada gole',16.95,48);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-19 13:42:47
