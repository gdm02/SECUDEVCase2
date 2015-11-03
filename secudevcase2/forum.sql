-- MySQL dump 10.13  Distrib 5.6.26, for Win64 (x86_64)
--
-- Host: localhost    Database: forum
-- ------------------------------------------------------
-- Server version	5.6.26-log

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `salutation` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `joindate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (7,'chester','ibarrientos','male','Sir','2015-09-09','rets','1234','im batman','user','2015-09-09'),(8,'shin','shin','male','Mr','1993-09-09','admin','1234','<a href=\'signout.php\'> </a>','admin','2015-09-09'),(9,'Evan','Livelo','male','Mr','1980-10-17','Vandenn','asdf','','User','2015-09-14'),(10,'NotEvanAnymore','Livelo','male','Mr','1980-10-17','johnpaul','asdf','','User','2015-09-14'),(11,'Jedrick','Chua','male','Mr','1980-10-17','jedrick','asdf','asdf','User','2015-09-14'),(12,'hi','jik','male','Mr','1990-01-01','hi','asdf','','Admin','2015-09-14'),(13,'shin','shin','male','Mr','1993-01-01','shin','shin','shin 1','User','2015-09-14'),(14,'shin','shin','male','Mr','1993-01-01','shin2','shin2','shin 3','User','2015-09-14'),(16,'shin','shin','male','Mr','1993-01-01','shin3','hello','shin 3','User','2015-09-14'),(17,'Matthew Allen','Go','male','Mr','1994-09-28','matt','matt','<script>\r\nalert(\'1\');\r\n</script>\r\n','User','2015-09-21'),(18,'JM','Soriano','male','Mr','1994-09-25','JM','password','I am kinda overweight.','User','2015-09-21'),(19,'qwerqwer','qwerqwer','male','Mr','1995-09-03','hey','hey','<script>alert(\"hack\")</script>','User','2015-09-21');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Jacket',20.00,'Leather Jacket',10),(2,'High heels',55.99,'Blue high heels',5),(3,'Crayons',5.50,'24 Crayons',20),(4,'Colour Pencils',15.25,'12 Colour Pencils',25);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,10,1,2),(4,10,2,1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) NOT NULL,
  `content` text,
  `postdate` date DEFAULT NULL,
  `last_edited` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acc_id` (`acc_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (111,8,'hello','2015-09-30','2015-09-30 03:24:26'),(112,8,'hi','2015-09-30','2015-09-30 03:24:29'),(113,7,'i am batman','2015-09-30','2015-09-30 03:24:39'),(114,7,'i am legend','2015-09-30','2015-09-30 03:24:43'),(115,7,'hi','2015-09-30','2015-09-30 03:24:46'),(116,7,'hello','2015-09-30','2015-09-30 03:24:48'),(117,8,'<b> bold</b>','2015-09-30','2015-09-30 03:25:19'),(118,8,'<i>italic</i>','2015-09-30','2015-09-30 03:25:32'),(119,8,'dummy post','2015-09-30','2015-09-30 03:25:39'),(121,8,'just some post!','2015-09-30','2015-09-30 03:29:04'),(123,8,'<img src=\"signout.php\" alt=\"signout.php\" />','2015-09-30','2015-09-30 03:46:25'),(124,8,'hello','2015-09-30','2015-09-30 03:46:29'),(125,8,'what','2015-09-30','2015-09-30 03:47:24'),(126,8,'hi there','2015-09-30','2015-09-30 03:48:56'),(127,8,'','2015-09-30','2015-09-30 11:21:28'),(128,8,'','2015-09-30','2015-09-30 11:22:27'),(129,8,'&lt;script type=\'text/js\'&gt;\r\nwindow.alert(\"hello\");\r\n&lt;/script&gt;','2015-09-30','2015-09-30 11:24:49'),(130,8,'','2015-09-30','2015-09-30 11:27:50'),(131,8,'','2015-09-30','2015-09-30 11:29:19'),(132,8,'<a href=\"signout.php\"> blahblah </a>','2015-09-30','2015-09-30 11:29:57'),(133,8,'<a> ahahah </a>','2015-09-30','2015-09-30 11:30:33'),(134,8,'','2015-09-30','2015-09-30 11:30:56'),(135,8,'','2015-09-30','2015-09-30 11:32:56'),(136,8,'','2015-09-30','2015-09-30 11:33:25'),(137,8,'<a>asjduasd</a>','2015-09-30','2015-09-30 11:33:35'),(138,8,'','2015-09-30','2015-09-30 11:34:39'),(139,8,'<a></a>','2015-09-30','2015-09-30 11:34:48'),(140,8,'','2015-09-30','2015-09-30 11:34:57'),(141,8,'<div></div>','2015-09-30','2015-09-30 11:35:32'),(142,8,'<div>\r\nDIV\r\n</div>','2015-09-30','2015-09-30 11:35:40'),(143,8,'','2015-09-30','2015-09-30 11:37:17'),(144,8,'<img src=\"asdasidas\" alt=\"asdasidas\" />','2015-09-30','2015-09-30 11:37:23'),(145,8,'<img src=\"www.google.com\" alt=\"www.google.com\" />','2015-09-30','2015-09-30 11:37:51'),(146,8,'<img src=\"signout.php\" alt=\"signout.php\" />','2015-09-30','2015-09-30 11:38:08'),(147,8,'<img src=\"/signout.php\" alt=\"signout.php\" />','2015-09-30','2015-09-30 11:38:21'),(148,8,'\r\n','2015-09-30','2015-09-30 11:40:07'),(149,17,'<a href=\"signout.php?verify=logout\">asdjasdjasd</a>','2015-09-30','2015-09-30 11:54:24'),(150,17,'<img src=\"superlogout.com\" alt=\"superlogout.com\" />','2015-09-30','2015-09-30 11:54:47'),(152,8,'','2015-09-30','2015-09-30 11:56:32'),(153,8,'<img src=\"http://globe-views.com/dcim/dreams/pig/pig-05.jpg\" alt=\"pig-05.jpg\" />','2015-09-30','2015-09-30 11:56:56'),(154,8,'<img src=\"http://globe-views.com/dcim/dreams/pig/pig-05.jpg\" alt=\"pig-05.jpg\" />','2015-09-30','2015-09-30 11:57:06'),(155,8,'<img src=\"https://tjthesportsgeek.files.wordpress.com/2014/12/miranda-sings.png?w=300&amp;h=287\" alt=\"miranda-sings.png?w=300&amp;h=287\" />','2015-09-30','2015-09-30 11:57:59'),(156,8,'<img src=\"https://tjthesportsgeek.files.wordpress.com/2014/12/miranda-sings.png?w=300&amp;h=287\" alt=\"miranda-sings.png?w=300&amp;h=287\" />','2015-09-30','2015-09-30 11:58:22'),(157,8,'<a href=\"http://superlogout.com\"><img src=\"https://tjthesportsgeek.files.wordpress.com/2014/12/miranda-sings.png?w=300&amp;h=287\" alt=\"miranda-sings.png?w=300&amp;h=287\" ></a>','2015-09-30','2015-09-30 12:00:20'),(158,8,'&lt;&gt; asidhasd &lt;&gt;','2015-09-30','2015-09-30 12:03:23'),(159,8,'rm onload=alert\"(\'yeah\')\"&gt;&gt;','2015-09-30','2015-09-30 12:03:57'),(160,8,'&lt;rm onload=alert\"(\'yeah\')\"&gt;&gt;','2015-09-30','2015-09-30 12:04:33'),(161,8,'&lt;form onload=alert\"(\'yeah\')\"&gt;&gt;','2015-09-30','2015-09-30 12:04:45'),(163,8,'&lt;form onload=\"alert(\'yeah\')\"&gt;&gt;','2015-09-30','2015-09-30 12:05:10'),(164,8,'&lt;script&gt;','2015-09-30','2015-09-30 12:05:27'),(165,8,'&lt;script&gt; &lt;/script&gt;','2015-09-30','2015-09-30 12:05:36'),(166,8,'&lt;script&gt; alert(\"YEAH\"); &lt;/script&gt;','2015-09-30','2015-09-30 12:05:45');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(255) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acc_id` (`acc_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (10,'PAY-76B83333AP4693913KY4SPHI',8,95.99,'approved','Payment by Paypal','2015-11-04 05:31:02');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-04  5:54:04
