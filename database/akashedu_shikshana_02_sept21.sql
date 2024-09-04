-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2021 at 02:00 AM
-- Server version: 5.6.51
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akashedu_shikshana`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `acd_year_id` int(11) NOT NULL,
  `acd_year_name` varchar(255) NOT NULL,
  `acd_year_start` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`acd_year_id`, `acd_year_name`, `acd_year_start`) VALUES
(1, '2021-22', '2021');

-- --------------------------------------------------------

--
-- Table structure for table `activity_history`
--

CREATE TABLE `activity_history` (
  `activity_id` int(11) NOT NULL,
  `login_user` varchar(255) NOT NULL,
  `panel_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `sub_menu` varchar(255) NOT NULL,
  `action_details` varchar(255) NOT NULL,
  `machine_name` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_history`
--

INSERT INTO `activity_history` (`activity_id`, `login_user`, `panel_id`, `menu_id`, `sub_menu`, `action_details`, `machine_name`, `browser`, `date`) VALUES
(33, 'superadmin', 2, 1, 'Add Class', 'Class Class1 is created', '165.225.104.106', 'Chrome', '2021-03-18 11:30:53'),
(34, 'admin', 2, 2, 'Add Section', 'Section A for Class Class1 is created', '165.225.104.106', 'Chrome', '2021-03-18 20:38:26'),
(35, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Tuition Fees is created', '165.225.104.106', 'Chrome', '2021-03-18 20:38:49'),
(36, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Admission Fees is created', '165.225.104.106', 'Chrome', '2021-03-18 20:38:56'),
(37, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Books is created', '165.225.104.106', 'Chrome', '2021-03-18 20:39:00'),
(38, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Uniform is created', '165.225.104.106', 'Chrome', '2021-03-18 20:39:05'),
(39, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Library is created', '165.225.104.106', 'Chrome', '2021-03-18 20:39:10'),
(40, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Sports is created', '165.225.104.106', 'Chrome', '2021-03-18 20:39:23'),
(41, 'admin', 2, 3, 'Assign Fee to class', 'For Class Class1 Fee is assigned', '165.225.104.106', 'Chrome', '2021-03-18 20:40:11'),
(42, 'admin', 2, 3, 'Institute Settings', 'The institute settings are updated.', '165.225.104.106', 'Chrome', '2021-03-18 20:41:47'),
(43, 'superadmin', 0, 0, '', 'Vasanth Fees Updated ', '165.225.104.106', 'Chrome', '2021-03-18 20:48:07'),
(44, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 14500 has been received.', '165.225.104.106', 'Chrome', '2021-03-18 20:49:42'),
(45, 'superadmin', 0, 0, '', 'Darshan Fees Updated ', '165.225.104.106', 'Chrome', '2021-03-18 21:00:13'),
(46, 'superadmin', 0, 0, '', 'Darshan School Fees of Rs 12000 has been received.', '165.225.104.106', 'Chrome', '2021-03-18 21:01:46'),
(47, 'admin', 0, 0, '', 'Vasanth School Fees of Rs 7000 has been received.', '165.225.104.106', 'Chrome', '2021-03-18 22:48:50'),
(48, 'admin', 0, 0, '', 'Vasanth Fees Approved', '165.225.104.106', 'Chrome', '2021-03-18 22:51:03'),
(49, 'admin', 0, 0, '', 'Darshan School Fees of Rs 5000 has been received.', '165.225.104.106', 'Chrome', '2021-03-18 22:54:40'),
(50, 'superadmin', 0, 0, '', 'Puja Fees Updated ', '106.210.42.230', 'Chrome', '2021-03-22 15:50:11'),
(51, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 100 has been received.', '106.210.42.230', 'Chrome', '2021-03-22 16:05:05'),
(52, 'superadmin', 0, 0, '', 'Puja School Fees of Rs 500 has been received.', '106.210.42.230', 'Chrome', '2021-03-22 16:13:26'),
(53, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 100 has been received.', '106.210.52.209', 'Chrome', '2021-03-23 17:23:23'),
(54, 'admin', 0, 0, '', 'Vasanth School Fees of Rs 2000 has been received.', '165.225.123.38', 'Chrome', '2021-03-24 17:36:40'),
(55, 'admin', 0, 0, '', 'Vasanth School Fees of Rs 1800 has been received.', '165.225.123.38', 'Chrome', '2021-03-24 17:40:02'),
(56, 'admin', 0, 0, '', 'Puja School Fees of Rs 11000 has been received.', '165.225.123.45', 'Chrome', '2021-03-25 19:17:06'),
(57, 'superadmin', 0, 0, '', 'Vasanth Fees Updated ', '165.225.123.45', 'Chrome', '2021-03-25 19:41:23'),
(58, 'superadmin', 0, 0, '', 'Rohan Fees Updated ', '165.225.123.45', 'Chrome', '2021-03-25 19:42:15'),
(59, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 15000 has been received.', '165.225.123.45', 'Chrome', '2021-03-25 19:45:52'),
(60, 'superadmin', 0, 0, '', 'Rohan School Fees of Rs 20000 has been received.', '165.225.123.45', 'Chrome', '2021-03-25 19:52:59'),
(61, 'superadmin', 0, 0, '', 'Vasanth Fees Approved', '165.225.123.45', 'Chrome', '2021-03-25 19:55:02'),
(62, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 2000 has been received.', '165.225.123.45', 'Chrome', '2021-03-25 19:56:10'),
(63, 'superadmin', 0, 0, '', 'Vasanth Fees Declined', '165.225.123.45', 'Chrome', '2021-03-25 19:59:11'),
(64, 'admin', 0, 0, '', 'Vasanth School Fees of Rs 12000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 19:26:19'),
(65, 'admin', 0, 0, '', 'Vasanth School Fees of Rs 2000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 19:27:03'),
(66, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 6000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 19:49:17'),
(67, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 6000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 19:53:04'),
(68, 'superadmin', 0, 0, '', 'Vasanth Fees Approved', '165.225.123.50', 'Chrome', '2021-03-29 19:54:03'),
(69, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 6000 has been deleted.', '165.225.123.50', 'Chrome', '2021-03-29 20:10:20'),
(70, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 12000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 20:13:46'),
(71, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 12000 has been deleted.', '165.225.123.50', 'Chrome', '2021-03-29 20:14:16'),
(72, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 10000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 20:15:24'),
(73, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 7000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 20:16:18'),
(74, 'superadmin', 0, 0, '', 'Vasanth Fees Approved', '165.225.123.50', 'Chrome', '2021-03-29 20:16:43'),
(75, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 5000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 20:17:47'),
(76, 'superadmin', 0, 0, '', 'Vasanth Fees Declined', '165.225.123.50', 'Chrome', '2021-03-29 20:18:25'),
(77, 'superadmin', 2, 3, 'Add Fee Header', 'Fee Header Donation is created', '165.225.123.50', 'Chrome', '2021-03-29 20:44:32'),
(78, 'superadmin', 0, 0, '', 'Vasanth Fees Updated ', '165.225.123.50', 'Chrome', '2021-03-29 20:48:29'),
(79, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 7000 has been received.', '165.225.123.50', 'Chrome', '2021-03-29 20:52:21'),
(80, 'superadmin', 2, 1, 'Add Class', 'Class Two is created', '157.42.236.50', 'Chrome', '2021-03-30 16:31:34'),
(81, 'superadmin', 2, 2, 'Add Section', 'Section B for Class Class1 is created', '157.42.236.50', 'Chrome', '2021-03-30 16:32:07'),
(82, 'superadmin', 0, 0, '', 'Expense type Desk is created', '157.42.236.50', 'Chrome', '2021-03-30 16:34:46'),
(83, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 500 has been received.', '157.42.236.50', 'Chrome', '2021-03-30 17:01:54'),
(84, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 2000 has been received.', '157.42.70.169', 'Chrome', '2021-04-03 09:47:31'),
(85, 'superadmin', 0, 0, '', 'Vasanth School Fees of Rs 2500 has been received.', '157.42.65.81', 'Chrome', '2021-04-03 11:21:53'),
(86, 'superadmin', 2, 1, 'Add Class', 'Class PUC1(Science) is created', '165.225.123.63', 'Chrome', '2021-07-15 11:52:23'),
(87, 'superadmin', 2, 2, 'Add Section', 'Section A for Class PUC1(Science) is created', '165.225.123.63', 'Chrome', '2021-07-15 11:52:32'),
(88, 'superadmin', 2, 3, 'Add Fee Header', 'Fee Header Admission Fees is created', '106.223.35.158', 'Chrome', '2021-07-15 17:56:09'),
(89, 'superadmin', 2, 3, 'Add Fee Header', 'Fee Header Computer Fees is created', '106.223.35.158', 'Chrome', '2021-07-15 17:56:12'),
(90, 'superadmin', 2, 3, 'Add Fee Header', 'Fee Header Tution Fees is created', '106.223.35.158', 'Chrome', '2021-07-15 17:56:17'),
(91, 'superadmin', 2, 3, 'Add Fee Header', 'Fee Header SMS Fees is created', '106.223.35.158', 'Chrome', '2021-07-15 17:56:21'),
(92, 'superadmin', 2, 3, 'Institute Settings', 'The institute settings are updated.', '106.223.35.158', 'Chrome', '2021-07-15 17:57:15'),
(93, 'superadmin', 0, 0, '', 'Expense type Office Expense is created', '106.223.35.158', 'Chrome', '2021-07-15 17:57:33'),
(94, 'superadmin', 0, 0, '', 'Expense type Other Expense is created', '106.223.35.158', 'Chrome', '2021-07-15 17:57:42'),
(95, 'superadmin', 2, 3, 'Assign Fee to class', 'For Class PUC1(Science) Fee is assigned', '106.223.35.158', 'Chrome', '2021-07-15 18:00:42'),
(96, 'superadmin', 0, 0, '', 'Sweta Fees Updated ', '106.223.33.254', 'Chrome', '2021-07-15 18:37:13'),
(97, 'superadmin', 0, 0, '', 'Sweta School Fees of Rs 10000 has been received.', '106.223.33.38', 'Chrome', '2021-07-15 18:54:00'),
(98, 'admin', 2, 1, 'Add Class', 'Class LKG is created', '165.225.123.58', 'Chrome', '2021-07-26 15:52:40'),
(99, 'admin', 2, 2, 'Add Section', 'Section A for Class LKG is created', '165.225.123.58', 'Chrome', '2021-07-26 15:52:51'),
(100, 'admin', 2, 1, 'Add Class', 'Class UKG is created', '165.225.123.58', 'Chrome', '2021-07-26 15:53:01'),
(101, 'admin', 2, 1, 'Add Class', 'Class 1STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:53:13'),
(102, 'admin', 2, 1, 'Edit Class', 'Class 1STD is edited', '165.225.123.58', 'Chrome', '2021-07-26 15:53:36'),
(103, 'admin', 2, 1, 'Add Class', 'Class NURSERY is created', '165.225.123.58', 'Chrome', '2021-07-26 15:53:50'),
(104, 'admin', 2, 1, 'Add Class', 'Class 2ND STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:53:58'),
(105, 'admin', 2, 1, 'Add Class', 'Class 3RD STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:03'),
(106, 'admin', 2, 1, 'Add Class', 'Class 4TH STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:08'),
(107, 'admin', 2, 1, 'Add Class', 'Class 5TH STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:12'),
(108, 'admin', 2, 2, 'Add Section', 'Section A for Class UKG is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:25'),
(109, 'admin', 2, 2, 'Add Section', 'Section A for Class 1ST STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:32'),
(110, 'admin', 2, 2, 'Add Section', 'Section A for Class NURSERY is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:36'),
(111, 'admin', 2, 2, 'Add Section', 'Section A for Class 2ND STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:40'),
(112, 'admin', 2, 2, 'Add Section', 'Section A for Class 3RD STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:44'),
(113, 'admin', 2, 2, 'Add Section', 'Section A for Class 4TH STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:50'),
(114, 'admin', 2, 2, 'Add Section', 'Section A for Class 5TH STD is created', '165.225.123.58', 'Chrome', '2021-07-26 15:54:55'),
(115, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Tution Fees is created', '165.225.123.58', 'Chrome', '2021-07-26 15:55:27'),
(116, 'admin', 2, 3, 'Add Fee Header', 'Fee Header School Maintenance Fees is created', '165.225.123.58', 'Chrome', '2021-07-26 15:55:45'),
(117, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Govt Fees is created', '165.225.123.58', 'Chrome', '2021-07-26 15:55:56'),
(118, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Admission Fees/Building Fund is created', '165.225.123.58', 'Chrome', '2021-07-26 15:56:34'),
(119, 'admin', 2, 3, 'Add Fee Header', 'Fee Header Other Fees is created', '165.225.123.58', 'Chrome', '2021-07-26 15:56:46'),
(120, 'admin', 2, 3, 'Assign Fee to class', 'For Class 1ST STD Fee is assigned', '165.225.123.58', 'Chrome', '2021-07-26 16:00:54'),
(121, 'admin', 2, 3, 'Assign Fee to class', 'For Class 2ND STD Fee is assigned', '165.225.123.58', 'Chrome', '2021-07-26 16:02:01'),
(122, 'admin', 2, 3, 'Assign Fee to class', 'For Class 3RD STD Fee is assigned', '165.225.123.58', 'Chrome', '2021-07-26 16:03:12'),
(123, 'admin', 2, 3, 'Assign Fee to class', 'For Class 4TH STD Fee is assigned', '165.225.123.58', 'Chrome', '2021-07-26 16:03:24'),
(124, 'admin', 2, 3, 'Assign Fee to class', 'For Class 5TH STD Fee is assigned', '165.225.123.58', 'Chrome', '2021-07-26 16:03:38'),
(125, 'admin', 2, 3, 'Institute Settings', 'The institute settings are updated.', '165.225.123.58', 'Chrome', '2021-07-26 16:07:43'),
(126, 'admin', 2, 1, 'Add Class', 'Class PUC 1st year Science is created', '103.252.145.11', 'Chrome', '2021-08-09 16:13:39'),
(127, 'admin', 2, 1, 'Add Class', 'Class PUC 1st year Commerce is created', '103.252.145.11', 'Chrome', '2021-08-09 16:13:58'),
(128, 'admin', 2, 1, 'Add Class', 'Class PUC II nd year Science is created', '103.252.145.11', 'Chrome', '2021-08-09 16:14:23'),
(129, 'admin', 2, 1, 'Add Class', 'Class PUC II nd year Commerce is created', '103.252.145.11', 'Chrome', '2021-08-09 16:14:34'),
(130, 'admin', 2, 2, 'Add Section', 'Section A Section for Class PUC 1st year Science is created', '103.252.145.11', 'Chrome', '2021-08-09 16:16:47'),
(131, 'admin', 2, 2, 'Add Section', 'Section A Section for Class PUC 1st year Commerce is created', '103.252.145.11', 'Chrome', '2021-08-09 16:17:11'),
(132, 'admin', 2, 2, 'Add Section', 'Section A Section for Class PUC II nd year Science is created', '103.252.145.11', 'Chrome', '2021-08-09 16:17:17'),
(133, 'admin', 2, 2, 'Add Section', 'Section A Section for Class PUC II nd year Commerce is created', '103.252.145.11', 'Chrome', '2021-08-09 16:17:21'),
(134, 'admin', 2, 1, 'Edit Class', 'Class PUC 1st year Science is edited', '103.252.145.11', 'Chrome', '2021-08-09 16:20:07'),
(135, 'admin', 2, 1, 'Edit Class', 'Class PUC 1st year Commerce is edited', '103.252.145.11', 'Chrome', '2021-08-09 16:20:17'),
(136, 'admin', 2, 3, 'Assign Fee to class', 'For Class PUC I st year Science Fee is assigned', '165.225.123.60', 'Chrome', '2021-08-13 13:02:46'),
(137, 'admin', 2, 3, 'Assign Fee to class', 'For Class PUC I st year Commerce Fee is assigned', '103.252.145.11', 'Chrome', '2021-08-13 13:06:52'),
(138, 'admin', 0, 0, '', 'Fareed Sohail Pasha Fees Updated ', '165.225.123.60', 'Chrome', '2021-08-13 13:10:01'),
(139, 'admin', 0, 0, '', 'Rimsha Tabassum Fees Updated ', '103.252.145.11', 'Chrome', '2021-08-14 14:53:32'),
(140, 'admin', 0, 0, '', 'Vihaan A Patil School Fees of Rs 5000 has been received.', '165.225.123.33', 'Chrome', '2021-08-25 16:35:39'),
(141, 'admin', 0, 0, '', 'K.Asra Fathima School Fees of Rs 5000 has been received.', '165.225.123.33', 'Chrome', '2021-08-25 16:36:13'),
(142, 'superadmin', 2, 3, 'Assign Fee to class', 'For Class LKG Fee is assigned', '139.167.210.201', 'Chrome', '2021-08-25 16:45:08'),
(143, 'superadmin', 2, 3, 'Assign Fee to class', 'For Class UKG Fee is assigned', '139.167.210.201', 'Chrome', '2021-08-25 16:45:14'),
(144, 'superadmin', 2, 3, 'Assign Fee to class', 'For Class NURSERY Fee is assigned', '139.167.210.201', 'Chrome', '2021-08-25 16:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `admission_id` int(100) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `fathername` text NOT NULL,
  `gender` text NOT NULL,
  `dob` varchar(50) NOT NULL,
  `age` int(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(100) NOT NULL,
  `aadhar` bigint(100) NOT NULL,
  `qualification` varchar(50) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `pincode` varchar(50) NOT NULL,
  `religion` text NOT NULL,
  `caste` text NOT NULL,
  `category` text NOT NULL,
  `previous_school` varchar(100) NOT NULL,
  `previous_grade` int(11) NOT NULL,
  `previous_result` text NOT NULL,
  `previous_percentage` varchar(50) NOT NULL,
  `apply_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1-requested, 2-accept, 3-decline',
  `requested_message` text NOT NULL,
  `requested_date` datetime NOT NULL,
  `decline_reason` varchar(255) NOT NULL,
  `accept_decline_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`admission_id`, `reference_no`, `name`, `fathername`, `gender`, `dob`, `age`, `email`, `phone`, `aadhar`, `qualification`, `grade`, `address`, `city`, `state`, `pincode`, `religion`, `caste`, `category`, `previous_school`, `previous_grade`, `previous_result`, `previous_percentage`, `apply_date`, `status`, `requested_message`, `requested_date`, `decline_reason`, `accept_decline_date`) VALUES
(1, '32d61ca8706fa442e341', 'test', 'hgjh', 'Male', '2020-07-10', 25, 'test@gmail.com', 9871980749, 24545465456, '1', '1', 'jghkgj', 'Delhi', 'Delhi', '110096', '1', 'Rajput', '1', 'hgkhhj', 1, 'Pass', '55', '2020-07-10 11:12:11', 0, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `admission_for_grade`
--

CREATE TABLE `admission_for_grade` (
  `adm_id` int(11) NOT NULL,
  `adm_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admission_for_grade`
--

INSERT INTO `admission_for_grade` (`adm_id`, `adm_name`) VALUES
(1, 'B.Com'),
(2, 'B.A');

-- --------------------------------------------------------

--
-- Table structure for table `admission_type`
--

CREATE TABLE `admission_type` (
  `adm_type_id` int(11) NOT NULL,
  `adm_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission_type`
--

INSERT INTO `admission_type` (`adm_type_id`, `adm_type_name`) VALUES
(1, 'Old'),
(2, 'New'),
(3, 'Mid-Year');

-- --------------------------------------------------------

--
-- Table structure for table `allocate_budget`
--

CREATE TABLE `allocate_budget` (
  `allocate_budget_id` int(11) NOT NULL,
  `budget_header_id` int(11) NOT NULL,
  `allocate_amount` int(11) NOT NULL,
  `available_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `allocate_budget_expense`
