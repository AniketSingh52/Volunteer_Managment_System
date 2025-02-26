-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 08:30 PM
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
-- Table structure for table `admin_manage_group`
--

CREATE TABLE `admin_manage_group` (
  `admin_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
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
(4, 'okaubiss', '11111', '0000-00-00', '2025-02-14', '15:23:00', '23:23:00', 's', 11, 50, 'Scheduled', 17, '2025-02-10 18:30:00', '../uploads/67ab8fa66c5ea4.82869368.png'),
(6, 'habibi co.ltd 151551', 'sasas', '2025-02-14', '2025-02-15', '19:49:00', '20:50:00', 'mumbai', 12, 50, 'Scheduled', 17, '2025-02-11 18:30:00', '../uploads/67acadff7a62d9.24516489.png'),
(7, 'sxsxsxxsx', 'hello world', '2025-02-13', '2025-02-14', '21:33:00', '21:34:00', 'sqs', 11, 50, 'Cancelled', 17, '2025-02-11 18:30:00', '../uploads/67acc6486af2f9.32904579.png'),
(8, 'ss', 'ss', '2025-02-17', '2025-02-20', '21:45:00', '22:45:00', 'www', 11, 50, 'Scheduled', 17, '2025-02-11 18:30:00', '../uploads/67acc94569e242.77215616.png'),
(9, 'merimarzi', 'haa meri jan', '2025-02-13', '2025-02-15', '21:51:00', '21:51:00', 'mere ghar pe', 100, 50, 'Scheduled', 17, '2025-02-11 18:30:00', '../uploads/67acca6993d134.91169310.png'),
(10, 'Community Garden Clean-up', 'Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?', '2025-02-19', '2025-02-21', '22:26:00', '23:26:00', 'Central Community Garden', 1, 50, 'Ongoing', 17, '2025-02-22 18:30:00', '../uploads/67b60d9ba6d3a5.36197222.png'),
(11, 'Youth Mentorship Program', 'Make a difference in a young person\'s life through our mentorship program. Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?', '2025-02-20', '2025-02-23', '22:30:00', '23:30:00', 'City Youth Center', 15, 50, 'Ongoing', 17, '2025-02-18 18:30:00', '../uploads/67b60e4baebf10.37713674.png'),
(12, 'Food Bank Distribution2', 'Make a difference in a young person\'s life through our mentorship program. Join us in maintaining our community garden. Help plant new vegetables and maintain existing beds. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex esse autem accusamus iste dolore amet sint magni ad, quas et, ratione doloribus modi nam unde tempore officiis ea. Quod, quae?', '2025-02-18', '2025-02-28', '13:00:00', '16:00:00', 'Community Food Bank', 20, 50, 'Completed', 17, '2025-02-10 15:11:24', '../uploads/67bb3a9c617da1.24237529.jpg'),
(13, 'hello shrusthti', 'kkaaaakkkakakakakskaskas sasasasasasasas asasa   cxc ss ws qqsq z  s cx z  qa     s xz    qaz  azaz az az zaaaa azzazz ', '2025-02-23', '2025-03-01', '09:51:00', '10:51:00', 'mumbai', 12, 50, 'Ongoing', 17, '2025-02-18 18:30:00', '../uploads/67ba0f4c232d23.99127156.jpg');

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
(17, 10, '2025-02-24 11:40:39', 'accepted'),
(16, 10, '2025-02-18 11:59:00', 'rejected'),
(17, 9, '2025-02-12 13:59:46', 'accepted'),
(19, 11, '2025-02-24 18:30:00', 'pending'),
(19, 13, '2025-02-24 18:30:00', 'accepted'),
(19, 6, '2025-02-25 18:30:00', 'pending');

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
(6, 1),
(6, 2),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(12, 2),
(12, 7),
(13, 2),
(13, 3),
(11, 5),
(11, 6),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(10, 1),
(10, 2),
(10, 3);

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

--
-- Dumping data for table `event_has_notices`
--

INSERT INTO `event_has_notices` (`event_id`, `user_id`, `notice`, `notice_id`, `date`) VALUES
(13, 17, 'ssss', 1, '2025-02-26 16:26:58'),
(13, 19, 'ssss', 2, '2025-02-26 15:26:58'),
(13, 19, 'habii', 3, '2025-02-26 17:04:16'),
(13, 19, 'zzzz', 4, '2025-02-26 17:05:40'),
(13, 19, 'ss', 5, '2025-02-26 17:06:47');

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
(6, 1),
(6, 2),
(8, 2),
(9, 1),
(9, 2),
(12, 1),
(12, 2),
(13, 1),
(11, 2),
(7, 1),
(7, 2),
(10, 1),
(10, 2);

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
(51, 'HELLO', '2025-02-20 17:34:19', 1, 17, 12),
(52, 'HAA MERI JAAN', '2025-02-20 17:34:40', 3, 17, 12),
(53, 'TU HE HAI PRABLUE', '2025-02-20 17:34:56', 4, 17, 12),
(54, 'DD', '2025-02-20 17:35:11', 2, 17, 12),
(55, 'd', '2025-02-20 17:56:15', 3, 17, 6),
(56, 'habbbb', '2025-02-20 18:07:59', 4, 18, 12),
(57, 'nach ke dikha', '2025-02-20 18:08:08', 5, 18, 12),
(58, 'he', '2025-02-22 13:05:24', 4, 17, 6),
(59, 'd', '2025-02-22 13:05:30', 4, 17, 6),
(60, 'a', '2025-02-25 07:31:59', 3, 17, 10),
(61, 'xx', '2025-02-26 15:16:57', 4, 19, 10),
(62, 'xsxs', '2025-02-26 15:17:04', 5, 19, 10),
(63, 'ss', '2025-02-26 15:25:20', 4, 19, 13),
(64, 'hello', '2025-02-26 15:49:09', 4, 19, 13),
(65, 'aaa', '2025-02-26 15:50:18', 5, 19, 13),
(66, 'xxx', '2025-02-26 17:04:55', 4, 19, 10),
(67, 'ss', '2025-02-26 17:05:02', 4, 19, 10);

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_msg`
--

CREATE TABLE `group_msg` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_of_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_msg`
--

INSERT INTO `group_msg` (`group_id`, `group_name`, `description`, `date_of_creation`, `creator_id`) VALUES
(1, 'habibi', '12', '2025-02-12 07:21:13', 17);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_url` varchar(255) NOT NULL,
  `status` enum('sent','read') NOT NULL,
  `message_type` enum('Private','Group') NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `to_groupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `text`, `date_time`, `image_url`, `status`, `message_type`, `from_id`, `to_id`, `to_groupID`) VALUES
(1, 'xxxx', '2025-02-17 07:22:15', 'xx', 'read', 'Private', 17, 16, 1);

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
(2, '../uploads/67bf5c961cfac2.43972930.jpg', 'habiiii', '2025-02-26 13:55:26', 19, 0),
(3, '../uploads/67bf5d07e633f0.41385679.jpg', 'habiiii', '2025-02-26 13:57:19', 19, 0),
(4, '../uploads/67bf5d1dad8323.59902368.jpeg', 'illov', '2025-02-26 13:57:41', 19, 0),
(5, '../uploads/67bf5d73f0c9b7.70060187.jpeg', 'ulove', '2025-02-26 13:59:07', 19, 0),
(6, '../uploads/67bf5e08cef614.54599381.jpeg', 'hhhh', '2025-02-26 14:01:36', 19, 0),
(7, '../uploads/67bf5e295ecaa7.64907046.jpeg', 'zzz', '2025-02-26 14:02:09', 19, 0),
(8, '../uploads/67bf5ec7b44142.46572518.jpg', '9800', '2025-02-26 14:04:47', 19, 0);

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
(2, 'Management');

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
(16, 'aniket', 'walfra52@gmail.com22', 7208541711, 'N', NULL, 'eee', 'dddddddd', ' ssas', '../uploads/9.jpg', 'V', '2023-02-04', '2025-02-05'),
(17, 'Aniket Singh', 'walfra52@gmail.com', 7208541711, 'M', 'student', 'aniket52777', 'Aniket52@', ' Diva E', '../uploads/9.jpg', 'O', '2007-02-01', '2025-02-05'),
(18, 'aniket2', 'walfra52777@gmail.com', 7208541711, 'N', NULL, 'GodLike', 'aniket52', ' habibi', '../uploads/67b70c3a97cf23.36096127.jpg', 'O', '2023-02-03', '2025-02-20'),
(19, 'shrushti', 'walfra5244@gmail.com', 7208541711, 'M', 'business man', 'shrusthi', 'aniket123', ' tere shar pe rehta hu kabhi check krna', '../uploads/67bde77d6cbbd1.43554717.jpg', 'V', '2007-02-09', '2025-02-25');

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
-- Indexes for table `admin_manage_group`
--
ALTER TABLE `admin_manage_group`
  ADD KEY `admin_manage_group_gid` (`group_id`),
  ADD KEY `admin_manage_group_adminID` (`admin_id`);

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
  ADD KEY `user_post_comment` (`user_id`),
  ADD KEY `comment_on_pic` (`picture_id`);

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
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD KEY `group_has_member` (`group_id`),
  ADD KEY `user_join_group` (`user_id`);

--
-- Indexes for table `group_msg`
--
ALTER TABLE `group_msg`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `group_has_creator` (`creator_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_send_msg` (`from_id`),
  ADD KEY `user_receive_msg` (`to_id`),
  ADD KEY `group_has_msg` (`to_groupID`);

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
-- AUTO_INCREMENT for table `causes`
--
ALTER TABLE `causes`
  MODIFY `cause_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `event_has_notices`
--
ALTER TABLE `event_has_notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedback_rating`
--
ALTER TABLE `feedback_rating`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
-- Constraints for table `admin_manage_group`
--
ALTER TABLE `admin_manage_group`
  ADD CONSTRAINT `admin_manage_group_adminID` FOREIGN KEY (`admin_id`) REFERENCES `administration` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_manage_group_gid` FOREIGN KEY (`group_id`) REFERENCES `group_msg` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `comment_on_pic` FOREIGN KEY (`picture_id`) REFERENCES `pictures` (`picture_id`),
  ADD CONSTRAINT `user_post_comment` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `EVENT_ORGANIZATION` FOREIGN KEY (`organization_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events_application`
--
ALTER TABLE `events_application`
  ADD CONSTRAINT `event_req_volunteer` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
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
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_has_member` FOREIGN KEY (`group_id`) REFERENCES `group_msg` (`group_id`),
  ADD CONSTRAINT `user_join_group` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `group_msg`
--
ALTER TABLE `group_msg`
  ADD CONSTRAINT `group_has_creator` FOREIGN KEY (`creator_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `group_has_msg` FOREIGN KEY (`to_groupID`) REFERENCES `group_msg` (`group_id`),
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
