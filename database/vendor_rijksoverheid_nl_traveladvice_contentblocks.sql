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
-- Table structure for table `vendor_rijksoverheid_nl_traveladvice_contentblocks`
--

CREATE TABLE `vendor_rijksoverheid_nl_traveladvice_contentblocks` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `id` varchar(255) NOT NULL DEFAULT '',
  `paragraph` text NOT NULL,
  `paragraphtitle` varchar(255) NOT NULL DEFAULT '',
  `sequence` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vendor_rijksoverheid_nl_traveladvice_contentblocks`
--
ALTER TABLE `vendor_rijksoverheid_nl_traveladvice_contentblocks`
  ADD KEY `id` (`id`(250));
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
