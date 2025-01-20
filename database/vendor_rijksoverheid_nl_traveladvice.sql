-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 20, 2025 at 01:53 PM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u10919p285003_see`
--

-- --------------------------------------------------------

--
-- Table structure for table `vendor_rijksoverheid_nl_traveladvice`
--

CREATE TABLE `vendor_rijksoverheid_nl_traveladvice` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL,
  `canonical` varchar(255) NOT NULL DEFAULT '',
  `dataurl` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `introduction` text NOT NULL,
  `location` varchar(255) NOT NULL DEFAULT '',
  `modificationdate` varchar(255) NOT NULL,
  `modifications` text NOT NULL,
  `authorities` varchar(255) NOT NULL,
  `creators` varchar(255) NOT NULL,
  `lastmodified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `issued` varchar(255) NOT NULL,
  `available` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL,
  `rightsholders` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vendor_rijksoverheid_nl_traveladvice`
--
ALTER TABLE `vendor_rijksoverheid_nl_traveladvice`
  ADD KEY `id` (`id`(250)),
  ADD KEY `location` (`location`(250));
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
