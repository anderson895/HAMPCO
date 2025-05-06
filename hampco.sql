-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 01:51 PM
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
  `rm_quantity` int(11) NOT NULL,
  `rm_status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, '111111', 'alden  padilla', 'sample@gmail.com', '09454454741', 'knotter', 'male', '$2y$10$ykHUkxTH2qycU7.vNuruAeOHakOHmEN/cAJmnz/X2cxqO34tCYXUK', '2025-05-05 04:13:48', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_member`
--
ALTER TABLE `user_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `weaver`
--
ALTER TABLE `weaver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
