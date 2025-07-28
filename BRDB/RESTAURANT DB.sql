-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 07:36 AM
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
  `creditor_id` int(11) DEFAULT NULL,
  `authorizing_staff_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`bill_id`, `staff_id`, `member_id`, `reservation_id`, `table_id`, `card_id`, `payment_method`, `bill_time`, `payment_time`, `creditor_id`, `authorizing_staff_id`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:16:51', NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:16:56', NULL, NULL, NULL),
(4, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-19 15:16:56', '2025-03-19 15:17:12', NULL, NULL),
(5, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 15:18:10', '2025-03-19 15:25:06', 4, NULL),
(6, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:34:48', NULL, NULL, NULL),
(7, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 15:37:41', '2025-03-19 15:37:55', 4, NULL),
(8, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:40:16', NULL, NULL, NULL),
(9, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 15:40:18', NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 16:11:53', NULL, NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-19 18:42:42', NULL, NULL, NULL),
(12, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 18:42:44', '2025-03-19 19:24:52', 1, NULL),
(13, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-19 21:10:06', '2025-03-19 21:10:20', 1, NULL),
(14, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 10:39:18', NULL, NULL, NULL),
(15, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 11:06:15', NULL, NULL, NULL),
(16, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-20 11:06:56', '2025-03-20 11:07:12', 4, NULL),
(17, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-20 11:07:37', '2025-03-20 11:07:58', NULL, NULL),
(18, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-20 11:10:01', '2025-03-20 11:10:15', NULL, NULL),
(19, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 11:11:17', NULL, NULL, NULL),
(20, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-20 11:11:19', '2025-03-20 11:11:30', NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 06:57:12', NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 07:06:00', NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 07:07:24', NULL, NULL, NULL),
(24, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-21 07:09:31', '2025-03-21 07:20:10', NULL, NULL),
(25, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-21 07:21:13', '2025-03-21 07:21:34', NULL, NULL),
(26, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-21 07:23:49', '2025-03-21 08:32:34', NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 08:33:00', NULL, NULL, NULL),
(28, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-21 08:33:23', '2025-03-21 13:33:53', NULL, NULL),
(29, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-21 13:39:55', '2025-03-21 13:45:43', 1, NULL),
(30, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 13:50:11', NULL, NULL, NULL),
(31, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-21 13:50:13', '2025-03-21 13:50:27', 4, NULL),
(32, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-21 13:52:54', '2025-03-21 14:51:24', NULL, 1),
(33, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-21 15:05:01', '2025-03-21 15:05:20', NULL, 1),
(34, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-21 15:15:11', '2025-03-21 15:36:35', NULL, 1),
(35, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-21 15:39:51', '2025-03-21 15:40:03', NULL, 1),
(36, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-21 15:48:22', '2025-03-21 15:48:33', NULL, 1),
(37, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 18:54:16', NULL, NULL, NULL),
(38, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-21 19:09:17', '2025-03-21 21:24:34', NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-21 21:37:58', NULL, NULL, NULL),
(40, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-22 13:03:21', '2025-03-22 13:53:57', NULL, NULL),
(41, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 13:55:09', NULL, NULL, NULL),
(42, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:10:34', NULL, NULL, NULL),
(43, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:13:46', NULL, NULL, NULL),
(44, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:29:42', NULL, NULL, NULL),
(45, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:31', NULL, NULL, NULL),
(46, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:41', NULL, NULL, NULL),
(47, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:42', NULL, NULL, NULL),
(48, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:42', NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:42', NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:42', NULL, NULL, NULL),
(51, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:43', NULL, NULL, NULL),
(52, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:43', NULL, NULL, NULL),
(53, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 14:35:47', NULL, NULL, NULL),
(54, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 15:52:41', NULL, NULL, NULL),
(55, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-22 15:52:43', NULL, NULL, NULL),
(56, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-23 09:10:43', '2025-03-23 09:16:29', NULL, 1),
(57, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:16:38', NULL, NULL, NULL),
(58, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:17:14', NULL, NULL, NULL),
(59, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:17:41', NULL, NULL, NULL),
(60, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:19:34', NULL, NULL, NULL),
(61, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:24:46', NULL, NULL, NULL),
(62, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:26:27', NULL, NULL, NULL),
(63, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 09:26:41', NULL, NULL, NULL),
(64, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 12:09:39', NULL, NULL, NULL),
(65, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 12:09:42', NULL, NULL, NULL),
(66, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-23 13:24:28', '2025-03-23 13:24:52', NULL, 1),
(67, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 13:25:06', NULL, NULL, NULL),
(68, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-23 13:48:22', '2025-03-23 14:55:37', NULL, NULL),
(69, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 13:49:07', '2025-03-23 16:08:38', NULL, NULL),
(70, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 15:00:10', '2025-03-23 16:08:06', NULL, NULL),
(71, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 15:09:39', '2025-03-23 15:27:34', NULL, NULL),
(72, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 15:35:38', '2025-03-23 15:47:27', NULL, NULL),
(73, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 15:50:01', '2025-03-23 15:50:06', NULL, NULL),
(74, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 15:50:26', '2025-03-23 15:50:31', NULL, NULL),
(75, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 16:03:40', '2025-03-23 16:03:45', NULL, NULL),
(76, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 16:04:06', '2025-03-23 16:04:16', NULL, NULL),
(77, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 16:08:57', NULL, NULL, NULL),
(78, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 18:23:08', '2025-03-23 18:23:34', NULL, NULL),
(79, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 18:24:25', '2025-03-23 18:24:31', NULL, NULL),
(80, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 18:28:40', NULL, NULL, NULL),
(81, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 18:29:55', NULL, NULL, NULL),
(82, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 18:34:46', '2025-03-23 20:26:49', NULL, NULL),
(83, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 20:26:33', NULL, NULL, NULL),
(84, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 20:27:06', NULL, NULL, NULL),
(85, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 20:28:43', NULL, NULL, NULL),
(86, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 20:49:51', '2025-03-23 20:49:57', NULL, NULL),
(87, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-23 20:50:45', '2025-03-23 20:50:59', NULL, NULL),
(88, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 21:08:57', NULL, NULL, NULL),
(89, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 05:10:40', '2025-03-24 05:26:37', NULL, NULL),
(90, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 05:11:09', '2025-03-24 05:11:17', NULL, NULL),
(91, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 05:21:10', '2025-03-24 05:25:43', NULL, NULL),
(92, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-24 05:29:38', '2025-03-24 05:29:49', NULL, 1),
(93, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-24 05:34:25', '2025-03-24 05:34:34', 4, NULL),
(94, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-24 05:35:13', '2025-03-24 05:35:22', 4, NULL),
(95, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 05:38:25', '2025-03-24 05:38:46', NULL, NULL),
(96, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 05:39:21', '2025-03-24 05:39:31', NULL, NULL),
(97, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-24 05:40:20', NULL, NULL, NULL),
(98, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-24 05:41:37', NULL, NULL, NULL),
(99, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 06:10:23', '2025-03-24 12:06:49', NULL, NULL),
(100, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-24 06:13:49', NULL, NULL, NULL),
(101, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 12:06:06', '2025-03-24 12:06:12', NULL, NULL),
(102, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:07:26', '2025-03-24 12:07:31', NULL, NULL),
(103, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:11:04', '2025-03-24 12:23:10', NULL, NULL),
(104, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:21:34', '2025-03-24 12:21:39', NULL, NULL),
(105, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:22:14', '2025-03-24 12:22:21', NULL, NULL),
(106, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:26:58', '2025-03-24 12:27:46', NULL, NULL),
(107, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:28:19', '2025-03-24 12:28:52', NULL, NULL),
(108, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-24 12:29:27', '2025-03-24 13:32:52', NULL, NULL),
(109, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-24 13:00:20', NULL, NULL, NULL),
(110, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 13:33:55', '2025-03-24 13:34:00', NULL, NULL),
(111, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-24 19:45:28', '2025-03-25 06:46:23', NULL, NULL),
(112, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-24 20:58:55', NULL, NULL, NULL),
(113, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 04:06:34', NULL, NULL, NULL),
(114, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 06:45:03', NULL, NULL, NULL),
(115, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-25 06:46:53', '2025-03-25 06:47:30', NULL, NULL),
(116, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 06:47:42', NULL, NULL, NULL),
(117, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 06:53:19', NULL, NULL, NULL),
(118, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 07:51:20', NULL, NULL, NULL),
(119, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-25 08:40:55', '2025-03-25 08:52:03', 4, NULL),
(120, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 08:52:24', NULL, NULL, NULL),
(121, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 09:01:41', NULL, NULL, NULL),
(122, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-25 13:19:21', '2025-03-25 13:27:05', NULL, NULL),
(123, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-25 13:28:54', '2025-03-25 13:29:55', NULL, 1),
(124, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-25 13:30:08', '2025-03-25 13:30:32', NULL, NULL),
(125, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-25 13:30:52', '2025-03-25 13:31:08', NULL, 1),
(126, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-25 13:31:32', '2025-03-25 13:31:46', 4, NULL),
(127, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-25 13:37:06', '2025-03-25 13:41:11', NULL, NULL),
(128, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-25 13:41:35', '2025-03-25 13:43:33', 4, NULL),
(129, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-25 13:44:45', '2025-03-25 13:45:38', NULL, 1),
(130, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-25 13:46:45', '2025-03-25 13:46:55', NULL, NULL),
(131, 1, 1, 1120251, NULL, NULL, 'card', '2025-03-25 13:47:10', '2025-03-25 13:47:22', NULL, NULL),
(132, 1, 1, 1120251, NULL, NULL, 'creditor', '2025-03-25 13:47:38', '2025-03-25 13:47:52', 4, NULL),
(133, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-25 13:48:17', '2025-03-25 13:48:38', NULL, 1),
(134, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-25 13:51:54', '2025-03-25 13:52:14', NULL, NULL),
(135, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-25 13:52:43', '2025-03-25 13:57:02', NULL, 1),
(136, 1, 1, 1120251, NULL, NULL, 'cash', '2025-03-25 13:54:26', '2025-03-25 13:54:59', NULL, NULL),
(137, 1, 1, 1120251, NULL, NULL, 'compo', '2025-03-25 13:57:17', '2025-03-25 13:58:38', NULL, 1),
(138, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 13:58:53', NULL, NULL, NULL),
(139, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 14:18:59', NULL, NULL, NULL),
(140, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 18:33:00', NULL, NULL, NULL),
(141, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-25 18:44:26', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `bill_item_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `item_id` varchar(6) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `item_source` enum('menu','stock') NOT NULL,
  `unit` enum('base','aggregate') DEFAULT NULL,
  `source` enum('menu','stock') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`bill_item_id`, `bill_id`, `item_id`, `quantity`, `item_source`, `unit`, `source`) VALUES
