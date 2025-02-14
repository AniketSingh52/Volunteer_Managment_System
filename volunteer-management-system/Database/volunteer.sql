-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 08:07 PM
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
(2, 'Awareness Campaigns'),
(3, 'CleanUp Drives'),
(4, 'Rural Education Campaigns');

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
  `status` enum('active','scheduled','completed','cancelled') NOT NULL,
  `organization_id` int(11) NOT NULL,
  `date_of_creation` date NOT NULL,
  `poster` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `description`, `from_date`, `to_date`, `from_time`, `to_time`, `location`, `volunteers_needed`, `maximum_application`, `status`, `organization_id`, `date_of_creation`, `poster`) VALUES
(1, 'klilll', 'nnkk', '0000-00-00', '2025-02-14', '21:00:00', '23:03:00', 'mumko', 511, 50, 'scheduled', 17, '2025-02-11', '../uploads/67ab8adabac5b7.43044535.png'),
(2, 'okaubiss', '11111', '0000-00-00', '2025-02-14', '15:23:00', '23:23:00', 's', 11, 50, 'scheduled', 17, '2025-02-11', '../uploads/67ab8f5b737ca2.10203097.png'),
(3, 'okaubiss', '11111', '0000-00-00', '2025-02-14', '15:23:00', '23:23:00', 's', 11, 50, 'scheduled', 17, '2025-02-11', '../uploads/67ab8f65ee5985.05757091.png'),
(4, 'okaubiss', '11111', '0000-00-00', '2025-02-14', '15:23:00', '23:23:00', 's', 11, 50, 'scheduled', 17, '2025-02-11', '../uploads/67ab8fa66c5ea4.82869368.png'),
(5, 'aniket566', 'deded', '2025-02-12', '2025-02-14', '16:32:00', '23:32:00', 'e33dd', 100, 50, 'scheduled', 17, '2025-02-11', '../uploads/67ab90ce1ea722.03576780.png'),
(6, 'habibi co.ltd 151551', 'sasas', '2025-02-14', '2025-02-15', '19:49:00', '20:50:00', 'mumbai', 12, 50, 'scheduled', 17, '2025-02-12', '../uploads/67acadff7a62d9.24516489.png'),
(7, 'sxsxsxxsx', 'scscscscs', '2025-02-13', '2025-02-14', '21:33:00', '21:34:00', 'sqs', 11, 50, 'scheduled', 17, '2025-02-12', '../uploads/67acc6486af2f9.32904579.png'),
(8, 'ss', 'ss', '2025-02-17', '2025-02-20', '21:45:00', '22:45:00', 'www', 11, 50, 'scheduled', 17, '2025-02-12', '../uploads/67acc94569e242.77215616.png'),
(9, 'merimarzi', 'haa meri jan', '2025-02-13', '2025-02-15', '21:51:00', '21:51:00', 'mere ghar pe', 100, 50, 'scheduled', 17, '2025-02-12', '../uploads/67acca6993d134.91169310.png');

-- --------------------------------------------------------

--
-- Table structure for table `events_application`
--

CREATE TABLE `events_application` (
  `volunteer_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','rejected','accepted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(8, 1),
(9, 1),
(9, 2),
(9, 3),
(9, 4);

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
(7, 1),
(7, 2),
(8, 2),
(9, 1),
(9, 2);

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
  `description` int(255) NOT NULL,
  `date_of_creation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `organization_belongs_type`
--

CREATE TABLE `organization_belongs_type` (
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `picture_url` int(11) NOT NULL,
  `caption` text NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(17, 'Aniket Singh', 'walfra52@gmail.com', 7208541711, 'M', 'student', 'aniket52777', 'Aniket52@', ' Diva E', '../uploads/9.jpg', 'O', '2007-02-01', '2025-02-05');

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
(17, 2);

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
(17, 1);

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
  MODIFY `cause_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_has_images` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `images_of_events` FOREIGN KEY (`image_id`) REFERENCES `pictures` (`picture_id`);

--
-- Constraints for table `event_req_skill`
--
ALTER TABLE `event_req_skill`
  ADD CONSTRAINT `event_req_skill` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `skill_for_event` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`);

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
