-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 08:33 PM
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
  `role` enum('super','Manager') NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `date_of_registration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','deactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`admin_id`, `name`, `email`, `role`, `password`, `profile_picture`, `date_of_registration`, `status`) VALUES
(1, 'Aniket Singh', 'walfra52777@gmail.com', 'super', '12345678', '../uploads/67cd87bb8491e6.49393526.jpg', '2025-03-09 16:07:02', 'active'),
(2, 'aniket', 'sachinsingh52777@gmail.com', 'Manager', '9000000000', '../uploads/67cd96843bf9d4.03544273.png', '2025-03-09 14:09:18', 'deactive'),
(3, 'Ajay', 'sachinsingh52777@gmail.com', 'Manager', 'aniket123', '../uploads/67cde765e70a07.81635968.jpg', '2025-03-09 19:09:25', 'active'),
(4, 'Lalita', 'sachinsingh52777@gmail.com', 'super', 'aniket123', '../uploads/67cde7881b4819.92604786.png', '2025-03-09 19:10:00', 'active'),
(5, 'Akshay', 'disgrace_yin697@aleeas.com', 'Manager', 'aniket123', '../uploads/67cde7ab958765.89152809.jpg', '2025-03-09 19:10:35', 'active');

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

--
-- Dumping data for table `admin_manage_post`
--

INSERT INTO `admin_manage_post` (`admin_id`, `picture_id`, `date`, `action`) VALUES
(1, 23, '2025-03-08 22:26:39', 'Suspend'),
(1, 23, '2025-03-08 22:28:34', ''),
(1, 21, '2025-03-08 22:28:42', 'Suspend'),
(1, 21, '2025-03-08 22:28:45', ''),
(1, 20, '2025-03-08 22:38:57', 'Suspend'),
(1, 20, '2025-03-08 22:39:01', ''),
(1, 23, '2025-03-09 08:31:53', 'Suspend'),
(1, 23, '2025-03-09 08:31:57', ''),
(1, 23, '2025-03-09 09:53:07', 'Suspend'),
(1, 22, '2025-03-09 09:58:56', 'Suspend'),
(1, 22, '2025-03-09 09:59:03', ''),
(1, 23, '2025-03-09 09:59:10', '');

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
(1, 17, '2025-03-09 14:08:18', 'Suspend'),
(1, 17, '2025-03-09 14:08:19', 'unsuspend');

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
(39, 'what a day it was', '2025-03-02 19:12:34', 17, 18),
(40, 'Nice Dog!!!', '2025-03-03 21:07:56', 19, 20),
(41, 'Yeah !!!', '2025-03-03 21:08:20', 17, 20),
(42, 'helloooo', '2025-03-08 07:23:17', 17, 22),
(43, 'he', '2025-03-08 07:23:20', 17, 22),
(44, 'ss', '2025-03-08 07:24:06', 17, 22),
(45, 'j', '2025-03-08 07:25:59', 19, 23),
(46, 'tree plantation', '2025-03-09 18:09:21', 25, 26);

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
(131, 'Tree Plantation drive', 'A tree plantation campaign promotes environmental sustainability by planting trees to improve air quality, combat climate change, and enhance biodiversity. It encourages community participation in greening urban and rural areas. The initiative fosters awareness about the importance of trees for a healthier planet.', '2025-03-09', '2025-03-14', '05:00:00', '10:30:00', 'Juhu Beach', 15, 50, 'Ongoing', 25, '2025-02-03 18:30:00', '../uploads/67cdd8055eb911.25762538.jpg'),
(132, 'Helps Save the Future', 'A tree plantation campaign promotes environmental sustainability by planting trees to improve air quality, combat climate change, and enhance biodiversity. It encourages community participation in greening urban and rural areas. The initiative fosters awareness about the importance of trees for a healthier planet.', '2025-03-09', '2025-03-14', '11:34:00', '12:38:00', 'Juhu Beach', 12, 50, 'Ongoing', 25, '2025-01-07 18:30:00', '../uploads/67cdd856b464d4.17229905.png'),
(133, 'Helps The One In Need', 'An animal rescue campaign focuses on saving and rehabilitating injured, abandoned, or mistreated animals. It promotes adoption, medical care, and awareness about animal welfare. The initiative encourages community involvement in protecting and providing shelter for animals in need.', '2025-03-15', '2025-03-18', '02:40:00', '07:41:00', 'Mumbai central', 20, 20, 'Scheduled', 26, '2025-01-01 18:30:00', '../uploads/67cdd9fb946db0.43288031.jpg'),
(134, 'Animal rescue Camp', 'An animal rescue campaign focuses on saving and rehabilitating injured, abandoned, or mistreated animals. It promotes adoption, medical care, and awareness about animal welfare. The initiative encourages community involvement in protecting and providing shelter for animals in need.', '2025-02-04', '2025-04-05', '14:42:00', '16:42:00', 'Thane Station', 13, 50, 'Ongoing', 26, '2025-03-08 18:30:00', '../uploads/67cdda4ddffa36.68431382.jpg'),
(135, 'Animal CARE Camp', 'An animal rescue campaign focuses on saving and rehabilitating injured, abandoned, or mistreated animals. It promotes adoption, medical care, and awareness about animal welfare. The initiative encourages community involvement in protecting and providing shelter for animals in need.', '2025-03-12', '2025-03-14', '00:45:00', '17:50:00', 'Dadar Animal Help Center', 25, 50, 'Cancelled', 26, '2025-03-08 18:30:00', '../uploads/67cddabbd2f452.55615185.png'),
(136, 'Donation Collection Campaign', 'A money collection campaign raises funds for a specific cause, such as charity, disaster relief, or community projects. It encourages donations through various means like crowdfunding, events, or direct contributions. The initiative aims to support those in need and drive positive social impact.', '2025-03-10', '2025-03-11', '13:00:00', '17:00:00', 'Thane Station', 10, 50, 'Scheduled', 17, '2025-03-08 18:30:00', '../uploads/67cddbb8567951.95802191.png'),
(137, 'Rural Education Campaign', 'A rural education campaign aims to provide quality learning opportunities to children in remote areas. It focuses on improving infrastructure, resources, and teacher support. The initiative helps bridge the education gap and empower rural communities for a better future.', '2025-03-09', '2025-03-12', '16:00:00', '20:00:00', 'Kopar Memorial', 15, 50, 'Scheduled', 17, '2025-03-08 18:30:00', '../uploads/67cddc17e07870.74389766.png'),
(138, 'Mental Health Awareness', 'A mental health campaign raises awareness about emotional well-being and encourages open conversations. It promotes support systems, resources, and professional help to reduce stigma. The initiative aims to improve mental wellness and foster a supportive community.', '2025-03-01', '2025-03-12', '14:55:00', '16:53:00', 'Nehru Planatorium', 15, 50, 'Ongoing', 17, '2025-01-16 18:30:00', '../uploads/67cddc80724ee9.37356629.jpg'),
(139, 'Beach Cleaning Drive', 'A beach cleanup campaign focuses on removing litter and plastic waste from shorelines to protect marine life and the environment. It promotes community participation in keeping beaches clean and sustainable. The initiative raises awareness about pollution and encourages responsible waste disposal.', '2025-03-09', '2025-03-20', '01:53:00', '05:53:00', 'Juhu Beach', 10, 50, 'Scheduled', 17, '2025-03-08 18:30:00', '../uploads/67cddcd8c8fd23.76244947.jpg'),
(140, 'Say No To Drugs', 'A \"No to Drugs\" campaign raises awareness about the harmful effects of drug abuse and addiction. It promotes a healthy lifestyle, prevention programs, and support for those in recovery. The initiative encourages youth and communities to stay drug-free for a better future.', '2025-03-07', '2025-03-20', '01:56:00', '05:00:00', 'Thane Station', 10, 50, 'Ongoing', 17, '2025-03-01 18:30:00', '../uploads/67cddd2dd07ce3.44171612.png'),
(141, 'Blood Donation', 'A blood donation campaign encourages people to donate blood to save lives in medical emergencies. It raises awareness about the importance of regular donations and their impact on patients in need. The initiative promotes a culture of generosity and community support.', '2025-03-01', '2025-03-05', '02:00:00', '04:03:00', 'Vashi Mall', 10, 50, 'Completed', 17, '2025-02-20 18:30:00', '../uploads/67cdde83944877.42247649.png');

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
(28, 134, '2025-03-08 18:30:00', 'accepted'),
(28, 136, '2025-03-08 18:30:00', 'pending'),
(28, 140, '2025-03-08 18:30:00', 'pending'),
(28, 132, '2025-03-08 18:30:00', 'pending'),
(27, 134, '2025-03-08 18:30:00', 'pending'),
(27, 136, '2025-03-08 18:30:00', 'pending');

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
(131, 2),
(131, 3),
(131, 4),
(132, 2),
(132, 3),
(132, 4),
(133, 1),
(133, 2),
(133, 4),
(134, 1),
(134, 2),
(134, 4),
(134, 8),
(135, 1),
(135, 2),
(135, 5),
(135, 8),
(136, 2),
(136, 4),
(136, 8),
(137, 2),
(137, 4),
(137, 8),
(139, 2),
(139, 3),
(139, 7),
(139, 8),
(138, 2),
(138, 5),
(138, 8),
(140, 2),
(140, 4),
(140, 5),
(140, 8),
(141, 4),
(141, 5),
(141, 6);

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
(131, 1),
(131, 2),
(131, 5),
(132, 1),
(132, 2),
(132, 5),
(133, 1),
(133, 2),
(133, 3),
(133, 5),
(134, 1),
(134, 2),
(134, 3),
(134, 4),
(134, 5),
(135, 1),
(135, 2),
(135, 3),
(135, 5),
(136, 1),
(136, 4),
(136, 5),
(137, 1),
(137, 2),
(137, 3),
(137, 4),
(137, 5),
(139, 1),
(139, 2),
(139, 3),
(139, 5),
(138, 1),
(138, 2),
(138, 3),
(138, 5),
(140, 1),
(140, 2),
(140, 3),
(140, 4),
(140, 5),
(141, 1),
(141, 2),
(141, 3);

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
(77, 'its was a wonderful experience', '2025-03-09 18:54:19', 5, 27, 134),
(78, 'its was a wonderful experience', '2025-03-09 18:54:33', 4, 27, 135),
(79, 'just amazingggggg', '2025-03-09 18:54:52', 4, 27, 139),
(80, 'Hoping for the best', '2025-03-09 18:55:10', 5, 27, 136);

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
(113, 'hello nice to meet you', '2025-03-09 18:34:40', 'sent', 17, 25),
(114, 'hello there !!', '2025-03-09 18:34:50', 'sent', 17, 19),
(115, 'hello there', '2025-03-09 18:55:20', 'sent', 27, 17),
(116, 'wanted to know more about your events', '2025-03-09 18:55:35', 'sent', 27, 25),
(117, 'hiii', '2025-03-09 18:55:40', 'sent', 27, 19);

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
(17, 2),
(25, 1),
(26, 4);

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
(15, '../uploads/67c49c721b1648.69728944.jpg', 'Mountain Campaiging', '2025-02-06 17:59:14', 17, 1),
(18, '../uploads/67c49cbcefeaf6.61775156.jpg', 'Beach Cleanup at goa', '2025-03-02 18:00:28', 17, 21),
(19, '../uploads/67c49cdc9d07f3.76376211.jpg', 'Juhu Brach Cleanup', '2025-03-02 18:01:00', 19, 0),
(20, '../uploads/67c49d40ac0dc9.91634873.png', 'Doggie The King', '2025-03-02 18:02:40', 19, 22),
(21, '../uploads/67c49d57a97a48.09556721.jpg', 'Baby Rhino Caretaking', '2025-03-02 18:03:03', 19, 4),
(22, '../uploads/67c49d712add81.21711442.jpeg', 'A small Dog RESCUE', '2025-01-23 18:03:29', 19, 2),
(23, '../uploads/67c49d8f43ba75.31744580.jpg', 'Kitten taken Care of!!', '2025-03-02 18:03:59', 19, 6),
(26, '../uploads/67cdd93c5bce85.32960665.jpg', 'A tree plantation campaign promotes environmental sustainability by planting trees to improve air quality.', '2025-03-09 18:09:00', 25, 24),
(27, '../uploads/67cddfefe08298.11479101.jpg', 'the smiling future', '2025-01-14 18:37:35', 28, 2),
(28, '../uploads/67cde01ab99528.15094471.jpg', 'making travel more cleaner', '2025-02-18 18:38:18', 28, 6),
(29, '../uploads/67cde1a8dca778.06341518.png', 'Hand that guide the future', '2025-03-09 18:44:56', 28, 23),
(30, '../uploads/67cde23b514c79.98901909.jpg', 'A big Thanks', '2025-03-09 18:47:23', 26, 30),
(31, '../uploads/67cde24f02b1a0.70995857.jpg', 'The future of the giant species', '2025-03-09 18:47:43', 26, 40),
(32, '../uploads/67cde26ee73b07.85995224.jpg', 'A cub waiting for its growth', '2025-03-09 18:48:14', 26, 49),
(33, '../uploads/67cde283b8a058.50559762.jpg', 'The little Guardians', '2025-03-09 18:48:35', 26, 7),
(34, '../uploads/67cde356b84d80.12420482.jpeg', 'Tree Plantation', '2025-03-09 18:52:06', 27, 7),
(35, '../uploads/67cde36a7ff499.18586396.jpg', 'The walk that never ends', '2025-03-09 18:52:26', 27, 9),
(36, '../uploads/67cde37e62d1f0.34035828.jpeg', 'The memories that would forever live', '2025-03-09 18:52:46', 27, 22),
(37, '../uploads/67cde5d5d98de7.39860022.png', 'The Olive Turtle on the run', '2025-03-09 19:02:45', 29, 0),
(38, '../uploads/67cde5f98bbb09.70658841.jpg', 'The 1st SUN SHINE ', '2025-03-09 19:03:21', 29, 19),
(39, '../uploads/67cde6192c6cc1.92551214.png', 'The turtle of the day', '2025-03-09 19:03:53', 29, 0);

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
(17, 'Aniket Singh', 'walfra52777@gmail.com', 7208541711, 'M', 'student', 'aniket52777', 'Aniket52@', 'And Building, Lotus C-wing, 601 , Agasan Road, Diva(E)', '../uploads/67cd87bb8491e6.49393526.jpg', 'O', '2007-02-01', '2025-02-01'),
(19, 'Aniket', 'walfra5244@gmail.com', 7208541711, 'M', 'business man', 'Aniket52', 'aniket123', ' Diva West, And Building', '../uploads/67cd87bb8491e6.49393526.jpg', 'V', '2007-02-09', '2025-03-03'),
(25, 'PlantationWarriors', 'aniketsingh52777@gmail.com', 7208541711, 'N', NULL, 'MakeWorldGreen', 'aniket123', 'And Building, Lotus C-wing, 601 , Agasan Road, Diva(E)', '../uploads/67cdd4392a1a66.07525533.png', 'O', '2023-02-15', '2025-03-09'),
(26, 'TheRescuers', 'aniketsingh42242@gmail.com', 7668541711, 'N', NULL, 'WeTheHelpers', 'aniket123', ' And Building, Lotus C-wing, 701 , Agasan Road, Diva(E)', '../uploads/67cdd4df430a90.49530903.png', 'O', '2019-01-09', '2025-03-09'),
(27, 'Omkar Dhadam', 'butcherwalfra@gmail.com', 9808541711, 'M', 'student', 'omkarDhadam23', 'aniket123', ' And Building, Lotus C-wing, 601 , Agasan Road, Diva(E)', '../uploads/67cdd5874ea4a5.23828964.jpg', 'V', '2006-11-16', '2025-03-09'),
(28, 'Sakshi Kamble', 'sachinsingh52777@gmail.com', 9808541711, 'F', 'student', 'sakshi8911', 'aniket123', ' And Building, Lotus C-wing, 601 , Agasan Road, Diva(E)', '../uploads/67cdd67f0df912.71464313.jpg', 'V', '2007-03-01', '2025-03-09'),
(29, 'Priyanka', 'disgrace_yin697@aleeas.com', 9808541711, 'F', 'student', 'Priyanka2344', 'aniket123', ' And Building, Lotus C-wing, 601 , Agasan Road, Diva(E)', '../uploads/67cdd6beef2815.53553611.jpg', 'V', '2007-02-16', '2025-03-09');

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
(19, 2),
(19, 6),
(19, 7),
(19, 8),
(25, 2),
(25, 7),
(25, 8),
(26, 1),
(26, 2),
(26, 4),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(27, 5),
(27, 7),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(28, 6),
(28, 7),
(28, 8),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 5),
(29, 6),
(29, 7),
(29, 8);

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
(19, 2),
(27, 1),
(27, 2),
(27, 3),
(27, 5),
(28, 1),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(29, 1),
(29, 3),
(29, 5);

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
  ADD KEY `user_receive_msg` (`to_id`),
  ADD KEY `user_send_msg` (`from_id`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `causes`
--
ALTER TABLE `causes`
  MODIFY `cause_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `event_has_notices`
--
ALTER TABLE `event_has_notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback_rating`
--
ALTER TABLE `feedback_rating`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  ADD CONSTRAINT `admin_manage_user` FOREIGN KEY (`admin_id`) REFERENCES `administration` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_areManged_admin` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `user_receive_msg` FOREIGN KEY (`to_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_send_msg` FOREIGN KEY (`from_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
