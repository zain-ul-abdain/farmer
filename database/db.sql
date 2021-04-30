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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

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
(14,16,'E-Commerce'),
(15,3,'Consultancy'),
(16,6,'Consultancy'),
(17,7,'Consultancy');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4;

/*Data for the table `consultancy_service` */

insert  into `consultancy_service`(`consultancy_service_id`,`consultant`,`client`,`category_id`,`query`,`discussion_start`,`discussion_end`,`status`,`rating`,`feedback`) values 
(46,8,1,6,'Rice','2021-04-19 11:29:00','2021-04-21 10:31:25','Complete',4,'It was very nice'),
(47,8,2,6,'Fertilizer','2021-04-19 12:05:46','2021-04-21 10:33:13','Complete',5,'i got what i wanted thanks'),
(49,6,2,7,'hello','2021-04-21 10:34:46','2021-04-21 10:56:21','Complete',4,''),
(50,10,2,7,'Rice','2021-04-21 10:37:43','2021-04-21 10:56:33','Complete',5,'ok'),
(51,8,2,6,'fertiziler','2021-04-21 12:06:29','2021-04-21 12:08:51','Complete',5,'it helped me alot thanks'),
(52,8,2,6,'flour','2021-04-21 13:01:01','2021-04-21 13:04:34','Complete',1,'im not satisfied'),
(53,4,2,1,'hi','2021-04-21 13:44:12','2021-04-21 14:41:05','Complete',3,'nice'),
(54,10,2,7,'hello','2021-04-21 14:41:17','2021-04-21 14:41:17','In-Process',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

/*Data for the table `consultancy_service_chat` */

insert  into `consultancy_service_chat`(`consultancy_service_chat_id`,`consultancy_service_id`,`chat_message`,`user_assign_role_id`,`added_on`) values 
(1,46,'Rice',1,'2021-04-19 11:29:00'),
(2,46,'?',1,'2021-04-19 11:47:45'),
(3,47,'Fertilizer',2,'2021-04-19 12:05:46'),
(5,47,'??',2,'2021-04-19 12:13:30'),
(7,46,'hi ahmed',8,'2021-04-19 12:36:31'),
(8,47,'hi aliya',8,'2021-04-19 12:49:48'),
(10,46,'Hi noshad',1,'2021-04-19 14:57:26'),
(11,47,'hey how is',8,'2021-04-19 14:59:30'),
(12,47,'the day is fine',2,'2021-04-19 15:00:25'),
(13,46,'hi',1,'2021-04-20 13:18:42'),
(14,46,'hello 3',1,'2021-04-20 13:18:51'),
(15,46,'fgh',1,'2021-04-20 13:20:50'),
(16,46,'hey how is the day',1,'2021-04-20 13:22:43'),
(17,46,'good',1,'2021-04-20 13:24:32'),
(18,46,'hi',8,'2021-04-20 13:28:33'),
(19,46,'hello 55',1,'2021-04-20 13:28:53'),
(20,46,'hello 56',8,'2021-04-20 13:29:02'),
(21,46,'how are you',8,'2021-04-20 13:50:49'),
(22,46,'im fine',1,'2021-04-20 13:51:02'),
(23,49,'hello',2,'2021-04-21 10:34:46'),
(24,50,'Rice',2,'2021-04-21 10:37:43'),
(25,51,'fertiziler',2,'2021-04-21 12:06:29'),
(26,51,'use the good one',8,'2021-04-21 12:06:47'),
(27,51,'where can i get one',2,'2021-04-21 12:07:15'),
(28,51,'you can get from any near store',8,'2021-04-21 12:07:36'),
(29,51,'alright thanks alot',2,'2021-04-21 12:08:07'),
(30,51,'my pleasure',8,'2021-04-21 12:08:24'),
(31,52,'flour',2,'2021-04-21 13:01:01'),
(32,52,'yes',8,'2021-04-21 13:01:17'),
(33,52,'what to do',2,'2021-04-21 13:01:36'),
(34,52,'i dont know',8,'2021-04-21 13:01:47'),
(35,52,'so why are u a consultant',2,'2021-04-21 13:02:03'),
(36,53,'hi',2,'2021-04-21 13:44:12'),
(37,53,'hello',4,'2021-04-21 13:45:04'),
(38,53,'how are you',2,'2021-04-21 14:39:36'),
(39,54,'hello',2,'2021-04-21 14:41:17');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

/*Data for the table `customer_order` */

insert  into `customer_order`(`customer_order_id`,`user_assign_role_id`,`added_on`,`payment_method`,`billing_address`,`shipping_address`,`status`,`delivered_on`) values 
(10,1,'2021-04-28 15:24:28','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(11,1,'2021-04-29 13:52:41','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(12,1,'2021-04-30 11:10:43','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(13,1,'2021-04-30 11:11:01','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(14,1,'2021-04-30 11:16:45','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(15,1,'2021-04-30 11:28:00','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(16,1,'2021-04-30 11:29:30','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(17,1,'2021-04-30 11:29:53','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(18,1,'2021-04-30 11:31:21','Cash On Delivery','h# A-29 SUECHS phase 2','','New Order',NULL),
(19,1,'2021-04-30 11:31:33','Cash On Delivery','','','New Order',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post` */

insert  into `post`(`post_id`,`category_id`,`user_assign_role_id`,`post_title`,`post_summary`,`post_description`,`post_type`,`is_active`,`added_on`,`updated_on`,`tag`) values 
(52,1,4,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Knowledge Base',0,'2021-03-17 12:30:36',NULL,NULL),
(53,3,8,'What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Knowledge Base',1,'2021-04-14 13:01:12',NULL,NULL),
(56,1,1,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Knowledge Base',1,'2021-04-05 18:08:55',NULL,NULL),
(57,1,1,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',1,'2021-04-06 11:57:29',NULL,NULL),
(58,1,3,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',0,'2021-03-20 15:37:24',NULL,NULL),
(59,1,2,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',1,'2021-04-05 17:54:06',NULL,NULL),
(60,3,10,'Fruit','In botany, a fruit is the seed-bearing structure in flowering plants formed from the ovary after flowering. Fruits are the means by which angiosperms disseminate seeds','Fruit, the fleshy or dry ripened ovary of a flowering plant, enclosing the seed or seeds. Thus, apricots, bananas, and grapes, as well as bean pods, corn grains, tomatoes, cucumbers, and (in their shells) acorns and almonds, are all technically fruits','Knowledge Base',1,'2021-04-05 17:46:11',NULL,NULL),
(61,6,3,'Where can I get some?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. ','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#039;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','Discussion Forum',0,'2021-04-05 17:54:10',NULL,NULL),
(62,1,1,'Where can I get some?','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Where can I get some?Where can I get some?There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#039;t look even slightly believable.','Discussion Forum',0,'2021-03-27 13:20:23',NULL,NULL),
(63,6,1,'What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?','What is Lorem Ipsum What is Lorem Ipsum?What is Lorem Ipsum What is Lorem Ipsum?What is Lorem Ipsum What is Lorem Ipsum?','Discussion Forum',0,'2021-03-27 13:23:36',NULL,NULL),
(64,3,1,'Mango','A mango is a stone fruit produced from numerous species of tropical trees belonging to the flowering plant genus Mangifera, cultivated mostly for their edible fruit.','A mango is a stone fruit produced from numerous species of tropical trees belonging to the flowering plant genus Mangifera, cultivated mostly for their edible fruit. Most of these species are found in nature as wild mangoes. The genus belongs to the cashew family Anacardiaceae.','Knowledge Base',1,'2021-04-05 18:08:45',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4;

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
(121,56,'uploads/56/Capture2.PNG','image'),
(122,64,'uploads/64/mango.jpg','image'),
(123,64,'uploads/64/mangoes-chopped-and-fresh.jpg','image');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

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
(14,56,1,1,'2021-03-27 15:25:07'),
(15,61,1,1,'2021-03-30 08:59:32'),
(16,64,1,1,'2021-04-06 14:53:04'),
(17,60,1,1,'2021-04-30 11:25:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post_reply` */

insert  into `post_reply`(`post_reply_id`,`message`,`user_assign_role_id`,`post_id`,`added_on`,`is_approved`) values 
(8,'In publishing and graphic design',3,53,'2021-03-19 17:04:48',0),
(13,'In publishing and graphic design',8,53,'2021-04-14 13:01:23',1),
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
(26,'Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,Lorem Ipsum available, Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,Lorem Ipsum available, but the majority have suffered alteration in some form,but the majority have suffered alteration in some form,',1,56,'2021-03-27 15:25:59',0),
(27,'Very nice',1,61,'2021-03-30 09:00:10',0),
(28,'ok',1,56,'2021-03-30 16:12:56',0),
(29,'Lorem Ipsum available, but the majority have suffered alteration in some form,',10,60,'2021-03-30 18:32:22',0),
(30,'hello',1,64,'2021-04-06 16:34:38',0),
(31,'hello 2',2,64,'2021-04-06 16:28:02',0),
(32,'ok',1,60,'2021-04-30 11:25:35',0);

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
  `shipping_charges` int(11) DEFAULT 0,
  `is_rating_allowed` tinyint(1) NOT NULL DEFAULT 1,
  `is_comment_allowed` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `product` */

insert  into `product`(`product_id`,`category_id`,`user_assign_role_id`,`product_title`,`product_description`,`price`,`quantity`,`low_inventory`,`added_on`,`updated_on`,`updated_by`,`is_active`,`is_featured`,`is_free_shipping`,`shipping_charges`,`is_rating_allowed`,`is_comment_allowed`) values 
(1,7,1,'Carrot','The carrot is a root vegetable, usually orange in color, though purple, black, red, white, and yellow cultivars exist. They are a domesticated form of the wild carrot, Daucus carota, native to Europe and Southwestern Asia. The plant probably originated in Persia and was originally cultivated for its leaves and seeds.',100,50,20,'2021-04-30 09:53:20',NULL,NULL,1,0,1,0,1,1),
(10,3,1,'Apple','An apple is an edible fruit produced by an apple tree. Apple trees are cultivated worldwide and are the most widely grown species in the genus Malus. The tree originated in Central Asia, where its wild ancestor, Malus sieversii, is still found today. ',150,992,100,'2021-04-30 11:28:00',NULL,NULL,1,1,1,0,1,1),
(11,16,8,'Fertiliser','A fertilizer or fertiliser is any material of natural or synthetic origin that is applied to soil or to plant tissues to supply plant nutrients. Fertilizers may be distinct from liming materials or other non-nutrient soil amendments. Many sources of fertilizer exist, both natural and industrially produced.',500,30,15,'2021-04-30 09:53:27',NULL,NULL,1,1,1,0,1,1),
(14,3,10,'Mango','A mango is a stone fruit produced from numerous species of tropical trees belonging to the flowering plant genus Mangifera, cultivated mostly for their edible fruit. Most of these species are found in nature as wild mangoes. The genus belongs to the cashew family Anacardiaceae.',100,993,15,'2021-04-30 11:31:33',NULL,NULL,1,1,1,0,1,1),
(15,3,1,'Banana','A banana is an elongated, edible fruit – botanically a berry – produced by several kinds of large herbaceous flowering plants in the genus Musa. In some countries, bananas used for cooking may be called \"plantains\", distinguishing them from dessert bananas.',50,100,20,'2021-04-30 11:43:09',NULL,NULL,1,1,1,0,1,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_comment` */

insert  into `product_comment`(`product_comment_id`,`user_assign_role_id`,`product_id`,`comment`,`added_on`,`is_active`) values 
(2,1,15,'banana very nice fruit','2021-04-29 14:53:02',0),
(3,1,15,'banana very nice fruit','2021-04-29 14:53:36',0),
(4,1,14,'Mango is a summer season fruit','2021-04-29 14:54:34',0),
(5,1,11,'Fertilizer is good to grow production fast','2021-04-29 14:55:33',0),
(6,1,15,'Banana 2','2021-04-30 09:46:10',0);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_image` */

insert  into `product_image`(`product_image_id`,`product_id`,`image_path`,`is_main`,`added_on`) values 
(1,1,'https://www.jessicagavin.com/wp-content/uploads/2019/02/carrots-7-1200.jpg',1,'2021-03-10 17:58:23'),
(2,1,'pages/shop/images/img-pro-01.jpg',0,'2021-03-10 17:58:29'),
(3,1,'https://www.highmowingseeds.com/wordpress/wp-content/uploads/2017/05/dolciva_carrot-92416-039-2x2.jpg',0,'2021-03-10 17:55:13'),
(6,10,'products/10/35552.jpeg',1,'2021-03-24 18:42:12'),
(7,10,'products/10/5f4dcc3b5aa765d61d8327deb882cf99.png',0,'2021-03-24 18:41:42'),
(8,10,'products/10/71278886.jpg',0,'2021-03-24 18:41:42'),
(9,10,'products/10/Jonagold_NYAS-Apples2.png',0,'2021-03-24 18:41:42'),
(10,11,'products/11/1305505_tanks_supermix_organic_600x600.jpg',0,'2021-03-25 09:30:01'),
(11,11,'products/11/hero agri fertilizers.jpg',0,'2021-03-25 09:30:01'),
(12,11,'products/11/outlook-for-the-global-fertilizer-market.jpg',1,'2021-03-25 09:40:39'),
(19,14,'products/14/707021_3090737_mangoes_akhbar.jpg',1,'2021-03-30 18:24:59'),
(20,14,'products/14/mango.jpg',0,'2021-03-30 18:24:59'),
(21,14,'products/14/mangoes-chopped-and-fresh.jpg',0,'2021-03-30 18:24:59'),
(22,15,'products/15/42E9as7NaTaAi4A6JcuFwG-1200-80.jpg',1,'2021-04-26 14:35:55'),
(23,15,'products/15/190902_banannas_full-1440x813.jpg',0,'2021-04-26 14:35:55'),
(24,15,'products/15/271157_2200-732x549.jpg',0,'2021-04-26 14:35:55');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `product_rating` */

insert  into `product_rating`(`product_rating_id`,`user_assign_role_id`,`product_id`,`rating`,`added_on`) values 
(1,1,15,3,'2021-04-29 14:53:02'),
(2,1,15,3,'2021-04-29 14:53:36'),
(3,1,14,4,'2021-04-29 14:54:34'),
(4,1,11,4,'2021-04-29 14:55:33');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`user_id`,`first_name`,`last_name`,`gender`,`user_email`,`user_password`,`user_image`,`city_id`,`expert_level`,`phone_number`,`address`,`is_active`,`is_approved`,`added_on`,`updated_on`,`category_id`) values 
(1,'Ahmed','Shah','Male','user1@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar5.png',1,'Expert','0321-1231231','H# c-1 citizen colony',1,1,'2021-04-28 10:12:29',NULL,1),
(2,'Aliya','Qureshi','Female','user2@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar2.png',3,'Intermediate','0311-1231231','H# c-1 citizen colony',1,1,'2021-04-28 10:12:30',NULL,3),
(3,'Siraj','Baig','Male','user3@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar4.png',4,'Intermediate','0345-1231231','H# c-1 citizen colony',1,1,'2021-04-28 10:12:31',NULL,6),
(5,'Nisar','Shah','Male','user4@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar4.png',5,'Beginner','0331-1231231','H# c-1 citizen colony',1,1,'2021-04-28 10:12:31',NULL,7),
(6,'Abdullah','Shah','Male','user5@example.com','5f4dcc3b5aa765d61d8327deb882cf99','dist/img/avatar5.png',6,'Intermediate','0312-1231231','H# c-1 citizen colony',1,1,'2021-04-28 10:12:34',NULL,3),
(10,'Noshad','Ali','Male','user6@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/123.jpg',2,'Intermediate','0300-1231231','H# c-1 citizen colony',1,1,'2021-03-30 15:09:49',NULL,6),
(12,'Rehman','Brohi','Male','user7@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/user1-128x128.jpg',2,'Intermediate','0312-1233214','PH-2 SUECHS',1,1,'2021-03-30 15:09:50',NULL,7),
(14,'Sajjad','Rajper','Male','user8@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/img-1.jpg',3,'Beginner','0300-1231231','PH-2 SUECHS',1,1,'2021-04-05 18:20:02',NULL,3),
(18,'Sarang','Ali','Male','user9@example.com','5f4dcc3b5aa765d61d8327deb882cf99','images/img-3.jpg',1,'Intermediate','0300-1231231','PH-1 SUECHS',1,0,'2021-03-30 15:09:55',NULL,6);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

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
