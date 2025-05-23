-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 07:49 AM
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
-- Database: `hampco`
--

-- --------------------------------------------------------

--
-- Table structure for table `raw_materials`
--

CREATE TABLE `raw_materials` (
  `id` int(11) NOT NULL,
  `rm_name` varchar(60) NOT NULL,
  `rm_description` text DEFAULT NULL,
  `rm_quantity` varchar(255) NOT NULL,
  `rm_status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `raw_materials`
--

INSERT INTO `raw_materials` (`id`, `rm_name`, `rm_description`, `rm_quantity`, `rm_status`) VALUES
(9, 'silk lambo', '', '792 kilo', 'Available'),
(10, 'pina loose liniwan', '', '65 bundle', 'Available'),
(11, 'abaca loose', '', '56 bundle', 'Available'),
(12, 'silk 21d', '', '86670 gram', 'Available'),
(13, 'fiver', 'dawdawd', '100004 kg', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `stock_id` int(11) NOT NULL,
  `stock_user_type` varchar(60) NOT NULL,
  `stock_raw_id` int(11) NOT NULL,
  `stock_user_id` int(11) NOT NULL,
  `stock_type` varchar(60) NOT NULL,
  `stock_outQty` int(11) NOT NULL,
  `stock_changes` text NOT NULL,
  `stock_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_history`
--

INSERT INTO `stock_history` (`stock_id`, `stock_user_type`, `stock_raw_id`, `stock_user_id`, `stock_type`, `stock_outQty`, `stock_changes`, `stock_date`) VALUES
(12, 'Administrator', 9, 1, 'Stock In', 10, '800 -> 810', '2025-05-23 05:09:17'),
(13, 'member', 9, 4, 'Stock Out', 20, '810 -> 790', '2025-05-23 05:21:02'),
(14, 'member', 10, 4, 'Stock Out', 10, '10 -> 0', '2025-05-23 05:21:02'),
(15, 'Administrator', 10, 1, 'Stock In', 50, '0 -> 50', '2025-05-23 05:24:17'),
(16, 'Administrator', 10, 1, 'Stock In', 1, '50 -> 51', '2025-05-23 05:25:39'),
(17, 'Administrator', 10, 1, 'Stock In', 2, '51 -> 53', '2025-05-23 05:26:55'),
(18, 'Administrator', 11, 1, 'Stock In', 1, '50 -> 51', '2025-05-23 05:27:49'),
(19, 'Administrator', 10, 1, 'Stock In', 1, '53 -> 54', '2025-05-23 05:30:16'),
(20, 'Administrator', 10, 1, 'Stock In', 1, '54 -> 55', '2025-05-23 05:32:45'),
(21, 'Administrator', 10, 1, 'Stock In', 5, '55 -> 60', '2025-05-23 05:35:12'),
(22, 'Administrator', 9, 1, 'Stock In', 1, '790 -> 791', '2025-05-23 05:35:43'),
(23, 'Administrator', 13, 1, 'Stock In', 1, '100000 -> 100001', '2025-05-23 05:36:31'),
(24, 'Administrator', 11, 1, 'Stock In', 2, '51 -> 53', '2025-05-23 05:38:09'),
(25, 'Administrator', 13, 1, 'Stock In', 3, '100001 -> 100004', '2025-05-23 05:38:46'),
(26, 'Administrator', 11, 1, 'Stock In', 1, '53 -> 54', '2025-05-23 05:41:45'),
(27, 'Administrator', 9, 1, 'Stock In', 1, '791 -> 792', '2025-05-23 05:42:34'),
(28, 'Administrator', 10, 1, 'Stock In', 3, '60 -> 63', '2025-05-23 05:44:18'),
(29, 'Administrator', 10, 1, 'Stock In', 2, '63 -> 65', '2025-05-23 05:45:24'),
(30, 'Administrator', 11, 1, 'Stock In', 2, '54 -> 56', '2025-05-23 05:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task_user_id` int(11) NOT NULL,
  `task_name` varchar(60) NOT NULL,
  `task_material` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`task_material`)),
  `task_category` varchar(60) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_user_id`, `task_name`, `task_material`, `task_category`, `date_start`, `date_end`, `status`) VALUES
(14, 4, 'j task', '[{\"raw_id\":9,\"quantity\":20,\"unit\":\"kilo\"},{\"raw_id\":10,\"quantity\":10,\"unit\":\"bundle\"}]', 'j cat', '2025-05-23', NULL, 'On Progress');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id`, `fullname`, `username`, `password`, `date_created`) VALUES
(1, 'John Doe', 'admin', '$2y$10$JQ1lmgWTeqdSVD3DFIibqeE.0BAjjBrhaBNt5qdLOXV5Fa6os7me.', '2025-05-04 09:54:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_member`
--

CREATE TABLE `user_member` (
  `id` int(11) NOT NULL,
  `id_number` varchar(60) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `role` varchar(60) NOT NULL,
  `sex` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=NonVerify,1=Verified,2=disabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_member`
--

INSERT INTO `user_member` (`id`, `id_number`, `fullname`, `email`, `phone`, `role`, `sex`, `password`, `date_created`, `status`) VALUES
(4, '12312', 'joshua padilla', 'joshua@gmail.com', '09454454741', 'warper', 'male', '$2y$10$KbOCoR8Joxq.8ARDTgbI0ed6mfXg/4ht6NtDjyWZCO6KVwYkLi1Gi', '2025-05-05 04:07:41', 1),
(7, '111111', 'alden  padilla', 'sample@gmail.com', '09454454741', 'knotter', 'male', '$2y$10$ykHUkxTH2qycU7.vNuruAeOHakOHmEN/cAJmnz/X2cxqO34tCYXUK', '2025-05-05 04:13:48', 1),
(9, '1312312312', 'justin melvin', 'jmelvin@gmail.com', '098454454744', 'knotter', 'male', '$2y$10$fUOOEVyd4Fs/Culb1ln9bO.68HdtXxHmjKT8snl6EEM4spPzl4jW2', '2025-05-22 16:36:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `weaver`
--

CREATE TABLE `weaver` (
  `id` int(11) NOT NULL,
  `category` varchar(60) NOT NULL,
  `product` varchar(60) NOT NULL,
  `product_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`product_details`)),
  `status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `raw_materials`
--
ALTER TABLE `raw_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `stock_raw_id` (`stock_raw_id`),
  ADD KEY `stock_user_id` (`stock_user_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_member`
--
ALTER TABLE `user_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weaver`
--
ALTER TABLE `weaver`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `raw_materials`
--
ALTER TABLE `raw_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_member`
--
ALTER TABLE `user_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `weaver`
--
ALTER TABLE `weaver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
