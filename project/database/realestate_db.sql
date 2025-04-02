-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2025 at 11:29 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realestate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int NOT NULL,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_comments_user` (`user_id`),
  KEY `fk_comments_property` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `property_id`, `user_id`, `comment`, `date`) VALUES
(1, 2, 'USR_6292', 'facilitys of this office is supper. i like it.', '2025-02-24 10:55:28'),
(2, 1, 'USR_6292', 'Oh wow, this house is a dream! I can already picture myself living here.', '2025-02-24 10:56:39'),
(3, 1, 'USR_6292', 'it is really supper.', '2025-02-24 10:56:52'),
(7, 3, 'USR_6292', 'ohh this house is very beautifull and all facilites available, but rent is high for me.', '2025-02-24 11:22:21'),
(8, 3, 'USR_6292', 'if i am rich then i buy this type of house.', '2025-02-24 11:23:01'),
(9, 3, 'USR_414', 'i need to see this house for rent. where is contect number of owner.', '2025-02-25 04:09:43'),
(10, 3, 'USR_414', 'ok, got it in view property.', '2025-02-25 04:10:44'),
(11, 1, 'USR_5687', 'ohh i like this house, it is beatiful but my family shift permanently canada or also i sell my flat at bhavnagar named royal heights. i rquest all gays please serch it or see it.', '2025-02-25 05:12:20'),
(12, 4, 'USR_5687', 'my brother also have one office in same building.', '2025-02-25 05:13:51'),
(13, 4, 'USR_5687', 'this building is created with morden design.', '2025-02-25 05:16:06'),
(14, 5, 'USR_5687', 'this property is my or intrested person please contect me as soon as posible.', '2025-02-25 05:17:23'),
(15, 6, 'USR_5687', 'interested persons contect me as soon as or also i seel my 3bhk flat at royal hieghts also show it or contect me for buying perpose', '2025-02-25 05:33:08'),
(16, 3, 'USR_3410', 'ohh this house is exactly what I was looking for when I rent it.', '2025-02-25 05:40:44'),
(17, 3, 'USR_3410', 'or also near to my office. plese leave this for me i need to rent it.', '2025-02-25 05:41:39'),
(18, 6, 'USR_3410', 'this office is only for sell , if any person need to rent it so..', '2025-02-25 05:43:10'),
(19, 6, 'USR_3410', 'because my sibling need to this type of office in bhavnagar.', '2025-02-25 05:44:19'),
(20, 7, 'USR_9922', 'rent is high but location is fine so perfect shop to open new start up.', '2025-02-25 06:49:57'),
(21, 8, 'USR_9922', 'for rent contect fast otherwise you miss oportunity for rent it.', '2025-02-25 06:58:38'),
(22, 5, 'USR_414', 'furniture status is fine, but i not need to leave ahemdabad. if this same flat in ahemdabad then i buy it.', '2025-02-25 07:25:13'),
(23, 5, 'USR_414', 'wow, wonderfull flat sell on wonder property.', '2025-02-25 07:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_messages_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `submitted_at`, `user_id`) VALUES
(2, 'vishal', 'vishal2004@gamil.com', 'i need to rent new velly house, but it\'s owner not recieve my call, befor any one else rent it please cantact me with it\'s owner.', '2025-02-25 09:52:31', 'USR_414'),
(5, 'Om Dhameliya', 'ompatel@gmail.com', 'i need to visit one house for buy it , how to..', '2025-02-26 17:18:20', 'USR_6292');

-- --------------------------------------------------------

--
-- Table structure for table `postproperty`
--

DROP TABLE IF EXISTS `postproperty`;
CREATE TABLE IF NOT EXISTS `postproperty` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `property_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `offer` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `deposite` decimal(10,2) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `furnished` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bhk` int NOT NULL,
  `bedroom` int NOT NULL,
  `bathroom` int NOT NULL,
  `balcony` int NOT NULL,
  `carpet` int NOT NULL,
  `age` int NOT NULL,
  `total_floors` int NOT NULL,
  `room_floor` int NOT NULL,
  `loan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lift` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `security_guard` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `play_ground` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `garden` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `water_supply` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `power_backup` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `fire_security` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `parking_area` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `gym` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `cctv_cameras` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `shopping_mall` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `hospital` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `school` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `market_area` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'no',
  `image_01` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_02` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_03` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_04` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_05` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `postproperty`
--

INSERT INTO `postproperty` (`id`, `user_id`, `property_name`, `type`, `offer`, `price`, `deposite`, `address`, `city`, `state`, `status`, `furnished`, `bhk`, `bedroom`, `bathroom`, `balcony`, `carpet`, `age`, `total_floors`, `room_floor`, `loan`, `description`, `lift`, `security_guard`, `play_ground`, `garden`, `water_supply`, `power_backup`, `fire_security`, `parking_area`, `gym`, `cctv_cameras`, `shopping_mall`, `hospital`, `school`, `market_area`, `image_01`, `image_02`, `image_03`, `image_04`, `image_05`, `date`) VALUES
(1, 'USR_6292', 'Infinity Villa', 'house', 'sale', 8500000.00, 400000.00, '20,aaditya soci, near vip circal', 'surat', 'gujarat', 'ready to move', 'furnished', 3, 3, 2, 1, 250, 5, 1, 2, 'available', 'This beautifully designed 3BHK house is located in the heart of the city, offering easy access to all essential amenities. Situated in a well-developed and sought-after area, this home is fully furnished, ensuring comfort and style. A perfect choice for families looking for a modern and convenient living space!', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'house-2.jpeg', 'badroom-2.jpg', 'house-extra-2.jpg', 'kichen-2.jpg', 'bathroom-2.jpeg', '2025-02-22 20:35:46'),
(2, 'USR_6292', 'green square', 'office', 'sale', 7000000.00, 500000.00, '404,silver poin,4th floor near jivan jyot circle', 'surat', 'gujarat', 'ready to move', 'furnished', 1, 0, 1, 1, 310, 10, 0, 0, 'available', 'Fully equipped IT office for sale, featuring modern workspaces, high-speed internet, and a prime location. Ideal for tech firms, startups, or business expansion.', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', '1741059907_office-2.jpg', '1741059907_office-2.1.jpg', '', '', '', '2025-02-23 20:18:08'),
(3, 'USR_9922', 'new velly', 'house', 'rent', 25000.00, 10000.00, '101 new haridarshn, nava gam variyav', 'surat', 'gujarat', 'ready to move', 'furnished', 3, 3, 3, 1, 265, 12, 1, 2, 'not available', 'A well-maintained 3BHK house with spacious rooms, a modular kitchen, and good ventilation. Ideal for a comfortable and convenient stay.', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', '1740466082_house-3.jpeg', '1740466082_badroom-3.jpg', '1740466082_kichen-3.jpg', '1740466082_bathroom-3.jpeg', '1740466082_house-extra-3.jpg', '2025-02-24 16:36:01'),
(4, 'USR_414', 'PixelWork', 'office', 'sale', 12000000.00, 800000.00, '302 atlanta, near power house', 'ahmedabad', 'gujarat', 'ready to move', 'furnished', 0, 0, 0, 0, 272, 10, 7, 0, 'available', 'this propertry is on 3rd floor or beilding has total 7 floors , or fully furnished for any start us IT company, all furniture is as it is at sell time.or also office has 3 diffrent office rooms like meeting room, work room etc..', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'offic-1.jpg', 'office-1.1.jpg', 'office-1.2.jpg', '', '', '2025-02-25 10:16:13'),
(5, 'USR_5687', 'Royal Heights', 'flat', 'sale', 1600000.00, 800000.00, '12\'th floor royal heights, near new ambika', 'bhavnagar', 'gujarat', 'ready to move', 'furnished', 3, 3, 3, 2, 320, 13, 15, 12, 'available', 'this flat is fully furnished or perfect for join family, or only 3.5km away from highway. i sell it because my family shift permanently canada so all things like shofa, bed or other as it is.', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'flat-1.jpg', 'badroom-1.jpg', 'kichen-1.jpg', 'bathroom-1.jpg', 'flat-extra-1.jpg', '2025-02-25 10:37:26'),
(6, 'USR_5687', 'Opal Workspace', 'office', 'sale', 14000000.00, 700000.00, '601 opera business center, waghawadi', 'bhavnagar', 'gujarat', 'ready to move', 'furnished', 0, 0, 0, 1, 240, 14, 11, 0, 'available', 'this office has 2 diffrent rooms for work, and aslo one owener cabin. whole office is fully furnised and i sell it as it is because my family shift permnantly canada.or this business help in improve your business because of standerd location.', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'office-5.jpg', 'office-5.1.jpg', 'office-5.2.jpg', '', '', '2025-02-25 11:01:24'),
(7, 'USR_3410', 'Atul Bakery', 'shop', 'rent', 12000.00, 3500.00, '15 maruti tred center,  near kiran chowk', 'surat', 'gujarat', 'ready to move', 'semi-furnished', 0, 0, 0, 0, 170, 13, 0, 0, 'not available', 'this cake shop serving happening 10 year or complate regular shop with some client who buy cake from our shop. furniture status is 50% complate but you can add your related furniture. standersd palce because near to collage.', 'no', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'shop-2.jpg', 'shop-2.1.jpg', '', '', '', '2025-02-25 12:14:33'),
(8, 'USR_9922', 'Sunset Haven', 'house', 'rent', 28000.00, 8000.00, '40 sunset city, near canal road', 'surat', 'gujarat', 'ready to move', 'furnished', 3, 3, 2, 1, 250, 9, 1, 2, 'not available', 'this house fully furnished or perfect for join family. or at center in city so all facilites in near area are available.', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'house-1.jpeg', 'badroom-1.jpg', 'kichen-1.jpg', 'bathroom-1.jpeg', 'house-extra-1.jpg', '2025-02-25 12:27:51'),
(9, 'USR_414', 'Dream Haven', 'house', 'sale', 14500000.00, 500000.00, '18 gokul dham, near bapu nagar', 'ahmedabad', 'gujarat', 'ready to move', 'furnished', 3, 3, 2, 1, 260, 6, 1, 2, 'available', 'Built 6 years ago, this house is in excellent condition, offering a perfect blend of comfort and durability.society states is exelent or In society, all festivals are joyfully celebrated by the residents, fostering unity and happiness among everyone!', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'house-5.jpeg', 'badroom-5.jpg', 'kichen-5.jpg', 'bathroom-5.jpeg', 'house-extra-5.jpg', '2025-02-25 12:47:01'),
(10, 'USR_414', 'sai krupa', 'house', 'rent', 22000.00, 5000.00, '45 sai krupa rohouse, near street road', 'ahmedabad', 'gujarat', 'ready to move', 'furnished', 2, 2, 2, 1, 210, 7, 0, 0, 'not available', 'this house is outside the main city but all facilities are available and also house furniture status is good.', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'house-8.jpeg', 'badroom-8.jpg', 'kichen-8.jpg', 'bathroom-8.jpeg', '', '2025-02-25 14:36:21'),
(11, 'USR_6292', 'Silver Heights', 'flat', 'rent', 30000.00, 5000.00, '501 silver heights, near mishion road', 'vadodara', 'gujarat', 'ready to move', 'furnished', 2, 2, 2, 1, 270, 8, 12, 5, 'not available', 'this flat is complatly rady to move and also or furniture like bed,sofa , chair is as it is with rent.it is good oportunity to rent is and make your dreams true.', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'flat-2.jpg', 'badroom-2.jpg', 'kichen-2.jpg', 'bathroom-2.jpg', 'flat-extra-2.jpg', '2025-02-25 14:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `owener_id` varchar(20) NOT NULL,
  `property_id` int NOT NULL,
  `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_request_user` (`user_id`),
  KEY `fk_request_property` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `user_id`, `owener_id`, `property_id`, `request_date`) VALUES
(33, 'USR_414', 'USR_9922', 3, '2025-02-25 09:41:15'),
(34, 'USR_3410', 'USR_9922', 3, '2025-02-25 11:08:47'),
(35, 'USR_414', 'USR_5687', 5, '2025-02-25 12:56:00'),
(49, 'USR_6292', 'USR_9922', 3, '2025-03-09 09:31:04'),
(50, 'USR_9922', 'USR_6292', 11, '2025-03-09 09:31:42'),
(58, 'USR_6292', 'USR_414', 10, '2025-04-02 14:07:36');

-- --------------------------------------------------------

--
-- Table structure for table `saved_properties`
--

DROP TABLE IF EXISTS `saved_properties`;
CREATE TABLE IF NOT EXISTS `saved_properties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `property_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_saved_user` (`user_id`),
  KEY `fk_saved_property` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `saved_properties`
