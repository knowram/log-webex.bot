-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 10, 2020 at 11:11 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u264166153_bots`
--

-- --------------------------------------------------------

--
-- Table structure for table `logAnswer`
--

CREATE TABLE `logAnswer` (
  `id` int(11) NOT NULL,
  `logM_id` int(11) NOT NULL,
  `messageId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `files_URL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LogMemberships`
--

CREATE TABLE `LogMemberships` (
  `id` int(11) NOT NULL,
  `personId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spaceId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `logReply`
--

CREATE TABLE `logReply` (
  `id` int(11) NOT NULL,
  `logM_id` int(11) NOT NULL,
  `messageId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `files_URL` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- --------------------------------------------------------

--
-- Table structure for table `logTemp`
--

CREATE TABLE `logTemp` (
  `id` int(11) NOT NULL,
  `postUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_DB`
--

CREATE TABLE `log_DB` (
  `id` int(11) NOT NULL,
  `spaceId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `files_URL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logAnswer`
--
ALTER TABLE `logAnswer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LogMemberships`
--
ALTER TABLE `LogMemberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logReply`
--
ALTER TABLE `logReply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logTemp`
--
ALTER TABLE `logTemp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_DB`
--
ALTER TABLE `log_DB`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logAnswer`
--
ALTER TABLE `logAnswer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `LogMemberships`
--
ALTER TABLE `LogMemberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logReply`
--
ALTER TABLE `logReply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `logTemp`
--
ALTER TABLE `logTemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_DB`
--
ALTER TABLE `log_DB`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
