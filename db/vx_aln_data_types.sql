-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2019 at 02:36 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `valuex`
--

-- --------------------------------------------------------

--
-- Table structure for table `vx_aln_data_types`
--

CREATE TABLE `vx_aln_data_types` (
  `vx_aln_data_typeID` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vx_aln_data_types`
--

INSERT INTO `vx_aln_data_types` (`vx_aln_data_typeID`, `name`, `create_userID`, `modify_userID`, `active`, `create_date`, `modify_date`) VALUES
(1, 'aln_master_airport', 1, 1, 1, 1554788423, 1554788423),
(2, 'aln_master_country', 1, 1, 1, 1554788423, 1554788423),
(3, 'aln_master_state', 1, 1, 1, 1554788423, 1554788423),
(4, 'aln_master_region', 1, 1, 1, 1554788423, 1554788423),
(5, 'aln_master_area', 1, 1, 1, 1554788423, 1554788423);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vx_aln_data_types`
--
ALTER TABLE `vx_aln_data_types`
  ADD PRIMARY KEY (`vx_aln_data_typeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vx_aln_data_types`
--
ALTER TABLE `vx_aln_data_types`
  MODIFY `vx_aln_data_typeID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
