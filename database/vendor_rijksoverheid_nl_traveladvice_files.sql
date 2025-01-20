-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 20, 2025 at 01:54 PM
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
-- Table structure for table `vendor_rijksoverheid_nl_traveladvice_files`
--

CREATE TABLE `vendor_rijksoverheid_nl_traveladvice_files` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` varchar(255) NOT NULL DEFAULT '',
  `fileurl` varchar(255) DEFAULT NULL,
  `mimetype` varchar(255) DEFAULT NULL,
  `filesize` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filetitle` varchar(255) DEFAULT NULL,
  `filedescription` varchar(255) DEFAULT NULL,
  `filemodifieddate` varchar(255) DEFAULT NULL,
  `maptype` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vendor_rijksoverheid_nl_traveladvice_files`
--
ALTER TABLE `vendor_rijksoverheid_nl_traveladvice_files`
  ADD KEY `id` (`id`(250));
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
