-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 05:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbosim`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcategorylist`
--

CREATE TABLE `tblcategorylist` (
  `category_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcategorylist`
--

INSERT INTO `tblcategorylist` (`category_id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(11, 'PANCIT DISHES', 'Pancit meals and Soup dishes', 1, 0, '2022-10-18 04:54:35', '2022-10-18 04:54:35'),
(12, 'COMBO MEALS', 'Combo meals with rice and drinks', 1, 0, '2022-10-18 04:54:35', '2022-10-18 04:54:35'),
(14, 'MILK TEA', 'Flavored milteas', 1, 0, '2022-10-18 04:54:35', '2022-10-18 04:54:35'),
(15, 'FRAPPE', 'Cold Frappes', 1, 0, '2022-10-18 04:54:35', '2022-10-18 04:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `tblmenulist`
--

CREATE TABLE `tblmenulist` (
  `menu_id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `price` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblmenulist`
--

INSERT INTO `tblmenulist` (`menu_id`, `category_id`, `code`, `name`, `description`, `price`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(9, 11, 'PD1', 'LOMI SMALL', 'small lomi', 110.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(10, 11, 'PD2', 'LOMI LARGE', 'large lomi', 220.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(11, 11, 'PD3', 'CHAMI GUISADO SMALL', 'small chami guisado', 120.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(12, 11, 'PD4', 'CHAMI GUISADO LARGE', 'large chami guisado', 220.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(13, 11, 'PD5', 'PANCIT CANTON SMALL', 'small pancit canton', 120.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(14, 11, 'PD6', 'PANCIT CANTON LARGE ', 'large pancit canton', 220.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(15, 11, 'PD7', 'MIXED CANTON BIHON LARGE', 'mixed canton and bihon in large size', 230.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(16, 11, 'PD8', 'PANCIT GUISADO SMALL', 'small pancit guisado', 110.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(17, 11, 'PD9', 'PANCIT GUISADO LARGE', 'large pancit guisado', 220.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(18, 11, 'PD10', 'PANCIT MIKI BIHON SMALL', 'small pancit miki bihon mixed', 170.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(19, 11, 'PD11', 'PANCIT MIKI BIHON LARGE', 'large pancit miki bihon mixed', 220.00, 1, 0, '2022-10-18 05:25:53', '2022-10-18 05:25:53'),
(20, 12, 'CM1', '2pc. CHICKEN WINGS W/ RICE AND DRINKS', '2 pieces chicken wings with rice and drinks', 110.00, 1, 0, '2022-10-18 05:44:56', '2022-10-18 05:44:56'),
(21, 12, 'CM2', '4pc. CHICKEN WINGS W/ RICE AND DRINKS', '4 pieces chicken wings with rice and drinks', 180.00, 1, 0, '2022-10-18 05:44:56', '2022-10-18 05:44:56'),
(22, 12, 'CM3', '8pc. CHICKEN WINGS W/ RICE AND DRINKS', '8 pieces chicken wings with rice and drinks', 230.00, 1, 0, '2022-10-18 05:44:56', '2022-10-18 05:44:56'),
(23, 12, 'CM4', '12pc. CHICKEN WINGS W/ RICE AND DRINKS', '12 pieces chicken wings with rice and drinks', 330.00, 1, 0, '2022-10-18 05:44:56', '2022-10-18 05:44:56'),
(24, 12, 'CM5', '24pc. CHICKEN WINGS W/ RICE AND DRINKS', '24 pieces chicken wings with rice and drinks', 550.00, 1, 0, '2022-10-18 05:44:56', '2022-10-18 05:44:56'),
(25, 14, 'M1', 'CLASSIC MILKTEA MEDIUM', 'medium classic milk tea', 60.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(26, 14, 'M2', 'CLASSIC MILKTEA LARGE', 'large classic milktea', 70.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(27, 14, 'M3', 'WINTERMELON MILKTEA MEDIUM', 'medium wintermelon milktea', 60.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(28, 14, 'M4', 'WINTERMELON MILKTEA LARGE', 'large wintermelon milktea', 70.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(29, 14, 'M5', 'OKINAWA MILKTEA MEDIUM', 'medium okinawa milktea', 65.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(30, 14, 'M6', 'OKINAWA MILKTEA LARGE', 'large okinawa milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(31, 14, 'M7', 'DARK CHOCOLATE MILKTEA MEDUIM', 'medium dark chocolate milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(32, 14, 'M8', 'DARK CHOCOLATE MILKTEA LARGE', 'large dark chocolate milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(33, 14, 'M9', 'BROWN SUGAR MILKTEA MEDIUM', 'medium brown sugar milktea', 65.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(34, 14, 'M10', 'BROWN SUGAR MILKTEA LARGE', 'large brown sugar milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(35, 14, 'M11', 'MATCHA MILKTEA MEDIUM', 'medium matcha milk tea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(36, 14, 'M12', 'MATCHA MILKTEA LARGE', 'large matcha milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(37, 14, 'M13', 'RED VELVET MILKTEA MEDIUM', 'medium red velvet milktea', 65.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(38, 14, 'M14', 'RED VELVER MILKTEA LARGE', 'large red velvet milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(39, 14, 'M15', 'TARO MILKTEA MEDIUM', 'medium taro milktea', 65.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(40, 14, 'M16', 'TARO MILKTEA LARGE', 'large taro milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(41, 14, 'M17', 'COOKIES N CREAM MILKTEA MEDIUM', 'medium cookies and cream milk tea', 65.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(42, 14, 'M18', 'COOKIES N CREAM MILKTEA LARGE', 'large cookies and cream milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(43, 14, 'M19', 'STRAWBERRY MILKTEA MEDIUM', 'medium strawberry milktea', 65.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(44, 14, 'M20', 'STRAWBERRY MILKTEA LARGE', 'large strawberry milktea', 75.00, 1, 0, '2022-10-18 06:11:31', '2022-10-18 06:11:31'),
(81, 15, 'F1', 'MOCHA FRAPPE MEDIUM', 'medium mocha frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(82, 15, 'F2', 'MOCHA FRAPPE LARGE', 'large mocha frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(83, 15, 'F3', 'DARK MOCHA FRAPPE MEDIUM', 'medium dark mocha frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(84, 15, 'F4', 'DARK MOCHA FRAPPE LARGE', 'large dark mocha frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(85, 15, 'F5', 'CAPPUCCCINO FRAPPE MEDIUM', 'medium cappuccino frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(86, 15, 'F6', 'CAPPUCCINO FRAPPE LARGE', 'large cappuccino frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(87, 15, 'F7', 'CARAMEL MACCHIATO FRAPPE MEDIUM', 'medium caramel macchiato frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(88, 15, 'F8', 'CARAMEL MACCHIATO FRAPPE LARGE', 'large caramel macchiato frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(89, 15, 'F9', 'JAVA CHIPS FRAPPE MEDIUM', 'medium java chips frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(90, 15, 'F10', 'JAVA CHIPS FRAPPE LARGE', 'large java chips frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(91, 15, 'F11', 'COOKIES N CREAM FRAPPE MEDIUM', 'medium cookies and cream frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(92, 15, 'F12', 'COOKIES N CREAM FRAPPE LARGE', 'large cookies and cream frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(93, 15, 'F13', 'STRAWBERRY FRAPPE MEDIUM', 'medium strawberry frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(94, 15, 'F14', 'STRAWBERRY FRAPPE LARGE', 'large strawberry frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(95, 15, 'F15', 'RED VELVET FRAPPE MEDIUM', 'medium red velvet frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(96, 15, 'F16', 'RED VELVET FRAPPE LARGE', 'large red velvet frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(97, 15, 'F17', 'MATCHA FRAPPE MEDIUM', 'medium matcha frappe', 110.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(98, 15, 'F18', 'MATCHA FRAPPE LARGE', 'large matcha frappe', 130.00, 1, 0, '2022-10-18 06:31:00', '2022-10-18 06:31:00'),
(120, 11, 'test', 'test', 'asdasdasdd', 25.00, 0, 0, '2022-10-30 02:18:08', '2022-10-30 21:22:19'),
(121, 11, '222', 'sss', 'asdasdasdasd', 25.00, 0, 0, '2022-10-30 03:44:22', '2022-10-31 00:06:48');

-- --------------------------------------------------------

--
-- Table structure for table `tblorderitems`
--

CREATE TABLE `tblorderitems` (
  `order_id` int(30) NOT NULL,
  `menu_id` int(30) NOT NULL,
  `price` float(12,2) NOT NULL DEFAULT 0.00,
  `quantity` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblorderitems`
--

INSERT INTO `tblorderitems` (`order_id`, `menu_id`, `price`, `quantity`) VALUES
(162, 24, 550.00, 1),
(163, 34, 75.00, 1),
(163, 25, 60.00, 1),
(164, 20, 110.00, 1),
(164, 24, 550.00, 1),
(165, 20, 110.00, 1),
(165, 24, 550.00, 1),
(166, 20, 110.00, 1),
(169, 117, 28.00, 1),
(170, 117, 28.00, 1),
(171, 117, 28.00, 1),
(172, 117, 28.00, 1),
(173, 117, 28.00, 1),
(177, 22, 230.00, 1),
(178, 20, 110.00, 1),
(179, 20, 110.00, 1),
(180, 20, 110.00, 2),
(181, 20, 110.00, 2),
(182, 20, 110.00, 2),
(183, 20, 110.00, 2),
(184, 20, 110.00, 2),
(185, 20, 110.00, 2),
(186, 121, 25.00, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblorderlist`
--

CREATE TABLE `tblorderlist` (
  `order_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `queue` varchar(50) NOT NULL,
  `total_amount` float(12,2) NOT NULL DEFAULT 0.00,
  `tendered_amount` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Queued,\r\n1 = Served',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblorderlist`
--

INSERT INTO `tblorderlist` (`order_id`, `user_id`, `code`, `queue`, `total_amount`, `tendered_amount`, `status`, `date_created`, `date_updated`) VALUES
(162, 1, '2022102400001', '00001', 550.00, 600.00, 1, '2022-10-24 04:20:59', '2022-10-24 14:39:24'),
(164, 1, '2022102400002', '00002', 660.00, 2220.00, 1, '2022-10-24 15:01:08', '2022-10-30 00:25:28'),
(166, 1, '2022102500001', '00001', 110.00, 220.00, 1, '2022-10-25 04:03:49', '2022-10-30 00:25:30'),
(169, 1, '2022103000001', '00001', 28.00, 50.00, 1, '2022-10-30 00:22:10', '2022-10-30 00:25:27'),
(170, 1, '2022103000002', '00002', 28.00, 51.00, 1, '2022-10-30 00:24:03', '2022-10-30 00:25:25'),
(171, 1, '2022103000003', '00003', 28.00, 52.00, 1, '2022-10-30 00:25:38', '2022-10-30 00:33:13'),
(172, 1, '2022103000004', '00004', 28.00, 53.00, 1, '2022-10-30 00:33:24', '2022-10-30 00:48:55'),
(173, 1, '2022103000005', '00005', 28.00, 50.00, 1, '2022-10-30 00:49:01', '2022-10-30 00:51:17'),
(174, 1, '2022103000006', '00006', 28.00, 50.00, 1, '2022-10-30 00:51:28', '2022-10-30 22:15:28'),
(175, 1, '2022103000007', '00007', 28.00, 60.00, 1, '2022-10-30 00:53:54', '2022-10-30 22:15:30'),
(176, 1, '2022103000008', '00008', 410.00, 500.00, 1, '2022-10-30 22:15:44', '2022-10-30 23:01:29'),
(177, 1, '2022103000009', '00009', 230.00, 500.00, 1, '2022-10-30 22:59:47', '2022-10-30 23:01:31'),
(178, 1, '2022103000010', '00010', 110.00, 220.00, 1, '2022-10-30 23:01:39', '2022-10-31 00:02:53'),
(179, 1, '2022103000011', '00011', 110.00, 220.00, 1, '2022-10-30 23:04:43', '2022-10-31 00:02:55'),
(180, 1, '2022103000012', '00012', 220.00, 220.00, 1, '2022-10-30 23:05:51', '2022-10-31 00:02:56'),
(181, 1, '2022103000013', '00013', 220.00, 220.00, 1, '2022-10-30 23:07:20', '2022-10-31 00:02:50'),
(182, 1, '2022103000014', '00014', 220.00, 220.00, 1, '2022-10-30 23:08:52', '2022-10-31 00:02:51'),
(183, 1, '2022103000015', '00015', 220.00, 220.00, 1, '2022-10-30 23:47:51', '2022-10-31 00:02:57'),
(184, 1, '2022103000016', '00016', 220.00, 220.00, 1, '2022-10-30 23:48:07', '2022-10-31 00:02:58'),
(185, 1, '2022103000017', '00017', 220.00, 590.00, 1, '2022-10-30 23:52:04', '2022-10-31 00:02:59'),
(186, 1, '2022103100001', '00001', 50.00, 110.00, 0, '2022-10-31 00:05:01', '2022-10-31 00:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `tblsalesreport`
--

CREATE TABLE `tblsalesreport` (
  `sales_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `date` float(12,2) NOT NULL,
  `sales_amount` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblstocks`
--

CREATE TABLE `tblstocks` (
  `stock_id` int(30) NOT NULL,
  `menu_id` int(30) NOT NULL,
  `amount` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblstocks`
--

INSERT INTO `tblstocks` (`stock_id`, `menu_id`, `amount`) VALUES
(102, 20, 30),
(103, 21, 50),
(104, 22, 49),
(105, 23, 50),
(106, 24, 50),
(107, 81, 50),
(108, 82, 50),
(109, 83, 50),
(110, 84, 50),
(111, 85, 50),
(112, 86, 50),
(113, 87, 50),
(114, 88, 50),
(115, 89, 50),
(116, 90, 50),
(117, 91, 50),
(118, 92, 50),
(119, 93, 50),
(120, 94, 50),
(121, 95, 50),
(122, 96, 50),
(123, 97, 50),
(124, 98, 50),
(125, 25, 50),
(126, 26, 50),
(127, 27, 50),
(128, 28, 50),
(129, 29, 50),
(130, 30, 50),
(131, 31, 50),
(132, 32, 50),
(133, 33, 50),
(134, 34, 50),
(135, 35, 50),
(136, 36, 50),
(137, 37, 50),
(138, 38, 50),
(139, 39, 50),
(140, 40, 50),
(141, 41, 50),
(142, 42, 50),
(143, 43, 50),
(144, 44, 50),
(145, 9, 20),
(146, 10, 21),
(147, 11, 21),
(148, 12, 50),
(149, 13, 50),
(150, 14, 50),
(151, 15, 50),
(152, 16, 50),
(153, 17, 50),
(154, 18, 50),
(155, 19, 50),
(182, 121, -1),
(183, 120, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblsysteminfo`
--

CREATE TABLE `tblsysteminfo` (
  `sys_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblsysteminfo`
--

INSERT INTO `tblsysteminfo` (`sys_id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'A Web Based System for Ordering and Inventory'),
(6, 'short_name', 'Korbanoi'),
(11, 'logo', 'uploads/logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@musicschool.com'),
(20, 'address', 'Here St, Down There City, Anywhere Here, 2306 -updated'),
(21, 'name', 'A Web Based System for Ordering and Inventory'),
(22, 'short_name', 'Korbanoi'),
(23, 'name', 'A Web Based System for Ordering and Inventory'),
(24, 'short_name', 'Korbanoi');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserlist`
--

CREATE TABLE `tbluserlist` (
  `user_id` int(30) NOT NULL,
  `changes` tinyint(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbluserlist`
--

INSERT INTO `tbluserlist` (`user_id`, `changes`, `date`) VALUES
(1, 2, '2022-10-12 08:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserlogs`
--

CREATE TABLE `tbluserlogs` (
  `logs_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbluserlogs`
--

INSERT INTO `tbluserlogs` (`logs_id`, `user_id`, `time_in`, `time_out`) VALUES
(1, 1, '2022-10-11 23:41:26', '2022-10-11 23:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `user_id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`user_id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', '', 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2022-10-09 16:22:55'),
(5, 'Gerico', 'a', 'Layones', 'gerico', 'd8578edf8458ce06fbc5bb76a58c5ca4', NULL, NULL, 2, '2022-10-10 23:35:55', '2022-10-10 23:35:55'),
(6, 'Gerico', 'qweqwe', 'qweqwe', 'qwerty', 'd8578edf8458ce06fbc5bb76a58c5ca4', NULL, NULL, 1, '2022-10-20 04:40:27', '2022-10-20 04:40:27'),
(7, 'asda', 'asdad', 'asdasda', 'qwerty', 'd8578edf8458ce06fbc5bb76a58c5ca4', NULL, NULL, 1, '2022-10-20 04:41:06', '2022-10-20 04:41:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcategorylist`
--
ALTER TABLE `tblcategorylist`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tblmenulist`
--
ALTER TABLE `tblmenulist`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tblorderitems`
--
ALTER TABLE `tblorderitems`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tblorderlist`
--
ALTER TABLE `tblorderlist`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tblsalesreport`
--
ALTER TABLE `tblsalesreport`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `tblstocks`
--
ALTER TABLE `tblstocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `tblsysteminfo`
--
ALTER TABLE `tblsysteminfo`
  ADD PRIMARY KEY (`sys_id`);

--
-- Indexes for table `tbluserlogs`
--
ALTER TABLE `tbluserlogs`
  ADD PRIMARY KEY (`logs_id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcategorylist`
--
ALTER TABLE `tblcategorylist`
  MODIFY `category_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblmenulist`
--
ALTER TABLE `tblmenulist`
  MODIFY `menu_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tblorderlist`
--
ALTER TABLE `tblorderlist`
  MODIFY `order_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `tblstocks`
--
ALTER TABLE `tblstocks`
  MODIFY `stock_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `tblsysteminfo`
--
ALTER TABLE `tblsysteminfo`
  MODIFY `sys_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblmenulist`
--
ALTER TABLE `tblmenulist`
  ADD CONSTRAINT `category_id_fk_ml` FOREIGN KEY (`category_id`) REFERENCES `tblcategorylist` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tblorderlist`
--
ALTER TABLE `tblorderlist`
  ADD CONSTRAINT `user_id_fk_ol` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `tblstocks`
--
ALTER TABLE `tblstocks`
  ADD CONSTRAINT `tblstocks_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `tblmenulist` (`menu_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
