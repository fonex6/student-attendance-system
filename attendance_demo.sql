-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 07:00 PM
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
-- Database: `attendance_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `reg_number` varchar(50) DEFAULT NULL,
  `scan_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `session_id`, `reg_number`, `scan_time`) VALUES
(1, 24, '231005333500768', '2026-02-26 00:40:29'),
(2, 25, '23100533350076', '2026-02-26 00:46:25'),
(3, 25, '231005333500768', '2026-02-26 00:49:29'),
(4, 26, '231005333500768', '2026-02-26 00:51:49'),
(5, 27, '23100533350001', '2026-02-26 00:55:00'),
(6, 27, '23100533350002', '2026-02-26 00:55:05'),
(7, 27, '23100533350003', '2026-02-26 00:55:10'),
(8, 28, '23100533350001', '2026-02-26 01:05:04'),
(9, 28, '23100533350002', '2026-02-26 01:05:08'),
(10, 28, '23100533350003', '2026-02-26 01:05:14'),
(11, 28, '23100533350005', '2026-02-26 01:05:24'),
(12, 29, '2310053335004', '2026-02-26 01:49:50'),
(13, 29, '23100533350001', '2026-02-26 01:50:04'),
(14, 29, '23100533350002', '2026-02-26 01:50:09'),
(15, 29, '23100533350003', '2026-02-26 01:50:13'),
(16, 29, '23100533350005', '2026-02-26 01:50:18'),
(17, 30, '23100533350001', '2026-02-26 02:30:17'),
(18, 30, '23100533350002', '2026-02-26 02:30:23'),
(19, 30, '23100533350003', '2026-02-26 02:30:26'),
(20, 30, '23100533350005', '2026-02-26 02:30:36'),
(21, 30, '23100533350007', '2026-02-26 02:30:44'),
(22, 30, '23100533350008', '2026-02-26 02:30:50'),
(23, 30, '23100533350009', '2026-02-26 02:30:54'),
(24, 30, '23100533350011', '2026-02-26 02:30:59'),
(25, 32, '23100533350002', '2026-02-26 03:23:14'),
(26, 32, '23100533350010', '2026-02-26 03:23:42'),
(27, 33, '23100533350003', '2026-02-26 12:58:14'),
(28, 40, '23100533350002', '2026-02-26 19:40:30'),
(29, 40, '23100533350005', '2026-02-26 19:41:03'),
(30, 40, '23100533350007', '2026-02-26 19:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_of_study` varchar(20) DEFAULT NULL,
  `session_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `subject`, `course`, `year_of_study`, `session_date`, `created_at`) VALUES
(27, 'kiswahili', 'BAED', 'Year 2', '2026-02-25', '2026-02-26 00:54:42'),
(28, 'NETWORKING CONCEPTS', 'COMPUTER ENGINEERING', 'Year 2', '2026-02-25', '2026-02-26 01:04:51'),
(29, 'AGRICULTURE', 'BACHELOR OF FOREST', 'Year 1', '2026-02-25', '2026-02-26 01:48:50'),
(30, 'BOTANICAL SCIENCE', 'AGRICULTURE', 'Year 4', '2026-02-26', '2026-02-26 02:29:52'),
(31, 'BOTANICAL SCIENCE', 'BAED', 'Year 1', '2026-02-26', '2026-02-26 03:18:28'),
(32, 'botanical science', 'BAED', 'Year 1', '2026-02-26', '2026-02-26 03:22:11'),
(33, 'hf', 'BAED', 'Year 1', '2026-02-26', '2026-02-26 12:57:50'),
(34, 'Mobile', 'BCS', 'Year 3', '2026-02-26', '2026-02-26 13:24:20'),
(35, 'Mobile', 'BCS', 'Year 3', '2026-02-26', '2026-02-26 13:24:28'),
(36, 'Mobile', 'BCS', 'Year 3', '2026-02-26', '2026-02-26 13:24:53'),
(37, 'Professional issues', 'BCS', 'Year 3', '2026-02-26', '2026-02-26 13:35:14'),
(38, 'Professional issues', 'BCS', 'Year 3', '2026-02-26', '2026-02-26 13:36:09'),
(39, 'network design', 'BCS', 'Year 3', '2026-02-26', '2026-02-26 13:39:19'),
(40, 'network administration', 'BCS', 'Year 1', '2026-02-26', '2026-02-26 19:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `reg_number` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_of_study` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `reg_number`, `full_name`, `course`, `year_of_study`, `created_at`) VALUES
(14, '23100533350002', 'MIRIAM MOHAMED', 'BAED', 'Year 2', '2026-02-26 00:53:22'),
(15, '23100533350003', 'ALLY KASULU', 'BAED', 'Year 1', '2026-02-26 00:53:41'),
(16, '23100533350005', 'ISAAAC ALOYCE', 'BCE', 'Year 1', '2026-02-26 01:02:59'),
(17, '2310053335004', 'ZAKARIA JUMA', 'BACHELOR OF FOREST', 'Year 1', '2026-02-26 01:47:53'),
(18, '23100533350007', 'CHARITY ISSA', 'BACHELOR OF FOREST', 'Year 1', '2026-02-26 01:52:56'),
(19, '23100533350008', 'ANNA JUMA', 'BACHELOR OF FOREST', 'Year 1', '2026-02-26 01:53:17'),
(20, '23100533350009', 'DIZO KIOKO', 'BACHELOR OF FOREST', 'Year 1', '2026-02-26 01:53:44'),
(21, '23100533350010', 'KIBOSHO KIBOSHO', 'BSCS', 'Year 4', '2026-02-26 02:03:00'),
(22, '23100533350011', 'ASHA KAGOMA', 'BSAS', 'Year 3', '2026-02-26 02:26:40'),
(27, '23100533350079', 'GERALD BERNALD', 'BCS', 'Year 3', '2026-02-26 13:23:26'),
(28, '23100533350068', 'JUMA ABDADA', 'BCS', 'Year 2', '2026-02-26 19:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_number` (`reg_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
