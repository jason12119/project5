-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 08, 2021 at 05:30 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project5`
--

-- --------------------------------------------------------

--
-- Table structure for table `project5_customers`
--

CREATE TABLE `project5_customers` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `heslo` varchar(100) NOT NULL,
  `jmeno` varchar(100) NOT NULL,
  `prijmeni` int(100) NOT NULL,
  `narozeni` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project5_kosiky`
--

CREATE TABLE `project5_kosiky` (
  `id` int(11) NOT NULL,
  `kosik_id` varchar(100) NOT NULL,
  `produkt_id` int(11) NOT NULL,
  `mnozstvi` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project5_kosiky`
--

INSERT INTO `project5_kosiky` (`id`, `kosik_id`, `produkt_id`, `mnozstvi`) VALUES
(161, '6155ca2047f212.17605418', 1, 1),
(162, '6155ca2047f212.17605418', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project5_produkty`
--

CREATE TABLE `project5_produkty` (
  `id` int(11) NOT NULL,
  `nazev` varchar(100) NOT NULL,
  `perex` varchar(200) NOT NULL,
  `cena` float NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project5_produkty`
--

INSERT INTO `project5_produkty` (`id`, `nazev`, `perex`, `cena`, `img`) VALUES
(1, 'Mapex Horizon Blue Sparkle', 'Lipová bicí souprava pro začátečníky', 15600, 'horizon-blue.jpg'),
(2, 'Fender Stratocaster', 'Kytarová klasika pro fajnšmekry', 30999, 'fender.jpg'),
(3, 'Fender Jazz Bass', 'Baskytarová legenda která neomrzí ', 14600, 'jazzbass.jpg'),
(4, 'Shure SM57', 'Léty ověřený univerzální mikrofon ', 3600, 'shure.jpg'),
(5, 'Sonor Benny Greb Signature', 'Jeden z nejlepších bubnů na trhu', 18299, 'benny.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project5_customers`
--
ALTER TABLE `project5_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project5_kosiky`
--
ALTER TABLE `project5_kosiky`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project5_produkty`
--
ALTER TABLE `project5_produkty`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project5_customers`
--
ALTER TABLE `project5_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project5_kosiky`
--
ALTER TABLE `project5_kosiky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `project5_produkty`
--
ALTER TABLE `project5_produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
