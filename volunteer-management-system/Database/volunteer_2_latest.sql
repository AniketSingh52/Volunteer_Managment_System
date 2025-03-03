-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2025 at 02:19 PM
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
-- Database: `volunteer`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE `administration` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('super','eventManager') NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`admin_id`, `name`, `email`, `role`, `password`, `profile_picture`) VALUES
(1, 'Habibi', 'wwwsws', 'super', 'wsws', '../uploads/9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin_manage_event`
--

CREATE TABLE `admin_manage_event` (
  `admin_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` enum('Suspend','unsuspend') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_manage_post`
--

CREATE TABLE `admin_manage_post` (
  `admin_id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` enum('Suspend','unsuspend') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_manage_user`
--

CREATE TABLE `admin_manage_user` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` enum('Suspend','unsuspend') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_manage_user`
--

INSERT INTO `admin_manage_user` (`admin_id`, `user_id`, `date`, `action`) VALUES
(1, 19, '2025-03-02 07:44:50', 'Suspend'),
(1, 19, '2025-03-02 08:40:39', 'unsuspend'),
(1, 19, '2025-03-02 08:41:04', 'Suspend'),
(1, 19, '2025-03-02 08:41:37', 'unsuspend');

-- --------------------------------------------------------

--
-- Table structure for table `causes`
--

CREATE TABLE `causes` (
  `cause_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `causes`
--

INSERT INTO `causes` (`cause_id`, `name`) VALUES
(1, 'Animal Rescue'),
(2, 'Social Awareness'),
(3, 'CleanUp Drives'),
(4, 'Rural Education Campaigns'),
(5, 'Health Camp'),
(6, 'Blood Donation'),
(7, 'Tree Plantation'),
(8, 'Donation Collection');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `text`, `date_time`, `user_id`, `picture_id`) VALUES
(29, 'hello', '2025-03-02 18:48:55', 19, 23),
(30, 'hello kitty', '2025-03-02 18:49:00', 19, 23),
(31, 'hii', '2025-03-02 19:12:13', 17, 15),
(32, 'd', '2025-03-02 19:12:14', 17, 15),
(33, 'd', '2025-03-02 19:12:14', 17, 15),
(34, 'd', '2025-03-02 19:12:15', 17, 15),
(35, 'd', '2025-03-02 19:12:15', 17, 15),
(36, 'gg', '2025-03-02 19:12:18', 17, 15),
(37, 'g', '2025-03-02 19:12:18', 17, 15),
(38, 'g', '2025-03-02 19:12:19', 17, 15),
(39, 'what a day it was', '2025-03-02 19:12:34', 17, 18);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `volunteers_needed` int(11) NOT NULL,
  `maximum_application` int(11) NOT NULL,
  `status` enum('Ongoing','Scheduled','Completed','Cancelled') NOT NULL,
  `organization_id` int(11) NOT NULL,
  `date_of_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `poster` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `description`, `from_date`, `to_date`, `from_time`, `to_time`, `location`, `volunteers_needed`, `maximum_application`, `status`, `organization_id`, `date_of_creation`, `poster`) VALUES
(10, 'Community Garden Clean-up', 'Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?', '2025-02-19', '2025-02-21', '22:26:00', '23:26:00', 'Central Community Garden', 1, 50, 'Ongoing', 17, '2025-03-01 18:30:00', '../uploads/67b60d9ba6d3a5.36197222.png'),
(11, 'Youth Mentorship Program', 'Make a difference in a young person\'s life through our mentorship program. Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?', '2025-02-20', '2025-02-23', '22:30:00', '23:30:00', 'City Youth Center', 15, 50, 'Ongoing', 17, '2025-03-01 18:30:00', '../uploads/67b60e4baebf10.37713674.png'),
(12, 'Food Bank Distribution2', 'Make a difference in a young person\'s life through our mentorship program. Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?', '2025-02-18', '2025-02-28', '13:00:00', '16:00:00', 'Community Food Bank', 20, 50, 'Completed', 17, '2025-02-10 15:11:24', '../uploads/67bb3a9c617da1.24237529.jpg'),
(125, 'Tree Plantation', 'we would be conducting tree plantation drive that would help us clean the reason and increase its visual appeal', '2025-03-09', '2025-03-12', '23:22:00', '23:26:00', 'Kondana Hallway', 15, 50, 'Ongoing', 17, '2025-03-01 18:30:00', '../uploads/67c49b363d0a99.95765106.png'),
(126, 'Road Safety Campaign', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis ab numquam harum repudiandae doloremque in quidem repellat exercitationem expedita amet debitis quas dolorum corrupti vero, magni consequuntur? Similique, incidunt doloribus!', '2025-03-02', '2025-03-21', '14:28:00', '17:30:00', 'Mumbai Highway', 15, 50, 'Scheduled', 17, '2025-03-01 18:30:00', '../uploads/67c49b940948b5.32769018.jpg'),
(127, 'Beach Cleaning Drive', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis ab numquam harum repudiandae doloremque in quidem repellat exercitationem expedita amet debitis quas dolorum corrupti vero, magni consequuntur? Similique, incidunt doloribus!', '2025-03-08', '2025-03-23', '02:29:00', '04:28:00', 'Sanjay Gandhi Beach', 15, 50, 'Completed', 17, '2025-03-01 18:30:00', '../uploads/67c49bff88efc0.28004455.jpg'),
(128, 'Blood Donation', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis ab numquam harum repudiandae doloremque in quidem repellat exercitationem expedita amet debitis quas dolorum corrupti vero, magni consequuntur? Similique, incidunt doloribus!', '2025-03-15', '2025-03-27', '15:27:00', '16:27:00', 'Thane Station', 15, 50, 'Cancelled', 17, '2025-03-01 18:30:00', '../uploads/67c49c4391e463.44968017.jpg'),
(129, 'Animal Rescue at Juhu', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis ab numquam harum repudiandae doloremque in quidem repellat exercitationem expedita amet debitis quas dolorum corrupti vero, magni consequuntur? Similique, incidunt doloribus!', '2025-03-09', '2025-03-22', '15:31:00', '17:31:00', 'Juhu Beach', 15, 50, 'Scheduled', 17, '2025-03-01 18:30:00', '../uploads/67c49d2b7f4380.22159233.jpg'),
(130, 'Awareness CAMPAIGN FOR NO TO TABACOO', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Perspiciatis ab numquam harum repudiandae doloremque in quidem repellat exercitationem expedita amet debitis quas dolorum corrupti vero, magni consequuntur? Similique, incidunt doloribus!', '2025-03-08', '2025-03-09', '13:36:00', '15:36:00', 'mumbai', 12, 50, 'Scheduled', 17, '2025-03-01 18:30:00', '../uploads/67c49e2e204844.49101579.png');

-- --------------------------------------------------------

--
-- Table structure for table `events_application`
--

CREATE TABLE `events_application` (
  `volunteer_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','rejected','accepted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_application`
--

INSERT INTO `events_application` (`volunteer_id`, `event_id`, `date`, `status`) VALUES
(19, 11, '2025-02-27 18:30:00', 'accepted'),
(19, 10, '2025-03-01 18:30:00', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `event_has_causes`
--

CREATE TABLE `event_has_causes` (
  `event_id` int(11) NOT NULL,
  `cause_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_has_causes`
--

INSERT INTO `event_has_causes` (`event_id`, `cause_id`) VALUES
(12, 2),
(12, 7),
(11, 5),
(11, 6),
(10, 1),
(10, 2),
(10, 3),
(126, 2),
(126, 4),
(129, 1),
(129, 2),
(130, 1),
(130, 2),
(130, 3),
(130, 4),
(130, 5),
(130, 6),
(130, 7),
(130, 8),
(125, 2),
(125, 3),
(125, 7),
(127, 2),
(127, 3),
(127, 4),
(128, 2),
(128, 5),
(128, 6);

-- --------------------------------------------------------

--
-- Table structure for table `event_has_notices`
--

CREATE TABLE `event_has_notices` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notice` varchar(255) NOT NULL,
  `notice_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `image_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_req_skill`
--

CREATE TABLE `event_req_skill` (
  `event_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_req_skill`
--

INSERT INTO `event_req_skill` (`event_id`, `skill_id`) VALUES
(12, 1),
(12, 2),
(11, 2),
(10, 1),
(10, 2),
(126, 1),
(126, 2),
(126, 5),
(129, 2),
(129, 3),
(129, 5),
(130, 2),
(130, 3),
(125, 1),
(125, 2),
(125, 5),
(127, 1),
(127, 2),
(127, 4),
(128, 1),
(128, 2),
(128, 3),
(128, 4),
(128, 5);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_rating`
--

CREATE TABLE `feedback_rating` (
  `review_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rating` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_rating`
--

INSERT INTO `feedback_rating` (`review_id`, `description`, `date_time`, `rating`, `volunteer_id`, `event_id`) VALUES
(73, 'hello there', '2025-03-02 18:34:49', 5, 17, 10),
(74, 'this could have been a great event', '2025-03-02 18:35:05', 4, 17, 10),
(75, 'Can\'t Wait TO see the event on role', '2025-03-02 18:35:29', 5, 19, 10);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('sent','read') DEFAULT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `text`, `date_time`, `status`, `from_id`, `to_id`) VALUES
(1, 'dddwdwd', '2025-03-01 14:11:08', 'sent', 17, 18),
(2, 'dddwdwdss', '2025-03-01 14:11:12', 'sent', 17, 18),
(3, 'dddwdwdssssss', '2025-03-01 14:11:14', 'sent', 17, 18),
(4, 'hh', '2025-03-01 14:17:37', 'sent', 17, 18),
(5, 'hh', '2025-03-01 14:17:43', 'sent', 17, 16),
(6, 'hekk', '2025-03-01 14:18:33', 'sent', 17, 18),
(7, 'hekk', '2025-03-01 14:18:39', 'sent', 17, 18),
(8, 'hekk', '2025-03-01 14:18:40', 'sent', 17, 18),
(9, 'heloo', '2025-03-01 14:19:03', 'sent', 17, 19),
(10, 'heloo', '2025-03-01 14:19:05', 'sent', 17, 19),
(11, 'hii', '2025-03-01 14:19:49', 'sent', 17, 19),
(12, 'h', '2025-03-01 14:22:13', 'sent', 17, 18),
(13, 'hekk', '2025-03-01 14:28:12', 'sent', 17, 19),
(14, 'hell', '2025-03-01 14:51:14', 'sent', 17, 18),
(15, 'hello', '2025-03-01 14:51:41', 'sent', 17, 18),
(16, 'ss', '2025-03-01 14:53:12', 'sent', 17, 18),
(17, 'ss', '2025-03-01 14:53:13', 'sent', 17, 18),
(18, 'ssssss', '2025-03-01 14:53:17', 'sent', 17, 18),
(19, 'hell', '2025-03-01 14:54:48', 'sent', 17, 19),
(20, 'hell', '2025-03-01 14:54:54', 'sent', 17, 19),
(21, 'hell556', '2025-03-01 14:54:57', 'sent', 17, 19),
(22, 'hell556tt', '2025-03-01 14:54:59', 'sent', 17, 19),
(23, 'hell556ttff', '2025-03-01 14:55:04', 'sent', 17, 19),
(24, 'hell556ttffcc', '2025-03-01 14:55:06', 'sent', 17, 19),
(25, 'hell556ttffcccc', '2025-03-01 14:55:08', 'sent', 17, 19),
(26, 'hell556ttffccccee', '2025-03-01 14:55:09', 'sent', 17, 19),
(27, 'hell556ttffcccceeee', '2025-03-01 14:55:10', 'sent', 17, 19),
(28, 'hell556ttffcccceeeeee', '2025-03-01 14:55:11', 'sent', 17, 19),
(29, 'hell556ttffcccceeeeeeee', '2025-03-01 14:55:12', 'sent', 17, 19),
(30, 'hell556ttffcccceeeeeeeeee', '2025-03-01 14:55:13', 'sent', 17, 19),
(31, 'helll', '2025-03-01 14:56:24', 'sent', 17, 18),
(32, 'hellle', '2025-03-01 14:56:26', 'sent', 17, 18),
(33, 'helllee', '2025-03-01 14:56:27', 'sent', 17, 18),
(34, 'hellleee', '2025-03-01 14:56:27', 'sent', 17, 18),
(35, 'hellleeedde', '2025-03-01 14:56:29', 'sent', 17, 18),
(36, 'g', '2025-03-01 14:57:22', 'sent', 17, 18),
(37, 'g', '2025-03-01 14:57:29', 'sent', 17, 18),
(38, 'g', '2025-03-01 14:57:32', 'sent', 17, 18),
(39, 'ggg', '2025-03-01 14:57:35', 'sent', 17, 18),
(40, 'gggdeee', '2025-03-01 14:57:41', 'sent', 17, 18),
(41, 'gggdeeeee', '2025-03-01 14:57:42', 'sent', 17, 18),
(42, 'gggdeeeeeee', '2025-03-01 14:57:43', 'sent', 17, 18),
(43, 'gggdeeeeeeeee4', '2025-03-01 14:57:50', 'sent', 17, 18),
(44, 'gggdeeeeeeeee44', '2025-03-01 14:57:52', 'sent', 17, 18),
(45, 'gggdeeeeeeeee444', '2025-03-01 14:57:56', 'sent', 17, 18),
(46, 'gggdeeeeeeeee4444444444', '2025-03-01 14:57:59', 'sent', 17, 18),
(47, 'gggdeeeeeeeee4444444444', '2025-03-01 14:58:00', 'sent', 17, 18),
(48, 'gggdeeeeeeeee444444444489', '2025-03-01 14:58:06', 'sent', 17, 18),
(49, 'gggdeeeeeeeee444444444489990', '2025-03-01 14:58:11', 'sent', 17, 18),
(50, 'gggdeeeeeeeee444444444489990o', '2025-03-01 14:58:15', 'sent', 17, 18),
(51, 'gggdeeeeeeeee444444444489990o9', '2025-03-01 14:58:21', 'sent', 17, 18),
(52, 'xss', '2025-03-01 15:04:21', 'sent', 17, 18),
(53, 'xss', '2025-03-01 15:04:22', 'sent', 17, 18),
(54, 'xss', '2025-03-01 15:04:23', 'sent', 17, 18),
(55, 'xss', '2025-03-01 15:04:23', 'sent', 17, 18),
(56, 'ss', '2025-03-01 15:05:10', 'sent', 17, 18),
(57, 'i', '2025-03-01 15:07:00', 'sent', 17, 18),
(58, 'ip', '2025-03-01 15:07:09', 'sent', 17, 18),
(59, 'ip\'', '2025-03-01 15:07:12', 'sent', 17, 18),
(60, 'ip\'9', '2025-03-01 15:07:34', 'sent', 17, 18),
(61, 'haa meri jan', '2025-03-01 15:10:22', 'sent', 17, 18),
(62, 'haa meri jan77', '2025-03-01 15:10:31', 'sent', 17, 18),
(63, 'haa meri jan77', '2025-03-01 15:10:31', 'sent', 17, 18),
(64, 'haa meri jan7799', '2025-03-01 15:10:42', 'sent', 17, 18),
(65, 'haa meri jan7799', '2025-03-01 15:15:13', 'sent', 17, 18),
(66, 'haa meri jan7799', '2025-03-01 15:15:14', 'sent', 17, 18),
(67, 'dd', '2025-03-01 15:18:14', 'sent', 17, 18),
(68, 'ddd', '2025-03-01 15:18:19', 'sent', 17, 18),
(69, 'ddd66', '2025-03-01 15:18:24', 'sent', 17, 18),
(70, 'hh', '2025-03-01 15:19:28', 'sent', 17, 19),
(71, 'hhf', '2025-03-01 15:19:32', 'sent', 17, 19),
(72, 'hhff', '2025-03-01 15:19:34', 'sent', 17, 19),
(73, 'ko', '2025-03-01 16:47:10', 'sent', 17, 19),
(74, 'ko', '2025-03-01 16:47:11', 'sent', 17, 19),
(75, 'ko', '2025-03-01 16:47:13', 'sent', 17, 19),
(76, 'ko89', '2025-03-01 16:47:17', 'sent', 17, 19),
(77, 'ko8988', '2025-03-01 16:47:21', 'sent', 17, 19),
(78, 'ko898866', '2025-03-01 16:47:27', 'sent', 17, 19),
(79, 'ko898866899', '2025-03-01 16:47:31', 'sent', 17, 19),
(80, 'ko89886689900', '2025-03-01 16:47:34', 'sent', 17, 19),
(81, 'ko89886689900777', '2025-03-01 16:47:38', 'sent', 17, 19),
(82, 'ko89886689900777rrr', '2025-03-01 16:47:40', 'sent', 17, 19),
(83, 'ko89886689900777rrrddde', '2025-03-01 16:47:43', 'sent', 17, 19),
(84, 'hello world meet', '2025-03-01 16:47:58', 'sent', 17, 19),
(85, 'hello', '2025-03-01 17:34:12', 'sent', 17, 19),
(86, 'haa meri jaan', '2025-03-01 17:36:17', 'sent', 17, 19),
(87, 'bol na bhai', '2025-03-01 17:36:25', 'sent', 19, 17),
(88, 'sun na ek kam tha', '2025-03-01 17:36:35', 'sent', 19, 17),
(89, 'kya', '2025-03-01 17:36:38', 'sent', 17, 19),
(90, 'bachi ke dil me dishakyu', '2025-03-01 17:37:30', 'sent', 17, 19),
(91, 'hello', '2025-03-01 17:37:42', 'sent', 19, 16),
(92, 'kaha gyi', '2025-03-01 17:37:50', 'sent', 17, 19),
(93, 'sun toh', '2025-03-01 17:37:55', 'sent', 17, 19),
(94, 'bol bhai bol', '2025-03-01 17:42:14', 'sent', 17, 19),
(95, 'haa mei jan', '2025-03-01 18:29:59', 'sent', 17, 19),
(96, 'jjj', '2025-03-01 18:30:23', 'sent', 19, 17),
(97, 'hello', '2025-03-02 12:23:19', 'sent', 17, 19),
(98, 'ee', '2025-03-02 12:23:25', 'sent', 17, 18),
(99, 'dddd', '2025-03-02 12:23:30', 'sent', 17, 16),
(100, 'nn', '2025-03-02 12:23:32', 'sent', 17, 16);

-- --------------------------------------------------------

--
-- Table structure for table `organization_belongs_type`
--

CREATE TABLE `organization_belongs_type` (
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_belongs_type`
--

INSERT INTO `organization_belongs_type` (`user_id`, `type_id`) VALUES
(18, 1),
(17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `organization_type`
--

CREATE TABLE `organization_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_type`
--

INSERT INTO `organization_type` (`type_id`, `type_name`) VALUES
(1, 'NGO'),
(2, 'Commercial'),
(3, 'Educational'),
(4, 'Charitable');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `picture_id` int(11) NOT NULL,
  `picture_url` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `upload_date` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`picture_id`, `picture_url`, `caption`, `upload_date`, `user_id`, `likes`) VALUES
(11, '../uploads/67c497ac9b4401.09999009.jpg', 'awareness campaigns', '2025-03-02 17:38:52', 19, 0),
(12, '../uploads/67c497c1eadef3.08135150.jpg', 'Tree Plantation and Cleanup', '2025-03-02 17:39:13', 19, 0),
(13, '../uploads/67c497e4e6f586.03386056.jpeg', 'National Service Scheme Awareness campaign', '2025-03-02 17:39:48', 19, 0),
(14, '../uploads/67c49c5c8e9ec6.58911866.jpg', 'Lonavla Trek', '2025-03-02 17:58:52', 17, 5),
(15, '../uploads/67c49c721b1648.69728944.jpg', 'Mountain Campaiging', '2025-03-02 17:59:14', 17, 1),
(18, '../uploads/67c49cbcefeaf6.61775156.jpg', 'Beach Cleanup at goa', '2025-03-02 18:00:28', 17, 16),
(19, '../uploads/67c49cdc9d07f3.76376211.jpg', 'Juhu Brach Cleanup', '2025-03-02 18:01:00', 19, 0),
(20, '../uploads/67c49d40ac0dc9.91634873.png', 'Doggie The King', '2025-03-02 18:02:40', 19, 1),
(21, '../uploads/67c49d57a97a48.09556721.jpg', 'Baby Rhino Caretaking', '2025-03-02 18:03:03', 19, 1),
(22, '../uploads/67c49d712add81.21711442.jpeg', 'A small Dog RESCUE', '2025-03-02 18:03:29', 19, 0),
(23, '../uploads/67c49d8f43ba75.31744580.jpg', 'Kitten taken Care of!!', '2025-03-02 18:03:59', 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`skill_id`, `skill_name`) VALUES
(1, 'Communication'),
(2, 'Management'),
(3, 'First Aid'),
(4, ' Project Management'),
(5, ' Leadership');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` bigint(11) NOT NULL,
  `gender` enum('M','F','O','N') NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `user_type` enum('V','O') NOT NULL,
  `DOB/DOE` date NOT NULL,
  `registration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `contact`, `gender`, `occupation`, `user_name`, `password`, `address`, `profile_picture`, `user_type`, `DOB/DOE`, `registration_date`) VALUES
(16, 'Ajay Singh', 'walfra52@gmail.com22', 7208541711, 'N', 'Driver', 'AjaySingh52', 'dddddddd', ' ssas', '../uploads/9.jpg', 'V', '2023-02-04', '2025-02-05'),
(17, 'Aniket Singh', 'walfra52@gmail.com', 7208541711, 'M', 'student', 'aniket52777', 'Aniket52@', ' Diva E', '../uploads/9.jpg', 'O', '2007-02-01', '2025-02-01'),
(18, 'Sakshi', 'walfra52777@gmail.com', 7208541711, 'N', NULL, 'GodLike', 'Sakshi', 'sakshi13', '../uploads/images.jpg', 'O', '2023-02-03', '2025-02-21'),
(19, 'Aniket', 'walfra5244@gmail.com', 7208541711, 'M', 'business man', 'Aniket52', 'aniket123', ' Diva West, And Building', '../uploads/profile1.jpg', 'V', '2007-02-09', '2025-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `user_workfor_causes`
--

CREATE TABLE `user_workfor_causes` (
  `user_id` int(11) NOT NULL,
  `cause_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_workfor_causes`
--

INSERT INTO `user_workfor_causes` (`user_id`, `cause_id`) VALUES
(17, 1),
(17, 2),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(18, 6),
(18, 7),
(18, 8),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(19, 7),
(19, 8);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_skill`
--

CREATE TABLE `volunteer_skill` (
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_skill`
--

INSERT INTO `volunteer_skill` (`user_id`, `skill_id`) VALUES
(17, 1),
(19, 1),
(19, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_manage_event`
--
ALTER TABLE `admin_manage_event`
  ADD KEY `admin_manage_events_eid` (`event_id`),
  ADD KEY `admin_manage_admin_AID` (`admin_id`);

--
-- Indexes for table `admin_manage_post`
--
ALTER TABLE `admin_manage_post`
  ADD KEY `admin_manage_post_pid` (`picture_id`),
  ADD KEY `admin_manage_post_ad_id` (`admin_id`);

--
-- Indexes for table `admin_manage_user`
--
ALTER TABLE `admin_manage_user`
  ADD KEY `admin_manage_user` (`admin_id`),
  ADD KEY `user_areManged_admin` (`user_id`);

--
-- Indexes for table `causes`
--
ALTER TABLE `causes`
  ADD PRIMARY KEY (`cause_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_on_pic` (`picture_id`),
  ADD KEY `user_post_comment` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `EVENT_ORGANIZATION` (`organization_id`);

--
-- Indexes for table `events_application`
--
ALTER TABLE `events_application`
  ADD KEY `volunteer_apply_events` (`volunteer_id`),
  ADD KEY `event_req_volunteer` (`event_id`);

--
-- Indexes for table `event_has_causes`
--
ALTER TABLE `event_has_causes`
  ADD KEY `event_has_causes_event_id` (`event_id`),
  ADD KEY `event_has_causes_cause_id` (`cause_id`);

--
-- Indexes for table `event_has_notices`
--
ALTER TABLE `event_has_notices`
  ADD PRIMARY KEY (`notice_id`),
  ADD KEY `notice_11` (`event_id`),
  ADD KEY `notice_12` (`user_id`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD KEY `images_of_events` (`image_id`),
  ADD KEY `event_has_images` (`event_id`);

--
-- Indexes for table `event_req_skill`
--
ALTER TABLE `event_req_skill`
  ADD KEY `event_req_skill` (`event_id`),
  ADD KEY `skill_for_event` (`skill_id`);

--
-- Indexes for table `feedback_rating`
--
ALTER TABLE `feedback_rating`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `volunteer_share_feedback` (`volunteer_id`),
  ADD KEY `event_has_feedback` (`event_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_send_msg` (`from_id`),
  ADD KEY `user_receive_msg` (`to_id`);

--
-- Indexes for table `organization_belongs_type`
--
ALTER TABLE `organization_belongs_type`
  ADD KEY `organization_id_type` (`user_id`),
  ADD KEY `type_id_belongs_organization` (`type_id`);

--
-- Indexes for table `organization_type`
--
ALTER TABLE `organization_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`picture_id`),
  ADD KEY `user_post_images` (`user_id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_workfor_causes`
--
ALTER TABLE `user_workfor_causes`
  ADD KEY `user_work_causes` (`user_id`),
  ADD KEY `causes_areFor_users` (`cause_id`);

--
-- Indexes for table `volunteer_skill`
--
ALTER TABLE `volunteer_skill`
  ADD KEY `volunteer_has_skill` (`user_id`),
  ADD KEY `skill_has_volunteer` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administration`
--
ALTER TABLE `administration`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `causes`
--
ALTER TABLE `causes`
  MODIFY `cause_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `event_has_notices`
--
ALTER TABLE `event_has_notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedback_rating`
--
ALTER TABLE `feedback_rating`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_manage_event`
--
ALTER TABLE `admin_manage_event`
  ADD CONSTRAINT `admin_manage_admin_AID` FOREIGN KEY (`admin_id`) REFERENCES `administration` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_manage_events_eid` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_manage_post`
--
ALTER TABLE `admin_manage_post`
  ADD CONSTRAINT `admin_manage_post_ad_id` FOREIGN KEY (`admin_id`) REFERENCES `administration` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_manage_post_pid` FOREIGN KEY (`picture_id`) REFERENCES `pictures` (`picture_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_manage_user`
--
ALTER TABLE `admin_manage_user`
  ADD CONSTRAINT `admin_manage_user` FOREIGN KEY (`admin_id`) REFERENCES `administration` (`admin_id`),
  ADD CONSTRAINT `user_areManged_admin` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_on_pic` FOREIGN KEY (`picture_id`) REFERENCES `pictures` (`picture_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_post_comment` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `EVENT_ORGANIZATION` FOREIGN KEY (`organization_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events_application`
--
ALTER TABLE `events_application`
  ADD CONSTRAINT `event_req_volunteer` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volunteer_apply_events` FOREIGN KEY (`volunteer_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `event_has_causes`
--
ALTER TABLE `event_has_causes`
  ADD CONSTRAINT `event_has_causes_cause_id` FOREIGN KEY (`cause_id`) REFERENCES `causes` (`cause_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_has_causes_event_id` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_has_notices`
--
ALTER TABLE `event_has_notices`
  ADD CONSTRAINT `notice_11` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notice_12` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_has_images` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `images_of_events` FOREIGN KEY (`image_id`) REFERENCES `pictures` (`picture_id`);

--
-- Constraints for table `event_req_skill`
--
ALTER TABLE `event_req_skill`
  ADD CONSTRAINT `event_req_skill` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skill_for_event` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback_rating`
--
ALTER TABLE `feedback_rating`
  ADD CONSTRAINT `event_has_feedback` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volunteer_share_feedback` FOREIGN KEY (`volunteer_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `user_receive_msg` FOREIGN KEY (`to_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_send_msg` FOREIGN KEY (`from_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `organization_belongs_type`
--
ALTER TABLE `organization_belongs_type`
  ADD CONSTRAINT `organization_id_type` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `type_id_belongs_organization` FOREIGN KEY (`type_id`) REFERENCES `organization_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `user_post_images` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user_workfor_causes`
--
ALTER TABLE `user_workfor_causes`
  ADD CONSTRAINT `causes_areFor_users` FOREIGN KEY (`cause_id`) REFERENCES `causes` (`cause_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_work_causes` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `volunteer_skill`
--
ALTER TABLE `volunteer_skill`
  ADD CONSTRAINT `skill_has_volunteer` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`),
  ADD CONSTRAINT `volunteer_has_skill` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
