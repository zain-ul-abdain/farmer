/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.17-MariaDB : Database - farmer
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`farmer` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `farmer`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(200) DEFAULT NULL,
  `parent_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  KEY `parent_category` (`parent_category`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent_category`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category` */

insert  into `category`(`category_id`,`category`,`parent_category`) values 
(1,'Rice',NULL),
(2,'Basmati',1),
(3,'Fruit',NULL),
(4,'Mango',3),
(5,'Banana',3),
(6,'Flour',NULL),
(7,'Vegetable',NULL),
(8,'Lady Finger',7),
(9,'Onion',7),
(10,'Tomato',7),
(11,'Potato',7),
(12,'Spanich',7),
(14,'Apple',3),
(15,'Carrot',7),
(16,'Fertilizer',NULL);

/*Table structure for table `category_assign` */

DROP TABLE IF EXISTS `category_assign`;

CREATE TABLE `category_assign` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `post_type` enum('Knowledge_Base','Discussion_Forum','E-Commerce','Consultancy') DEFAULT NULL,
  PRIMARY KEY (`assign_id`),
  KEY `category_id` (`category_id`),
  KEY `category_type_id` (`post_type`),
  CONSTRAINT `category_assign_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `category_assign` */

insert  into `category_assign`(`assign_id`,`category_id`,`post_type`) values 
(1,1,'Knowledge_Base'),
(2,1,'Discussion_Forum'),
(3,3,'Knowledge_Base'),
(4,2,'Knowledge_Base'),
(5,4,'Discussion_Forum'),
(6,6,'Discussion_Forum'),
(7,2,'Discussion_Forum'),
(8,3,'E-Commerce'),
(10,14,'E-Commerce'),
(11,7,'E-Commerce'),
(12,1,'E-Commerce'),
(13,1,'Consultancy'),
(14,16,'E-Commerce');

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(200) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`city_id`),
  KEY `state_id` (`state_id`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

/*Data for the table `city` */

insert  into `city`(`city_id`,`city_name`,`state_id`) values 
(1,'Karachi',1),
(2,'Hyderabad',1),
(3,'Sukkur',1),
(4,'Larkana',1),
(5,'Lahore',2),
(6,'Rawalpindi',2),
(7,'Islamabad',2),
(8,'Sibi',3),
(9,'Sui',3),
(10,'Quetta',3),
(11,'Peshawar',4),
(12,'Mardan',4),
(13,'Kohat',4),
(14,'Dera Ismail khan',4),
(15,'Swat',4),
(16,'	Ming',5),
(17,'Qing',5),
(18,'Zhangmu',6),
(19,'Lokhla',6),
(20,'Andheri',7),
(21,'Goregaon',7),
(22,'Firozabad',8),
(23,'Siri',8),
(24,'Shergarh',8),
(25,'Jaipur',9),
(26,'Udaipur',9),
(27,'Jacksonville',10),
(28,'Tallahassee',11),
(29,'Miami',12);

/*Table structure for table `consultancy_service` */

DROP TABLE IF EXISTS `consultancy_service`;

CREATE TABLE `consultancy_service` (
  `consultancy_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `consultant` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `query` longtext NOT NULL,
  `discussion_start` timestamp NOT NULL DEFAULT current_timestamp(),
  `discussion_end` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('In-Process','Complete') DEFAULT 'In-Process',
  `rating` int(1) DEFAULT NULL,
  `feedback` longtext DEFAULT NULL,
  PRIMARY KEY (`consultancy_service_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `consultancy_service_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

/*Data for the table `consultancy_service` */

insert  into `consultancy_service`(`consultancy_service_id`,`consultant`,`client`,`category_id`,`query`,`discussion_start`,`discussion_end`,`status`,`rating`,`feedback`) values 
(33,6,8,1,'hi','2021-03-27 13:06:23','2021-03-27 13:06:43','Complete',4,'nice'),
(34,6,8,1,'how to you reply','2021-03-27 13:15:29','2021-03-27 13:15:43','Complete',4,'thanks'),
(35,6,1,1,'null','2021-03-27 13:24:15','2021-03-27 13:24:15','In-Process',NULL,NULL),
(36,8,10,1,'Fertilizer','2021-03-27 15:09:54','2021-03-27 15:12:20','In-Process',0,''),
(37,6,1,1,'how are you','2021-03-27 15:19:03','2021-03-27 15:19:41','Complete',3,''),
(38,10,1,1,'ok','2021-03-27 15:20:30','2021-03-27 15:20:30','In-Process',NULL,NULL);

/*Table structure for table `consultancy_service_chat` */

DROP TABLE IF EXISTS `consultancy_service_chat`;

CREATE TABLE `consultancy_service_chat` (
  `consultancy_service_chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `consultancy_service_id` int(11) NOT NULL,
  `chat_message` longtext NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`consultancy_service_chat_id`),
  KEY `consultancy_service_id` (`consultancy_service_id`),
  CONSTRAINT `consultancy_service_chat_ibfk_1` FOREIGN KEY (`consultancy_service_id`) REFERENCES `consultancy_service` (`consultancy_service_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

/*Data for the table `consultancy_service_chat` */

insert  into `consultancy_service_chat`(`consultancy_service_chat_id`,`consultancy_service_id`,`chat_message`,`user_assign_role_id`,`added_on`) values 
(37,33,'hi',8,'2021-03-27 13:06:23'),
(38,33,'Hello, how can i fertilize rice?',8,'2021-03-27 13:06:31'),
(39,34,'how to you reply',8,'2021-03-27 13:15:29'),
(40,34,'Hello, how can i fertilize rice?',8,'2021-03-27 13:15:34'),
(41,35,'null',1,'2021-03-27 13:24:15'),
(42,36,'Fertilizer',10,'2021-03-27 15:09:54'),
(43,36,'Hello, how can i fertilize rice?',10,'2021-03-27 15:10:13'),
(44,37,'how are you',1,'2021-03-27 15:19:03'),
(45,37,'Hello, how can i fertilize rice?',1,'2021-03-27 15:19:19'),
(46,38,'ok',1,'2021-03-27 15:20:30'),
(47,36,'Hello, how can i fertilize rice?',10,'2021-03-27 15:21:43'),
(48,36,'Hello, how can i fertilize rice?',10,'2021-03-27 15:35:43');

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `country` */

insert  into `country`(`country_id`,`country_name`) values 
(1,'Pakistan'),
(2,'China'),
(3,'India'),
(4,'USA');

/*Table structure for table `customer_order` */

DROP TABLE IF EXISTS `customer_order`;

CREATE TABLE `customer_order` (
  `customer_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assign_role_id` int(11) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_method` enum('Cash On Delivery','Jazz Cash','Easy Paisa','Payza','Skrill') NOT NULL,
  `billing_address` longtext NOT NULL,
  `shipping_address` longtext NOT NULL,
  `status` enum('New Order','On The Way','Delivered','Cancel') NOT NULL DEFAULT 'New Order',
  `delivered_on` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_order_id`),
  KEY `user_assign_role_id` (`user_assign_role_id`),
  CONSTRAINT `customer_order_ibfk_1` FOREIGN KEY (`user_assign_role_id`) REFERENCES `user_assign_role` (`user_assign_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order` */

insert  into `customer_order`(`customer_order_id`,`user_assign_role_id`,`added_on`,`payment_method`,`billing_address`,`shipping_address`,`status`,`delivered_on`) values 
(1,3,'2021-03-06 17:09:04','Cash On Delivery','Jamshoro','Hyderabad','New Order',NULL),
(2,2,'2021-03-06 09:49:27','Cash On Delivery','Jamshoro','Hyderabad','Delivered',NULL),
(3,1,'2021-03-06 15:21:35','Cash On Delivery','Jamshoro','Hyderabad','Cancel',NULL),
(4,1,'2021-03-06 15:21:38','Cash On Delivery','Jamshoro','Hyderabad','On The Way',NULL);

/*Table structure for table `customer_order_detail` */

DROP TABLE IF EXISTS `customer_order_detail`;

CREATE TABLE `customer_order_detail` (
  `customer_order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`customer_order_detail_id`),
  KEY `customer_order_id` (`customer_order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `customer_order_detail_ibfk_1` FOREIGN KEY (`customer_order_id`) REFERENCES `customer_order` (`customer_order_id`),
  CONSTRAINT `customer_order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order_detail` */

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `post_title` varchar(500) NOT NULL,
  `post_summary` longtext NOT NULL,
  `post_description` longtext DEFAULT NULL,
  `post_type` enum('Knowledge Base','Discussion Forum') NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `tag` enum('Success Story','Farmer Experience') DEFAULT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_assign_role_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_assign_role_id`) REFERENCES `user_assign_role` (`user_assign_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post` */

insert  into `post`(`post_id`,`category_id`,`user_assign_role_id`,`post_title`,`post_summary`,`post_description`,`post_type`,`is_active`,`added_on`,`updated_on`,`tag`) values 
(52,1,4,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Knowledge Base',0,'2021-03-17 12:30:36',NULL,NULL),
(53,3,8,'What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Knowledge Base',0,'2021-03-17 13:03:05',NULL,NULL),
(56,1,1,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Knowledge Base',0,'2021-03-17 14:55:37',NULL,NULL),
(57,1,1,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',0,'2021-03-20 12:10:06',NULL,NULL),
(58,1,3,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',0,'2021-03-20 15:37:24',NULL,NULL),
(59,1,2,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',0,'2021-03-20 15:37:26',NULL,NULL),
(60,3,10,'Fruit','In botany, a fruit is the seed-bearing structure in flowering plants formed from the ovary after flowering. Fruits are the means by which angiosperms disseminate seeds','Fruit, the fleshy or dry ripened ovary of a flowering plant, enclosing the seed or seeds. Thus, apricots, bananas, and grapes, as well as bean pods, corn grains, tomatoes, cucumbers, and (in their shells) acorns and almonds, are all technically fruits','Knowledge Base',0,'2021-03-20 12:38:21',NULL,NULL),
(61,6,3,'Where can I get some?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. ','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#039;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','Discussion Forum',0,'2021-03-20 15:36:38',NULL,NULL),
(62,1,1,'Where can I get some?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Where can I get some?Where can I get some?There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',0,'2021-03-27 13:20:23',NULL,NULL),
(63,6,1,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?What is Lorem Ipsum What is Lorem Ipsum?What is Lorem Ipsum What is Lorem Ipsum?','Discussion Forum',0,'2021-03-27 13:23:36',NULL,NULL);

/*Table structure for table `post_attachment` */

DROP TABLE IF EXISTS `post_attachment`;

CREATE TABLE `post_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `file_name` longtext NOT NULL,
  `file_type` varchar(200) NOT NULL,
  PRIMARY KEY (`attachment_id`),
  KEY `blog_id` (`post_id`),
  CONSTRAINT `post_attachment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_attachment` */

insert  into `post_attachment`(`attachment_id`,`post_id`,`file_name`,`file_type`) values 
(66,52,'uploads/52/rice1.jpg','image'),
(67,53,'uploads/53/apple.png','image'),
(68,52,'uploads/52/rice1.jpg','image'),
(69,53,'uploads/53/apple.png','image'),
(98,56,'uploads/56/assignmet_status.docx','application'),
(99,56,'uploads/56/big_buck_bunny_720p_1mb.mp4','video'),
(102,56,'uploads/56/Conditional Code (Day-2).pptx','application'),
(103,56,'uploads/56/Course Plan & Actual (Batch_ HIST 2K21-PHP-BAS Feb-May).xlsx','application'),
(104,56,'uploads/56/file_example_MP3_700KB.mp3','audio'),
(106,56,'uploads/56/Hydrangeas.jpg','image'),
(107,56,'uploads/56/keyboard-shortcuts-windows.pdf','application'),
(109,56,'uploads/56/New Text Document.txt','text'),
(110,56,'uploads/56/New WinRAR archive.rar','application'),
(111,56,'uploads/56/New WinRAR ZIP archive.zip','application'),
(112,56,'uploads/56/file_example_MP3_700KB.mp3','audio'),
(113,56,'uploads/56/big_buck_bunny_720p_1mb.mp4','video'),
(120,60,'uploads/60/fruit.jpg','image'),
(121,56,'uploads/56/Capture2.PNG','image');

/*Table structure for table `post_like` */

DROP TABLE IF EXISTS `post_like`;

CREATE TABLE `post_like` (
  `post_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `is_like` tinyint(1) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`post_like_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_like` */

insert  into `post_like`(`post_like_id`,`post_id`,`user_assign_role_id`,`is_like`,`added_on`) values 
(1,56,10,1,'2021-03-19 17:42:23'),
(4,53,10,1,'2021-03-19 18:09:55'),
(5,56,8,1,'2021-03-20 10:46:35'),
(6,53,8,1,'2021-03-20 10:47:10'),
(8,52,8,1,'2021-03-20 12:15:27'),
(9,59,8,1,'2021-03-20 12:18:22'),
(10,60,10,1,'2021-03-20 12:38:59'),
(11,61,3,1,'2021-03-20 15:49:14'),
(12,60,3,1,'2021-03-20 15:49:22'),
(13,58,3,1,'2021-03-20 16:26:05'),
(14,56,1,1,'2021-03-27 15:25:07');

/*Table structure for table `post_reply` */

DROP TABLE IF EXISTS `post_reply`;

CREATE TABLE `post_reply` (
  `post_reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`post_reply_id`),
  KEY `post_id` (`post_id`),
  KEY `user_assigned_role_id` (`user_assign_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_reply` */

insert  into `post_reply`(`post_reply_id`,`message`,`user_assign_role_id`,`post_id`,`added_on`,`is_approved`) values 
(8,'In publishing and graphic design',3,53,'2021-03-19 17:04:48',0),
(13,'In publishing and graphic design',8,53,'2021-03-20 12:14:17',0),
(14,'Very nice',8,52,'2021-03-20 12:15:43',0),
(15,'Very nice',8,59,'2021-03-20 12:19:35',0),
(18,'Lorem Ipsum available, but the majority have suffered alteration in some form,',3,61,'2021-03-20 15:58:35',0),
(19,'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,',3,61,'2021-03-20 16:01:23',0),
(20,'The generated Lorem Ipsum is therefore always free from repetition',3,61,'2021-03-20 16:03:59',0),
(21,'The generated Lorem Ipsum is therefore always free from repetition',3,56,'2021-03-20 16:03:59',0),
(22,'asd',1,56,'2021-03-27 15:25:22',0),
(23,'Lorem Ipsum available, but the majority have suffered alteration in some form,',1,56,'2021-03-27 15:25:24',0),
(24,'cha hal aa',1,56,'2021-03-27 15:25:33',0),
(25,'Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,',1,56,'2021-03-27 15:25:45',0),
(26,'Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,',1,56,'2021-03-27 15:25:59',0);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `user_assign_role_id` int(11) NOT NULL,
  `product_title` varchar(800) NOT NULL,
  `product_description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `low_inventory` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_free_shipping` tinyint(1) NOT NULL DEFAULT 1,
  `shipping_charges` int(11) DEFAULT NULL,
  `is_rating_allowed` tinyint(1) NOT NULL DEFAULT 1,
  `is_comment_allowed` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `product` */

insert  into `product`(`product_id`,`category_id`,`user_assign_role_id`,`product_title`,`product_description`,`price`,`quantity`,`low_inventory`,`added_on`,`updated_on`,`updated_by`,`is_active`,`is_featured`,`is_free_shipping`,`shipping_charges`,`is_rating_allowed`,`is_comment_allowed`) values 
(1,7,1,'Carrot','The carrot is a root vegetable, usually orange in color, though purple, black, red, white, and yellow cultivars exist. They are a domesticated form of the wild carrot, Daucus carota, native to Europe and Southwestern Asia. The plant probably originated in Persia and was originally cultivated for its leaves and seeds.',100,50,5,'2021-03-10 18:09:22',NULL,NULL,1,1,1,0,1,1),
(2,1,2,'Rice','Rice is the seed of the grass species Oryza sativa (Asian rice) or less commonly Oryza glaberrima (African rice). As a cereal grain, it is the most widely consumed staple food for a large part of the world\'s human population, especially in Asia and Africa.',150,100,10,'2021-03-12 15:30:36',NULL,NULL,1,0,1,NULL,1,1),
(10,3,1,'Apple','An apple is an edible fruit produced by an apple tree. Apple trees are cultivated worldwide and are the most widely grown species in the genus Malus. The tree originated in Central Asia, where its wild ancestor, Malus sieversii, is still found today. ',150,1000,0,'2021-03-25 09:09:53',NULL,NULL,1,0,1,NULL,1,1),
(11,16,8,'Fertiliser','A fertilizer or fertiliser is any material of natural or synthetic origin that is applied to soil or to plant tissues to supply plant nutrients. Fertilizers may be distinct from liming materials or other non-nutrient soil amendments. Many sources of fertilizer exist, both natural and industrially produced.',500,30,0,'2021-03-25 09:40:08',NULL,NULL,1,0,1,NULL,1,1);

/*Table structure for table `product_comment` */

DROP TABLE IF EXISTS `product_comment`;

CREATE TABLE `product_comment` (
  `product_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assign_role_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_comment_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_comment_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_comment` */

/*Table structure for table `product_image` */

DROP TABLE IF EXISTS `product_image`;

CREATE TABLE `product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_path` longtext NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_image_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_image` */

insert  into `product_image`(`product_image_id`,`product_id`,`image_path`,`is_main`,`added_on`) values 
(1,1,'https://www.jessicagavin.com/wp-content/uploads/2019/02/carrots-7-1200.jpg',1,'2021-03-10 17:58:23'),
(2,1,'pages/shop/images/img-pro-01.jpg',0,'2021-03-10 17:58:29'),
(3,1,'https://www.highmowingseeds.com/wordpress/wp-content/uploads/2017/05/dolciva_carrot-92416-039-2x2.jpg',0,'2021-03-10 17:55:13'),
(4,2,'data:image/jpeg;base64,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',1,'2021-03-13 09:12:25'),
(5,2,'data:image/jpeg;base64,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',0,'2021-03-13 09:12:42'),
(6,10,'products/10/35552.jpeg',1,'2021-03-24 18:42:12'),
(7,10,'products/10/5f4dcc3b5aa765d61d8327deb882cf99.png',0,'2021-03-24 18:41:42'),
(8,10,'products/10/71278886.jpg',0,'2021-03-24 18:41:42'),
(9,10,'products/10/Jonagold_NYAS-Apples2.png',0,'2021-03-24 18:41:42'),
(10,11,'products/11/1305505_tanks_supermix_organic_600x600.jpg',0,'2021-03-25 09:30:01'),
(11,11,'products/11/hero agri fertilizers.jpg',0,'2021-03-25 09:30:01'),
(12,11,'products/11/outlook-for-the-global-fertilizer-market.jpg',1,'2021-03-25 09:40:39');

/*Table structure for table `product_rating` */

DROP TABLE IF EXISTS `product_rating`;

CREATE TABLE `product_rating` (
  `product_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_assign_role_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_rating_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_rating_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_rating` */

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(200) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`state_id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `state_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `state` */

insert  into `state`(`state_id`,`state_name`,`country_id`) values 
(1,'Sindh',1),
(2,'Punjab',1),
(3,'Balochistan',1),
(4,'KPK',1),
(5,'Beijing',2),
(6,'Tibet',2),
(7,'Mumbai',3),
(8,'Delhi',3),
(9,'Rajastan',3),
(10,'Florida',4),
(11,'North Carolina',4),
(12,'Orlando',4);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_image` varchar(200) NOT NULL,
  `city_id` int(11) NOT NULL,
  `expert_level` enum('Expert','Intermediate','Beginner') NOT NULL,
  `phone_number` varchar(200) NOT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `is_active` int(1) DEFAULT 1,
  `is_approved` int(1) DEFAULT 0,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_on` timestamp NULL DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`user_id`,`first_name`,`last_name`,`gender`,`user_email`,`user_password`,`user_image`,`city_id`,`expert_level`,`phone_number`,`address`,`is_active`,`is_approved`,`added_on`,`updated_on`,`category_id`) values 
(1,'Ahmed','Shah','Male','user1@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar5.png',1,'Expert','0321-1231231','',1,1,'2021-03-25 10:26:12',NULL,1),
(2,'Aliya','Qureshi','Female','user2@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar2.png',3,'Intermediate','0311-1231231','',1,1,'2021-03-25 10:26:15',NULL,1),
(3,'Siraj','Baig','Male','user3@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar4.png',4,'Intermediate','0345-1231231','',1,1,'2021-03-25 10:26:17',NULL,1),
(5,'Nisar','Shah','Male','user4@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar4.png',5,'Beginner','0331-1231231','',1,1,'2021-03-25 10:26:19',NULL,1),
(6,'Abdullah','Shah','Male','user5@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar5.png',6,'Intermediate','0312-1231231','',0,1,'2021-03-27 15:17:06',NULL,1),
(10,'Noshad','Ali','Male','user6@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/123.jpg',2,'Intermediate','0300-1231231','H# c-1 citizen colony',1,1,'2021-03-25 10:26:23',NULL,1),
(12,'Rehman','Brohi','Male','user7@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/user1-128x128.jpg',2,'Intermediate','0312-1233214','PH-2 SUECHS',1,1,'2021-03-25 10:26:25',NULL,1),
(14,'Sajjad','Rajper','Male','user8@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/img-1.jpg',3,'Beginner','0300-1231231','PH-2 SUECHS',0,0,'2021-03-27 15:18:44',NULL,1),
(18,'Sarang','Ali','Male','user9@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/img-3.jpg',1,'Intermediate','0300-1231231','PH-1 SUECHS',1,0,'2021-03-25 10:26:29',NULL,1);

/*Table structure for table `user_assign_role` */

DROP TABLE IF EXISTS `user_assign_role`;

CREATE TABLE `user_assign_role` (
  `user_assign_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_assign_role_id`),
  KEY `user_role_id` (`user_role_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_assign_role_ibfk_1` FOREIGN KEY (`user_role_id`) REFERENCES `user_role` (`user_role_id`),
  CONSTRAINT `user_assign_role_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_assign_role` */

insert  into `user_assign_role`(`user_assign_role_id`,`user_id`,`user_role_id`) values 
(1,1,1),
(2,2,3),
(3,3,2),
(4,1,4),
(6,5,4),
(8,10,4),
(10,12,4),
(12,14,5),
(15,18,4);

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_role` */

insert  into `user_role`(`user_role_id`,`user_role`) values 
(1,'Admin'),
(2,'Academic'),
(3,'Farmer'),
(4,'Consultant'),
(5,'Other');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