--

CREATE TABLE `allocate_budget_expense` (
  `id` int(11) NOT NULL,
  `expense_id` varchar(11) NOT NULL,
  `budget_header_id` int(11) NOT NULL,
  `allocated_amount` int(11) NOT NULL,
  `available_amount` int(11) NOT NULL,
  `expensed_amount` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `amount_remaining` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_clsteacher`
--

CREATE TABLE `assign_clsteacher` (
  `assign_clst_id` int(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `st_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_custome_group`
--

CREATE TABLE `assign_custome_group` (
  `ass_cus_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `register_no` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assign_department`
--

CREATE TABLE `assign_department` (
  `ass_dept_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `assign_driver_route`
--

CREATE TABLE `assign_driver_route` (
  `assign_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `route_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_driver_route`
--

INSERT INTO `assign_driver_route` (`assign_id`, `driver_id`, `vehicle_id`, `vehicle_no`, `route_id`, `description`, `status`, `date`) VALUES
(1, 1, 1, 'KA35 1200', 1, 'Bus for College Road', '0', '2020-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `assign_fee_class`
--

CREATE TABLE `assign_fee_class` (
  `assign_fee_id` int(50) NOT NULL,
  `class_id` int(50) DEFAULT NULL,
  `fee_header_id` varchar(100) DEFAULT NULL,
  `fee_header_amount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_fee_class`
--

INSERT INTO `assign_fee_class` (`assign_fee_id`, `class_id`, `fee_header_id`, `fee_header_amount`) VALUES
(1, 3, '1,2,3', '19980,1000,20'),
(2, 5, '1,2,3', '19980,1000,20'),
(3, 6, '1,2,3', '19980,1000,20'),
(4, 7, '1,2,3', '19980,1000,20'),
(5, 8, '1,2,3', '19980,1000,20'),
(6, 9, '1,2,3,4,5', '30000,1000,1000,10000,3000'),
(7, 10, '1,2,3,4,5', '15000,1000,500,5000,3500'),
(8, 1, '1', '0'),
(9, 2, '1', '0'),
(10, 4, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `assign_subject`
--

CREATE TABLE `assign_subject` (
  `assign_sub_id` int(50) NOT NULL,
  `st_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_syllabus_staff`
--

CREATE TABLE `assign_syllabus_staff` (
  `assign_syllabus_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `chapter` varchar(255) NOT NULL,
  `from_dt` date NOT NULL,
  `to_dt` date NOT NULL,
  `days` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1-Done, 2-In Progress, 3-Not Started',
  `completion_date` date NOT NULL,
  `comments` varchar(255) NOT NULL,
  `creation_dt` date NOT NULL,
  `updated_dt` date NOT NULL,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assign_syllabus_staff`
--

INSERT INTO `assign_syllabus_staff` (`assign_syllabus_id`, `staff_id`, `class_id`, `section_id`, `subject_id`, `chapter`, `from_dt`, `to_dt`, `days`, `description`, `status`, `completion_date`, `comments`, `creation_dt`, `updated_dt`, `updated_by`) VALUES
(1, 1, 1, 1, 3, '1', '2021-01-04', '2021-01-05', 2, 'Completion of Chapter 1.', 3, '2021-01-26', 'done', '2021-01-25', '2021-01-27', 'admin'),
(2, 1, 1, 1, 3, '2', '2021-01-06', '2021-01-07', 2, 'Completion of Chapter 2.', 3, '0000-00-00', '', '2021-01-25', '0000-00-00', ''),
(3, 1, 3, 4, 3, '1', '2021-01-08', '2021-01-08', 1, 'Completion of Chapter 1.', 3, '0000-00-00', '', '2021-01-25', '0000-00-00', ''),
(4, 1, 3, 4, 3, '2', '2021-01-10', '2021-01-13', 3, 'Completion of Chapter 2.', 3, '0000-00-00', '', '2021-01-25', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_type`
--

CREATE TABLE `attendance_type` (
  `att_type_id` int(11) NOT NULL,
  `att_type_name` varchar(50) NOT NULL,
  `short_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_type`
--

INSERT INTO `attendance_type` (`att_type_id`, `att_type_name`, `short_name`) VALUES
(1, 'Present', 'PR'),
(2, 'Absent', 'AB'),
(3, 'Leave', 'LV');

-- --------------------------------------------------------

--
-- Table structure for table `att_report_month`
--

CREATE TABLE `att_report_month` (
  `month_id` int(10) NOT NULL,
  `month_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `att_report_month`
--

INSERT INTO `att_report_month` (`month_id`, `month_name`) VALUES
(1, 'January'),
(2, 'February '),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

--
-- Table structure for table `automatic_messages`
--

CREATE TABLE `automatic_messages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0-Active, 1-deactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `automatic_messages`
--

INSERT INTO `automatic_messages` (`id`, `title`, `status`) VALUES
(1, 'birthday_message', '1');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `bill_id` int(11) NOT NULL,
  `student_id` int(10) NOT NULL,
  `admfeepaid` int(50) DEFAULT NULL,
  `tutionfeepaid` int(50) DEFAULT NULL,
  `miscfeepaid` int(50) DEFAULT NULL,
  `transfeepaid` int(50) DEFAULT NULL,
  `due` int(50) DEFAULT NULL,
  `month` int(10) NOT NULL,
  `paidby` varchar(255) DEFAULT NULL,
  `challan_no` int(50) DEFAULT NULL,
  `issued_by` varchar(255) DEFAULT NULL,
  `issued_date` varchar(255) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(50) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `book_isbn` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `book_type_id` int(11) NOT NULL,
  `quantity` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_return_type`
--

CREATE TABLE `book_return_type` (
  `book_return_type_id` int(11) NOT NULL,
  `book_return_type_name` varchar(100) NOT NULL,
  `return_type_days` int(50) NOT NULL,
  `book_fine_per_day` int(50) NOT NULL,
  `remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `book_type`
--

CREATE TABLE `book_type` (
  `book_type_id` int(50) NOT NULL,
  `book_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(50) NOT NULL,
  `branch_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `budget_header`
--

CREATE TABLE `budget_header` (
  `budget_header_id` int(50) NOT NULL,
  `budget_header_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE `certificate` (
  `certificate_id` int(11) NOT NULL,
  `certificate_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`certificate_id`, `certificate_name`) VALUES
(1, 'Bonafide Certificate'),
(2, 'Study Certificate'),
(3, 'Transfer Certificate');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(10) NOT NULL,
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(1, 'LKG'),
(2, 'UKG'),
(3, '1ST STD'),
(4, 'NURSERY'),
(5, '2ND STD'),
(6, '3RD STD'),
(7, '4TH STD'),
(8, '5TH STD'),
(9, 'PUC I st year Science'),
(10, 'PUC I st year Commerce'),
(11, 'PUC II nd year Science'),
(12, 'PUC II nd year Commerce');

-- --------------------------------------------------------

--
-- Table structure for table `co_scholastic`
--

CREATE TABLE `co_scholastic` (
  `scholastic_id` int(11) NOT NULL,
  `scholastic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `co_scholastic`
--

INSERT INTO `co_scholastic` (`scholastic_id`, `scholastic_name`) VALUES
(1, 'General Knowledge'),
(2, 'Attitude towards awareness programme'),
(3, 'Attitude towards school functions'),
(4, 'Ability to work in group / leadership quality'),
(5, 'Attitude Towards Peers'),
(6, 'Attitude Towards Teachers'),
(7, 'Art and Culture'),
(8, 'Computer Science'),
(9, 'Dance / Drama'),
(10, 'Health and Hygiene'),
(11, 'Music'),
(12, 'Physical Education And Sports'),
(13, 'Value Education'),
(15, 'Yoga');

-- --------------------------------------------------------

--
-- Table structure for table `custome_group`
--

CREATE TABLE `custome_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `day_id` int(11) NOT NULL,
  `day_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`day_id`, `day_name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `dead_stock`
--

CREATE TABLE `dead_stock` (
  `dead_stock_id` int(11) NOT NULL,
  `dsid` varchar(255) NOT NULL,
  `issue_ord_id` int(11) NOT NULL,
  `pur_ord_id` int(11) NOT NULL,
  `stock_type_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `dead_stock_qty` int(11) NOT NULL,
  `identification_no` varchar(255) NOT NULL,
  `returned_date` date NOT NULL,
  `returned_by` varchar(255) NOT NULL,
  `returned_to` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `alternate_no` bigint(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `dlno` varchar(255) NOT NULL,
  `aadhar_no` varchar(255) NOT NULL,
  `previous_exp` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('0','1') NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `creation_date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `event_for` int(11) NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `event_heading` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - unseen, 1 - seen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`event_id`, `event_name`) VALUES
(1, 'Student'),
(2, 'Staff'),
(3, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(10) NOT NULL,
  `expense_type_id` int(10) DEFAULT NULL,
  `expense_details` varchar(255) DEFAULT NULL,
  `amount` int(10) DEFAULT NULL,
  `proofs` varchar(255) DEFAULT NULL,
  `point_of_contact` varchar(255) DEFAULT NULL,
  `expensed_datetime` varchar(255) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `expense_type_id` int(50) NOT NULL,
  `expense_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `submission_date` date NOT NULL,
  `student_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `raised_for` varchar(50) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `response` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - notrespond, 1 - respond'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `fees_id` int(10) NOT NULL,
  `class_id` int(10) DEFAULT NULL,
  `admissionfees` int(10) DEFAULT NULL,
  `tutionfees` int(10) DEFAULT NULL,
  `misfees` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fee_header`
--

CREATE TABLE `fee_header` (
  `fee_header_id` int(11) NOT NULL,
  `fee_header_name` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fee_header`
--

INSERT INTO `fee_header` (`fee_header_id`, `fee_header_name`) VALUES
(1, 'Tution Fees'),
(2, 'School Maintenance Fees'),
(3, 'Govt Fees'),
(4, 'Admission Fees/Building Fund'),
(5, 'Other Fees');

-- --------------------------------------------------------

--
-- Table structure for table `fee_mode`
--

CREATE TABLE `fee_mode` (
  `fee_mode_id` int(11) NOT NULL,
  `fee_mode_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fee_mode`
--

INSERT INTO `fee_mode` (`fee_mode_id`, `fee_mode_name`) VALUES
(1, 'Configured'),
(2, 'Increase'),
(3, 'Discount'),
(4, 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(50) NOT NULL,
  `condition1` int(11) NOT NULL,
  `condition2` int(11) NOT NULL,
  `colors` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `idcard`
--

CREATE TABLE `idcard` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `regno` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `idcard`
--

INSERT INTO `idcard` (`id`, `class_id`, `section_id`, `regno`, `pic`) VALUES
(1, 1, 1, 'St01', 'St01.jpg'),
(3, 1, 1, 'St02', 'St02.jpg'),
(4, 1, 1, 'St03', 'St03.jpg'),
(5, 1, 1, 'St04', 'St04.jpg'),
(6, 1, 1, 'St01', 'St01.jpg'),
(7, 1, 1, 'St01', 'St01.jpg'),
(8, 1, 1, 'St02', 'St02.jpg'),
(9, 1, 1, 'St03', 'St03.jpg'),
(10, 1, 1, 'St04', 'St04.jpg'),
(11, 1, 1, 'St01', 'St01.jpg'),
(12, 1, 1, 'St02', 'St02.jpg'),
(13, 1, 1, 'St03', 'St03.jpg'),
(14, 1, 1, 'St04', 'St04.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  `tags` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image`, `tags`) VALUES
(1, '10.jpg', 'gift'),
(2, '10.jpg', 'gift'),
(3, '10.jpg', 'gift'),
(4, '10.jpg', 'gift'),
(5, '10.jpg', 'gift');

-- --------------------------------------------------------

--
-- Table structure for table `installed_app`
--

CREATE TABLE `installed_app` (
  `inst_app_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `register_no` varchar(100) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `parent_no` bigint(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issue_bookto_faculty`
--

CREATE TABLE `issue_bookto_faculty` (
  `faculty_issue_id` int(11) NOT NULL,
  `book_id` varchar(255) NOT NULL,
  `st_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `return_type_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date NOT NULL,
  `returned_date` date NOT NULL,
  `return_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issue_bookto_students`
--

CREATE TABLE `issue_bookto_students` (
  `issue_id` int(11) NOT NULL,
  `book_id` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `register_no` varchar(100) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `return_type_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date NOT NULL,
  `returned_date` date NOT NULL,
  `return_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `issue_order`
--

CREATE TABLE `issue_order` (
  `issue_ord_id` int(11) NOT NULL,
  `ioid` varchar(255) NOT NULL,
  `issued_date` date NOT NULL,
  `issued_department` varchar(100) NOT NULL,
  `issued_to_id` int(11) NOT NULL,
  `stock_type_id` int(11) NOT NULL,
  `pur_ord_id` int(100) NOT NULL,
  `identification_no` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(100) NOT NULL,
  `description` text NOT NULL,
  `item_incharge` varchar(100) NOT NULL,
  `stock_vendor_id` int(11) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `leave_id` int(11) NOT NULL,
  `leave_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`leave_id`, `leave_name`) VALUES
(1, 'Sick Leave'),
(2, 'Casual Leave');

-- --------------------------------------------------------

--
-- Table structure for table `library_payment`
--

CREATE TABLE `library_payment` (
  `library_pay_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `penalty_amount` int(100) NOT NULL,
  `paid_amount` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `issue_date` datetime NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(100) NOT NULL,
  `student_id` int(50) NOT NULL,
  `admission_fee` int(100) NOT NULL,
  `tution_fee` int(100) NOT NULL,
  `misc_fee` int(100) NOT NULL,
  `transportation_fee` int(100) NOT NULL,
  `paidby` varchar(255) NOT NULL,
  `challan_no` int(100) NOT NULL,
  `issued_by` varchar(255) NOT NULL,
  `issued_date` varchar(255) NOT NULL,
  `action_type` varchar(255) NOT NULL,
  `loginuser` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `action_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `mark_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `test_name` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `marks` int(50) NOT NULL,
  `max_mark` int(11) DEFAULT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `panel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `panel_id`) VALUES
(1, 'Class', 2),
(2, 'Section', 2),
(3, 'Fees', 2);

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE `message_type` (
  `msg_type_id` int(11) NOT NULL,
  `msg_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`msg_type_id`, `msg_name`) VALUES
(1, 'Mobile App'),
(2, 'Message'),
(3, 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `month_id` int(10) NOT NULL,
  `month_name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `months`
--

INSERT INTO `months` (`month_id`, `month_name`, `short_name`) VALUES
(1, 'January', 'Jan'),
(2, 'February', 'Feb'),
(3, 'March', 'Mar'),
(4, 'April', 'Apr'),
(5, 'May', 'May'),
(6, 'June', 'Jun'),
(7, 'July', 'Jul'),
(8, 'August', 'Aug'),
(9, 'September', 'Sep'),
(10, 'October', 'Oct'),
(11, 'November', 'Nov'),
(12, 'December', 'Dec');

-- --------------------------------------------------------

--
-- Table structure for table `mytable`
--

CREATE TABLE `mytable` (
  `request_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `sender_id` varchar(6) NOT NULL,
  `date` varchar(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(10) NOT NULL,
  `mobile` bigint(12) DEFAULT NULL,
  `otp` bigint(6) DEFAULT '0',
  `status` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`id`, `mobile`, `otp`, `status`) VALUES
(1, 9110890120, 2356, 0),
(2, 9110890120, 2406, 0),
(3, 9110890120, 2416, 0);

-- --------------------------------------------------------

--
-- Table structure for table `panel`
--

CREATE TABLE `panel` (
  `panel_id` int(11) NOT NULL,
  `panel_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `panel`
--

INSERT INTO `panel` (`panel_id`, `panel_name`) VALUES
(1, 'Dashboard'),
(2, 'Configuration Panel');

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `payment_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`payment_type_id`, `payment_type_name`) VALUES
(1, 'Cash'),
(2, 'Cheque/DD'),
(3, 'Bank Deposit');

-- --------------------------------------------------------

--
-- Table structure for table `previous_fees`
--

CREATE TABLE `previous_fees` (
  `prev_fee_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `previous_fees` int(11) NOT NULL,
  `remarks` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisher_id` int(50) NOT NULL,
  `publisher_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `pur_ord_id` int(11) NOT NULL,
  `poid` varchar(255) NOT NULL,
  `stock_type_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `pur_ord_created` datetime NOT NULL,
  `identification_no` varchar(225) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amt_per_item` int(11) NOT NULL,
  `disc_per_item` int(11) NOT NULL,
  `description` text NOT NULL,
  `stock_vendor_id` int(11) NOT NULL,
  `amount` int(100) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qualification`
--

CREATE TABLE `qualification` (
  `qualification_id` int(11) NOT NULL,
  `qualification_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `qualification`
--

INSERT INTO `qualification` (`qualification_id`, `qualification_name`) VALUES
(1, 'PUC 2');

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `religion_id` int(11) NOT NULL,
  `religion_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `religion`
--

INSERT INTO `religion` (`religion_id`, `religion_name`) VALUES
(1, 'Hindu'),
(2, 'Islam'),
(3, 'Christian'),
(4, 'Buddhism'),
(5, 'Parsi'),
(6, 'Jain'),
(7, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `remedy`
--

CREATE TABLE `remedy` (
  `remedy_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `observations` varchar(255) NOT NULL,
  `observations_proof` varchar(255) NOT NULL,
  `remedies_taken` varchar(255) NOT NULL,
  `duration` int(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `improvement` varchar(255) NOT NULL,
  `improvement_proof` varchar(255) NOT NULL,
  `approved_by` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - disapprove, 1 - approve'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_type`
--

CREATE TABLE `request_type` (
  `request_id` int(11) NOT NULL,
  `request_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request_type`
--

INSERT INTO `request_type` (`request_id`, `request_name`) VALUES
(1, 'Feedback'),
(2, 'Suggestion'),
(3, 'Compliments');

-- --------------------------------------------------------

--
-- Table structure for table `return_stock`
--

CREATE TABLE `return_stock` (
  `ret_ord_id` int(11) NOT NULL,
  `roid` varchar(255) NOT NULL,
  `issue_ord_id` int(11) NOT NULL,
  `pur_ord_id` int(11) NOT NULL,
  `stock_type_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `return_qty` int(50) NOT NULL,
  `identification_no` varchar(255) NOT NULL,
  `returned_date` date NOT NULL,
  `returned_by` varchar(255) NOT NULL,
  `returned_to` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(10) NOT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `class_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`, `class_id`) VALUES
(1, 'A', 1),
(2, 'A', 2),
(3, 'A', 3),
(4, 'A', 4),
(5, 'A', 5),
(6, 'A', 6),
(7, 'A', 7),
(8, 'A', 8),
(9, 'A Section', 9),
(10, 'A Section', 10),
(11, 'A Section', 11),
(12, 'A Section', 12);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `company_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_email` varchar(255) NOT NULL,
  `company_number` bigint(20) NOT NULL,
  `company_address` varchar(255) NOT NULL,
  `company_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`company_id`, `company_name`, `company_email`, `company_number`, `company_address`, `company_image`) VALUES
(1, 'Akash International Public School', 'akashipschool@gmail.com', 7338180789, '1st Ward,Old Amaravathi Road,Chittawadagi, Hospet', 'Akash School Logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sms_setting`
--

CREATE TABLE `sms_setting` (
  `sms_id` int(50) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `secret_code` varchar(255) NOT NULL,
  `sender_id` varchar(255) NOT NULL,
  `api_url` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_setting`
--

INSERT INTO `sms_setting` (`sms_id`, `user_name`, `password`, `api_key`, `secret_code`, `sender_id`, `api_url`, `status`) VALUES
(1, 'kanchan', '123', '15304AappUeDm5e4bba26', '123', 'BPNTEK', 'http://login.bulksms365.in/api/v2/sendsms', '0');

-- --------------------------------------------------------

--
-- Table structure for table `social_category`
--

CREATE TABLE `social_category` (
  `soc_cat_id` int(11) NOT NULL,
  `soc_cat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_category`
--

INSERT INTO `social_category` (`soc_cat_id`, `soc_cat_name`) VALUES
(1, 'General'),
(2, 'SC'),
(3, 'ST'),
(4, 'CAT-1'),
(5, '2A'),
(6, '2B'),
(7, '3A'),
(8, '3B'),
(9, 'OBC'),
(10, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `st_id` int(50) NOT NULL,
  `staff_name` varchar(100) DEFAULT NULL,
  `staff_id` varchar(50) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL,
  `mobno` bigint(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `alt_mobno` bigint(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `teaching_type` varchar(100) DEFAULT NULL,
  `teaching_type_other` varchar(100) DEFAULT NULL,
  `skills` varchar(100) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `msg_type_id` int(11) NOT NULL,
  `aadharno` varchar(255) DEFAULT NULL,
  `caste` varchar(50) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `resume` varchar(100) DEFAULT NULL,
  `status` enum('0','1') NOT NULL COMMENT '0-deactive, 1-active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_idcard`
--

CREATE TABLE `staff_idcard` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_notifications`
--

CREATE TABLE `staff_notifications` (
  `st_notification_id` int(50) NOT NULL,
  `category` int(2) DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `selected_no` bigint(20) NOT NULL,
  `message` text CHARACTER SET utf8mb4 NOT NULL,
  `photos` varchar(255) NOT NULL,
  `loginuser` varchar(50) NOT NULL,
  `notice_datetime` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_notifications`
--

INSERT INTO `staff_notifications` (`st_notification_id`, `category`, `dept_id`, `staff_id`, `selected_no`, `message`, `photos`, `loginuser`, `notice_datetime`, `date`, `status`) VALUES
(1, 1, 1, 1, 9871980749, 'Hello \r\nThis is testing msg for Physics Dept.', '', 'superadmin', '2021-03-02 06:14:05', '2021-03-02', 0),
(2, 1, 1, 2, 9015501897, 'Hello \r\nThis is testing msg for Physics Dept.', '', 'superadmin', '2021-03-02 06:14:05', '2021-03-02', 0),
(3, 1, 1, 1, 9871980749, 'Message from admin\n', '', 'admin', '2021-03-03 02:29:31', '2021-03-03', 0),
(4, 1, 1, 2, 9015501897, 'Message from admin\n', '', 'admin', '2021-03-03 02:29:31', '2021-03-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_timetable`
--

CREATE TABLE `staff_timetable` (
  `stt_id` int(11) NOT NULL,
  `class_id` varchar(50) NOT NULL,
  `section_id` varchar(50) NOT NULL,
  `tperiod` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `subject_id` varchar(50) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_timetable`
--

INSERT INTO `staff_timetable` (`stt_id`, `class_id`, `section_id`, `tperiod`, `day`, `period`, `subject_id`, `staff_id`) VALUES
(1, '1', '1', 5, 1, 1, '1', 1),
(2, '1', '2', 5, 1, 2, '3', 1),
(3, 'Leisure', 'Leisure', 5, 1, 3, 'Leisure', 1),
(4, '2', '3', 5, 1, 4, '5', 1),
(5, '2', '4', 5, 1, 5, '7', 1),
(6, '1', '1', 5, 2, 1, '1', 1),
(7, '1', '2', 5, 2, 2, '3', 1),
(8, 'Leisure', 'Leisure', 5, 2, 3, 'Leisure', 1),
(9, '2', '3', 5, 2, 4, '5', 1),
(10, '2', '4', 5, 2, 5, '7', 1),
(11, '1', '1', 5, 3, 1, '1', 1),
(12, '1', '2', 5, 3, 2, '3', 1),
(13, '1', '1', 5, 3, 3, '4', 1),
(14, '2', '3', 5, 3, 4, '5', 1),
(15, '2', '4', 5, 3, 5, '7', 1),
(16, '1', '1', 5, 4, 1, '1', 1),
(17, '1', '2', 5, 4, 2, '3', 1),
(18, '1', '1', 5, 4, 3, '4', 1),
(19, 'Leisure', 'Leisure', 5, 4, 4, 'Leisure', 1),
(20, '2', '4', 5, 4, 5, '7', 1),
(21, '1', '1', 5, 5, 1, '1', 1),
(22, '1', '2', 5, 5, 2, '3', 1),
(23, 'Leisure', 'Leisure', 5, 5, 3, 'Leisure', 1),
(24, '2', '3', 5, 5, 4, '5', 1),
(25, 'Leisure', 'Leisure', 5, 5, 5, 'Leisure', 1),
(26, '1', '1', 5, 6, 1, '1', 1),
(27, '1', '2', 5, 6, 2, '3', 1),
(28, 'Leisure', 'Leisure', 5, 6, 3, 'Leisure', 1),
(29, '2', '3', 5, 6, 4, '5', 1),
(30, '2', '4', 5, 6, 5, '7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock_type`
--

CREATE TABLE `stock_type` (
  `stock_type_id` int(50) NOT NULL,
  `stock_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_vendor`
--

CREATE TABLE `stock_vendor` (
  `stock_vendor_id` int(50) NOT NULL,
  `stock_vendor_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(10) NOT NULL,
  `register_no` varchar(255) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `gender` enum('FEMALE','MALE') NOT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `admission_date` varchar(255) DEFAULT NULL,
  `student_contact` bigint(20) DEFAULT NULL,
  `class_id` int(10) DEFAULT NULL,
  `section_id` int(10) DEFAULT NULL,
  `due` int(50) NOT NULL,
  `month` int(10) NOT NULL,
  `parent_no` bigint(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `stuaddress` varchar(255) DEFAULT NULL,
  `adm_type_id` int(11) NOT NULL,
  `msg_type_id` int(11) NOT NULL,
  `academic_year` varchar(255) DEFAULT NULL,
  `admin_rte` varchar(100) NOT NULL,
  `religion_id` int(11) NOT NULL,
  `caste` varchar(100) NOT NULL,
  `soc_cat_id` int(11) NOT NULL,
  `blood_grp` varchar(100) NOT NULL,
  `mother_tongue` varchar(100) NOT NULL,
  `aadhar_card` bigint(20) NOT NULL,
  `stu_image` varchar(255) DEFAULT NULL,
  `birth_place` varchar(255) NOT NULL,
  `village` varchar(255) NOT NULL,
  `fqualification` varchar(255) NOT NULL,
  `mqualification` varchar(255) NOT NULL,
  `foccupation` varchar(255) NOT NULL,
  `moccupation` varchar(255) NOT NULL,
  `fannual_income` int(50) NOT NULL,
  `dependents` int(11) NOT NULL,
  `guardians` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `subcaste` varchar(255) NOT NULL,
  `other_language` varchar(255) NOT NULL,
  `present_address` varchar(255) NOT NULL,
  `previous_school` varchar(255) NOT NULL,
  `father_aadhar` bigint(20) NOT NULL,
  `mother_aadhar` bigint(20) NOT NULL,
  `student_bankacc` bigint(20) NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `bus_facility` varchar(255) NOT NULL,
  `stu_status` enum('0','1') NOT NULL,
  `android_status` int(11) NOT NULL DEFAULT '0',
  `firebase_reg_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `register_no`, `student_name`, `father_name`, `mother_name`, `gender`, `dob`, `admission_date`, `student_contact`, `class_id`, `section_id`, `due`, `month`, `parent_no`, `password`, `stuaddress`, `adm_type_id`, `msg_type_id`, `academic_year`, `admin_rte`, `religion_id`, `caste`, `soc_cat_id`, `blood_grp`, `mother_tongue`, `aadhar_card`, `stu_image`, `birth_place`, `village`, `fqualification`, `mqualification`, `foccupation`, `moccupation`, `fannual_income`, `dependents`, `guardians`, `nationality`, `subcaste`, `other_language`, `present_address`, `previous_school`, `father_aadhar`, `mother_aadhar`, `student_bankacc`, `ifsc_code`, `branch`, `bus_facility`, `stu_status`, `android_status`, `firebase_reg_id`) VALUES
(1, 'AKS1STSTD01', 'Vihaan A Patil', 'Alok A Patil', 'Saloni A Patil', 'MALE', '2015-11-22', '2021-06-15', 9620584244, 3, 3, 16000, 0, 9620584244, '9620584244', 'Hospet', 2, 1, '2021-22', 'No', 1, 'Sc', 1, 'A+', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(2, 'AKS1STSTD02', 'Nusart AHemadi', 'Niyaz Ahmed Rashid Niyazi', 'Shabeena Banu', 'FEMALE', '2015-04-08', '2021-06-15', 9845410702, 3, 3, 21000, 0, 9845410702, '9845410702', 'Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(3, 'AKS1STSTD03', 'A.Abdur Razak', 'A.Mabu Basha', 'A.Sabiya', 'MALE', '2016-02-14', '2021-06-18', 7676292492, 3, 3, 21000, 0, 9448483244, '9448483244', '19th Ward, Kurubara Oni, Near Madivallappa Temple, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '19th Ward, Kurubara Oni, Near Madivallappa Temple, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(4, 'AKS1STSTD04', 'A.Abdul Hannan', 'A.Umar Sab', 'A.Nasreen', 'MALE', '2015-09-09', '2021-06-18', 9986816019, 3, 3, 21000, 0, 9986816019, '9986816019', '19th Ward, Kurubara Oni, Near Madivallappa Temple,Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '19th Ward, Kurubara Oni, Near Madivallappa Temple,Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(5, 'AKS1STSTD05', 'A.Mahin', 'A.Ramathi', 'A.Tabbasum', 'FEMALE', '2015-05-19', '2021-06-18', 9845884158, 3, 3, 21000, 0, 9845884158, '9845884158', '19th Ward, Kurubara Oni, Near Madivallappa Temple,Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '19th Ward, Kurubara Oni, Near Madivallappa Temple,Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(6, 'AKS1STSTD06', 'Mohammed Alim Khan.A', 'Dada Khan.A', 'A.Reshma', 'MALE', '2014-11-17', '2021-06-21', 9742138734, 3, 3, 21000, 0, 9742138734, '9742138734', '16th Ward, Indira Nagar, Near Ambedkar Circle, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '16th Ward, Indira Nagar, Near Ambedkar Circle, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(7, 'AKS1STSTD07', 'B.S.Dhruva Sagar', 'B.Shanmukha', 'Pavithra', 'MALE', '2015-08-06', '2021-06-15', 9740873519, 3, 3, 21000, 0, 9740873519, '9740873519', 'Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(8, 'AKS1STSTD08', 'M.Sidharth', 'M.B.Devendrappa', 'S.Renuka', 'MALE', '2014-10-13', '2021-06-25', 7019781552, 3, 3, 21000, 0, 9880634042, '9880634042', 'Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(9, 'AKS1STSTD09', 'K.Ruzeena', 'K.Abdul Rauf', 'Safiya', 'FEMALE', '2014-12-31', '2021-07-15', 8971435805, 3, 3, 21000, 0, 8971435802, '8971435802', '17th Ward, Behind Noorani Masjid, SR Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '17th Ward, Behind Noorani Masjid, SR Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(10, 'AKS1STSTD010', 'F.Allen Christo', 'A.Franklin Christopher', 'Shalini', 'MALE', '2015-07-04', '2021-07-17', 7204743177, 3, 3, 21000, 0, 8453454586, '8453454586', 'H.No.NA 82, 30th Ward, Near TSPL Quarters, T B Dam, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.NA 82, 30th Ward, Near TSPL Quarters, T B Dam, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(11, 'AKSSTSTD011', 'Aliya Firdos', 'Ayub Basha', 'Asma', 'FEMALE', '2015-01-05', '2021-07-27', 6360339889, 3, 3, 21000, 0, 6360339889, '6360339889', 'No.636, 18th Ward, Near Noorani Masjid, S.R.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.636, 18th Ward, Near Noorani Masjid, S.R.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(12, 'AKS1STSTD012', 'Ezra Muqadas', 'Mohammed Ghouse.B', 'Nafeesa Azmi.M', 'FEMALE', '2015-07-12', '2015-07-28', 7975757607, 3, 3, 21000, 0, 7975757607, '7975757607', 'D.No.45, 11t Ward, Varakeri, chitwadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.45, 11t Ward, Varakeri, chitwadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(13, 'AKSSTSTD013', 'Harika.K', 'Ramesh.K', 'Surekha.K', 'FEMALE', '2015-08-12', '2021-07-28', 9886143155, 3, 3, 21000, 0, 6362602279, '6362602279', 'H.No.381, 16th Ward, Behind Masjid, Indra Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.381, 16th Ward, Behind Masjid, Indra Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(14, 'AKS2NDSTD', 'K.Asra Fathima', 'K.Ismail', 'Ruksana Parveen', 'FEMALE', '2014-10-09', '2021-06-28', 8880986420, 5, 5, 16000, 0, 8880986420, '8880986420', 'Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(15, 'AKS2NDSTD02', 'Sakshi Mahesh Kanavi', 'Mahesh S.K.', 'Madhavi Mahesh Kanavi', 'FEMALE', '2014-04-22', '2021-07-08', 8095988899, 5, 5, 21000, 0, 8095988899, '8095988899', '1st Ward, Near 2nd Theru, Chitwadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Near 2nd Theru, Chitwadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(16, 'AKS2NDSTD03', 'Mohammad Jishan Darvesh', 'Akbar Basha .MD', 'Shabana Anjum', 'MALE', '2014-03-17', '2021-07-19', 9480082670, 5, 5, 21000, 0, 9480082670, '9480082670', 'H.No.823, 10th Ward, 2nd Cross, S.L.Chowki, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.823, 10th Ward, 2nd Cross, S.L.Chowki, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(17, 'AKS3RDSTD01', 'Rafah Mariam', 'Zakir Hussain', 'Reshma', 'FEMALE', '2013-06-21', '2021-06-21', 9886370584, 6, 6, 21000, 0, 9886370584, '9886370584', 'No.80, 2nd G Cross, 5th Phase, Vinayakanagar, J.P.Nagar, Bangalore', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.80, 2nd G Cross, 5th Phase, Vinayakanagar, J.P.Nagar, Bangalore', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(18, 'AKS3RDSTD02', 'E.Manasa', 'Vishwanath', 'Nethravathi', 'FEMALE', '2013-05-18', '2021-06-23', 8197864426, 6, 6, 21000, 0, 8861435770, '8861435770', 'H.No.285, Near Govt Primary School, Main road, Hosur', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.285, Near Govt Primary School, Main road, Hosur', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(19, 'AKS3RDSTD03', 'Saad Waheed Pathan', 'Waheed Pathan', 'Rubina Pathan', 'MALE', '2012-12-28', '2021-07-14', 8792550154, 6, 6, 21000, 0, 9740654543, '9740654543', '8th Cross, Near Mother Theresa School, M.J.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '8th Cross, Near Mother Theresa School, M.J.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(20, 'AKS3RDSTD04', 'Sanmitha Rao.H', 'H Anil Kumar', 'H.Manasa', 'FEMALE', '2013-09-14', '2021-07-28', 9844395424, 6, 6, 21000, 0, 8660847368, '8660847368', 'Raghavendra Nilaya, Near Old RTO Office, Amaravathi, Dam Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Raghavendra Nilaya, Near Old RTO Office, Amaravathi, Dam Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(21, 'AKS4THSTD01', 'Mohammed Khaja Moinuddin', 'Mohammed Nazeer Basha', 'Tarannum Banu', 'MALE', '2012-05-31', '2021-03-21', 9481176328, 7, 7, 21000, 0, 6360592329, '6360592329', '10-23 E7/A, 29th Ward, 2nd Cross, Rajiv Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '10-23 E7/A, 29th Ward, 2nd Cross, Rajiv Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(22, 'AKS4THSTD02', 'Tanisha', 'Riyaz.M.S.', 'Shireentaj', 'FEMALE', '2012-02-02', '2021-06-26', 9343131212, 7, 7, 21000, 0, 9343131212, '9343131212', '175/1, 12th Ward, Pinjar Street, Behind Urdu Primary School, Chittwadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '175/1, 12th Ward, Pinjar Street, Behind Urdu Primary School, Chittwadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(23, 'AKS4THSTD03', 'Mohammed Ayaan.A', 'Y.Arif Basha', 'G.Shameem Banu', 'MALE', '2013-02-04', '2021-07-19', 9449434709, 7, 7, 21000, 0, 8508744405, '8508744405', '4th Cross, 17th Ward, S.R.Nagar, Near Dhobi Ghat raghu plot, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '4th Cross, 17th Ward, S.R.Nagar, Near Dhobi Ghat raghu plot, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(24, 'AKS5THSTD01', 'S.Wazeed', 'S.Rafiq', 'S.Firdose', 'MALE', '2010-09-02', '2021-06-21', 9535737430, 8, 8, 21000, 0, 9535737430, '9535737430', '12th Ward, Pinjar Street, Tippu Nagar, Chittawadagi, Hospet ', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Pinjar Street, Tippu Nagar, Chittawadagi, Hospet ', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(25, 'AKSNUR01', 'Rimsha Tabassum', 'Imran', 'Anjum Shaheen', 'FEMALE', '2018-05-03', '2021-06-25', 9036545344, 4, 4, 0, 0, 9036545344, '9036545344', '12th Ward, Banagar Street, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Banagar Street, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(26, 'AKSNUR02', 'K.Chandrashekar', 'K.Venkob', 'K.Yellamma', 'MALE', '2017-08-29', '2021-06-25', 9980546650, 4, 4, 0, 0, 9980546650, '9980546650', '34th Ward, Near Banada Keri Garadi Mane, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '34th Ward, Near Banada Keri Garadi Mane, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(27, 'AKSNUR03', 'G.Rithiksha', 'G.Lakshmana', 'G.Sridevi', 'FEMALE', '2018-09-12', '2021-06-25', 8073589125, 4, 4, 0, 0, 9844589004, '9844589004', 'D.No.1/207, 1st Ward, Sante Bayalu, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.1/207, 1st Ward, Sante Bayalu, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(28, 'AKSNUR04', 'K.Tawfeeq', 'K. Noor Mohammad', 'K.shaheen', 'MALE', '2018-07-18', '2021-06-25', 9663564501, 4, 4, 0, 0, 9663564501, '9663564501', 'H.No.1-197, 1st ward, Guled Street, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.1-197, 1st ward, Guled Street, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(29, 'AKSNUR05', 'M. Ruthvik', 'M. Srinivasulu', 'M Aksata', 'MALE', '2018-10-25', '2021-06-25', 8880033995, 4, 4, 0, 0, 9449009330, '9449009330', 'H.No.935/14/G,6th Ward, Kotal road, Opp Hero Hond Showroom, Muddapura No.10, Kampli', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.935/14/G,6th Ward, Kotal road, Opp Hero Hond Showroom, Muddapura No.10, Kampli', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(30, 'AKSNUR06', 'Abhishek Manjunath Mandali', 'Manjunath Mandali', 'Manjula', 'MALE', '2018-05-17', '2021-06-25', 8123952507, 4, 4, 0, 0, 8123952507, '8123952507', '1st Ward, Near 2nd Teru, Sante Bayalu, chittawadagi, Hospet', 1, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Near 2nd Teru, Sante Bayalu, chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(31, 'AKSLKG01', 'Abdul Mujeeb', 'Abdul Mujeeb', 'Mohammed Saleem', 'MALE', '2016-10-05', '2021-06-25', 9880058901, 1, 1, 0, 0, 9448287659, '9448287659', 'H.No.230, 12th Ward, Banagar Street, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.230, 12th Ward, Banagar Street, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(32, 'AKSLKG02', 'Mohammad Salmaan Shaik', 'Moula Hussain Shaik', 'Shabina Begum', 'MALE', '2017-02-04', '2021-06-25', 7338386162, 1, 1, 0, 0, 8147581704, '8147581704', '3rd Ward, 3rd Cross, Patel Nagar, Near Gopinath School, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '3rd Ward, 3rd Cross, Patel Nagar, Near Gopinath School, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(33, 'AKSLKG03', 'Harshit H.M.', 'Daruka Swamy THM', 'Kusuma G', 'MALE', '2017-12-06', '2021-06-25', 9482772338, 1, 1, 0, 0, 9448988883, '9448988883', 'Chetana Nilaya, 1st Cross, Amaravathi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Chetana Nilaya, 1st Cross, Amaravathi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(34, 'AKSLKG04', 'Rida Zayn', 'Shakeel Ahmed', 'Yasmeen', 'FEMALE', '2017-05-03', '2021-06-25', 6363414180, 1, 1, 0, 0, 9916433143, '9916433143', '33rd Ward, Near Valmiki Ashrama, Myaskeri, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '33rd Ward, Near Valmiki Ashrama, Myaskeri, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(35, 'AKSLKG05', 'Sanobar Yasmeen', 'B Badruddin', 'Ayesha Siddiqua', 'FEMALE', '2017-10-22', '2021-06-25', 9620164452, 1, 1, 0, 0, 8105199756, '8105199756', '12th Ward, Pinjar Street, tippu Nagar, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Pinjar Street, tippu Nagar, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(36, 'AKSLKG06', 'Mohammed Gouse', 'Mohammed Imran', 'S.Bashreen', 'MALE', '2017-03-21', '2021-06-25', 9741460667, 1, 1, 0, 0, 9741460667, '9741460667', 'H.No.1460, 24th Ward, Housing Board Colony, Teachers Quarters, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.1460, 24th Ward, Housing Board Colony, Teachers Quarters, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(37, 'AKSLKG07', 'Lubna Ali Jaisha', 'B.Zakir', 'B.Farah', 'FEMALE', '2017-11-09', '2021-06-25', 9844989894, 1, 1, 0, 0, 9844989894, '9844989894', 'Opp: Kammavari Bhavan, Azad Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Opp: Kammavari Bhavan, Azad Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(38, 'AKSLKG08', 'Kalegar Nafia', 'Kalegar Chand Basha', 'Kalegar Ameena', 'FEMALE', '2017-05-24', '2021-06-25', 8792124296, 1, 1, 0, 0, 8792124296, '8792124296', '17th Ward, Behind Noorani Masjid, Chuluvadkeri, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '17th Ward, Behind Noorani Masjid, Chuluvadkeri, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(39, 'AKSLKG09', 'H.Varun', 'H. Virupaksha', 'Sudha', 'MALE', '2017-01-15', '2021-06-25', 9480400420, 1, 1, 0, 0, 9480400420, '9480400420', '3rd Ward, Near Virupaksheshwara Temple, Hampi', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '3rd Ward, Near Virupaksheshwara Temple, Hampi', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(40, 'AKSLKG10', 'M Rakshith', 'Manju Naik S', 'Mala T', 'MALE', '2017-06-05', '2021-06-30', 9880420294, 1, 1, 0, 0, 8494946815, '8494946815', 'No.39/7, 13th Ward, Canal Road, Old PLC, T B Dam, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.39/7, 13th Ward, Canal Road, Old PLC, T B Dam, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(41, 'AKSLKG11', 'Yashika.K', 'K.Dhanaraj', 'K.Lakshmi', 'FEMALE', '2017-03-20', '2021-06-30', 6362596887, 1, 1, 0, 0, 6362596887, '6362596887', 'H.No.780-B,1st Cross, 2nd Ward, Patel Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.780-B,1st Cross, 2nd Ward, Patel Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(42, 'AKSLKG12', 'K Mohammed Faraan', 'K.Mohammed Imran', 'Sayad Nasrin Fatima', 'MALE', '2017-10-26', '2021-06-30', 9449815966, 1, 1, 0, 0, 9449815966, '9449815966', 'NAS Building, 12th Ward, Near Jhanda Katte, Banagar Street, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'NAS Building, 12th Ward, Near Jhanda Katte, Banagar Street, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(43, 'AKSLKG13', 'J.Aryan', 'J.somashekar', 'J.Padmavathi', 'MALE', '2016-01-19', '2021-07-02', 9513071231, 1, 1, 0, 0, 9513071231, '9513071231', '31st Ward, BTR Nagar, Behind RTO Office, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '31st Ward, BTR Nagar, Behind RTO Office, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(44, 'AKSLKG14', 'Nihal.G', 'Girisha.G', 'Aruna.I.G', 'MALE', '2017-09-01', '2021-07-03', 9379091371, 1, 1, 0, 0, 8867462745, '8867462745', 'Main Road, Morigeri', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Main Road, Morigeri', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(45, 'AKSLKG15', 'Samruddhi Mahesh Kanavi', 'Mahesh S Kanavi', 'Madhavi M Kanavi', 'FEMALE', '2017-07-05', '2021-07-03', 8095988899, 1, 1, 0, 0, 8095988899, '8095988899', '1st Ward, Near 2nd Teru, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Near 2nd Teru, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(46, 'AKSLKG16', 'K Abdul Waaris', 'K.Abdul Rauf', 'K.Safiya', 'MALE', '2017-12-20', '2021-07-04', 8971435802, 1, 1, 0, 0, 8971435802, '891435802', '17th Ward, S.R.Nagar, Behind Noorani Masjid, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '17th Ward, S.R.Nagar, Behind Noorani Masjid, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(47, 'AKSLKG17', 'Mohammmed Afizan Darvesh', 'Md.Akbar Basha', 'Shabana Anjum', 'MALE', '2017-03-19', '2021-07-05', 9480082670, 1, 1, 0, 0, 9480082670, '9480082670', 'H.No.823/1, 2nd Ward,10th Ward, SL Chowki, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.823/1, 2nd Ward,10th Ward, SL Chowki, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(48, 'AKSLKG18', 'Mohammed Zuber', 'M Moulasab', 'Haseena Begum', 'MALE', '2017-11-19', '2021-07-05', 9739866647, 1, 1, 0, 0, 9739866647, '9739866647', '1st Ward, Rehamat Nagar, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Rehamat Nagar, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(49, 'AKSLKG19', 'H.Mohammed Jiyan', 'Hussain', 'Reshma', 'MALE', '2017-08-22', '2021-07-05', 789247911, 1, 1, 0, 0, 9008860061, '9008860061', '1st Ward, Koravara Oni, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Koravara Oni, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(50, 'AKSLKG20', 'P.Purshothama', 'P.Ramali', 'P.Nagaratna', 'MALE', '2017-11-14', '2021-07-05', 8431320212, 1, 1, 0, 0, 8431320212, '8431320212', '1st Ward, Kurubara Oni, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Kurubara Oni, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(51, 'AKSLKG21', 'Khureshi Mohammad Faaiz', 'Mohammed Jeelan', 'Shabana Banu', 'MALE', '2017-09-19', '2021-07-15', 7795069784, 1, 1, 0, 0, 7795069784, '7795069784', '19th Ward, Ramalinga Temple, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '19th Ward, Ramalinga Temple, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(52, 'AKSLKG22', 'Harshil.H.M.', 'Daruka Swamy.THM', 'Kusuma.G', 'MALE', '2017-12-06', '2021-07-15', 9482772338, 1, 1, 0, 0, 9448988883, '9448988883', 'Sri Marulasiddeshwara, Opp: Subbareddy Compound, Amaravathi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Sri Marulasiddeshwara, Opp: Subbareddy Compound, Amaravathi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(53, 'AKSUKG01', 'Swathi S Rathod', 'Seetu Naik', 'Sunitha Bai', 'FEMALE', '2015-12-17', '2021-06-14', 9740746886, 2, 2, 0, 0, 9740746886, '9740746886', 'D.No.188,Kallahalli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.188,Kallahalli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(54, 'AKSUKG02', 'Azma Maheera', 'Basheer Ahmed', 'Shaheen Sultana', 'FEMALE', '2016-04-23', '2021-06-25', 9449235226, 2, 2, 0, 0, 7406359780, '7406359780', 'D.No.1796, Syed Manzil, 22nd Ward, Aravind Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.1796, Syed Manzil, 22nd Ward, Aravind Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(55, 'AKSUKG03', 'Akshay.K.V', 'Basavaraj .K.V', 'Kavitha.M', 'MALE', '2016-07-18', '2021-06-25', 7406224977, 2, 2, 0, 0, 7406224977, '7406224977', '15th Ward, Behind Geetha Ladies Tailor, Amaravathi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '15th Ward, Behind Geetha Ladies Tailor, Amaravathi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(56, 'AKSUKG04', 'G.Meghashree', 'G.Siddeshwar', 'Ashwini.K.T.', 'FEMALE', '2016-10-15', '2021-06-25', 7259906977, 2, 2, 0, 0, 7259906977, '7259906977', '3rd Ward, Near PLD Bank, Patel Nagar Main Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '3rd Ward, Near PLD Bank, Patel Nagar Main Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(57, 'AKSUKG05', 'Zaina Kaineeth', 'T.A.Saleem', 'Nazia Khanum', 'FEMALE', '2017-01-05', '2021-06-25', 8147460980, 2, 2, 0, 0, 8147460980, '8147460980', 'H.No.39, Honnurvali Building, Mehaboob Nagar, Jambunath Roa, Near Noorani Masjid, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.39, Honnurvali Building, Mehaboob Nagar, Jambunath Roa, Near Noorani Masjid, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(58, 'AKSUKG06', 'Hooriya Fathima', 'K.Mohammed Imran', 'Sayad Nasrin Fatima', 'FEMALE', '2016-05-04', '2021-06-25', 9449815966, 2, 2, 0, 0, 9449815966, '9449815966', '6/6/761, Ward No.6, Hatagarpet, Koppal', 2, 1, '2021-22', 'No', 1, 'Muslim', 6, 'A Positive', 'Urdu', 605202107666, NULL, 'Koppal', 'Koppal', '0', '0', 'Business', 'House Wife', 0, 0, '0', 'Indian', '0', '0', '6/6/761, Ward No.6, Hatagarpet, Koppal', '0', 0, 0, 0, '0', '0', 'No', '0', 0, ''),
(59, 'AKSUKG07', 'A.S.Koushik', 'Sathyanarayana', 'Vanajakshi', 'MALE', '2016-10-20', '2021-06-25', 7899021760, 2, 2, 0, 0, 7899021760, '7899021760', '1st Ward, Paranakvti House, Chittawadgi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Paranakvti House, Chittawadgi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(60, 'AKSUKG08', 'Afrah Naaz .M.S', 'Mabu Basha.M.S.', 'Farzana Begum.M.S.', 'FEMALE', '2016-08-08', '2021-06-25', 9900786784, 2, 2, 0, 0, 9900786784, '9900786784', 'H.No.263, NEar Water Tank, Garaga, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.263, NEar Water Tank, Garaga, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(61, 'AKSUKG09', 'P.Maseefa', 'P.Mohammed Aslam', 'P.Afreen', 'FEMALE', '2016-10-25', '2021-07-02', 9353638993, 2, 2, 0, 0, 9353638993, '935363899', '12th Ward, Banagar Oni, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Banagar Oni, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(62, 'AKSUKG10', 'Deepa Pattar', 'Prakash ', 'Nandini', 'FEMALE', '2016-07-03', '2021-07-02', 8880667754, 2, 2, 0, 0, 8880667754, '8880667754', 'Sri Veerabhadreshwara Nilaya, 29th Ward, BDCC Bank Colony, MJ Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Sri Veerabhadreshwara Nilaya, 29th Ward, BDCC Bank Colony, MJ Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(63, 'AKSUKG11', 'Kalgudi Ishaan', 'Kalgudi Sharanabasappa', 'Kalgudi Rashmi', 'MALE', '2016-09-26', '2021-07-05', 8095979011, 2, 2, 0, 0, 9008598500, '9008598500', '59/70, 15th Ward, Main Road, Kampli', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '59/70, 15th Ward, Main Road, Kampli', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(64, 'AKSUKG12', 'M.Daiwik', 'M.Srinivasulu', 'M.Akshata', 'MALE', '2016-05-25', '2021-07-05', 8880033995, 2, 2, 0, 0, 9449009330, '9449009330', '6th Ward, H.No.935/14/G, Kotal Road, Opp: Hero Honda Showroom, Muddapura No.10, Kampli', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '6th Ward, H.No.935/14/G, Kotal Road, Opp: Hero Honda Showroom, Muddapura No.10, Kampli', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(65, 'AKSUKG13', 'Ritika Thippeswamy', 'Thippeswamy.B.R.', 'Shilpa.K', 'FEMALE', '2016-09-06', '2021-07-05', 7259782757, 2, 2, 0, 0, 7259782757, '7259782757', '35th Ward, Annapurna Nivasa, Near Akashavani, Eshwar Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '35th Ward, Annapurna Nivasa, Near Akashavani, Eshwar Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(66, 'AKSUKG14', 'Madhur Kumar', 'Mahendra Kumar.K', 'Roopa Mahendra Kumar', 'MALE', '2016-10-26', '2021-07-05', 7019030336, 2, 2, 0, 0, 7019030336, '7019030336', '4th A Cross, Seethappa Layout, Manorayanapalya, Bengaluru', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '4th A Cross, Seethappa Layout, Manorayanapalya, Bengaluru', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(67, 'AKSUKG15', 'S.Anushka', 'S.Ravikumar', 'S.Prashanthi', 'FEMALE', '2016-04-04', '2021-07-05', 9449654178, 2, 2, 0, 0, 9035314238, '9035314238', 'H.No.628, 12th Ward, Sairam Badvane, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.628, 12th Ward, Sairam Badvane, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(68, 'AKSUKG16', 'S.Aadhya', 'S.Raghavendra Shetty', 'Rakshitha', 'FEMALE', '2016-06-22', '2021-07-05', 9741902259, 2, 2, 0, 0, 9035314300, '9035314300', '7th Cross, Near HUDA Park, 29th Ward, MJ Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '7th Cross, Near HUDA Park, 29th Ward, MJ Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(69, 'AKSUKG17', 'Gautham.J', 'Jeevan.K.', 'Pallavi.S.R.', 'MALE', '2016-04-04', '2021-07-05', 9980381087, 2, 2, 0, 0, 9980381087, '9980381087', '3rd Cross, 3rd Ward, Patel Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '3rd Cross, 3rd Ward, Patel Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(70, 'AKSUKG18', 'Arshiya', 'Ayub Basha', 'Asma ', 'FEMALE', '2016-03-18', '2021-07-05', 6360339889, 2, 2, 0, 0, 6360339889, '6360339889', 'H.No.636, 18th Ward, Durga Area, SR Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.636, 18th Ward, Durga Area, SR Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(71, 'AKSUKG19', 'Avirup Kakubal', 'Dheeraj Kakubal', 'Meenakshi Deeraj', 'MALE', '2016-06-08', '2021-07-08', 7760088338, 2, 2, 0, 0, 7760088338, '7760088338', 'Maruthi Nivasa, Vijaya Talkies Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Maruthi Nivasa, Vijaya Talkies Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(72, 'AKSUKG20', 'Fariha Naaz', 'Nazar', 'Asma Banu', 'FEMALE', '2016-04-28', '2021-07-10', 7760354979, 2, 2, 0, 0, 7760354979, '7760354979', '1st Cross, R.K.Hegde Nagar, Bangalore North,Dr.Shivaramkaranth Nagar, Bengaluru', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Cross, R.K.Hegde Nagar, Bangalore North,Dr.Shivaramkaranth Nagar, Bengaluru', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(73, 'AKSUKG21', 'S.Mohammed Afroz', 'Shabbir.B', 'Heena', 'MALE', '2016-04-15', '2021-07-30', 9481157748, 2, 2, 0, 0, 9481157748, '9481157748', 'Maliyamma Street, Subbarayana Halli, Deogiri, Bellary', 2, 1, '2020-21', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Maliyamma Street, Subbarayana Halli, Deogiri, Bellary', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(74, 'AKSUKG22', 'Bhagath.S.H', 'Sandeep Kumar', 'Chaithra', 'MALE', '2016-12-11', '2021-07-31', 9741456843, 2, 2, 0, 0, 8618911794, '8918911794', 'H.No.F 1842/ 1st Ward, Near Banashankari Temple, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.F 1842/ 1st Ward, Near Banashankari Temple, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(75, 'AKSUKG23', 'Aadhya Patil', 'Prakash Patil', 'Channabasamma', 'FEMALE', '2016-05-07', '2021-08-02', 7259428928, 2, 2, 0, 0, 7760395747, '7760395747', '415, Gurubasava, Basaweshwara Badavane, 1st Cross, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '415, Gurubasava, Basaweshwara Badavane, 1st Cross, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(76, 'AKSUKG24', 'Sreevathshaya.J.P', 'Jagadeesha.P', 'Shilpa.L', 'MALE', '2016-04-26', '2021-08-04', 8095883588, 2, 2, 0, 0, 8095883588, '8095883588', 'D.No.660, 1st Floor,Srinivash House, MSPL Blood Bank Road, Jain Colony, 31st Ward, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.660, 1st Floor,Srinivash House, MSPL Blood Bank Road, Jain Colony, 31st Ward, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(77, 'AKSLKG23', 'Saatvik Gangoor', 'G.Srikrishna', 'G.Manasi', 'MALE', '2016-12-22', '2021-08-04', 8105415315, 1, 1, 0, 0, 9742513636, '9742513636', '12th Ward, Sri Sai Ram Badavane, chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Sri Sai Ram Badavane, chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '1', 0, ''),
(78, 'AKSIKG25', 'Arooba Fatima', 'Roshan Zamir Shaikh', 'Anjum Banu', 'FEMALE', '2016-12-26', '2021-08-04', 9448077860, 2, 2, 0, 0, 9380929592, '9380929592', '24th Ward, Behind Meeralam Nawaz Dargha, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '24th Ward, Behind Meeralam Nawaz Dargha, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(79, 'AKSPUCOM01', 'S R Manasa', 'RSM Ramu', 'T N Shilpa', 'FEMALE', '2002-01-01', '2021-06-25', 9480256249, 10, 10, 25000, 0, 9480256249, '9480256249', '35th Ward, Behind DYSP Bunglow, 3rd Cross End, Parvathi Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '35th Ward, Behind DYSP Bunglow, 3rd Cross End, Parvathi Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(80, 'AKSPUCOM02', 'Sana Erum', 'S.Jeelan Basha', 'Rizwana Begum', 'FEMALE', '2006-03-17', '2021-07-12', 9972467804, 10, 10, 25000, 0, 8073719927, '8073719927', 'D.No.1240, Opp: TSP Limited, Indira Nagar, T B Dam, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.1240, Opp: TSP Limited, Indira Nagar, T B Dam, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(81, 'AKSPUCOM03', 'Ankitha.K', 'Krishna.S', 'Shila', 'FEMALE', '2005-08-23', '2021-07-14', 9880419661, 10, 10, 25000, 0, 9880419661, '7411347456', '17th Ward, 2nd Cross, SR Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '17th Ward, 2nd Cross, SR Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(82, 'AKSPUCOM04', 'Nikshitha.H', 'H.T.Shankar', 'H.Arathi', 'FEMALE', '2005-10-31', '2021-07-24', 9480726135, 10, 10, 25000, 0, 9620114934, '9620114934', 'No.402, 19th Ward, Near Maddigudi, Cowlpet, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.402, 19th Ward, Near Maddigudi, Cowlpet, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(83, 'AKSPUCOM05', 'H.M.Anusha', 'H.Manjunath', 'H.M.Meenakshi', 'FEMALE', '2005-03-20', '2021-07-26', 8310795203, 10, 10, 25000, 0, 8431600851, '8431600851', 'Main Bazaar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Main Bazaar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(84, 'AKSPUCOM06', 'S.Aminul Sanfila Parveen', 'S.Sayed Ali', 'S.Ali Gulshan', 'FEMALE', '2005-05-09', '2021-07-27', 9482049111, 10, 10, 25000, 0, 948071586, '9483071586', 'Hameediya Store, 5th Ward, Ranipet, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hameediya Store, 5th Ward, Ranipet, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(85, 'AKSPUCOM07', 'S.Saniya Miharaj', 'K.Mohammed Ali', 'M.Jereenul Hameeda ', 'FEMALE', '2005-09-01', '2021-07-27', 8904198489, 10, 10, 25000, 0, 9880588299, '9880588299', 'Indra Nagar, TSP,T.B.Dam, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Indra Nagar, TSP,T.B.Dam, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(86, 'AKSPUCOM08', 'P Saniya Zoha', 'P.Sha Sha Vali', 'P.Shamina Banu', 'FEMALE', '2005-12-09', '2021-07-27', 9845237332, 10, 10, 25000, 0, 8123347547, '8123347547', 'Kanchagarpet, Bellary Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Kanchagarpet, Bellary Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(87, 'AKSPUCOM09', 'Deepika Jain', 'Rakesh Kumar', 'Laxmi Devi', 'FEMALE', '2005-11-23', '2021-07-29', 9742748248, 10, 10, 25000, 0, 8867469959, '8867469959', 'No.3, Navkar Nagar, 10th Ward, Hampi Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.3, Navkar Nagar, 10th Ward, Hampi Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(88, 'AKSPUCOM10', 'A.M.Kavana', 'M.Mariyappa', 'Rekha', 'FEMALE', '2006-04-16', '2021-07-30', 9741066939, 10, 10, 25000, 0, 7760913313, '7760913313', '3rd Cross, 17th Ward, S.R.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '3rd Cross, 17th Ward, S.R.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(89, 'AKSPUCOM11', 'M.Nethravathi', 'Maruthi', 'Shantamma', 'FEMALE', '2005-06-07', '2021-08-02', 9663579638, 10, 10, 25000, 0, 8197111969, '8197111969', '12th Cross, M J Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Cross, M J Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(90, 'AKSPUSCI001', 'Fareed Sohail Pasha', 'Pasha', 'Mubina Begum', 'MALE', '2003-11-29', '2021-06-14', 7899169239, 9, 9, 45000, 0, 7899197309, '7899197309', 'Near CSI Church, TB Dam, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Near CSI Church, TB Dam, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(91, 'AKSPUSCI002', 'Srikar.K', 'Gopal Krishna', 'Sridevi', 'MALE', '2005-09-04', '2021-06-22', 9632903212, 9, 9, 45000, 0, 9481445103, '9481445103', 'No.103, Opp National School, Patel Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.103, Opp National School, Patel Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(92, 'AKSPUSCI003', 'C.Veneshwar Reddy', 'C.Mallikarjuna Reddy', 'A.S.Nava Neela', 'MALE', '2005-10-06', '2021-06-23', 9535613801, 9, 9, 45000, 0, 9481544985, '9481544985', 'Jambunatha Halli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Jambunatha Halli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(93, 'AKSPUSCI04', 'S.Deepika', 'R.Simon Christopher', 'Shashi Rekha', 'FEMALE', '2005-05-31', '2021-06-25', 9844876652, 9, 9, 45000, 0, 631205068, '6361205068', 'No.63, 16th Wrd, ISR Road, Indira Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.63, 16th Wrd, ISR Road, Indira Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(94, 'AKSPUSCI05', 'Umme Ruhi', 'Maqsood Khan', 'Gouhar Jahan', 'FEMALE', '2006-03-07', '2021-06-25', 7676071030, 9, 9, 45000, 0, 9880279675, '9880279675', '7th Cross, Ajneneya Temple Line, M J Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '7th Cross, Ajneneya Temple Line, M J Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(95, 'AKSPUSCI06', 'Bharat Kumar Choudary', 'Joita Ram Choudary', 'Champa Devi', 'MALE', '2004-09-22', '2021-07-02', 9480493812, 9, 9, 45000, 0, 900575962, '9008575962', 'Renuka Nilaya Apartment, 16th Ward, Basaveshwara Badavane, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Renuka Nilaya Apartment, 16th Ward, Basaveshwara Badavane, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(96, 'AKSPUSCI07', 'Mutturaj N Pujar', 'Late. Nagaraj F Pujar', 'Padmashree N Pujar', 'MALE', '2004-12-11', '2021-07-05', 8722324240, 9, 9, 45000, 0, 8722324240, '8722324240', 'Indira Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Indira Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(97, 'AKSPUSCI08', 'Preethi.K', 'Siddappa.K', 'Annapurna.K', 'FEMALE', '2005-10-30', '2021-07-05', 8123777789, 9, 9, 45000, 0, 6360733242, '6360733242', 'Vijayanagar Colony, Bellay Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Vijayanagar Colony, Bellay Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(98, 'AKSPUSCI09', 'Kasab Barika', 'K.Shakeel Ahamed', 'K.Shamshad Begum', 'MALE', '2004-08-25', '2021-07-04', 9741657069, 9, 9, 45000, 0, 9743687869, '9743687869', 'H.No.34, Yamuna Block, IRB Police Huts, Munirabad, Koppal Dist', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.34, Yamuna Block, IRB Police Huts, Munirabad, Koppal Dist', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(99, 'AKSPUSCI10', 'Shivani', 'Rajesh Singh', 'Rekha', 'FEMALE', '2005-11-09', '2021-07-08', 9449545250, 9, 9, 45000, 0, 9483865069, '9485865069', 'Near Vivekananda School, Ranipet, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Near Vivekananda School, Ranipet, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(100, 'AKSPUSCI11', 'C.Ghousiya Begum', 'Chand Basha', 'Shekan Bi', 'FEMALE', '2005-05-13', '2021-06-29', 9380422296, 9, 9, 45000, 0, 9845910580, '9845910580', '18th Ward, S.R.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '18th Ward, S.R.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(101, 'AKSPUSCI12', 'Burhan M Kittur', 'Mohhedin S Kittr', 'Rashma S Kittur', 'MALE', '2005-10-07', '2021-07-12', 9606676875, 9, 9, 45000, 0, 8762273917, '8762273917', 'D 1300, Indra Nagar, TB Dam, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D 1300, Indra Nagar, TB Dam, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(102, 'AKSPUSCI13', 'Soumya.Y', 'Yankanna', 'Aruna', 'FEMALE', '2005-07-25', '2021-07-14', 8217203021, 9, 9, 45000, 0, 7795456805, '7795456805', 'HC 52, House No.01, F BlockMunirabad, Koppal Dist', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'HC 52, House No.01, F BlockMunirabad, Koppal Dist', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(103, 'AKSPUSCI14', 'Pallavi Ravindra Vaddi', 'Ravindra Murthi Vaddi', 'Anitha Ravindra Vaddi', 'FEMALE', '2005-01-02', '2021-07-23', 9535769908, 9, 9, 45000, 0, 8496086142, '8496086142', 'KNP Nagar Road -, Islampur', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'KNP Nagar Road -, Islampur', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(104, 'AKSPUSCI15', 'Gagandeep Ippettar.R', 'Ramesh Ippattar', 'Yamuna Ippettar.R', 'MALE', '2005-10-22', '2021-07-23', 9740258010, 9, 9, 45000, 0, 9019093676, '9019093676', 'H.No.99, 32nd Ward,Banadakeri, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.99, 32nd Ward,Banadakeri, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(105, 'AKSPUSCI16', 'Tamqeen Siddiqa', 'Jeelan Basha Siddiqe', 'Reshma', 'FEMALE', '2005-09-24', '2021-07-23', 9902046597, 9, 9, 45000, 0, 9902046597, '9902046597', 'Mehaboob Nagar, Jambunath Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Mehaboob Nagar, Jambunath Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(106, 'AKSPUSCI17', 'J Shriraksha', 'J.Sheshagiri Achar', 'R.Shakunthala', 'FEMALE', '2004-11-03', '2021-07-27', 9632547218, 9, 9, 45000, 0, 8105266042, '8105266042', '1st Ward, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(107, 'AKSPUSCI18', 'E.Sharanesha', 'E.Pakkirappa', 'E.Basamma', 'MALE', '2005-01-11', '2021-07-28', 9632549276, 9, 9, 45000, 0, 8073479616, '8073479616', '1st Ward, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(108, 'AKSPUSCI19', 'M.Poornima', 'H.Mohan Kumar', 'H.Bharathi', 'FEMALE', '2005-04-23', '2021-07-24', 8861172582, 9, 9, 45000, 0, 9986126299, '9986126299', '16th Ward, Indira Nagar, College Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '16th Ward, Indira Nagar, College Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(109, 'AKSPUSCI20', 'Syeeda Asiya', 'Syed Khalleq-ur-Rehaman', 'Nasreen', 'FEMALE', '2004-12-01', '2021-07-27', 7259430663, 9, 9, 45000, 0, 6361742054, '6361742054', '18th Ward, Near Noorani Masjid, SR Nagar Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '18th Ward, Near Noorani Masjid, SR Nagar Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(110, 'AKSPUSCI21', 'S.Keerthana', 'S.Kumar', 'S.Annapurna', 'FEMALE', '2004-12-15', '2021-07-28', 9844926846, 9, 9, 45000, 0, 9342962919, '9342962919', 'MP Prakash Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'MP Prakash Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(111, 'AKSPUSCI22', 'T.Venu', 'Venkateswarulu.TJ', 'Lakshmi', 'MALE', '2005-01-11', '2021-07-29', 9663544890, 9, 9, 45000, 0, 895146785, '8951467850', 'Vinayaka Nagar, Sanklapur, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Vinayaka Nagar, Sanklapur, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(112, 'AKSPUSCI23', 'T.Suradhya', 'T.Manjunath', 'E.Shobha', 'MALE', '2005-10-25', '2021-07-29', 8073567627, 9, 9, 45000, 0, 8073593527, '9073593527', '12th Ward, Sai Ram Badavane, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Sai Ram Badavane, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(113, 'AKSPUSCI24', 'Harshavardhan Pattar', 'Virupakshappa Pattar', 'Sudha Pattar', 'MALE', '2004-12-13', '2021-08-02', 9483422666, 9, 9, 45000, 0, 9901076533, '9901076533', 'Near Markandeshwara School, Mahalakshmi Layout, MP Prakash Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Near Markandeshwara School, Mahalakshmi Layout, MP Prakash Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(114, 'AKSPUSCI25', 'J.Vinutha', 'J.Raghavendra', 'J.Veena', 'FEMALE', '2005-06-28', '2021-08-03', 9482795158, 9, 9, 45000, 0, 9980445664, '9980445664', 'Sri Mathru Nilaya, 1st Cross,9th Ward, Shankar Colony, MP Prakash Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Sri Mathru Nilaya, 1st Cross,9th Ward, Shankar Colony, MP Prakash Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(115, 'AKSPUSCI26', 'Ameena', 'Kashim Patel Jamadar', 'Sainaja Jamadar', 'FEMALE', '2005-06-24', '2021-08-04', 9980852219, 9, 9, 45000, 0, 6360331339, '6360331339', 'No.16, Saraswathi Block, IRB Police Quarters, Muniabad, Koppal', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.16, Saraswathi Block, IRB Police Quarters, Muniabad, Koppal', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(116, 'AKSPUSCI27', 'Mohammed Asif.N', 'Hashim Ali Noorbasha', 'Sharfunnisa', 'MALE', '2005-04-26', '2021-08-05', 9449981592, 9, 9, 45000, 0, 9513993302, '9513993302', 'Near Madarsha Darga, S.R.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Near Madarsha Darga, S.R.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(117, 'AKSPUSCI28', 'Tanaaz Jahan', 'Syed Mohammed Khayam', 'Ruqiya Ishrath', 'FEMALE', '2006-02-13', '2021-08-07', 7899666612, 9, 9, 45000, 0, 8904467857, '8904467857', 'Behind Mahaveer Eng Med School, Aravind Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Behind Mahaveer Eng Med School, Aravind Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(118, 'AKSPUSCI29', 'M Naaz Anjum', 'M.Mastan Vali', 'M.Ruksana', 'FEMALE', '2006-01-03', '2021-08-07', 9900695724, 9, 9, 45000, 0, 9900695724, '9900695724', '12th Ward, Khaja Nagar, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Khaja Nagar, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(119, 'AKSPUSCI30', 'Mohammed Yaseen', 'K.Ghouse Peer', 'Kamrunissa', 'MALE', '2005-01-11', '2021-08-09', 9342125172, 9, 9, 45000, 0, 9342125172, '9342125172', '6th Cross, Basaveshwara Badavane, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '6th Cross, Basaveshwara Badavane, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(120, 'AKSPUSCI31', 'H.Shreya Chowdary', 'H.Ravindra', 'H.Radha', 'FEMALE', '2005-08-06', '2021-08-12', 8660131462, 9, 9, 45000, 0, 8147638445, '8147638445', '748/5,22nd Ward, Sai Colony, MP Prakash Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '748/5,22nd Ward, Sai Colony, MP Prakash Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(121, 'AKSPUSCI32', 'H.Ifra Khanum', 'H.Fayaz Khan', 'H.Imrana Begum', 'FEMALE', '2006-01-30', '2021-08-12', 9902999651, 9, 9, 45000, 0, 9902999651, '9902999651', 'Behind SKRTC Bus Depot, Azad Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Behind SKRTC Bus Depot, Azad Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(122, 'AKSPUSCI33', 'Sadiya Afreen', 'Khaja Hussain', 'Arifa Begum', 'FEMALE', '2005-05-11', '2021-08-12', 9902410766, 9, 9, 45000, 0, 9902410766, '9902410766', 'Behind SKRTC Bus Depot, Rajaji Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Behind SKRTC Bus Depot, Rajaji Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, '');
INSERT INTO `students` (`student_id`, `register_no`, `student_name`, `father_name`, `mother_name`, `gender`, `dob`, `admission_date`, `student_contact`, `class_id`, `section_id`, `due`, `month`, `parent_no`, `password`, `stuaddress`, `adm_type_id`, `msg_type_id`, `academic_year`, `admin_rte`, `religion_id`, `caste`, `soc_cat_id`, `blood_grp`, `mother_tongue`, `aadhar_card`, `stu_image`, `birth_place`, `village`, `fqualification`, `mqualification`, `foccupation`, `moccupation`, `fannual_income`, `dependents`, `guardians`, `nationality`, `subcaste`, `other_language`, `present_address`, `previous_school`, `father_aadhar`, `mother_aadhar`, `student_bankacc`, `ifsc_code`, `branch`, `bus_facility`, `stu_status`, `android_status`, `firebase_reg_id`) VALUES
(123, 'AKSPUSCI34', 'Suvaiba Hanzala', 'K.Naushad Ali', 'Hajra', 'FEMALE', '2006-06-27', '2021-08-13', 9880120907, 9, 9, 45000, 0, 9480919390, '9480919390', 'Srinavasa Nilaya, Near Akashavani, Eshwar Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Srinavasa Nilaya, Near Akashavani, Eshwar Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(124, 'AKSPUSCI35', 'Praveene', 'Parashuram', 'Muddamma', 'FEMALE', '2005-01-16', '2021-08-13', 8660490145, 9, 9, 45000, 0, 7899625009, '7899625009', 'Hitnal, Koppal Dist', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hitnal, Koppal Dist', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(126, 'AKSPUSIC36', 'Divyashree.S', 'Umapathi.S', 'Nagarathna.S', 'FEMALE', '2005-05-31', '2021-08-14', 9886281764, 9, 9, 45000, 0, 7976904599, '7676904599', 'Old Malapanagudi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Old Malapanagudi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(127, 'AKS1STSTD14', 'Sanvi', 'Panduranga', 'Ashwini', 'FEMALE', '2015-03-26', '2021-08-02', 8095107741, 3, 3, 21000, 0, 8095107741, '8095107741', 'Hulgi, RS, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Hulgi, RS, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(128, 'AKS1STSTD15', 'A.Sharvani', 'A.Narayana', 'Shilpa', 'FEMALE', '2014-07-28', '2021-08-03', 962142821, 3, 3, 21000, 0, 9632142821, '9632142821', 'Eppiteri Magani, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Eppiteri Magani, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(129, 'AKS1STSTD16', 'D.R.Druva', 'Rudrakumar.D', 'Poornima.D', 'MALE', '2015-08-31', '2015-08-12', 7353100999, 3, 3, 21000, 0, 7353100999, '7353100999', '1st Ward, Near Banashankari Temple, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Near Banashankari Temple, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(130, 'AKS2NDSTD04', 'D.Vidhyashri', 'D.Prashanth Kumar', 'D.Kavya', 'FEMALE', '2014-08-07', '2021-08-12', 7353810999, 5, 5, 21000, 0, 7353810999, '7353810999', '1st Ward, Near Banashankari Temple, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Near Banashankari Temple, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(131, 'AKS3RDSTD05', 'Khasai Hafsa', 'K.Md.Nazar Hussain', 'Asma Banu', 'FEMALE', '2013-06-09', '2021-07-30', 7760354979, 6, 6, 21000, 0, 7760354979, '7760354979', 'No.113, 4th Cross, Jambunath Road, Mehaboob Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.113, 4th Cross, Jambunath Road, Mehaboob Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(132, 'AKSPUSCI37', 'Abhishek.G', 'Veerabhadrappa', 'Gangamma', 'MALE', '2006-03-04', '2021-08-15', 8792401729, 9, 9, 45000, 0, 8904939997, '8904939997', '29th Ward, Behind Markandeshwara Temple, M.J.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '29th Ward, Behind Markandeshwara Temple, M.J.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(133, 'AKSPUSCI38', 'Mahesh Kumar.M.V.', 'Mahanthayya.V', 'Prema.M.V', 'MALE', '2005-06-23', '2021-08-16', 9845513025, 9, 9, 45000, 0, 901805668, '9901805668', '1st Ward, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(134, 'AKSPUSCI39', 'Deepika.V', 'Veeresh.C', 'Dhanalakshmi.P', 'FEMALE', '2005-05-27', '2021-08-16', 9845441513, 9, 9, 45000, 0, 9845166454, '9845166454', '7th Ward, M P Prakash Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '7th Ward, M P Prakash Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(135, 'AKS2NDSTD05', 'Ahana.K', 'Kishore.S', 'Kshama Kishore', 'FEMALE', '2014-05-24', '2021-08-16', 7411388849, 5, 5, 21000, 0, 7204314858, '704314858', 'Banashankari, Opp: Subbareddy Building, Amaravathi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Banashankari, Opp: Subbareddy Building, Amaravathi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(136, 'AKSPUCOM12', 'D.Mizba Tabassum', 'D.M.Abdulla', 'D.Zubeda Begum', 'FEMALE', '2005-01-02', '2021-08-12', 9880921123, 10, 10, 25000, 0, 9742668701, '9742668701', 'No.728, 18th Ward, 11th Cross, Near Ibrahim Milk Agent House, SR Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.728, 18th Ward, 11th Cross, Near Ibrahim Milk Agent House, SR Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(137, 'AKSPUCOM13', 'Afiya Anjum', 'Shabir', 'Reshma', 'FEMALE', '2005-08-27', '2005-08-13', 9945072098, 10, 10, 25000, 0, 9731474544, '9731474544', '1st Ward, Rahamath Nagar, Chittawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Rahamath Nagar, Chittawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(138, 'AKSPUCOM14', 'Varshini V Naragund', 'Vishnuthirth Naragund', 'Vaishnavi Naragund', 'FEMALE', '2005-02-24', '2021-08-13', 9742315664, 10, 10, 25000, 0, 8971348485, '8971348485', '28th Ward, Chapparadahalli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '28th Ward, Chapparadahalli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(139, 'AKSPUCOM15', 'Karam Jahan', 'Mehaboob Basha', 'Farzana Banu', 'FEMALE', '2004-12-14', '2021-08-13', 9606791744, 10, 10, 25000, 0, 6363572642, '6363572642', '12th Cross, Bangar, Near Sardari Masjid, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Cross, Bangar, Near Sardari Masjid, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(140, 'AKSPUCOM16', 'Saniya Saba', 'Late Noor Basha', 'Rameeza Banu', 'FEMALE', '2005-01-11', '2021-08-16', 6362179306, 10, 10, 25000, 0, 6362179306, '6362179306', 'Sardar Mohalla, 26th Ward, Chitkeri, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Sardar Mohalla, 26th Ward, Chitkeri, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(141, 'AKSNUR07', 'Brahmini R Hegade', 'Ravi Kumar.H', 'Kavitha.L', 'MALE', '2017-12-20', '2021-08-11', 9901304983, 4, 4, 0, 0, 6364649264, '6364649264', '15th Ward, Mariyammanahalli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '15th Ward, Mariyammanahalli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(142, 'AKSNUR08', 'Khushi K Nagaraj', 'K.Nagaraj', 'R.Savitha', 'MALE', '2018-06-13', '2021-08-11', 9538883501, 4, 4, 0, 0, 9538883501, '9535596563', 'New Police Quarters, B-Block, No.9, Azad Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'New Police Quarters, B-Block, No.9, Azad Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(143, 'AKSNUR09', 'Athreya.K', 'Pranesh Rao.K', 'Jyothi', 'MALE', '2018-04-19', '2021-08-12', 9743163370, 4, 4, 0, 0, 9743163370, '9743163370', 'H.No.103, 1st Ward, Opp: Nagareshwar Temple, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.103, 1st Ward, Opp: Nagareshwar Temple, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(144, 'AKSNUR10', 'Sudeeksha.P', 'Narendra Podaralla', 'Sreesathya', 'FEMALE', '2018-01-28', '2021-08-12', 8722123752, 4, 4, 0, 0, 9902411137, '9902411137', 'D.No.459, 25th Ward, Eshwar Nagar, 4th Cross, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'D.No.459, 25th Ward, Eshwar Nagar, 4th Cross, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(145, 'AKSNUR11', 'B.Rishith Kumar', 'B.Devraja', 'B.Bharathi', 'MALE', '2018-04-02', '2021-08-12', 9980404741, 4, 4, 0, 0, 9980404741, '9980404741', '34th Ward, Banada Keri,Near Lal Bahadur Shastri School, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '34th Ward, Banada Keri,Near Lal Bahadur Shastri School, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(146, 'AKSNUR12', 'Tanveer.R.D.', 'Riyaz.M.S.', 'Shireen Taj.H', 'MALE', '2018-06-02', '2021-08-24', 9343131212, 4, 4, 0, 0, 9343131212, '9343131212', 'No.175/1, 12th Ward, Pinjar Street, Behing Urdu Primary School, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.175/1, 12th Ward, Pinjar Street, Behing Urdu Primary School, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(147, 'AKSNUR13', 'G.Chakrini', 'Maruthi', 'Shridevi', 'FEMALE', '2018-01-17', '2021-08-26', 9611042521, 4, 4, 0, 0, 9611042521, '9611042521', 'Near Yeritata Temple, Narasapura Magani, Nagenahalli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Near Yeritata Temple, Narasapura Magani, Nagenahalli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(148, 'AKSLKG24', 'A Umme Arfa Naaz', 'A.Dada Khan', 'Reshma', 'FEMALE', '2018-02-26', '2021-08-05', 9742138734, 1, 1, 0, 0, 9900338706, '9900338706', 'Plot No.23, 28th Ward, Near Taha Masjid, Chapparadahalli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Plot No.23, 28th Ward, Near Taha Masjid, Chapparadahalli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(149, 'AKSLKG25', 'Aadhya Joshi', 'Jithendra Joshi', 'Rashmi', 'FEMALE', '2017-03-04', '2021-08-05', 8884631442, 1, 1, 0, 0, 8861980551, '8861980551', '6th Cross, MJ Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '6th Cross, MJ Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(150, 'AKSLKG26', 'Jangam Sathvik Anand', 'K Vinay Kumar', 'M P Surekha', 'MALE', '2016-09-15', '2021-08-15', 9611381138, 1, 1, 0, 0, 9010430717, '9901043077', '5th Cross, Behind Jain Temple, MJ Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '5th Cross, Behind Jain Temple, MJ Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(151, 'AKSLKG27', 'Dhruva Surya.B.S.', 'Satish', 'Rashmi', 'MALE', '2017-05-21', '2021-08-13', 6361448040, 1, 1, 0, 0, 9686349297, '9686349297', 'Bettadalur, Madihalli, Hobali Belure Taluk', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Bettadalur, Madihalli, Hobali Belure Taluk', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(152, 'AKSLKG28', 'Muhammad Mudassir', 'Naseer Hussain.U', 'Fairoz .U', 'MALE', '2016-12-06', '2021-08-13', 8748870361, 1, 1, 0, 0, 8748870361, '8748870361', '12th Ward, Banagar Street, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Banagar Street, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(153, 'AKSLKG29', 'R.Arshiya Fatima', 'Naseer Hussain.U', 'Fairoz.U', 'FEMALE', '2017-02-11', '2021-08-17', 9945164151, 1, 1, 0, 0, 8310836534, '8310836534', 'No.144/C, Rihan Manzil, Near Geetha Seva Ashram,Bellary Road, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.144/C, Rihan Manzil, Near Geetha Seva Ashram,Bellary Road, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(154, 'AKSLKG30', 'Aniket Bhat.A', 'Praveen Kumar.A', 'Chandrika.A', 'MALE', '2017-06-14', '2021-08-16', 9380677801, 1, 1, 0, 0, 9481042489, '9481042489', 'No.1351, Near Banashankari Temple, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.1351, Near Banashankari Temple, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(155, 'AKSLKG31', 'Fasiha Zainab', 'inayath Udegal', 'Shameem Udegal', 'FEMALE', '2016-07-11', '2016-08-15', 9008751789, 2, 2, 0, 0, 9741002786, '9741002789', '12th Ward, Banagar Street, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Banagar Street, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '1', 0, ''),
(156, 'AKSLKG32', 'Zidaan Sha Maniyar', 'Adilsha M Maniyar', 'Neelufer Maniyar', 'MALE', '2017-01-19', '2021-08-20', 8123017709, 1, 1, 0, 0, 8123017709, '8123017709', 'H.No.1/6/559, Salar Jung Road, Near Star Talkies, Paltan Street, Koppal', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.1/6/559, Salar Jung Road, Near Star Talkies, Paltan Street, Koppal', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(157, 'AKSLKG33', 'Atharv ', 'Pravin Kumar Wali', 'Pratima Pravinkumar Wali', 'MALE', '2017-02-12', '2021-08-24', 9916431122, 1, 1, 0, 0, 9916431122, '9916431122', 'Banashankari, Amaravathi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Banashankari, Amaravathi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(158, 'AKSLKG34', 'Munahaaz', 'Raja Bakshi', 'Rizwana.B', 'FEMALE', '2017-08-23', '2021-08-24', 9591497259, 1, 1, 0, 0, 9591372933, '95913272933', '4th Cross, 17th Wad, S.R.Nagar, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '4th Cross, 17th Wad, S.R.Nagar, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(159, 'AKSLKG35', 'Umme Salma', 'Zameer Khan', 'Farhana Begum', 'FEMALE', '2017-09-28', '2021-08-05', 8884931620, 1, 1, 0, 0, 8884931620, '8884931620', '28th Ward, Near Taha Masjid, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '28th Ward, Near Taha Masjid, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(160, 'AKSLKG36', 'Mohammed Noman Chornur', 'Chornur Noushad', 'C. Ruksana', 'MALE', '2018-01-04', '2021-08-23', 8951939801, 1, 1, 0, 0, 8951939801, '8951939801', '24th Ward, Near Dhobi Street, Sirnsinakallu, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '24th Ward, Near Dhobi Street, Sirnsinakallu, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(161, 'AKSLKG37', 'Mohammad Arush', 'Abbas', 'Sana Kousar', 'MALE', '2017-04-24', '2021-08-30', 8088229156, 1, 1, 0, 0, 9591265667, '9591265667', '24th Ward, Agasara Street, Bellary Road, Sirisinakallu, Hopet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '24th Ward, Agasara Street, Bellary Road, Sirisinakallu, Hopet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(162, 'AKSUKG26', 'Raj Mohammed', 'Kasim Ali', 'Raziya', 'MALE', '2016-07-25', '2021-08-05', 6360363823, 2, 2, 0, 0, 6360363823, '6360363823', '1st Ward, Kurubara Oni, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Kurubara Oni, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(163, 'AKSUKG27', 'T.S.Goutam Siddharth', 'Shiva Kumar.T.S.', 'Shilpa Kanahalli', 'MALE', '2016-05-27', '2021-08-05', 9611888941, 2, 2, 0, 0, 9880445582, '9880445582', 'No.660, Srinivasa Nilaya, 31st Ward, Jain colony, Near Reliance Petrol Bunk, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'No.660, Srinivasa Nilaya, 31st Ward, Jain colony, Near Reliance Petrol Bunk, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(164, 'AKSUKG28', 'Vivek Dommi', 'Jayanyh.D', 'Adiga Dodda Tayamma', 'MALE', '2016-04-29', '2021-08-15', 7204004414, 2, 2, 0, 0, 7204004414, '7204004414', '1st Ward, Near Banashankari Temple, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '1st Ward, Near Banashankari Temple, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(165, 'AKSUKG29', 'B.Sai Sharath', 'B.Devaraja', 'B.Bharathi', 'MALE', '2016-03-09', '2021-08-18', 9980404741, 2, 2, 0, 0, 9980404741, '9980404741', '34th Ward, Near Lal Bahadur Shastri School, Banada Keri, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '34th Ward, Near Lal Bahadur Shastri School, Banada Keri, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(166, 'AKSUKG30', 'K Akshara', 'Karanam Sunil Kumar', 'Karanam Deepa', 'FEMALE', '2016-06-04', '2021-08-18', 9182719493, 2, 2, 0, 0, 9182719493, '9182719493', 'Renuka Sadana, 1st Ward, Brahmin Street, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Renuka Sadana, 1st Ward, Brahmin Street, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(167, 'AKSUKG31', 'Atishay Chawan.U.S.', 'K.Suresh Chawan', 'Umadevi.L', 'MALE', '2017-01-07', '2021-08-22', 9535668356, 2, 2, 0, 0, 9535668356, '9535668356', 'H.No.76, Ward No.3, Seetharama Thanda, Bellary', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'H.No.76, Ward No.3, Seetharama Thanda, Bellary', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(168, 'AKSUKG32', 'G.Vikram', 'G Maruthi', 'G Shree Devi', 'MALE', '2016-04-19', '2021-08-26', 9611042521, 2, 2, 0, 0, 9611042521, '96042521', 'Near Yerritata Temple, Narsapura Magani, Nagenahalli, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', 'Near Yerritata Temple, Narsapura Magani, Nagenahalli, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(169, 'AKSUKG33', 'Fasiha Zainab', 'Inayath Udegal', 'Shameem Udegal', 'FEMALE', '2016-07-11', '2021-08-15', 9008751789, 2, 2, 0, 0, 9741002786, '9741002786', '12th Ward, Banagar Stret, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Banagar Stret, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(170, 'AKSNUR14', 'Mohammed Danish', 'Mukthiyar.C', 'Thabasum', 'MALE', '2018-09-25', '2021-08-30', 8147471847, 4, 4, 0, 0, 8147471847, '847471847', '24th Ward, Behind TMAE College, Sirisinakallu, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '24th Ward, Behind TMAE College, Sirisinakallu, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, ''),
(171, 'AKSNUR15', 'Saatvik Gangoor', 'G.Srikrishna', 'G.Manasi', 'MALE', '2016-12-22', '2021-08-04', 8105415315, 4, 4, 0, 0, 9742513636, '9742513636', '12th Ward, Sri Sairam Badavane, Chitawadagi, Hospet', 2, 1, '2021-22', 'No', 1, '', 1, '', '', 0, NULL, '', '', '', '', '', '', 0, 0, '', 'Indian', '', '', '12th Ward, Sri Sairam Badavane, Chitawadagi, Hospet', '', 0, 0, 0, '', '', 'No', '0', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `student_daily_attendance`
--

CREATE TABLE `student_daily_attendance` (
  `student_att_id` int(11) NOT NULL,
  `register_no` varchar(100) DEFAULT NULL,
  `student_id` int(50) DEFAULT NULL,
  `class_id` int(2) DEFAULT NULL,
  `section_id` int(2) DEFAULT NULL,
  `type_of_attend` varchar(11) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_due_fees`
--

CREATE TABLE `student_due_fees` (
  `student_due_fee_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `fee_header_id` varchar(255) NOT NULL,
  `received_amount` varchar(255) NOT NULL,
  `previous_amount` int(100) NOT NULL,
  `transport_amount` int(100) NOT NULL,
  `due_amount` varchar(255) NOT NULL,
  `month` date NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `payment_detail` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `issued_by` varchar(50) NOT NULL,
  `issue_date` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1-Approved, 2-Declined, 3-Paid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_due_fees`
--

INSERT INTO `student_due_fees` (`student_due_fee_id`, `student_id`, `class_id`, `fee_header_id`, `received_amount`, `previous_amount`, `transport_amount`, `due_amount`, `month`, `payment_type_id`, `payment_detail`, `bank_name`, `remarks`, `comment`, `issued_by`, `issue_date`, `date`, `status`) VALUES
(1, 1, 3, '1,2,3', '4000,1000,', 0, 0, '16000', '2021-10-01', 1, '', '', '', '', 'admin', '2021-08-25T16:35:15', '2021-08-25', 0),
(2, 14, 5, '1,2,3', '4000,1000,', 0, 0, '16000', '2021-10-01', 1, '', '', '', '', 'admin', '2021-08-25T16:35:55', '2021-08-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_leave`
--

CREATE TABLE `student_leave` (
  `stu_leave_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `submission_date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `leave_id` int(11) NOT NULL,
  `total_days` int(11) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `note` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - nothing, 1 - approve, 2 - disapprove'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_notifications`
--

CREATE TABLE `student_notifications` (
  `st_notification_id` int(50) NOT NULL,
  `category` int(2) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(10) DEFAULT NULL,
  `section_id` int(10) DEFAULT NULL,
  `subject` int(11) DEFAULT NULL,
  `selected_no` bigint(20) NOT NULL,
  `message` text CHARACTER SET utf8mb4 NOT NULL,
  `photos` varchar(255) NOT NULL,
  `loginuser` varchar(50) NOT NULL,
  `notice_datetime` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_notifications`
--

INSERT INTO `student_notifications` (`st_notification_id`, `category`, `group_id`, `student_id`, `class_id`, `section_id`, `subject`, `selected_no`, `message`, `photos`, `loginuser`, `notice_datetime`, `date`, `status`) VALUES
(1, 3, 0, 1, 3, 3, 0, 9620584244, 'Dear Mr. Alok A Patil,<br>Your Son Vihaan A Patil School Fees of Rs 5000 has been received. The remaining amount 16000 is Pending.<br>From,<br>Akash International Public School', '', 'admin', '2021-08-25T16:35:15', '2021-08-25', 0),
(2, 3, 0, 14, 5, 5, 0, 8880986420, 'Dear Mr. K.Ismail,<br>Your Daughter K.Asra Fathima School Fees of Rs 5000 has been received. The remaining amount 16000 is Pending.<br>From,<br>Akash International Public School', '', 'admin', '2021-08-25T16:35:55', '2021-08-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_restrict`
--

CREATE TABLE `student_restrict` (
  `id` int(50) NOT NULL,
  `total_students` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_restrict`
--

INSERT INTO `student_restrict` (`id`, `total_students`) VALUES
(1, 500);

-- --------------------------------------------------------

--
-- Table structure for table `student_route`
--

CREATE TABLE `student_route` (
  `sturoute_id` int(50) NOT NULL,
  `student_id` int(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `trans_id` int(50) NOT NULL,
  `fee_mode_id` int(11) NOT NULL,
  `price` int(100) NOT NULL,
  `discount` int(100) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_scheduled_notifications`
--

CREATE TABLE `student_scheduled_notifications` (
  `st_notification_id` int(50) NOT NULL,
  `category` int(2) DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(10) DEFAULT NULL,
  `section_id` int(10) DEFAULT NULL,
  `subject` int(11) DEFAULT NULL,
  `selected_no` bigint(20) NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `photos` varchar(255) NOT NULL,
  `loginuser` varchar(50) NOT NULL,
  `notice_datetime` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_wise_fees`
--

CREATE TABLE `student_wise_fees` (
  `student_wise_fee_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `fee_header_id` varchar(255) NOT NULL,
  `fee_mode` varchar(100) NOT NULL,
  `fee_amount` varchar(255) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `discount_amount` int(100) NOT NULL,
  `extra_amount` int(100) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_wise_fees`
--

INSERT INTO `student_wise_fees` (`student_wise_fee_id`, `student_id`, `class_id`, `section_id`, `fee_header_id`, `fee_mode`, `fee_amount`, `due_amount`, `discount_amount`, `extra_amount`, `reason`, `status`) VALUES
(1, 1, 3, 3, '1,2,3', '', '19980,1000,20', 16000, 0, 0, '', 0),
(2, 2, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(3, 3, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(4, 4, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(5, 5, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(6, 6, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(7, 7, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(8, 8, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(9, 9, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(10, 10, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(11, 11, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(12, 12, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(13, 13, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(14, 14, 5, 5, '1,2,3', '', '19980,1000,20', 16000, 0, 0, '', 0),
(15, 15, 5, 5, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(16, 16, 5, 5, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(17, 17, 6, 6, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(18, 18, 6, 6, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(19, 19, 6, 6, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(20, 20, 6, 6, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(21, 21, 7, 7, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(22, 22, 7, 7, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(23, 23, 7, 7, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(24, 24, 8, 8, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(25, 25, 4, 4, '1', '1', '0', 0, 0, 0, '', 1),
(26, 26, 4, 4, '1,2,3,4,5', '', '0,0,0,0,0', 0, 0, 0, '', 0),
(27, 27, 4, 4, '1,2,3,4,5', '', '0,0,0,0,0', 0, 0, 0, '', 0),
(28, 28, 4, 4, '1,2,3,4,5', '', '0,0,0,0,0', 0, 0, 0, '', 0),
(29, 29, 4, 4, '1,2,3,4,5', '', '0,0,0,0,0', 0, 0, 0, '', 0),
(30, 30, 4, 4, '1,2,3,4,5', '', '0,0,0,0,0', 0, 0, 0, '', 0),
(31, 31, 1, 1, '', '', '', 0, 0, 0, '', 0),
(32, 32, 1, 1, '', '', '', 0, 0, 0, '', 0),
(33, 33, 1, 1, '', '', '', 0, 0, 0, '', 0),
(34, 34, 1, 1, '', '', '', 0, 0, 0, '', 0),
(35, 35, 1, 1, '', '', '', 0, 0, 0, '', 0),
(36, 36, 1, 1, '', '', '', 0, 0, 0, '', 0),
(37, 37, 1, 1, '', '', '', 0, 0, 0, '', 0),
(38, 38, 1, 1, '', '', '', 0, 0, 0, '', 0),
(39, 39, 1, 1, '', '', '', 0, 0, 0, '', 0),
(40, 40, 1, 1, '', '', '', 0, 0, 0, '', 0),
(41, 41, 1, 1, '', '', '', 0, 0, 0, '', 0),
(42, 42, 1, 1, '', '', '', 0, 0, 0, '', 0),
(43, 43, 1, 1, '', '', '', 0, 0, 0, '', 0),
(44, 44, 1, 1, '', '', '', 0, 0, 0, '', 0),
(45, 45, 1, 1, '', '', '', 0, 0, 0, '', 0),
(46, 46, 1, 1, '', '', '', 0, 0, 0, '', 0),
(47, 47, 1, 1, '', '', '', 0, 0, 0, '', 0),
(48, 48, 1, 1, '', '', '', 0, 0, 0, '', 0),
(49, 49, 1, 1, '', '', '', 0, 0, 0, '', 0),
(50, 50, 1, 1, '', '', '', 0, 0, 0, '', 0),
(51, 51, 1, 1, '', '', '', 0, 0, 0, '', 0),
(52, 52, 1, 1, '', '', '', 0, 0, 0, '', 0),
(53, 53, 2, 2, '', '', '', 0, 0, 0, '', 0),
(54, 54, 2, 2, '', '', '', 0, 0, 0, '', 0),
(55, 55, 2, 2, '', '', '', 0, 0, 0, '', 0),
(56, 56, 2, 2, '', '', '', 0, 0, 0, '', 0),
(57, 57, 2, 2, '', '', '', 0, 0, 0, '', 0),
(58, 58, 2, 2, '', '', '', 0, 0, 0, '', 0),
(59, 59, 2, 2, '', '', '', 0, 0, 0, '', 0),
(60, 60, 2, 2, '', '', '', 0, 0, 0, '', 0),
(61, 61, 2, 2, '', '', '', 0, 0, 0, '', 0),
(62, 62, 2, 2, '', '', '', 0, 0, 0, '', 0),
(63, 63, 2, 2, '', '', '', 0, 0, 0, '', 0),
(64, 64, 2, 2, '', '', '', 0, 0, 0, '', 0),
(65, 65, 2, 2, '', '', '', 0, 0, 0, '', 0),
(66, 66, 2, 2, '', '', '', 0, 0, 0, '', 0),
(67, 67, 2, 2, '', '', '', 0, 0, 0, '', 0),
(68, 68, 2, 2, '', '', '', 0, 0, 0, '', 0),
(69, 69, 2, 2, '', '', '', 0, 0, 0, '', 0),
(70, 70, 2, 2, '', '', '', 0, 0, 0, '', 0),
(71, 71, 2, 2, '', '', '', 0, 0, 0, '', 0),
(72, 72, 2, 2, '', '', '', 0, 0, 0, '', 0),
(73, 73, 2, 2, '', '', '', 0, 0, 0, '', 0),
(74, 74, 2, 2, '', '', '', 0, 0, 0, '', 0),
(75, 75, 2, 2, '', '', '', 0, 0, 0, '', 0),
(76, 76, 2, 2, '', '', '', 0, 0, 0, '', 0),
(77, 77, 1, 1, '', '', '', 0, 0, 0, '', 0),
(78, 78, 2, 2, '', '', '', 0, 0, 0, '', 0),
(79, 79, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(80, 80, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(81, 81, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(82, 82, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(83, 83, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(84, 84, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(85, 85, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(86, 86, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(87, 87, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(88, 88, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(89, 89, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(90, 90, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(91, 91, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(92, 92, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(93, 93, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(94, 94, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(95, 95, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(96, 96, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(97, 97, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(98, 98, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(99, 99, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(100, 100, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(101, 101, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(102, 102, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(103, 103, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(104, 104, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(105, 105, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(106, 106, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(107, 107, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(108, 108, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(109, 109, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(110, 110, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(111, 111, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(112, 112, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(113, 113, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(114, 114, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(115, 115, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(116, 116, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(117, 117, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(118, 118, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(119, 119, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(120, 120, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(121, 121, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(122, 122, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(123, 123, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(124, 124, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(126, 126, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(127, 127, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(128, 128, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(129, 129, 3, 3, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(130, 130, 5, 5, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(131, 131, 6, 6, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(132, 132, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(133, 133, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(134, 134, 9, 9, '1,2,3,4,5', '', '30000,1000,1000,10000,3000', 45000, 0, 0, '', 0),
(135, 135, 5, 5, '1,2,3', '', '19980,1000,20', 21000, 0, 0, '', 0),
(136, 136, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(137, 137, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(138, 138, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(139, 139, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(140, 140, 10, 10, '1,2,3,4,5', '', '15000,1000,500,5000,3500', 25000, 0, 0, '', 0),
(141, 141, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(142, 142, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(143, 143, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(144, 144, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(145, 145, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(146, 146, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(147, 147, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(148, 148, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(149, 149, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(150, 150, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(151, 151, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(152, 152, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(153, 153, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(154, 154, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(155, 155, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(156, 156, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(157, 157, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(158, 158, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(159, 159, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(160, 160, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(161, 161, 1, 1, '1', '', '0', 0, 0, 0, '', 0),
(162, 162, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(163, 163, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(164, 164, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(165, 165, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(166, 166, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(167, 167, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(168, 168, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(169, 169, 2, 2, '1', '', '0', 0, 0, 0, '', 0),
(170, 170, 4, 4, '1', '', '0', 0, 0, 0, '', 0),
(171, 171, 4, 4, '1', '', '0', 0, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stu_att_type`
--

CREATE TABLE `stu_att_type` (
  `stu_att_id` int(11) NOT NULL,
  `stu_att_name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stu_att_type`
--

INSERT INTO `stu_att_type` (`stu_att_id`, `stu_att_name`) VALUES
(1, 'daily');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(10) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `class_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjectwise_attendance`
--

CREATE TABLE `subjectwise_attendance` (
  `student_att_id` int(11) NOT NULL,
  `register_no` varchar(100) DEFAULT NULL,
  `student_id` int(50) DEFAULT NULL,
  `class_id` int(2) DEFAULT NULL,
  `section_id` int(2) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `type_of_attend` varchar(11) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `sub_menu_id` int(11) NOT NULL,
  `sub_menu_name` varchar(255) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `panel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`sub_menu_id`, `sub_menu_name`, `menu_id`, `panel_id`) VALUES
(1, 'Add Class', 1, 2),
(2, 'Edit Class', 1, 2),
(3, 'Delete Class', 1, 2),
(4, 'Add Section', 2, 2),
(5, 'Add Fee Header', 3, 2),
(6, 'Assign Fee to class', 3, 2),
(7, 'Edit Assign Fee to class', 3, 2),
(8, 'Delete Assign Fee to class', 3, 2),
(9, 'Institute Settings', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(50) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `starttime` varchar(50) NOT NULL,
  `endtime` varchar(50) NOT NULL,
  `class_id` int(50) DEFAULT NULL,
  `section_id` int(50) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `min_marks` int(50) DEFAULT NULL,
  `max_marks` int(50) DEFAULT NULL,
  `room_no` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `time_table`
--

CREATE TABLE `time_table` (
  `tt_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `tperiod` int(11) NOT NULL,
  `tbreak` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `start_period` time NOT NULL,
  `end_period` time NOT NULL,
  `subject_id` varchar(50) NOT NULL,
  `staff_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transports`
--

CREATE TABLE `transports` (
  `trans_id` int(10) NOT NULL,
  `route_name` varchar(255) NOT NULL,
  `price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploadimage`
--

CREATE TABLE `uploadimage` (
  `image_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `upload_sign`
--

CREATE TABLE `upload_sign` (
  `sign_id` int(11) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload_sign`
--

INSERT INTO `upload_sign` (`sign_id`, `designation`, `signature`) VALUES
(1, 'Principle', 'Signature.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `roles`, `phone`, `email`, `pass`, `profile_image`) VALUES
(1, 'superadmin', 'superadmin', 9110890120, 'nimmavasanthdn@gmail.com', 'superadmin', '10.jpg'),
(2, 'admin', 'admin', 9110890120, 'admin@gmail.com', 'admin', '10.jpg'),
(3, 'systemuser', 'systemuser', 9110890120, 'user@gmail.com', 'user1', '10.jpg'),
(4, 'User2', 'systemuser', 9110890120, 'user2@gmail.com', 'User2', ''),
(5, 'ANIL KUMAR DN', 'systemuser', 9535880445, 'anilkumardn933@gmail.com', '', '2.copiyess (2).jpg'),
(6, 'admin1', 'admin', 9110890120, 'ursvassu@gmail.com', '143143', ''),
(7, 'Accountant', 'systemuser', 9916062377, 'admin12@gmail.com', 'admin12', ''),
(8, 'VNCSystemUser', 'systemuser', 9916062377, 'asdsa@gmail.com', '123456', ''),
(9, 'VNCAccount', 'account', 8945612630, 'dsfsdd@gmail.com', '123456', ''),
(10, 'stock1', 'stock', 1234564561, 'stock@gmail.com', 'stock', ''),
(11, 'Library', 'library', 1234561420, 'librarianvnc@gmail.com', 'librarian', '');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_name` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `vehicle_number` varchar(255) NOT NULL,
  `chassis_no` int(100) NOT NULL,
  `purchased_year` varchar(255) NOT NULL,
  `vehicle_status` varchar(255) NOT NULL,
  `about_vehicle` text NOT NULL,
  `prev_exp` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(50) NOT NULL,
  `vendor_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `voice_message`
--

CREATE TABLE `voice_message` (
  `voice_msg_id` int(50) NOT NULL,
  `msgfor` varchar(255) NOT NULL,
  `stu_staff_id` int(11) NOT NULL,
  `class_id` int(10) DEFAULT NULL,
  `section_id` int(10) DEFAULT NULL,
  `selected_no` bigint(20) NOT NULL,
  `message_name` varchar(255) NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `loginuser` varchar(50) NOT NULL,
  `login_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voice_message`
--

INSERT INTO `voice_message` (`voice_msg_id`, `msgfor`, `stu_staff_id`, `class_id`, `section_id`, `selected_no`, `message_name`, `message`, `loginuser`, `login_id`, `date`, `status`) VALUES
(1, 'student', 1, 1, 1, 9871980749, 'Voice msg', 'HNLLEAudioRecording.mp3', 'staff', 1, '2021-03-02 08:32:36', 0),
(2, 'student', 2, 1, 1, 9871980749, 'Voice msg', 'HNLLEAudioRecording.mp3', 'staff', 1, '2021-03-02 08:32:36', 0),
(3, 'student', 3, 1, 1, 9868538503, 'Voice msg', 'HNLLEAudioRecording.mp3', 'staff', 1, '2021-03-02 08:32:36', 0),
(4, 'student', 4, 1, 1, 9868538503, 'Voice msg', 'HNLLEAudioRecording.mp3', 'staff', 1, '2021-03-02 08:32:37', 0),
(5, 'student', 1, 1, 1, 9871980749, 'Staff', 'EPMINAudioRecording.mp3', 'staff', 1, '2021-03-03 02:23:57', 0),
(6, 'student', 2, 1, 1, 9871980749, 'Staff', 'EPMINAudioRecording.mp3', 'staff', 1, '2021-03-03 02:23:57', 0),
(7, 'student', 3, 1, 1, 9868538503, 'Staff', 'EPMINAudioRecording.mp3', 'staff', 1, '2021-03-03 02:23:57', 0),
(8, 'student', 4, 1, 1, 9868538503, 'Staff', 'EPMINAudioRecording.mp3', 'staff', 1, '2021-03-03 02:23:57', 0),
(9, 'staff', 1, NULL, NULL, 9871980749, 'Admin', 'DCLOMAudioRecording.mp3', 'users', 2, '2021-03-03 02:30:05', 0),
(10, 'staff', 2, NULL, NULL, 9015501897, 'Admin', 'DCLOMAudioRecording.mp3', 'users', 2, '2021-03-03 02:30:05', 0),
(11, 'staff', 3, NULL, NULL, 9871980749, 'Admin', 'DCLOMAudioRecording.mp3', 'users', 2, '2021-03-03 02:30:05', 0),
(12, 'staff', 4, NULL, NULL, 9015501897, 'Admin', 'DCLOMAudioRecording.mp3', 'users', 2, '2021-03-03 02:30:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `year_id` int(10) NOT NULL,
  `year_name` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`year_id`, `year_name`) VALUES
(1, 2019),
(2, 2020);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`acd_year_id`);

--
-- Indexes for table `activity_history`
--
ALTER TABLE `activity_history`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`admission_id`);

--
-- Indexes for table `admission_for_grade`
--
ALTER TABLE `admission_for_grade`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `admission_type`
--
ALTER TABLE `admission_type`
  ADD PRIMARY KEY (`adm_type_id`);

--
-- Indexes for table `allocate_budget`
--
ALTER TABLE `allocate_budget`
  ADD PRIMARY KEY (`allocate_budget_id`);

--
-- Indexes for table `allocate_budget_expense`
--
ALTER TABLE `allocate_budget_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_clsteacher`
--
ALTER TABLE `assign_clsteacher`
  ADD PRIMARY KEY (`assign_clst_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `st_id` (`st_id`);

--
-- Indexes for table `assign_custome_group`
--
ALTER TABLE `assign_custome_group`
  ADD PRIMARY KEY (`ass_cus_id`);

--
-- Indexes for table `assign_department`
--
ALTER TABLE `assign_department`
  ADD PRIMARY KEY (`ass_dept_id`);

--
-- Indexes for table `assign_driver_route`
--
ALTER TABLE `assign_driver_route`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `assign_fee_class`
--
ALTER TABLE `assign_fee_class`
  ADD PRIMARY KEY (`assign_fee_id`);

--
-- Indexes for table `assign_subject`
--
ALTER TABLE `assign_subject`
  ADD PRIMARY KEY (`assign_sub_id`),
  ADD KEY `st_id` (`st_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `assign_syllabus_staff`
--
ALTER TABLE `assign_syllabus_staff`
  ADD PRIMARY KEY (`assign_syllabus_id`);

--
-- Indexes for table `attendance_type`
--
ALTER TABLE `attendance_type`
  ADD PRIMARY KEY (`att_type_id`);

--
-- Indexes for table `att_report_month`
--
ALTER TABLE `att_report_month`
  ADD PRIMARY KEY (`month_id`);

--
-- Indexes for table `automatic_messages`
--
ALTER TABLE `automatic_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`bill_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `book_return_type`
--
ALTER TABLE `book_return_type`
  ADD PRIMARY KEY (`book_return_type_id`);

--
-- Indexes for table `book_type`
--
ALTER TABLE `book_type`
  ADD PRIMARY KEY (`book_type_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `budget_header`
--
ALTER TABLE `budget_header`
  ADD PRIMARY KEY (`budget_header_id`);

--
-- Indexes for table `certificate`
--
ALTER TABLE `certificate`
  ADD PRIMARY KEY (`certificate_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `co_scholastic`
--
ALTER TABLE `co_scholastic`
  ADD PRIMARY KEY (`scholastic_id`);

--
-- Indexes for table `custome_group`
--
ALTER TABLE `custome_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `dead_stock`
--
ALTER TABLE `dead_stock`
  ADD PRIMARY KEY (`dead_stock_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expense_type_id` (`expense_type_id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`expense_type_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`fees_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `fee_header`
--
ALTER TABLE `fee_header`
  ADD PRIMARY KEY (`fee_header_id`);

--
-- Indexes for table `fee_mode`
--
ALTER TABLE `fee_mode`
  ADD PRIMARY KEY (`fee_mode_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `idcard`
--
ALTER TABLE `idcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installed_app`
--
ALTER TABLE `installed_app`
  ADD PRIMARY KEY (`inst_app_id`);

--
-- Indexes for table `issue_bookto_faculty`
--
ALTER TABLE `issue_bookto_faculty`
  ADD PRIMARY KEY (`faculty_issue_id`);

--
-- Indexes for table `issue_bookto_students`
--
ALTER TABLE `issue_bookto_students`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `issue_order`
--
ALTER TABLE `issue_order`
  ADD PRIMARY KEY (`issue_ord_id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `library_payment`
--
ALTER TABLE `library_payment`
  ADD PRIMARY KEY (`library_pay_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`mark_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `message_type`
--
ALTER TABLE `message_type`
  ADD PRIMARY KEY (`msg_type_id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`month_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panel`
--
ALTER TABLE `panel`
  ADD PRIMARY KEY (`panel_id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `previous_fees`
--
ALTER TABLE `previous_fees`
  ADD PRIMARY KEY (`prev_fee_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`pur_ord_id`);

--
-- Indexes for table `qualification`
--
ALTER TABLE `qualification`
  ADD PRIMARY KEY (`qualification_id`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`religion_id`);

--
-- Indexes for table `remedy`
--
ALTER TABLE `remedy`
  ADD PRIMARY KEY (`remedy_id`);

--
-- Indexes for table `request_type`
--
ALTER TABLE `request_type`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `return_stock`
--
ALTER TABLE `return_stock`
  ADD PRIMARY KEY (`ret_ord_id`),
  ADD UNIQUE KEY `roid` (`roid`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `sms_setting`
--
ALTER TABLE `sms_setting`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `social_category`
--
ALTER TABLE `social_category`
  ADD PRIMARY KEY (`soc_cat_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`st_id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_idcard`
--
ALTER TABLE `staff_idcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_notifications`
--
ALTER TABLE `staff_notifications`
  ADD PRIMARY KEY (`st_notification_id`);

--
-- Indexes for table `staff_timetable`
--
ALTER TABLE `staff_timetable`
  ADD PRIMARY KEY (`stt_id`);

--
-- Indexes for table `stock_type`
--
ALTER TABLE `stock_type`
  ADD PRIMARY KEY (`stock_type_id`);

--
-- Indexes for table `stock_vendor`
--
ALTER TABLE `stock_vendor`
  ADD PRIMARY KEY (`stock_vendor_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `register_no` (`register_no`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `student_daily_attendance`
--
ALTER TABLE `student_daily_attendance`
  ADD PRIMARY KEY (`student_att_id`);

--
-- Indexes for table `student_due_fees`
--
ALTER TABLE `student_due_fees`
  ADD PRIMARY KEY (`student_due_fee_id`);

--
-- Indexes for table `student_leave`
--
ALTER TABLE `student_leave`
  ADD PRIMARY KEY (`stu_leave_id`);

--
-- Indexes for table `student_notifications`
--
ALTER TABLE `student_notifications`
  ADD PRIMARY KEY (`st_notification_id`);

--
-- Indexes for table `student_restrict`
--
ALTER TABLE `student_restrict`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_route`
--
ALTER TABLE `student_route`
  ADD PRIMARY KEY (`sturoute_id`);

--
-- Indexes for table `student_scheduled_notifications`
--
ALTER TABLE `student_scheduled_notifications`
  ADD PRIMARY KEY (`st_notification_id`);

--
-- Indexes for table `student_wise_fees`
--
ALTER TABLE `student_wise_fees`
  ADD PRIMARY KEY (`student_wise_fee_id`);

--
-- Indexes for table `stu_att_type`
--
ALTER TABLE `stu_att_type`
  ADD PRIMARY KEY (`stu_att_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjectwise_attendance`
--
ALTER TABLE `subjectwise_attendance`
  ADD PRIMARY KEY (`student_att_id`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`sub_menu_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `time_table`
--
ALTER TABLE `time_table`
  ADD PRIMARY KEY (`tt_id`);

--
-- Indexes for table `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `upload_sign`
--
ALTER TABLE `upload_sign`
  ADD PRIMARY KEY (`sign_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `voice_message`
--
ALTER TABLE `voice_message`
  ADD PRIMARY KEY (`voice_msg_id`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `acd_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_history`
--
ALTER TABLE `activity_history`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `admission_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admission_for_grade`
--
ALTER TABLE `admission_for_grade`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admission_type`
--
ALTER TABLE `admission_type`
  MODIFY `adm_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `allocate_budget`
--
ALTER TABLE `allocate_budget`
  MODIFY `allocate_budget_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allocate_budget_expense`
--
ALTER TABLE `allocate_budget_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_clsteacher`
--
ALTER TABLE `assign_clsteacher`
  MODIFY `assign_clst_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_custome_group`
--
ALTER TABLE `assign_custome_group`
  MODIFY `ass_cus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_department`
--
ALTER TABLE `assign_department`
  MODIFY `ass_dept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_driver_route`
--
ALTER TABLE `assign_driver_route`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assign_fee_class`
--
ALTER TABLE `assign_fee_class`
  MODIFY `assign_fee_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `assign_subject`
--
ALTER TABLE `assign_subject`
  MODIFY `assign_sub_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_syllabus_staff`
--
ALTER TABLE `assign_syllabus_staff`
  MODIFY `assign_syllabus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance_type`
--
ALTER TABLE `attendance_type`
  MODIFY `att_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `att_report_month`
--
ALTER TABLE `att_report_month`
  MODIFY `month_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `automatic_messages`
--
ALTER TABLE `automatic_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_return_type`
--
ALTER TABLE `book_return_type`
  MODIFY `book_return_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_type`
--
ALTER TABLE `book_type`
  MODIFY `book_type_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_header`
--
ALTER TABLE `budget_header`
  MODIFY `budget_header_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificate`
--
ALTER TABLE `certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `co_scholastic`
--
ALTER TABLE `co_scholastic`
  MODIFY `scholastic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `custome_group`
--
ALTER TABLE `custome_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `day_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dead_stock`
--
ALTER TABLE `dead_stock`
  MODIFY `dead_stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `expense_type_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `fees_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fee_header`
--
ALTER TABLE `fee_header`
  MODIFY `fee_header_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fee_mode`
--
ALTER TABLE `fee_mode`
  MODIFY `fee_mode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idcard`
--
ALTER TABLE `idcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `installed_app`
--
ALTER TABLE `installed_app`
  MODIFY `inst_app_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_bookto_faculty`
--
ALTER TABLE `issue_bookto_faculty`
  MODIFY `faculty_issue_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_bookto_students`
--
ALTER TABLE `issue_bookto_students`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_order`
--
ALTER TABLE `issue_order`
  MODIFY `issue_ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `library_payment`
--
ALTER TABLE `library_payment`
  MODIFY `library_pay_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message_type`
--
ALTER TABLE `message_type`
  MODIFY `msg_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `month_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `panel`
--
ALTER TABLE `panel`
  MODIFY `panel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `payment_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `previous_fees`
--
ALTER TABLE `previous_fees`
  MODIFY `prev_fee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `publisher_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `pur_ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualification`
--
ALTER TABLE `qualification`
  MODIFY `qualification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `religion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `remedy`
--
ALTER TABLE `remedy`
  MODIFY `remedy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_type`
--
ALTER TABLE `request_type`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_stock`
--
ALTER TABLE `return_stock`
  MODIFY `ret_ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `company_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_setting`
--
ALTER TABLE `sms_setting`
  MODIFY `sms_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_category`
--
ALTER TABLE `social_category`
  MODIFY `soc_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `st_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_idcard`
--
ALTER TABLE `staff_idcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_notifications`
--
ALTER TABLE `staff_notifications`
  MODIFY `st_notification_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_timetable`
--
ALTER TABLE `staff_timetable`
  MODIFY `stt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `stock_type`
--
ALTER TABLE `stock_type`
  MODIFY `stock_type_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_vendor`
--
ALTER TABLE `stock_vendor`
  MODIFY `stock_vendor_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `student_daily_attendance`
--
ALTER TABLE `student_daily_attendance`
  MODIFY `student_att_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_due_fees`
--
ALTER TABLE `student_due_fees`
  MODIFY `student_due_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_leave`
--
ALTER TABLE `student_leave`
  MODIFY `stu_leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_notifications`
--
ALTER TABLE `student_notifications`
  MODIFY `st_notification_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_restrict`
--
ALTER TABLE `student_restrict`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_route`
--
ALTER TABLE `student_route`
  MODIFY `sturoute_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_scheduled_notifications`
--
ALTER TABLE `student_scheduled_notifications`
  MODIFY `st_notification_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_wise_fees`
--
ALTER TABLE `student_wise_fees`
  MODIFY `student_wise_fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `stu_att_type`
--
ALTER TABLE `stu_att_type`
  MODIFY `stu_att_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjectwise_attendance`
--
ALTER TABLE `subjectwise_attendance`
  MODIFY `student_att_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `sub_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_table`
--
ALTER TABLE `time_table`
  MODIFY `tt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transports`
--
ALTER TABLE `transports`
  MODIFY `trans_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload_sign`
--
ALTER TABLE `upload_sign`
  MODIFY `sign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voice_message`
--
ALTER TABLE `voice_message`
  MODIFY `voice_msg_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
  MODIFY `year_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assign_clsteacher`
--
ALTER TABLE `assign_clsteacher`
  ADD CONSTRAINT `assign_clsteacher_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `assign_clsteacher_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `assign_clsteacher_ibfk_3` FOREIGN KEY (`st_id`) REFERENCES `staff` (`st_id`);

--
-- Constraints for table `assign_subject`
--
ALTER TABLE `assign_subject`
  ADD CONSTRAINT `assign_subject_ibfk_1` FOREIGN KEY (`st_id`) REFERENCES `staff` (`st_id`),
  ADD CONSTRAINT `assign_subject_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `assign_subject_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `assign_subject_ibfk_4` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
