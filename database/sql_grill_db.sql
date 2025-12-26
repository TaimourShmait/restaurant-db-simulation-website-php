-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 01, 2025 at 07:24 PM
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
-- Database: `sql_grill_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_order`
--

DROP TABLE IF EXISTS `customer_order`;
CREATE TABLE IF NOT EXISTS `customer_order` (
  `customer_order_id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `customer_order_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `customer_order_total_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`customer_order_id`),
  KEY `customer_order_employee_fk` (`employee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer_order`
--

INSERT INTO `customer_order` (`customer_order_id`, `employee_id`, `customer_order_datetime`, `customer_order_total_price`) VALUES
(1, 6, '2025-12-01 15:02:18', 10.00),
(2, 6, '2025-12-01 15:05:59', 1.00),
(3, 6, '2025-12-01 15:07:53', 1.00),
(4, 6, '2025-12-01 15:08:42', 1.50),
(5, 6, '2025-12-01 15:10:50', 10.50),
(6, 3, '2025-12-01 15:12:04', 21.50),
(7, 9, '2025-12-01 15:13:44', 32.50),
(8, 9, '2025-12-01 15:29:02', 15.50),
(9, 3, '2025-12-01 15:35:59', 21.50),
(10, 3, '2025-12-01 15:40:06', 9.00),
(11, 9, '2025-12-01 15:44:48', 12.50),
(12, 3, '2025-12-01 15:51:36', 11.50),
(13, 9, '2025-12-01 15:55:52', 36.50),
(14, 3, '2025-12-01 20:20:03', 17.50),
(15, 6, '2025-12-01 20:20:13', 17.50),
(16, 3, '2025-12-01 20:21:48', 5.00),
(17, 9, '2025-12-01 20:24:03', 13.00),
(18, 9, '2025-12-01 20:24:53', 16.00),
(19, 9, '2025-12-01 20:59:14', 20.50),
(20, 3, '2025-12-01 21:10:51', 35.00);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `employee_role_id` int NOT NULL,
  `employee_manager_id` int DEFAULT NULL,
  `employee_firstname` varchar(50) NOT NULL,
  `employee_lastname` varchar(50) NOT NULL,
  `employee_phone` varchar(20) NOT NULL,
  `employee_email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `employee_phone` (`employee_phone`),
  UNIQUE KEY `employee_email` (`employee_email`),
  KEY `employee_role_fk` (`employee_role_id`),
  KEY `employee_manager_fk` (`employee_manager_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_role_id`, `employee_manager_id`, `employee_firstname`, `employee_lastname`, `employee_phone`, `employee_email`) VALUES
(1, 1, NULL, 'Bachar', 'Harb', '70942690', 'bacharharb@gmail.com'),
(2, 1, NULL, 'Maher', 'Abou Farraj', '12555654', 'maheraboufarraj@gmail.com'),
(3, 2, 1, 'Ali', 'Monzer', '80942690', NULL),
(4, 3, 5, 'Pascal', 'Ayoub', '90942690', NULL),
(5, 4, 1, 'Vlad', 'Shmodenko', '67777545', 'vladshmodenko@gmail.com'),
(6, 2, 1, 'Taimour', 'Shmait', '124765908', NULL),
(7, 3, 5, 'Tarek', 'Hajjar', '10942690', 'tarekhajjar@gmail.com'),
(8, 4, 1, 'Napoleon', 'Bonaparte', '34768908', 'napoleonbonaparte@gmail.com'),
(9, 2, 1, 'Nassim', 'Kayyal', '20000656', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_role`
--

DROP TABLE IF EXISTS `employee_role`;
CREATE TABLE IF NOT EXISTS `employee_role` (
  `employee_role_id` int NOT NULL AUTO_INCREMENT,
  `employee_role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`employee_role_id`),
  UNIQUE KEY `employee_role_name` (`employee_role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee_role`
--

INSERT INTO `employee_role` (`employee_role_id`, `employee_role_name`) VALUES
(1, 'Manager'),
(2, 'Cashier'),
(3, 'Chef'),
(4, 'Cleaner');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` int NOT NULL AUTO_INCREMENT,
  `ingredient_name` varchar(50) NOT NULL,
  PRIMARY KEY (`ingredient_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`ingredient_id`, `ingredient_name`) VALUES
(1, 'Beef Patty'),
(2, 'Chicken Breast'),
(3, 'Shredded Chicken'),
(4, 'Beef Strips'),
(5, 'Halloumi Cheese'),
(6, 'Lettuce'),
(7, 'Tomato'),
(8, 'Onion'),
(9, 'Pickles'),
(10, 'Cucumber'),
(11, 'Mixed Salad Greens'),
(12, 'Cheddar Cheese'),
(13, 'Swiss Cheese'),
(14, 'Burger Bun'),
(15, 'Toasted Bread'),
(16, 'French Bread'),
(17, 'Wrap Bread'),
(18, 'Club Bread'),
(19, 'Fries'),
(20, 'Wedges'),
(21, 'Hash Browns'),
(22, 'Garlic Mayo'),
(23, 'Mustard'),
(24, 'Ketchup'),
(25, 'Spicy Sauce'),
(26, 'Mayo');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`) VALUES
(1, 'Burgers'),
(2, 'Sandwiches'),
(3, 'Sides'),
(4, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

DROP TABLE IF EXISTS `menu_item`;
CREATE TABLE IF NOT EXISTS `menu_item` (
  `menu_item_id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `menu_item_name` varchar(50) NOT NULL,
  `menu_item_description` varchar(100) DEFAULT NULL,
  `menu_item_image_url` varchar(255) DEFAULT 'default-item.png',
  `menu_item_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`menu_item_id`),
  KEY `menu_item_menu_fk` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`menu_item_id`, `menu_id`, `menu_item_name`, `menu_item_description`, `menu_item_image_url`, `menu_item_price`) VALUES
(1, 1, 'Classic Grilled Beef Burger', 'Grilled beef patty with lettuce, tomato, and house sauce. Served with pickles.', 'default-item.png', 12.50),
(2, 1, 'NULL Burger', 'Simple beef burger with basic toppings. Served with a small side of fries.', 'default-item.png', 5.00),
(3, 1, 'Stack Burger', 'Double beef patty with cheese, lettuce, and onions. Served with fries.', 'default-item.png', 12.50),
(4, 1, 'The Big O Burger', 'Single beef patty with cheddar cheese and caramelized onions. Served with pickles.', 'default-item.png', 10.00),
(5, 1, 'Classic Chicken Burger', 'Grilled chicken breast with lettuce and light mayo. Served with pickles.', 'default-item.png', 9.00),
(6, 1, 'Spicy Beef Burger', 'Beef patty with spicy sauce, lettuce, and tomato. Served with fries.', 'default-item.png', 11.00),
(7, 2, 'Pull Chicken Sandwich', 'Shredded grilled chicken with lettuce and light mayo. Served with a small side.', 'default-item.png', 8.00),
(8, 2, 'Kernel Club Sandwich', 'Chicken club sandwich with tomato, lettuce, and cheese. Served with chips.', 'default-item.png', 10.00),
(9, 2, 'Fransisco Sandwich', 'Grilled chicken with lettuce, tomato, and garlic mayo in toasted French bread.', 'default-item.png', 8.00),
(10, 2, 'Grilled Halloumi Sandwich', 'Halloumi cheese with tomato and lettuce in toasted bread.', 'default-item.png', 7.50),
(11, 2, 'Beef Shawarma Wrap', 'Thinly sliced beef with garlic sauce and pickles. Served warm.', 'default-item.png', 7.00),
(12, 3, 'Hash Browns', 'Crispy fried hash brown potatoes. Served warm.', 'default-item.png', 4.00),
(13, 3, 'Recursive Onion Rings', 'Crispy golden onion rings. Served with dipping sauce.', 'default-item.png', 4.00),
(14, 3, 'Stacked Potato Wedges', 'Seasoned potato wedges. Served with ketchup.', 'default-item.png', 5.00),
(15, 3, 'Fries Basket', 'Freshly fried shoestring fries. Served with salt.', 'default-item.png', 3.50),
(16, 3, 'Cheese Dip', 'Warm melted cheese dip. Served as a side.', 'default-item.png', 1.00),
(17, 3, 'Side Salad', 'Fresh lettuce, cucumber, and tomato with a light dressing.', 'default-item.png', 3.00),
(18, 4, 'Soda', 'Carbonated soft drink, assorted flavors.', 'default-item.png', 1.50),
(19, 4, 'Water', 'Standard bottled still water.', 'default-item.png', 0.50),
(20, 4, 'Sparkling Water', 'Carbonated mineral water.', 'default-item.png', 1.00),
(21, 4, 'Juice', 'Fresh fruit juice selection (orange, apple, or mixed).', 'default-item.png', 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_ingredient`
--

DROP TABLE IF EXISTS `menu_item_ingredient`;
CREATE TABLE IF NOT EXISTS `menu_item_ingredient` (
  `menu_item_id` int NOT NULL,
  `ingredient_id` int NOT NULL,
  PRIMARY KEY (`menu_item_id`,`ingredient_id`),
  KEY `menu_item_ingredient_ingredient_fk` (`ingredient_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu_item_ingredient`
--

INSERT INTO `menu_item_ingredient` (`menu_item_id`, `ingredient_id`) VALUES
(1, 1),
(1, 6),
(1, 7),
(1, 9),
(1, 14),
(1, 22),
(2, 1),
(2, 6),
(2, 14),
(2, 24),
(3, 1),
(3, 6),
(3, 8),
(3, 12),
(3, 14),
(4, 1),
(4, 8),
(4, 12),
(4, 14),
(4, 24),
(5, 2),
(5, 6),
(5, 14),
(5, 26),
(6, 1),
(6, 6),
(6, 14),
(6, 25),
(7, 3),
(7, 6),
(7, 17),
(7, 26),
(8, 2),
(8, 6),
(8, 7),
(8, 12),
(8, 18),
(9, 2),
(9, 6),
(9, 7),
(9, 16),
(9, 22),
(10, 5),
(10, 6),
(10, 7),
(10, 15),
(11, 4),
(11, 9),
(11, 17),
(11, 22),
(12, 21),
(13, 8),
(14, 20),
(15, 19),
(16, 12),
(17, 6),
(17, 7),
(17, 10),
(17, 11);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `customer_order_id` int NOT NULL,
  `menu_item_id` int NOT NULL,
  `order_item_quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`customer_order_id`,`menu_item_id`),
  KEY `order_item_menu_item_fk` (`menu_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`customer_order_id`, `menu_item_id`, `order_item_quantity`) VALUES
(1, 8, 1),
(2, 19, 2),
(3, 19, 2),
(4, 19, 3),
(5, 8, 1),
(5, 19, 1),
(6, 8, 2),
(6, 19, 3),
(7, 5, 1),
(7, 1, 1),
(7, 16, 1),
(7, 18, 2),
(7, 15, 2),
(8, 5, 1),
(8, 14, 1),
(8, 18, 1),
(9, 18, 1),
(9, 4, 2),
(10, 5, 1),
(11, 1, 1),
(12, 15, 1),
(12, 12, 2),
(13, 6, 2),
(13, 16, 2),
(13, 18, 3),
(13, 9, 1),
(14, 1, 1),
(14, 2, 1),
(15, 2, 1),
(15, 1, 1),
(16, 2, 1),
(17, 2, 2),
(17, 18, 2),
(18, 18, 1),
(18, 15, 1),
(18, 6, 1),
(19, 2, 1),
(19, 1, 1),
(19, 18, 2),
(20, 16, 1),
(20, 11, 1),
(20, 21, 1),
(20, 13, 1),
(20, 4, 1),
(20, 6, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