(104, 53, 'F068', 3, 'menu', 'aggregate', 'menu'),
(107, 19, 'F069', 2, 'menu', 'aggregate', 'menu'),
(108, 55, 'F068', 3, 'menu', 'aggregate', 'menu'),
(112, 56, '4', 3, 'menu', 'aggregate', 'stock'),
(113, 56, 'F001', 3, 'menu', 'aggregate', 'menu'),
(122, 66, '4', 2, 'menu', 'aggregate', 'stock'),
(124, 69, '4', 2, 'menu', 'aggregate', 'stock'),
(131, 89, 'F068', 4, 'menu', 'aggregate', 'menu'),
(132, 95, 'F068', 4, 'menu', 'aggregate', 'menu'),
(133, 99, 'F068', 5, 'menu', 'aggregate', 'menu'),
(134, 103, 'F068', 204, 'menu', 'aggregate', 'menu'),
(135, 106, 'F068', 3, 'menu', 'aggregate', 'menu'),
(136, 106, '4', 3, 'menu', 'aggregate', 'stock'),
(137, 107, '4', 3, 'menu', 'aggregate', 'stock'),
(138, 108, 'F068', 19, 'menu', 'aggregate', 'menu'),
(139, 108, '4', 9, 'menu', 'aggregate', 'stock'),
(161, 111, 'F068', 3, 'menu', 'base', 'menu'),
(162, 115, '4', 3, 'menu', 'base', 'stock'),
(163, 115, '4', 3, 'menu', 'aggregate', 'stock'),
(168, 119, 'F068', 3, 'menu', 'base', 'menu'),
(181, 122, '11', 1, 'menu', 'base', 'stock'),
(182, 123, '4', 2, 'menu', 'aggregate', 'stock'),
(183, 124, '4', 2, 'menu', 'aggregate', 'stock'),
(184, 125, '4', 15, 'menu', 'aggregate', 'stock'),
(185, 126, '4', 3, 'menu', 'aggregate', 'stock'),
(187, 127, '64', 1, 'menu', 'base', 'stock'),
(188, 127, '64', 1, 'menu', 'aggregate', 'stock'),
(189, 128, '4', 3, 'menu', 'aggregate', 'stock'),
(190, 129, '4', 1, 'menu', 'base', 'stock'),
(191, 130, '4', 2, 'menu', 'aggregate', 'stock'),
(192, 131, '4', 2, 'menu', 'base', 'stock'),
(193, 132, '4', 3, 'menu', 'base', 'stock'),
(194, 133, '4', 2, 'menu', 'base', 'stock'),
(195, 134, '4', 3, 'menu', 'base', 'stock'),
(197, 135, '4', 2, 'menu', 'aggregate', 'stock'),
(198, 137, 'F068', 5, 'menu', 'base', 'menu'),
(199, 137, '4', 3, 'menu', 'aggregate', 'stock'),
(200, 137, '4', 3, 'menu', 'base', 'stock'),
(201, 137, '4', 2, 'menu', 'aggregate', 'stock'),
(202, 137, '4', 4, 'menu', 'aggregate', 'stock'),
(203, 137, '4', 3, 'menu', 'base', 'stock'),
(204, 137, 'F069', 5, 'menu', 'base', 'menu'),
(205, 137, 'F069', 3, 'menu', 'base', 'menu');

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
-- Table structure for table `compologs`
--