--

INSERT INTO `saved_properties` (`id`, `user_id`, `property_id`) VALUES
(44, 'USR_6292', 1),
(45, 'USR_9922', 2),
(46, 'USR_6292', 2),
(47, 'USR_6292', 3),
(48, 'USR_414', 3),
(49, 'USR_414', 1),
(50, 'USR_5687', 1),
(52, 'USR_3410', 6),
(53, 'USR_414', 5),
(54, 'USR_3410', 3),
(78, 'USR_9922', 11);

-- --------------------------------------------------------

--
-- Table structure for table `user_ragister`
--

DROP TABLE IF EXISTS `user_ragister`;
CREATE TABLE IF NOT EXISTS `user_ragister` (
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_ragister`
--

INSERT INTO `user_ragister` (`user_id`, `fname`, `lname`, `age`, `email`, `mobile`, `password`, `created_at`) VALUES
('USR_3410', 'tulsi', 'bhatasana', '29', 'tulsi1221@gmail.com', '9638103636', 'tulsi@123', '2025-02-25 06:09:22'),
('USR_414', 'vishal', 'Botadara', '22', 'vishal2004@gamil.com', '6358163142', '@12345678', '2025-02-16 03:00:37'),
('USR_5687', 'jensi', 'markana', '31', 'jensi20@gmail.com', '9909276610', 'jensi@123', '2025-02-25 05:03:11'),
('USR_6292', 'om', 'dhameliya', '20', 'ompatel@gmail.com', '9313739003', 'ompatel003', '2025-02-18 06:46:24'),
('USR_9922', 'kamlesh', 'baldaniya', '21', 'kamlesh@gmail.com', '9099836310', 'kamlesh@123', '2025-02-24 11:02:48');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_property` FOREIGN KEY (`property_id`) REFERENCES `postproperty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `user_ragister` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_user` FOREIGN KEY (`user_id`) REFERENCES `user_ragister` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `postproperty`
--
ALTER TABLE `postproperty`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_ragister` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `fk_request_property` FOREIGN KEY (`property_id`) REFERENCES `postproperty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_request_user` FOREIGN KEY (`user_id`) REFERENCES `user_ragister` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_properties`
--
ALTER TABLE `saved_properties`
  ADD CONSTRAINT `fk_saved_property` FOREIGN KEY (`property_id`) REFERENCES `postproperty` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_saved_user` FOREIGN KEY (`user_id`) REFERENCES `user_ragister` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
