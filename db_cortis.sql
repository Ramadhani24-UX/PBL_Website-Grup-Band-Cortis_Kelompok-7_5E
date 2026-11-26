-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_cortis
CREATE DATABASE IF NOT EXISTS `db_cortis` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_cortis`;

-- Dumping structure for table db_cortis.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Super Admin','Staff') NOT NULL DEFAULT 'Staff',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.admins: ~2 rows (approximately)
INSERT INTO `admins` (`admin_id`, `full_name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
	(1, 'Rifdah Ramadhani', 'admin', 'admin@cortis.com', '$2y$10$DNvdDrInZrrk3loiMfBVpOpuEzH26YBprkQJjVKs7Nz9to3zET886', 'Super Admin', '2026-11-25 13:26:35'),
	(2, 'Dinda Nafa Putri', 'admin2', 'DindaNafa_24@gmail.com', '$2y$10$9hkI6u0Y6ZQ4EdBfYE4P.e.towEzcz09B1BUyIzkuk9niJYVeHyPu', 'Staff', '2026-11-25 13:48:57');

-- Dumping structure for table db_cortis.albums
CREATE TABLE IF NOT EXISTS `albums` (
  `album_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `release_type` enum('EP','Single') NOT NULL,
  `release_label` varchar(30) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `description` text,
  `cover_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.albums: ~4 rows (approximately)
INSERT INTO `albums` (`album_id`, `title`, `release_type`, `release_label`, `release_date`, `description`, `cover_path`) VALUES
	(1, 'Color Outside the Lines', 'EP', '1st EP', '2025-09-08', 'A statement on self-discovery, embracing imperfections, and rejecting conventional societal rules and standards.', 'Assets/images/Color Outside the Lines.png'),
	(2, 'GreenGreen', 'EP', '2nd EP', '2026-05-04', 'Represents CORTIS\'s mature principles, dividing priorities into "Green" (pursuits) and "Red" (red flags/social pressures to reject).', 'Assets/images/GreenGreen.png'),
	(3, 'Mention Me', 'Single', 'Digital Single', '2026-02-13', 'Released as the Official Soundtrack (OST) for the American animated sports comedy film "GOAT".', 'Assets/images/Mention Me.png'),
	(4, 'It\'s Me X Redred', 'Single', 'Digital Single', '2026-06-05', 'An exclusive digital mashup track distributed on YouTube, combining the beats of CORTIS\'s "RedRed" with "It\'s Me".', 'Assets/images/It\'s Me X Redred.png');

-- Dumping structure for table db_cortis.gallery
CREATE TABLE IF NOT EXISTS `gallery` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `caption` text,
  `image_path` varchar(255) NOT NULL,
  `display_order` tinyint DEFAULT '0',
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.gallery: ~6 rows (approximately)
INSERT INTO `gallery` (`image_id`, `title`, `caption`, `image_path`, `display_order`) VALUES
	(1, 'Gallery 1', 'RedRed Concept Visual', 'Assets/images/redred.jpg', 1),
	(2, 'Gallery 2', 'GO! Stage Visual', 'Assets/images/go.jpg', 2),
	(3, 'Gallery 3', 'FaSHioN Editorial Shoot', 'Assets/images/fashion.jpg', 3),
	(4, 'Gallery 4', 'Color Concept Teaser', 'Assets/images/color.jpg', 4),
	(5, 'Gallery 5', 'Outside Concept Photo', 'Assets/images/outside.jpg', 5),
	(6, 'Gallery 6', 'Lines Concept Photo', 'Assets/images/lines.jpg', 6);

-- Dumping structure for table db_cortis.group_profile
CREATE TABLE IF NOT EXISTS `group_profile` (
  `profile_id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `name_meaning` varchar(100) DEFAULT NULL,
  `agency_name` varchar(100) DEFAULT NULL,
  `agency_website` varchar(255) DEFAULT NULL,
  `agency_contact` varchar(100) DEFAULT NULL,
  `biography` text,
  `banner_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.group_profile: ~1 rows (approximately)
INSERT INTO `group_profile` (`profile_id`, `group_name`, `name_meaning`, `agency_name`, `agency_website`, `agency_contact`, `biography`, `banner_path`) VALUES
	(1, 'CORTIS', 'Color Outside The Lines', 'Big Hit Music (a subsidiary of HYBE)', 'https://ibighit.com', 'contact@bighitmusic.com', 'CORTIS is a five-member group formed with the vision of creating meaningful music and unforgettable experiences.\r\nThrough innovative concepts, strong performances, and authentic music, CORTIS continues to connect with audiences around the world.\r\nTheir journey is defined by passion, creativity, and a commitment to pushing artistic boundaries.', 'Assets/images/CORTIS_POSTER..png');

-- Dumping structure for table db_cortis.member_profile
CREATE TABLE IF NOT EXISTS `member_profile` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `stage_name` varchar(30) NOT NULL,
  `full_name` varchar(60) DEFAULT NULL,
  `english_name` varchar(30) DEFAULT NULL,
  `position` varchar(60) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nationality` varchar(40) DEFAULT NULL,
  `height_cm` decimal(4,1) DEFAULT NULL,
  `mbti` char(4) DEFAULT NULL,
  `birth_place` varchar(50) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.member_profile: ~5 rows (approximately)
INSERT INTO `member_profile` (`member_id`, `stage_name`, `full_name`, `english_name`, `position`, `birth_date`, `nationality`, `height_cm`, `mbti`, `birth_place`, `photo_path`) VALUES
	(1, 'Martin', 'Martin Edwards Park', NULL, 'Leader & Main Rapper', '2008-03-20', 'Canadian-Korean', 190.5, NULL, NULL, 'Assets/images/member1.jpg'),
	(2, 'James', 'Chao Yu-fan', NULL, 'Main Dancer & Rapper', '2005-10-14', 'Thai-Taiwanese', 178.0, NULL, NULL, 'Assets/images/member2.jpg'),
	(3, 'Seonghyeon', 'Seo Seong-hyeon', 'Sean', 'Main Vocalist', '2009-01-13', 'South Korean', 175.0, 'INTP', NULL, 'Assets/images/member3.jpg'),
	(4, 'Keonho', 'Ahn Geon-ho', NULL, 'Vocalist & Visual', '2009-02-14', 'South Korean', NULL, NULL, 'Seoul', 'Assets/images/member4.jpg'),
	(5, 'Juhoon', 'Kim Ju-hoon', 'marco', 'Vocalist', '2008-01-03', 'South Korean', 185.0, 'ISFP', 'Seoul', 'Assets/images/member5.jpg');

-- Dumping structure for table db_cortis.products
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,0) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `weight_gram` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.products: ~6 rows (approximately)
INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `image_path`, `weight_gram`) VALUES
	(1, 'CORTIS T-Shirt', 'Kaos resmi CORTIS berbahan 100% katun combed 24s yang adem dan nyaman dengan sablon logo eksklusif.', 250000, 'Assets/images/tshirt.png', 250),
	(2, 'CORTIS Hoodie', 'Hoodie premium berbahan fleece tebal dan lembut, dilengkapi bordir logo CORTIS dan saku depan.', 450000, 'Assets/images/hoodie.png', 650),
	(3, 'CORTIS Cap', 'Topi baseball edisi terbatas dengan bordir emblem CORTIS dan tali pengatur ukuran di bagian belakang.', 180000, 'Assets/images/cap.png', 150),
	(4, 'CORTIS Tote Bag', 'Tas jinjing kanvas tebal (38x42 cm) dengan ilustrasi karakter eksklusif CORTIS, kuat untuk membawa barang harian.', 150000, 'Assets/images/totebag.png', 200),
	(5, 'CORTIS Lightstick', 'Lightstick resmi konser CORTIS dengan fitur sinkronisasi Bluetooth dan efek cahaya LED Cyan-Magenta.', 300000, 'Assets/images/lightstick.png', 400),
	(6, 'CORTIS Album Set', 'Paket album fisik resmi lengkap berisi CD, photobook eksklusif, lyric book, stiker, dan random photocard member.', 550000, 'Assets/images/albumset.png', 850);

-- Dumping structure for table db_cortis.product_variations
CREATE TABLE IF NOT EXISTS `product_variations` (
  `variation_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `size` varchar(30) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `gender_type` enum('Male','Female','Unisex') DEFAULT NULL,
  `stock` int NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`variation_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.product_variations: ~21 rows (approximately)
INSERT INTO `product_variations` (`variation_id`, `product_id`, `size`, `color`, `gender_type`, `stock`, `image_path`) VALUES
	(1, 1, 'S', 'Black', 'Unisex', 18, 'Assets/images/tshirt.png'),
	(2, 1, 'M', 'Black', 'Unisex', 30, 'Assets/images/tshirt.png'),
	(3, 1, 'L', 'Black', 'Unisex', 35, 'Assets/images/tshirt.png'),
	(4, 1, 'XL', 'Black', 'Unisex', 25, 'Assets/images/tshirt.png'),
	(5, 1, 'M', 'White', 'Unisex', 20, 'Assets/images/tshirt.png'),
	(6, 1, 'L', 'White', 'Unisex', 25, 'Assets/images/tshirt.png'),
	(7, 2, 'M', 'Jet Black', 'Unisex', 12, 'Assets/images/hoodie.png'),
	(8, 2, 'L', 'Jet Black', 'Unisex', 20, 'Assets/images/hoodie.png'),
	(9, 2, 'XL', 'Jet Black', 'Unisex', 15, 'Assets/images/hoodie.png'),
	(10, 2, 'L', 'Tosca Teal', 'Unisex', 12, 'Assets/images/hoodie.png'),
	(11, 2, 'XL', 'Tosca Teal', 'Unisex', 10, 'Assets/images/hoodie.png'),
	(12, 3, 'Adjustable', 'Black Logo', 'Unisex', 30, 'Assets/images/cap.png'),
	(13, 3, 'Adjustable', 'Off-White', 'Unisex', 25, 'Assets/images/cap.png'),
	(14, 3, 'Adjustable', 'Cyber Teal', 'Unisex', 20, 'Assets/images/cap.png'),
	(15, 4, 'Standard (38x42 cm)', 'Red Edition', 'Unisex', 35, 'Assets/images/totebag.png'),
	(16, 4, 'Standard (38x42 cm)', 'Charcoal Black', 'Unisex', 30, 'Assets/images/totebag.png'),
	(17, 5, 'Official Ver. 1', 'Cyan-Magenta LED', 'Unisex', 45, 'Assets/images/lightstick.png'),
	(18, 5, 'Concert Bundle + Strap', 'Cyan-Magenta LED', 'Unisex', 25, 'Assets/images/lightstick.png'),
	(19, 6, 'Color Outside the Lines Ver.', '1st EP Photobook Set', 'Unisex', 25, 'Assets/images/albumset.png'),
	(20, 6, 'GreenGreen Ver.', '2nd EP Photobook Set', 'Unisex', 25, 'Assets/images/albumset.png'),
	(21, 6, 'Complete Duo Set', '1st + 2nd EP Bundle', 'Unisex', 15, 'Assets/images/albumset.png');

-- Dumping structure for table db_cortis.tracks
CREATE TABLE IF NOT EXISTS `tracks` (
  `track_id` int NOT NULL AUTO_INCREMENT,
  `album_id` int NOT NULL,
  `track_number` tinyint DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `release_date` date DEFAULT NULL,
  `cover_path` varchar(255) DEFAULT NULL,
  `spotify_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `play_count` int DEFAULT '0',
  `rating` decimal(3,2) DEFAULT '0.00',
  PRIMARY KEY (`track_id`),
  KEY `album_id` (`album_id`),
  CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.tracks: ~14 rows (approximately)
INSERT INTO `tracks` (`track_id`, `album_id`, `track_number`, `title`, `release_date`, `cover_path`, `spotify_url`, `youtube_url`, `play_count`, `rating`) VALUES
	(1, 1, 1, 'GO!', '2025-08-11', 'Assets/images/GO!.png', 'https://open.spotify.com/track/6OWWZtNQORY1McaZmOrwhc', 'https://www.youtube.com/watch?v=WXS-o57VJ5w', 1500000, 4.90),
	(2, 1, 2, 'What You Want', '2025-08-18', 'Assets/images/What You Want.png', 'https://open.spotify.com/track/3rAcN3CLeSrkhIZN8PHbwb', 'https://www.youtube.com/watch?v=e2OpbOv_JiQ', 1200000, 4.85),
	(3, 1, 3, 'FaSHioN', '2025-09-08', 'Assets/images/FaSHioN.png', 'https://open.spotify.com/track/4ecdsGz3Hg6TKPwQ0ZOdJz', 'https://www.youtube.com/watch?v=42wfEs7oIP8', 2400000, 4.95),
	(4, 1, 4, 'JoyRide', '2025-09-08', 'Assets/images/JoyRide.png', 'https://open.spotify.com/track/6T17ZI0glfM2IGLdUwtnLK', 'https://www.youtube.com/watch?v=8QZeXvOjgGE', 980000, 4.80),
	(5, 1, 5, 'Lullaby', '2025-09-08', 'Assets/images/Lullaby.png', 'https://open.spotify.com/track/0nyhsAcyDj533QrXa4hUug', 'https://www.youtube.com/watch?v=8ej2YOBsimQ', 870000, 4.75),
	(6, 1, 6, 'What You Want (feat. Teezo Touchdown)', '2025-08-22', 'Assets/images/What You Want (feat. Teezo Touchdown).png', 'https://open.spotify.com/track/1pFQRreMptp3dkh64WiUNx', 'https://www.youtube.com/watch?v=J8s5-vsT_Dc', 1100000, 4.85),
	(7, 2, 1, 'TNT', '2026-05-04', 'Assets/images/TNT.png', 'https://open.spotify.com/track/7diH1qnFziArYzynk3vkr6', 'https://www.youtube.com/watch?v=kRpaqR5sbf0', 1750000, 4.90),
	(8, 2, 2, 'RedRed', '2026-04-20', 'Assets/images/RedRed.png', 'https://open.spotify.com/track/2fCwv2ppU5nTRTckomIGsd', 'https://www.youtube.com/watch?v=U6BDbXIah-Y', 2100000, 4.92),
	(9, 2, 3, 'Acai', '2026-05-04', 'Assets/images/Acai.png', 'https://open.spotify.com/track/7Ldcvhcl4Xj4eOTSWpZus5', 'https://www.youtube.com/watch?v=nCElUD0jvgo', 920000, 4.80),
	(10, 2, 4, 'YoungCreatorCrew', '2026-05-04', 'Assets/images/YoungCreatorCrew.png', 'https://open.spotify.com/track/2vKNzC9T3kdU2JECcvob3V', 'https://www.youtube.com/watch?v=tCSBgOIA63M', 1050000, 4.82),
	(11, 2, 5, 'Wassup', '2026-05-04', 'Assets/images/Wassup.png', 'https://open.spotify.com/track/3dCdcURa0Kk5UWXRY00HQy', 'https://www.youtube.com/watch?v=oEow4l7mP7c', 890000, 4.78),
	(12, 2, 6, 'Blue Lips', '2026-05-04', 'Assets/images/Blue Lips.png', 'https://open.spotify.com/track/1VyXprVXZYNGWWZf1u4JfN', 'https://www.youtube.com/watch?v=hOIY3OhvD94', 960000, 4.81),
	(13, 3, 1, 'Mention Me', '2026-02-13', 'Assets/images/Mention Me (2).png', 'https://open.spotify.com/track/3f0OEJd7mlPNhmH3fUOrqy', 'https://www.youtube.com/watch?v=iGGxMGeJzmw', 1350000, 4.88),
	(14, 4, 1, 'It\'s Me X Redred', '2026-06-05', 'Assets/images/It\'s Me X Redred (2).png', 'https://open.spotify.com/playlist/1u6HN7g47i4sCELDWgemWp', 'https://www.youtube.com/watch?v=XAZWDEljjdk', 1150000, 4.84);

-- Dumping structure for table db_cortis.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `courier_service` varchar(50) DEFAULT NULL,
  `shipping_cost` decimal(10,0) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_weight` int DEFAULT NULL,
  `grand_total` decimal(12,0) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `status` enum('Pending','Paid','Shipped','Completed') NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.transactions: ~1 rows (approximately)
INSERT INTO `transactions` (`transaction_id`, `customer_name`, `customer_phone`, `shipping_address`, `courier_service`, `shipping_cost`, `payment_method`, `total_weight`, `grand_total`, `transaction_date`, `status`) VALUES
	(2, 'Rifdah Ramadhani', '087716809798', 'Jalan H Rais A Rahman', 'Standard Delivery', 0, 'Transfer Bank', 650, 450000, '2026-11-26 11:26:22', 'Pending');

-- Dumping structure for table db_cortis.transaction_details
CREATE TABLE IF NOT EXISTS `transaction_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `variation_id` int NOT NULL,
  `quantity` int NOT NULL,
  `subtotal_price` decimal(10,0) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `variation_id` (`variation_id`),
  CONSTRAINT `transaction_details_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaction_details_ibfk_2` FOREIGN KEY (`variation_id`) REFERENCES `product_variations` (`variation_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_cortis.transaction_details: ~1 rows (approximately)
INSERT INTO `transaction_details` (`detail_id`, `transaction_id`, `variation_id`, `quantity`, `subtotal_price`) VALUES
	(2, 2, 7, 1, 450000);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