CREATE TABLE `compologs` (
  `log_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `authorizing_staff_id` int(11) NOT NULL,
  `compo_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compologs`
--

INSERT INTO `compologs` (`log_id`, `bill_id`, `authorizing_staff_id`, `compo_time`) VALUES
(1, 36, 1, '2025-03-21 15:48:33'),
(2, 56, 1, '2025-03-23 09:16:29'),
(3, 66, 1, '2025-03-23 13:24:52'),
(4, 92, 1, '2025-03-24 05:29:49'),
(5, 123, 1, '2025-03-25 13:29:11'),
(6, 123, 1, '2025-03-25 13:29:55'),
(7, 125, 1, '2025-03-25 13:31:08'),
(8, 129, 1, '2025-03-25 13:45:38'),
(9, 133, 1, '2025-03-25 13:48:38'),
(10, 135, 1, '2025-03-25 13:57:02'),
(11, 137, 1, '2025-03-25 13:58:38');

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
(1, 'Admins', 250000.00, '2025-03-18 08:57:09', '+2556210'),
(4, 'RAMADHANI RAMADHANI', 727000.00, '2025-03-19 15:39:56', '+255621060107'),
(5, 'Admins', 20000.00, '2025-03-21 18:29:01', '123456789');

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
(65, NULL, 'F006', 4, '2025-03-23 18:34:28', '2025-03-25 05:19:12'),
(83, NULL, 'F032', 3, '2025-03-24 06:13:57', '2025-03-25 05:19:14'),
(128, NULL, 'F001', 3, '2025-03-25 13:54:26', NULL),
(129, NULL, 'F002', 4, '2025-03-25 13:54:32', NULL),
(130, NULL, 'F002', 4, '2025-03-25 13:54:32', NULL),
(131, NULL, 'F003', 3, '2025-03-25 13:54:37', NULL),
(132, NULL, 'F068', 5, '2025-03-25 13:57:21', NULL),
(133, NULL, 'F069', 5, '2025-03-25 13:58:18', NULL),
(134, NULL, 'F069', 3, '2025-03-25 13:58:24', NULL);

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
(1, 'Default ', 10600050, 2);

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
-- Table structure for table `payment_records`
--

CREATE TABLE `payment_records` (
  `record_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `payment_method` enum('cash','card','mobile') NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_time` datetime NOT NULL,
  `staff_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_records`
--

INSERT INTO `payment_records` (`record_id`, `bill_id`, `payment_method`, `payment_amount`, `payment_time`, `staff_id`, `member_id`, `tax_amount`) VALUES
(1, 108, 'cash', 406000.00, '2025-03-24 13:32:52', 1, 1, 0.00),
(2, 110, 'card', 84000.00, '2025-03-24 13:34:00', 1, 1, 4000.00),
(3, 111, 'card', 59850.00, '2025-03-25 06:46:23', 1, 1, 2850.00),
(4, 115, 'card', 141750.00, '2025-03-25 06:47:30', 1, 1, 6750.00),
(5, 122, 'card', 5250.00, '2025-03-25 13:27:05', 1, 1, 250.00),
(6, 124, 'cash', 10000.00, '2025-03-25 13:30:32', 1, 1, 0.00),
(7, 127, 'cash', 110000.00, '2025-03-25 13:41:11', 1, 1, 0.00),
(8, 130, 'cash', 10000.00, '2025-03-25 13:46:55', 1, 1, 0.00),
(9, 131, 'card', 84000.00, '2025-03-25 13:47:22', 1, 1, 4000.00),
(10, 134, 'cash', 120000.00, '2025-03-25 13:52:14', 1, 1, 0.00),
(11, 136, 'cash', 138000.00, '2025-03-25 13:54:59', 1, 1, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `pendingorderitems`
--

CREATE TABLE `pendingorderitems` (
  `pending_order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` varchar(50) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `source` enum('menu','stock') NOT NULL,
  `unit` enum('base','aggregate') NOT NULL,
  `item_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendingorders`
--

CREATE TABLE `pendingorders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `status` enum('Pending','Closed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1120251, 'DEFAULT ‼️‼️DO NOT DELETE THIS ROW', NULL, NULL, NULL, NULL, NULL);

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
(1, 1, 0),
(2, 8, 1);

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
  `AggregateUnitName` varchar(50) NOT NULL DEFAULT 'Tot',
  `PendingAggregate` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`ItemID`, `ItemName`, `BaseUnitQuantity`, `ConversionRatio`, `PricePerBaseUnit`, `PricePerSubUnit`, `LastUpdated`, `BaseUnitName`, `AggregateUnitName`, `PendingAggregate`) VALUES
(1, 'Soda', 940, 1, 2000.00, 2000.00, '2025-03-23 08:25:12', 'Bottle', 'Tot', 0),
(2, 'Small Water', 0, 1, 2000.00, 2000.00, '2025-03-25 06:39:40', 'Bottle', 'Tot', 0),
(3, 'Big Water', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(4, 'Kilimanjaro', 28, 6, 40000.00, 5000.00, '2025-03-25 12:58:13', 'Bottle', 'Tot', 2),
(5, 'Safari', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(6, 'Serengeti Lager', 10, 2, 5000.00, 5000.00, '2025-03-19 18:01:39', 'Bottle', 'Tot', 0),
(7, 'Serengeti Lite', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(8, 'Desperados', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(9, 'Redd\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(10, 'Castle Lite', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(11, 'Heineken', 0, 1, 5000.00, 5000.00, '2025-03-25 12:27:01', 'Bottle', 'Tot', 0),
(12, 'Savanna Cycler', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(13, 'Red Bull', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(14, 'Triple Sec', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(15, 'Khalua', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(16, 'Amarula', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(17, 'Blue Curacao', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(18, 'Disaronno', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(19, 'Jaegermeister', 1, 1, 7000.00, 7000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(20, 'Belaire', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(21, 'Zappa Black', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(22, 'Zappa Red', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(23, 'Zappa Blue', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(24, 'Zappa Green', 100, 2, 5000.00, 5000.00, '2025-03-19 18:02:09', 'Bottle', 'Tot', 0),
(25, 'Tia Maria', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(26, 'Campari', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(27, 'Martini Rosso', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(28, 'Martini Bianco', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(29, 'Pimm\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(30, 'Archers', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(31, 'Cinzano Rosso', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(32, 'Cinzano Bianco', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(33, 'Aperol', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(34, 'Southern Comfort', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(35, 'Grants', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(36, 'Ballantines', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(37, 'Jameson', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(38, 'VAT 69', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(39, 'Double Black', 1, 1, 10000.00, 10000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(40, 'Black Label', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(41, 'Red Label', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(42, 'J&B Rare', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(43, 'Jim Beam', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(44, 'Jack Daniel\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(45, 'Dimpy Whisky', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(46, 'Russian Standard', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(47, 'Smirnoff', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(48, 'Romanoff', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(49, 'Absolut Vodka', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(50, 'Absolut Peach', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(51, 'Nicols Green', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(52, 'Nicols Normal', 1, 1, 3000.00, 3000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(53, 'Sky Vodka', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(54, 'Sambuca Valentino', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(55, 'Sambuca Cellini', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(56, 'Jose Cuervo Silver', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(57, 'Jose Cuervo Gold', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(58, 'Sauza Silver', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(59, 'Sauza Gold', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(60, 'Dos Mexicanos', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(61, 'Camino Silver', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(62, 'Camino Gold', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(63, 'Sierra Tequila', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(64, 'Hennessy', 99, 40, 100000.00, 10000.00, '2025-03-25 12:40:05', 'Bottle', 'Tot', 1),
(65, 'Courvoisier', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(66, 'JP Chenet', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(67, 'Nobleman', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(68, 'Beehive', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(69, 'Gold Crest', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(70, 'Captain Morgan Dark', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(71, 'Captain Morgan Gold', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(72, 'Bacardi White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(73, 'Bacardi Dark', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(74, 'Four Palms', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(75, 'Ship Master', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(76, 'Malibu', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(77, 'Old Monk Dark', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(78, 'Old Monk White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(79, 'King Robert', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(80, 'Bombay Sapphire', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(81, 'Gordon\'s', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(82, 'Black Bull', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(83, 'Affron Gin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(84, 'Bentley Gin', 1, 1, 5000.00, 5000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(85, 'Heinkes Gin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(86, 'K-Vant', 1, 1, 16000.00, 16000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(87, 'Konyagi', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(88, 'Chenin Black Wild White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(89, 'Chenin Black Wild Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(90, 'Dodoma White', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(91, 'Dodoma Red', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(92, 'Wild Rose', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(93, 'Chardonnay Reef White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(94, 'Table Mountain Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(95, 'Table Mountain White', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(96, 'Culemborg Red', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(97, 'Culemborg White', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(98, 'Papillon', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(99, 'Personal Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(100, 'Saint Anna', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(101, 'Fantasia Night', 1, 1, 45000.00, 45000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(102, 'Brut Supermit Chenin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(103, 'For Cousin', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(104, 'Mount Rozier White', 1, 1, 50000.00, 50000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(105, 'Dodoma Sweet Rose', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(106, 'Duet Brut', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(107, 'Lions Hill White', 1, 1, 45000.00, 45000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(108, 'Lions Hill Red', 1, 1, 45000.00, 45000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(109, 'Cuvee Brut', 1, 1, 40000.00, 40000.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(110, 'Beach House Sauvignon Black', 1, 10, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(111, 'Beach House Sunset Shiraz', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(112, 'Weaver Chardonnay', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(113, 'Weaver Red', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0),
(114, 'Cinzano Prosecco', 1, 1, 0.00, 0.00, '2025-03-19 17:51:34', 'Bottle', 'Tot', 0);

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
-- Dumping data for table `table_availability`
--

INSERT INTO `table_availability` (`availability_id`, `table_id`, `reservation_date`, `reservation_time`, `status`) VALUES
(1020251, 1, '2025-03-22', '10:00:00', 'no'),
(1120252, 2, '2025-03-22', '11:00:00', 'no');

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
-- Indexes for table `compologs`
--
ALTER TABLE `compologs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `bill_id` (`bill_id`),
  ADD KEY `authorizing_staff_id` (`authorizing_staff_id`);

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
-- Indexes for table `payment_records`
--
ALTER TABLE `payment_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `pendingorderitems`
--
ALTER TABLE `pendingorderitems`
  ADD PRIMARY KEY (`pending_order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `pendingorders`
--
ALTER TABLE `pendingorders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `bill_id` (`bill_id`);

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
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `bill_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `card_payments`
--
ALTER TABLE `card_payments`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compologs`
--
ALTER TABLE `compologs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `creditors`
--
ALTER TABLE `creditors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kitchen`
--
ALTER TABLE `kitchen`
  MODIFY `kitchen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_records`
--
ALTER TABLE `payment_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pendingorderitems`
--
ALTER TABLE `pendingorderitems`
  MODIFY `pending_order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `pendingorders`
--
ALTER TABLE `pendingorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1120253;

--
-- AUTO_INCREMENT for table `restaurant_tables`
--
ALTER TABLE `restaurant_tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `table_availability`
--
ALTER TABLE `table_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1120253;

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
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`);

--
-- Constraints for table `compologs`
--
ALTER TABLE `compologs`
  ADD CONSTRAINT `compologs_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`),
  ADD CONSTRAINT `compologs_ibfk_2` FOREIGN KEY (`authorizing_staff_id`) REFERENCES `staffs` (`staff_id`);

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
-- Constraints for table `payment_records`
--
ALTER TABLE `payment_records`
  ADD CONSTRAINT `payment_records_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`);

--
-- Constraints for table `pendingorderitems`
--
ALTER TABLE `pendingorderitems`
  ADD CONSTRAINT `pendingorderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `pendingorders` (`order_id`);

--
-- Constraints for table `pendingorders`
--
ALTER TABLE `pendingorders`
  ADD CONSTRAINT `pendingorders_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`bill_id`);

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
