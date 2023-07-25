-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2022 at 11:45 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: user_manager
--

-- --------------------------------------------------------

--
-- Table structure for table `login_token`
--

CREATE TABLE `login_token` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotToken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activeToken` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `lastActivity` datetime DEFAULT NULL,
  `createAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `phone`, `password`, `forgotToken`, `activeToken`, `status`, `lastActivity`, `createAt`, `updateAt`) VALUES
(5, 'hoangan.web@gmail.com', 'Tạ Hoàng An', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 1, '2021-07-09 16:59:39', '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(6, 'hoanganit19@gmail.com', 'Hoàng An Unicode', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 1, '2021-07-09 17:02:08', '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(7, 'nguyenvana@gmail.com', 'Nguyễn Văn A', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 1, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(8, 'nguyenvanb@gmail.com', 'Nguyễn Văn B', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(9, 'nguyenvanc@gmail.com', 'Nguyễn Văn C', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(10, 'nguyenvand@gmail.com', 'Nguyễn Văn D', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 1, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(11, 'nguyenvane@gmail.com', 'Nguyễn Văn E', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(12, 'nguyenvanf@gmail.com', 'Nguyễn Văn F', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(13, 'nguyenvan1@gmail.com', 'Nguyễn Văn 1', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 1, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(14, 'nguyenvan2@gmail.com', 'Nguyễn Văn 2', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(15, 'nguyenvan3@gmail.com', 'Nguyễn Văn 3', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(16, 'nguyenvan4@gmail.com', 'Nguyễn Văn 4', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 1, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(17, 'nguyenvan5@gmail.com', 'Nguyễn Văn 5', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-07 04:47:22', '2021-07-07 07:18:33'),
(18, 'nguyenvan6@gmail.com', 'Nguyễn Văn 6', '0388875179', '$2y$10$tTk81Q/WCmCEb8IJCRodZORKVjPusacNN3Ov7rtdptQ3RDTcY/m.q', NULL, NULL, 0, NULL, '2021-07-09 04:47:22', '2021-07-07 07:18:33'),
(19, 'nguyenvan7@gmail.com', 'Nguyễn Văn 7', '0388875179', '$2y$10$54UzBDKC2ryipaMhm5Jsb.fIN5vxpmJ.m.g0Zb.G6ysCa6s/fazkm', NULL, NULL, 0, NULL, '2021-07-09 07:12:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_token`
--
ALTER TABLE `login_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_token`
--
ALTER TABLE `login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_token`
--
ALTER TABLE `login_token`
  ADD CONSTRAINT `login_token_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
