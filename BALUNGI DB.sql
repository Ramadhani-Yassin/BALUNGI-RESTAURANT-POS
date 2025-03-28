-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 07:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurantdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `register_date` date DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `email`, `register_date`, `phone_number`, `password`) VALUES
(1, 'yasynramah@gmail.com', '0000-00-00', '0621060107', '12345678'),
(2, 'yasynramah@gmail.com', '2025-03-17', '0621060107', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `bill_id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `card_id` int(11) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `bill_time` datetime DEFAULT NULL,
  `payment_time` datetime DEFAULT NULL,
  `creditor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `staff_id`, `member_id`, `reservation_id`, `table_id`, `card_id`, `payment_method`, `bill_time`, `payment_time`, `creditor_id`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:16:51', NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:16:56', NULL, NULL),
(4, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-19 15:16:56', '2025-03-19 15:17:12', NULL),
(5, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 15:18:10', '2025-03-19 15:25:06', 4),
(6, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:34:48', NULL, NULL),
(7, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 15:37:41', '2025-03-19 15:37:55', 4),
(8, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:40:16', NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:40:18', NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 16:11:53', NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 18:42:42', NULL, NULL),
(12, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 18:42:44', '2025-03-19 19:24:52', 1),
(13, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 21:10:06', '2025-03-19 21:10:20', 1),
(14, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 10:39:18', NULL, NULL),
(15, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 11:06:15', NULL, NULL),
(16, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-20 11:06:56', '2025-03-20 11:07:12', 4),
(17, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-20 11:07:37', '2025-03-20 11:07:58', NULL),
(18, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-20 11:10:01', '2025-03-20 11:10:15', NULL),
(19, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 11:11:17', NULL, NULL),
(20, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-20 11:11:19', '2025-03-20 11:11:30', NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:57:12', NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 07:06:00', NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 07:07:24', NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 07:09:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `bill_item_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `item_id` varchar(6) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`bill_item_id`, `bill_id`, `item_id`, `quantity`) VALUES
(36, 4, 'F001', 2),
(37, 5, 'F001', 3),
(38, 6, 'F001', 4),
(39, 7, 'F001', 3),
(40, 10, 'F001', 3),
(41, 12, 'F001', 3),
(42, 13, 'F004', 3),
(43, 16, 'F001', 4),
(44, 17, 'F068', 5),
(45, 18, 'F004', 4),
(46, 20, 'F002', 3);

-- --------------------------------------------------------

--
-- Table structure for table `card_payments`
--

CREATE TABLE `card_payments` (
  `card_id` int(11) NOT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `security_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creditors`
--

CREATE TABLE `creditors` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Due_Amount` decimal(10,2) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creditors`
--

INSERT INTO `creditors` (`ID`, `Name`, `Due_Amount`, `Date`, `Telephone`) VALUES
(1, 'Admins', 90000.00, '2025-03-18 08:57:09', '+2556210'),
(4, 'RAMADHANI RAMADHANI', 80000.00, '2025-03-19 15:39:56', '+255621060107');

-- --------------------------------------------------------

--
-- Table structure for table `kitchen`
--

CREATE TABLE `kitchen` (
  `kitchen_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `item_id` varchar(6) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `time_submitted` datetime DEFAULT NULL,
  `time_ended` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kitchen`
--

INSERT INTO `kitchen` (`kitchen_id`, `table_id`, `item_id`, `quantity`, `time_submitted`, `time_ended`) VALUES
(1, NULL, 'F001', 20, '2025-03-16 21:54:28', '2025-03-16 21:54:52'),
(2, NULL, 'F025', 20, '2025-03-16 22:04:26', '2025-03-16 22:04:39'),
(3, NULL, 'F068', 5, '2025-03-18 07:35:26', '2025-03-18 07:35:34'),
(4, NULL, 'F001', 4, '2025-03-18 07:48:16', '2025-03-18 07:48:37'),
(5, NULL, 'F001', 3, '2025-03-18 22:11:57', '2025-03-19 15:42:06'),
(6, NULL, 'F001', 3, '2025-03-18 22:16:11', '2025-03-19 15:42:07'),
(7, NULL, 'F001', 3, '2025-03-18 22:17:04', '2025-03-19 15:42:07'),
(8, NULL, 'F001', 3, '2025-03-18 22:19:45', '2025-03-19 15:42:07'),
(9, NULL, 'F001', 3, '2025-03-18 22:22:18', '2025-03-19 15:42:08'),
(10, NULL, 'F001', 3, '2025-03-19 08:32:39', '2025-03-19 15:42:08'),
(11, NULL, 'F001', 4, '2025-03-19 08:40:52', '2025-03-19 15:42:08'),
(12, NULL, 'F001', 3, '2025-03-19 08:47:44', '2025-03-19 15:42:08'),
(13, NULL, 'F001', 4, '2025-03-19 08:50:17', '2025-03-19 15:42:09'),
(14, NULL, 'F001', 5, '2025-03-19 08:55:51', '2025-03-19 15:42:09'),
(15, NULL, 'F001', 3, '2025-03-19 09:02:14', '2025-03-19 15:42:09'),
(16, NULL, 'F001', 2, '2025-03-19 15:17:02', '2025-03-19 15:42:09'),
(17, NULL, 'F001', 3, '2025-03-19 15:18:15', '2025-03-19 15:42:09'),
(18, NULL, 'F001', 4, '2025-03-19 15:34:52', '2025-03-19 15:42:09'),
(19, NULL, 'F001', 3, '2025-03-19 15:37:45', '2025-03-19 15:42:10'),
(20, NULL, 'F001', 3, '2025-03-19 16:11:57', '2025-03-21 07:05:39'),
(21, NULL, 'F001', 3, '2025-03-19 19:24:01', '2025-03-21 07:05:40'),
(22, NULL, 'F004', 3, '2025-03-19 21:10:14', '2025-03-21 07:05:41'),
(23, NULL, 'F001', 4, '2025-03-20 11:07:02', '2025-03-21 07:05:41'),
(24, NULL, 'F068', 5, '2025-03-20 11:07:52', '2025-03-21 07:05:41'),
(25, NULL, 'F004', 4, '2025-03-20 11:10:08', '2025-03-21 07:05:41'),
(26, NULL, 'F002', 3, '2025-03-20 11:11:25', '2025-03-21 07:05:42');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`member_id`, `member_name`, `points`, `account_id`) VALUES
(1, 'Default ', 2665550, 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `item_id` varchar(6) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_type` varchar(255) DEFAULT NULL,
  `item_category` varchar(255) DEFAULT NULL,
  `item_price` decimal(10,2) DEFAULT NULL,
  `item_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`item_id`, `item_name`, `item_type`, `item_category`, `item_price`, `item_description`) VALUES
('F001', 'THE BIG BREAKFAST', 'BREAKFAST', 'Main Dishes', 20000.00, ' Cofee or tea, Fresh fruit juice, Fruit of the day, Pancakes (2 pcs),Sausages (2 pcs), A slice of, toasted bread & Eggs (2 pcs).'),
('F002', ' Pancakes ', 'BREAKFAST', 'Main Dishes', 12000.00, 'Banana and Nutella, fetta cheese, tomato, \r\nlettuce and hubs.'),
('F003', 'Porridge', 'BREAKFAST', 'Main Dishes', 10000.00, 'With peanut butter, cinamon and fresh fruits'),
('F004', 'Fruit Platter', 'BREAKFAST', 'Main Dishes', 10000.00, 'Fruit Platter'),
('F005', 'Breakfast on Toast ', 'BREAKFAST', 'Main Dishes', 12000.00, 'With cheese, omlet, bacon, tomato, mustard,\r\nmayonaise'),
('F006', 'Bread with homemade topping', 'BREAKFAST', 'Main Dishes', 15000.00, 'Bacon, tomatoes, sausage, fried eggs, egg\r\npaste and crunch onion.'),
('F007', 'Balungi choice of eggs ', 'BREAKFAST', 'Main Dishes', 8000.00, 'Omlet (Plain, spanish or cheese), Scrumbled, Sunny side up One side\r\nBoiled'),
('F008', 'Sausages ', 'BREAKFAST', 'Main Dishes', 4000.00, 'Sausages '),
('F009', 'Cake', 'BREAKFAST', 'Main Dishes', 5000.00, 'Cake'),
('F010', 'Conflakes', 'BREAKFAST', 'Main Dishes', 7000.00, 'Conflakes'),
('F011', ' Clear veggie soup', 'STARTERS', 'Main Dishes', 10000.00, ' Clear veggie soup'),
('F012', ' Cream veggie soup', 'STARTERS', 'Main Dishes', 10000.00, ' Cream veggie soup'),
('F013', 'Chicken soup', 'STARTERS', 'Main Dishes', 13000.00, ' Chicken soup'),
('F0138', 'meal', 'PIZZA', 'Main Dishes', 99999999.99, 'TYU'),
('F014', 'Pumpkin and ginger soup', 'STARTERS', 'Main Dishes', 10000.00, 'Pumpkin and ginger soup'),
('F015', 'Fish soup', 'STARTERS', 'Main Dishes', 13000.00, ' Fish soup'),
('F016', 'Seafood soup', 'STARTERS', 'Main Dishes', 16000.00, ' Seafood soup'),
('F017', 'Beef soup', 'STARTERS', 'Main Dishes', 13000.00, 'Beef soup'),
('F018', ' Kvasha - Salad', 'STARTERS', 'Main Dishes', 10000.00, 'Cabbage, carrots, olive oil, lime and pepper'),
('F019', 'Leyer ‘Green’  - Salad', 'STARTERS', 'Main Dishes', 12000.00, 'Cabbage, carrots, sweet green pepper,\r\ncucumber, tomato, oil, salt and pepper.'),
('F020', 'Mshamba - Salad ', 'STARTERS', 'Main Dishes', 12000.00, 'Lettuce, cucumber, g-pepper, corriander,\r\ntomato, olive oil, salt and pepper'),
('F021', ' Mr. ‘A’ - Salad', 'STARTERS', 'Main Dishes', 12000.00, 'Avocado, tomato, g-pepper, cahew nuts, olive\r\noil, lime, salt and pepper'),
('F022', 'Seafood Salad ', 'STARTERS', 'Main Dishes', 20000.00, 'Calamari, octopus, sh, prawns, tomato, lettuce,\r\nlimes, salt and pepper.'),
('F023', 'Tomato & Cucumber - Salad', 'STARTERS', 'Main Dishes', 10000.00, 'Tomato slices, cucumber and dressing'),
('F024', 'Octopus with sweet chill - Salad', 'STARTERS', 'Main Dishes', 15000.00, 'Octopus with sweet chill - Salad'),
('F025', 'Chicken Hawaii Salad', 'STARTERS', 'Main Dishes', 15000.00, 'Lettuce, chicken, cucumber, pineaple, mayo, salt\r\nand pepper.'),
('F026', 'Fish fillet', 'GRILLED • FRIED', 'Main Dishes', 30000.00, 'Fish fillet'),
('F027', 'King fish', 'GRILLED • FRIED', 'Main Dishes', 30000.00, 'King fish'),
('F028', 'Whole fish', 'GRILLED • FRIED', 'Main Dishes', 27000.00, 'Whole fish'),
('F029', 'Calamari ', 'GRILLED • FRIED', 'Main Dishes', 27000.00, 'Calamari '),
('F030', ' Octopus ', 'GRILLED • FRIED', 'Main Dishes', 27000.00, ' Octopus '),
('F031', 'Prawns', 'GRILLED • FRIED', 'Main Dishes', 50000.00, ' Prawns'),
('F032', ' Lobster', 'GRILLED • FRIED', 'Main Dishes', 35000.00, ' Lobster'),
('F033', 'Special seafood platter', 'GRILLED • FRIED', 'Main Dishes', 120000.00, 'Lobster, calamari, fish, octopus and prawns.'),
('F034', 'Grilled beef fillet ', 'GRILLED • FRIED', 'Main Dishes', 30000.00, 'Grilled beef fillet '),
('F035', 'Grilled beef skewers', 'GRILLED • FRIED', 'Main Dishes', 25000.00, 'Grilled beef skewers'),
('F036', 'Grilled chicken', 'GRILLED • FRIED', 'Main Dishes', 27000.00, 'Grilled chicken'),
('F037', 'Seafood - Curry In Coconut Sauce', 'GRILLED • FRIED', 'Main Dishes', 30000.00, 'Seafood - Curry In Coconut Sauce'),
('F038', ' Fish -  Curry In Coconut Sauce', 'GRILLED • FRIED', 'Main Dishes', 25000.00, ' Fish -  Curry In Coconut Sauce'),
('F039', 'Chicken - Curry In Coconut Sauce', 'GRILLED • FRIED', 'Main Dishes', 25000.00, 'Chicken - Curry In Coconut Sauce'),
('F040', 'Octopus - Curry in Coconut Sauce', 'GRILLED • FRIED', 'Main Dishes', 250000.00, 'Octopus - Curry in Coconut Sauce'),
('F041', ' Calamari - Curry In Coconut Sauce', 'GRILLED • FRIED', 'Main Dishes', 25000.00, ' Calamari - Curry In Coconut Sauce'),
('F042', 'Vegetables -  Curry In Coconut Sauce', 'GRILLED • FRIED', 'Main Dishes', 20000.00, 'Vegetables -  Curry In Coconut Sauce'),
('F043', 'Eggs curry', 'GRILLED • FRIED', 'Main Dishes', 14000.00, 'Eggs curry'),
('F044', 'Pumpkin Rissoto', 'GRILLED • FRIED', 'Main Dishes', 25000.00, ' Pumpkin Rissoto'),
('F045', 'Beef Masala', 'GRILLED • FRIED', 'Main Dishes', 27000.00, 'Beef Masala'),
('F046', ' Fish fingers - Deep Fried', 'GRILLED • FRIED', 'Main Dishes', 25000.00, ' Fish fingers - Deep Fried'),
('F047', 'Octopus - Deep Fried', 'GRILLED • FRIED', 'Main Dishes', 28000.00, ' Octopus - Deep Fried'),
('F048', ' Calamari Tempura - Deep Fried', 'GRILLED • FRIED', 'Main Dishes', 28000.00, ' Calamari Tempura - Deep Fried'),
('F049', 'Whole fish - Deep Fried', 'GRILLED • FRIED', 'Main Dishes', 25000.00, 'Whole fish - Deep Fried'),
('F050', 'Bolognaise ', 'PASTAS & MORE', 'Main Dishes', 23000.00, 'Spagheti or penne \r\n'),
('F051', 'Pasta with tomato', 'PASTAS & MORE', 'Main Dishes', 15000.00, 'Spaghetti, penne or fusil'),
('F052', 'Seafood with tomato and cream', 'PASTAS & MORE', 'Main Dishes', 27000.00, 'Spaghetti, penne or fusil'),
('F053', 'Spaghetti, fusil, penne matriciana', 'PASTAS & MORE', 'Main Dishes', 25000.00, ' Spaghetti, fusil, penne matriciana'),
('F054', 'Homemade creamy veggie', 'PASTAS & MORE', 'Main Dishes', 18000.00, 'Spaghetti or fusil'),
('F055', 'Fish or octopus with tomatoes', 'PASTAS & MORE', 'Main Dishes', 25000.00, 'Spaghetti or penne'),
('F056', 'Stir strip fry noodles with nuts', 'PASTAS & MORE', 'Main Dishes', 20000.00, 'Veggie, beef or chicken'),
('F057', 'Heavy burger', 'PASTAS & MORE', 'Main Dishes', 25000.00, 'Beef, chicken, fish or veggie with cheese and\r\nomlet + fries'),
('F058', 'Chapati wraps', 'PASTAS & MORE', 'Main Dishes', 20000.00, 'Egg, veggie, chicken or fish + fries/chips'),
('F059', 'Sambusa rolls', 'PASTAS & MORE', 'Main Dishes', 15000.00, 'Veggie, beef or mixed'),
('F060', 'Sandwiches', 'PASTAS & MORE', 'Main Dishes', 25000.00, 'Club tuna, chicken, bacon and eggs, egg cheese\r\nor cheese tomato + fries/chips'),
('F061', 'Deep fried potatoes', 'PASTAS & MORE', 'Main Dishes', 5000.00, 'Deep fried potatoes'),
('F062', 'Mushed potatoes', 'PASTAS & MORE', 'Main Dishes', 7000.00, 'Mushed potatoes'),
('F063', 'Potato fried in butter', 'PASTAS & MORE', 'Main Dishes', 5000.00, 'Potato fried in butter'),
('F064', 'Rice or chati', 'PASTAS & MORE', 'Main Dishes', 5000.00, 'Rice or chati'),
('F065', 'Srewed veggie', 'PASTAS & MORE', 'Main Dishes', 5000.00, 'Srewed veggie'),
('F066', ' Chips Mayai', 'PASTAS & MORE', 'Main Dishes', 10000.00, ' Chips Mayai'),
('F067', 'Chips Masala', 'PASTAS & MORE', 'Main Dishes', 10000.00, 'Chips Masala'),
('F068', 'Magharita Pizza', 'PIZZA', 'Main Dishes', 19000.00, 'Tomato sauce, mozarella cheese, basil, tomato\r\nslices'),
('F069', 'Chicken Pizza', 'PIZZA', 'Main Dishes', 27000.00, 'Tomato sauce, mozarella cheese, chicken'),
('F070', 'Seafood Pizza', 'PIZZA', 'Main Dishes', 32000.00, 'Tomato sauce, mozarella, cheese, seafood mix,\r\nparsley'),
('F071', 'Diavola Pizza', 'PIZZA', 'Main Dishes', 30000.00, 'Tomato sauce, mozarella, fresh chill, salami,\r\ngreen/black olives'),
('F072', 'Beef Pizza', 'PIZZA', 'Main Dishes', 32000.00, 'Tomato sauce, mozarella cheese and beef'),
('F073', 'Ortolana Pizza', 'PIZZA', 'Main Dishes', 24000.00, 'Tomato sauce, mozarella cheese and veg mix'),
('F074', 'Marinara Pizza', 'PIZZA', 'Main Dishes', 22000.00, 'Tomato sauce, mozarella cheese, oregano &\r\ngarlic'),
('F075', 'Americana Pizza', 'PIZZA', 'Main Dishes', 27000.00, 'Tomato sauce, mozarella, mushrooms,\r\npepperoni'),
('F076', 'Prosciutto Pizza', 'PIZZA', 'Main Dishes', 30000.00, 'Tomato sauce, mozarella cheese, ham and\r\nmushrooms'),
('F077', 'Mexican Pizza', 'PIZZA', 'Main Dishes', 30000.00, 'Bolognaise, mozzarella cheese, sweetcorn and\r\nfresh chilli.'),
('F078', 'Hawaii pizza', 'PIZZA', 'Main Dishes', 30000.00, 'Tomato, mozzarella cheese, salami and\r\npineapple');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `head_count` int(11) DEFAULT NULL,
  `special_request` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `customer_name`, `table_id`, `reservation_time`, `reservation_date`, `head_count`, `special_request`) VALUES
(1120251, 'DEFAULT', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_tables`
--

CREATE TABLE `restaurant_tables` (
  `table_id` int(11) NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_tables`
--

INSERT INTO `restaurant_tables` (`table_id`, `capacity`, `is_available`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`staff_id`, `staff_name`, `role`, `account_id`) VALUES
(1, 'Admin', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `ItemID` int(11) NOT NULL,
  `ItemName` varchar(255) NOT NULL,
  `BaseUnitQuantity` int(11) NOT NULL,
  `ConversionRatio` int(11) NOT NULL,
  `AggregateQuantity` int(11) GENERATED ALWAYS AS (`BaseUnitQuantity` * `ConversionRatio`) STORED,
  `PricePerBaseUnit` decimal(10,2) NOT NULL,
  `PricePerSubUnit` decimal(10,2) NOT NULL,
  `LastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `BaseUnitName` varchar(50) NOT NULL DEFAULT 'Bottle',
  `AggregateUnitName` varchar(50) NOT NULL DEFAULT 'Tot'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`ItemID`, `ItemName`, `BaseUnitQuantity`, `ConversionRatio`, `PricePerBaseUnit`, `PricePerSubUnit`, `LastUpdated`, `BaseUnitName`, `AggregateUnitName`) VALUES
(1, 'Soda', 1000, 1, 2000.00, 2000.00, '2025-03-21 05:59:14', 'Bottle', 'Tot'),
(2, 'Small Water', 1, 1, 2000.00, 2000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(3, 'Big Water', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(4, 'Kilimanjaro', 195, 6, 5000.00, 5000.00, '2025-03-21 06:07:33', 'Bottle', 'Tot'),
(5, 'Safari', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(6, 'Serengeti Lager', 10, 2, 5000.00, 5000.00, '2025-03-19 18:01:39', 'Bottle', 'Tot'),
(7, 'Serengeti Lite', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(8, 'Desperados', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(9, 'Redd\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(10, 'Castle Lite', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(11, 'Heineken', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(12, 'Savanna Cycler', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(13, 'Red Bull', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(14, 'Triple Sec', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(15, 'Khalua', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(16, 'Amarula', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(17, 'Blue Curacao', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(18, 'Disaronno', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(19, 'Jaegermeister', 1, 1, 7000.00, 7000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(20, 'Belaire', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(21, 'Zappa Black', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(22, 'Zappa Red', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(23, 'Zappa Blue', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(24, 'Zappa Green', 100, 2, 5000.00, 5000.00, '2025-03-19 18:02:09', 'Bottle', 'Tot'),
(25, 'Tia Maria', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(26, 'Campari', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(27, 'Martini Rosso', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(28, 'Martini Bianco', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(29, 'Pimm\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(30, 'Archers', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(31, 'Cinzano Rosso', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(32, 'Cinzano Bianco', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(33, 'Aperol', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(34, 'Southern Comfort', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(35, 'Grants', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(36, 'Ballantines', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(37, 'Jameson', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(38, 'VAT 69', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(39, 'Double Black', 1, 1, 10000.00, 10000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(40, 'Black Label', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(41, 'Red Label', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(42, 'J&B Rare', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(43, 'Jim Beam', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(44, 'Jack Daniel\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(45, 'Dimpy Whisky', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(46, 'Russian Standard', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(47, 'Smirnoff', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(48, 'Romanoff', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(49, 'Absolut Vodka', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(50, 'Absolut Peach', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(51, 'Nicols Green', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(52, 'Nicols Normal', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(53, 'Sky Vodka', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(54, 'Sambuca Valentino', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(55, 'Sambuca Cellini', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(56, 'Jose Cuervo Silver', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(57, 'Jose Cuervo Gold', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(58, 'Sauza Silver', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(59, 'Sauza Gold', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(60, 'Dos Mexicanos', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(61, 'Camino Silver', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(62, 'Camino Gold', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(63, 'Sierra Tequila', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(64, 'Hennessy', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(65, 'Courvoisier', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(66, 'JP Chenet', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(67, 'Nobleman', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(68, 'Beehive', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(69, 'Gold Crest', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(70, 'Captain Morgan Dark', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(71, 'Captain Morgan Gold', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(72, 'Bacardi White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(73, 'Bacardi Dark', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(74, 'Four Palms', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(75, 'Ship Master', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(76, 'Malibu', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(77, 'Old Monk Dark', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(78, 'Old Monk White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(79, 'King Robert', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(80, 'Bombay Sapphire', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(81, 'Gordon\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(82, 'Black Bull', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(83, 'Affron Gin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(84, 'Bentley Gin', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(85, 'Heinkes Gin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(86, 'K-Vant', 1, 1, 16000.00, 16000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(87, 'Konyagi', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(88, 'Chenin Black Wild White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(89, 'Chenin Black Wild Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(90, 'Dodoma White', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(91, 'Dodoma Red', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(92, 'Wild Rose', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(93, 'Chardonnay Reef White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(94, 'Table Mountain Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(95, 'Table Mountain White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(96, 'Culemborg Red', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(97, 'Culemborg White', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(98, 'Papillon', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(99, 'Personal Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(100, 'Saint Anna', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(101, 'Fantasia Night', 1, 1, 45000.00, 45000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(102, 'Brut Supermit Chenin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(103, 'For Cousin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(104, 'Mount Rozier White', 1, 1, 50000.00, 50000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(105, 'Dodoma Sweet Rose', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(106, 'Duet Brut', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(107, 'Lions Hill White', 1, 1, 45000.00, 45000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(108, 'Lions Hill Red', 1, 1, 45000.00, 45000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(109, 'Cuvee Brut', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(110, 'Beach House Sauvignon Black', 1, 10, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(111, 'Beach House Sunset Shiraz', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(112, 'Weaver Chardonnay', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(113, 'Weaver Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot'),
(114, 'Cinzano Prosecco', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot');

-- --------------------------------------------------------

--
-- Table structure for table `table_availability`
--

CREATE TABLE `table_availability` (
  `availability_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`bill_item_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `card_payments`
--
ALTER TABLE `card_payments`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `creditors`
--
ALTER TABLE `creditors`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kitchen`
--
ALTER TABLE `kitchen`
  ADD PRIMARY KEY (`kitchen_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `table_availability`
--
ALTER TABLE `table_availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `table_id` (`table_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `bill_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `card_payments`
--
ALTER TABLE `card_payments`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creditors`
--
ALTER TABLE `creditors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kitchen`
--
ALTER TABLE `kitchen`
  MODIFY `kitchen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1120252;

--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `table_availability`
--
ALTER TABLE `table_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`staff_id`),
  ADD CONSTRAINT `bills_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `memberships` (`member_id`),
  ADD CONSTRAINT `bills_ibfk_3` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`),
  ADD CONSTRAINT `bills_ibfk_4` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`),
  ADD CONSTRAINT `bills_ibfk_5` FOREIGN KEY (`card_id`) REFERENCES `card_payments` (`card_id`);

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `bill_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`);

--
-- Constraints for table `kitchen`
--
ALTER TABLE `kitchen`
  ADD CONSTRAINT `kitchen_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`),
  ADD CONSTRAINT `kitchen_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu` (`item_id`);

--
-- Constraints for table `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`);

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`);

--
-- Constraints for table `table_availability`
--
ALTER TABLE `table_availability`
  ADD CONSTRAINT `table_availability_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `restaurant_tables` (`table_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
