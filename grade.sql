-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2023 at 04:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grade`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin', '2023-03-11 07:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` text NOT NULL,
  `course_description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_description`, `created_at`) VALUES
(18, 'BSIT', 'Bachelor of Science in Information Technology', '2023-03-11 20:53:50'),
(19, 'BSED', 'Bachelor of Science in Elementary Education', '2023-03-11 21:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `curriculums`
--

CREATE TABLE `curriculums` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `curriculum_year_level` text NOT NULL,
  `curriculum_session` text NOT NULL,
  `curriculum_school_year` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curriculums`
--

INSERT INTO `curriculums` (`id`, `student_id`, `curriculum_year_level`, `curriculum_session`, `curriculum_school_year`, `created_at`) VALUES
(12, 23, '1st Year', 'First Semester', '2019 - 2020', '2023-03-12 12:03:36'),
(13, 23, '1st Year', 'Second Semester', '2019 - 2020', '2023-03-12 12:06:20'),
(16, 23, '4th Year', 'Second Semester', '2026 - 2027', '2023-03-12 12:11:42'),
(18, 24, '1st Year', 'First Semester', '2019 - 2020', '2023-03-12 14:38:37'),
(19, 24, '1st Year', 'Summer', '2016 - 2017', '2023-03-12 15:30:07'),
(20, 24, '4th Year', 'First Semester', '2022 - 2023', '2023-03-12 15:38:04'),
(21, 25, '1st Year', 'First Semester', '2018 - 2019', '2023-03-12 16:52:09'),
(22, 26, '1st Year', 'First Semester', '2018 - 2019', '2023-03-12 16:55:27'),
(23, 26, '2nd Year', 'Second Semester', '2017 - 2018', '2023-03-12 16:57:47'),
(24, 26, '4th Year', 'Second Semester', '2019 - 2020', '2023-03-12 17:21:54'),
(25, 32, '4th Year', 'First Semester', '2015 - 2016', '2023-03-13 09:37:49'),
(26, 35, '1st Year', 'First Semester', '2023 - 2024', '2023-04-07 10:51:16'),
(27, 36, '1st Year', 'Second Semester', '2022 - 2023', '2023-12-17 22:52:43');

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `otp_code` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `student_id`, `teacher_id`, `otp_code`, `created_at`) VALUES
(35, NULL, 9, '997771', '2023-03-12 12:46:01'),
(36, 26, NULL, '472849', '2023-03-12 12:48:47'),
(37, 31, NULL, '202017', '2023-03-12 20:04:09'),
(38, 32, NULL, '145162', '2023-03-12 20:05:06'),
(39, 33, NULL, '576890', '2023-03-12 20:10:20'),
(40, 34, NULL, '809683', '2023-04-07 10:49:20'),
(41, 35, NULL, '521494', '2023-04-07 10:50:06'),
(42, 36, NULL, '178462', '2023-12-17 22:33:06'),
(43, NULL, 10, '929658', '2023-12-17 22:49:02'),
(44, 37, NULL, '529639', '2023-12-17 23:04:28'),
(45, 38, NULL, '883504', '2023-12-17 23:10:00'),
(46, 39, NULL, '978561', '2023-12-17 23:20:26'),
(47, 40, NULL, '174961', '2023-12-17 23:24:42'),
(48, 41, NULL, '478541', '2023-12-17 23:27:30'),
(49, 42, NULL, '953865', '2023-12-17 23:30:29'),
(50, NULL, 11, '435391', '2023-12-17 23:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `id_number` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `status` text NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `parents_email` text NOT NULL,
  `parents_otp` text NOT NULL,
  `verify_email` varchar(255) NOT NULL,
  `verify_parents_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `course_id`, `id_number`, `email`, `password`, `first_name`, `last_name`, `status`, `created_at`, `parents_email`, `parents_otp`, `verify_email`, `verify_parents_email`) VALUES
(24, 18, '447', 'huqipy@mailinator.com', 'asd', 'Avye', 'Slater', 'pending', '2023-03-11 20:39:30', '', '', '', ''),
(26, 19, '456', 'ortegacanillo76@gmail.com2', 'asd', 'Nissim', 'Wilcox', 'pending', '2023-03-12 12:48:47', '', '', '', ''),
(28, 18, '872123', 'pusura@mailinator.com', 'Pa$$w0rd!', 'Orlando', 'Maldonado', 'pending', '2023-03-12 19:46:46', '', '', '', ''),
(29, 18, '918123', 'ortegacanillo76@gmail.comww', 'Pa$$w0rd!', 'Ina', 'Richard', 'pending', '2023-03-12 19:47:55', '', '', '', ''),
(30, 19, '106123', 'geguhemut@mailinator.com', 'Pa$$w0rd!', 'Ivana', 'Lynn', 'pending', '2023-03-12 19:59:34', '', '', '', ''),
(32, 18, '234', 'ortegacanillo76@gmail.com', '123', 'Fritz', 'Erickson', 'pending', '2023-03-12 20:05:06', '', '', '', ''),
(33, 19, '762123', 'hysa@mailinator.com', 'Pa$$w0rd!', 'Logan', 'Estrada', 'pending', '2023-03-12 20:10:20', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `curriculum_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `grade` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`id`, `student_id`, `curriculum_id`, `subject_id`, `teacher_id`, `grade`) VALUES
(40, 32, 25, 15, 9, '3'),
(41, 32, 25, 16, 4, '2');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subject_code` text NOT NULL,
  `subject_description` text NOT NULL,
  `subject_units` text NOT NULL,
  `grade` text NOT NULL DEFAULT 'null',
  `status` text NOT NULL DEFAULT 'close',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `course_id`, `subject_code`, `subject_description`, `subject_units`, `grade`, `status`, `created_at`) VALUES
(13, 19, 'THEO', 'fsfsd', '9', 'null', 'close', '2023-03-12 11:24:13'),
(14, 19, 'Ratione dicta praese', 'Voluptas quia qui de', '45', 'null', 'close', '2023-03-12 11:35:40'),
(15, 18, 'COMP1', 'Computer Programming', '3', 'null', 'close', '2023-03-12 12:04:24'),
(16, 18, 'WEB DEV', 'Web Development', '3', 'null', 'close', '2023-03-12 12:19:07'),
(18, 18, 'IT321', 'BSI', '2', 'null', 'close', '2023-12-17 22:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `username` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `status` text NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `status`, `created_at`) VALUES
(1, 'qexipi', 'hibudajyd@mailinator.com', 'asd', 'Yetta', 'Hutchinson', 'pending', '2023-03-12 12:30:36'),
(4, 'jihujoman', 'risu@mailinator.com', 'Pa$$w0rd!', 'Noah', 'Wheeler', 'pending', '2023-03-12 12:35:45'),
(9, 'munoxdd', 'ortegacanillo76@gmail.com', 'Pa$$w0rd!', 'Camilla', 'Estes', 'pending', '2023-03-12 12:46:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH;

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`) USING HASH;

--
-- Indexes for table `curriculums`
--
ALTER TABLE `curriculums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `otp_code` (`otp_code`) USING HASH;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `curriculums`
--
ALTER TABLE `curriculums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
