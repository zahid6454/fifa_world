-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2022 at 04:03 AM
-- Server version: 10.3.25-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pointerr_fifaworld`
--

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE `club` (
  `club_logo` varchar(200) NOT NULL,
  `club_id` char(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(20) DEFAULT NULL,
  `founded` varchar(20) NOT NULL,
  `stadium` varchar(20) DEFAULT NULL,
  `league` varchar(20) DEFAULT NULL,
  `budget` int(10) NOT NULL,
  `manager_status` varchar(11) NOT NULL,
  `manager_salary` int(10) NOT NULL,
  `scout_salary` int(10) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`club_logo`, `club_id`, `name`, `city`, `country`, `founded`, `stadium`, `league`, `budget`, `manager_status`, `manager_salary`, `scout_salary`, `point`) VALUES
('real_madrid.jpg', '00000', 'Real Madrid FC', 'Madrid', 'Spain', '1902', 'Santiago Bernabeu', 'Champions League', 122800000, 'available', 80000, 0, 50),
('barcelona.jpg', '00001', 'FC Barcelona', 'Barcelona', 'Spain', '1899', ' Camp Nou', 'Champions League', 29000000, 'available', 70000, 0, 45),
('manchester_unitd.jpg', '00002', 'Manchester United', 'Manchester ', 'United Kingdom', '1878', ' Old Trafford', 'Champions League', 102600000, 'unavailable', 50000, 0, 30),
('bayern_munich.jpg', '00003', 'Bayern Munich', 'Munich', 'Germany', '1900', 'Allianz Arena', 'Champions League', 105220000, 'unavailable', 62000, 0, 39),
('chelsea.jpg', '00004', 'F.C. Chelsea', 'Chelsea', 'United Kingdom', '1905', 'Stamford Bridge', 'Champions League', 5100000, 'available', 55000, 0, 35);

-- --------------------------------------------------------

--
-- Table structure for table `club_request`
--

CREATE TABLE `club_request` (
  `id` int(5) NOT NULL,
  `club_id` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `manager_id` int(5) NOT NULL,
  `club_id` char(5) DEFAULT NULL,
  `contract` date DEFAULT NULL,
  `salary` int(5) DEFAULT NULL,
  `picture` varchar(500) NOT NULL,
  `club_status` varchar(15) NOT NULL,
  `leave_wish` varchar(3) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`manager_id`, `club_id`, `contract`, `salary`, `picture`, `club_status`, `leave_wish`, `point`) VALUES
(39, '00000', NULL, 80000, '', 'available', 'yes', 14),
(51, NULL, NULL, NULL, '', 'unavailable', '', 3),
(53, '00004', NULL, 55000, '', 'available', '', 12),
(127, '00001', NULL, 70000, '', 'available', '', 2),
(128, NULL, NULL, NULL, '', 'unavailable', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `manager_history`
--

CREATE TABLE `manager_history` (
  `manager_id` int(5) NOT NULL,
  `club_id` char(5) NOT NULL,
  `joining_date` date DEFAULT NULL,
  `leave_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager_history`
--

INSERT INTO `manager_history` (`manager_id`, `club_id`, `joining_date`, `leave_date`) VALUES
(39, '00000', '2017-04-21', '2017-04-21'),
(39, '00000', '2017-04-21', '2017-04-21'),
(39, '00003', '2017-04-21', '2017-04-21'),
(39, '00000', '2017-04-21', '2017-04-21'),
(39, '00000', '2017-04-21', '2017-04-21'),
(39, '00000', '2017-04-21', '2017-04-24'),
(127, '00001', '2017-04-22', '2018-05-19'),
(39, '00000', '2017-04-24', '2017-04-24'),
(39, '00000', '2017-04-24', '2017-04-25'),
(39, '00000', '2017-04-25', '2017-04-25'),
(39, '00000', '2017-04-25', '2017-04-25'),
(39, '00000', '2017-04-25', NULL),
(127, '00001', '2018-05-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(5) NOT NULL,
  `club_id` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_id`, `club_id`) VALUES
(32, '00000'),
(37, '00001'),
(54, '00002'),
(125, '00003'),
(126, '00004');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(5) NOT NULL,
  `type` varchar(10) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `name` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `address` varchar(40) NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `mail` varchar(30) NOT NULL,
  `country` varchar(20) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `type`, `picture`, `name`, `DOB`, `address`, `city`, `mail`, `country`, `username`, `password`) VALUES
(32, 'Owner', '', 'Owner1', '2017-04-12', 'UIU', 'Dhaka', 'owner1@gmail.com', 'Bangladesh', 'owner1', '1234'),
(37, 'Owner', '', 'Owner2', '2017-04-06', 'UIU', 'Dhaka', 'owner2@gmail.com', 'Bangladesh', 'owner2', '1234'),
(39, 'Manager', '', 'SAIF AHMED ANIK', '1994-04-20', 'UIU', 'Dhaka', 'saif@gmail.com', 'Bangladesh', 'saif43', '1234'),
(51, 'Manager', '', 'Saimoon', '2004-04-05', 'UIU', 'Dhaka', 'saimoon@gmail.com', 'Bangladesh', 'saimoon', '1234'),
(53, 'Manager', '', 'Piya', '2004-04-05', 'UIU', 'Dhaka', 'piya@gmail.com', 'Bangladesh', 'piya', '1234'),
(54, 'Owner', '', 'owner3', '2017-04-06', 'UIU', 'Dhaka', 'owner3@gmail.com', 'Bangladesh', 'owner3', '1234'),
(58, 'Player', 'pictures\\real madrid\\ronaldo.jpg', 'Christiano Ronaldo', '1985-02-05', '', NULL, 'ronaldo@gmail.com', 'Portugal', '', ''),
(59, 'Player', 'pictures\\real madrid\\lewandowski.jpg', 'Lewandowski', '1988-02-05', '', NULL, 'lewandeski@gmail.com', 'Portugal', '', ''),
(61, 'Player', 'pictures\\real madrid\\bale.jpg', 'Bale', '1987-02-05', '', NULL, 'bale@gmail.com', 'United Kingdom', '', ''),
(62, 'Player', 'pictures\\real madrid\\rodriguez.jpg', 'Rodriguez', '1991-02-05', '', NULL, 'james@gmail.com', 'Colombia', '', ''),
(63, 'Player', 'pictures\\real madrid\\kroos.jpg', 'Kroos', '1990-02-05', '', NULL, 'kroos@gmail.com', 'Germany', '', ''),
(64, 'Player', 'pictures\\real madrid\\modric.jpg', 'Modric', '1985-02-05', '', NULL, 'modric@gmail.com', 'Coratia', '', ''),
(65, 'Player', 'pictures\\real madrid\\marcelo.jpg', 'Marcelo', '1984-02-05', '', NULL, 'marcelo@gmail.com', 'Brazil', '', ''),
(66, 'Player', 'pictures\\real madrid\\ramos.jpg', 'Ramos', '1983-02-05', '', NULL, 'ramos@gmail.com', 'Spain', '', ''),
(67, 'Player', 'pictures\\real madrid\\pepe.jpg', 'Pepe', '1985-02-05', '', NULL, 'pepe@gmail.com', 'Brazil', '', ''),
(68, 'Player', 'pictures\\real madrid\\carvajal.jpg', 'Carvajal', '1991-02-05', '', NULL, 'carvajal@gmail.com', 'Spain', '', ''),
(69, 'Player', 'pictures\\real madrid\\navas.jpg', 'Navas', '1986-02-05', '', NULL, 'navas@gmail.com', 'Costa Rica', '', ''),
(70, 'Player', 'pictures\\barcelona\\neymar.jpg', 'Neymar', '1992-02-05', '', NULL, 'neymar@gmail.com', 'Brazil', '', ''),
(71, 'Player', 'pictures\\barcelona\\suarez.jpg', 'Suarez', '1987-02-05', '', NULL, 'suarez@gmail.com', 'Uruguay', '', ''),
(72, 'Player', 'pictures\\barcelona\\messi.jpg', 'Messi', '1987-02-05', '', NULL, 'messi@gmail.com', 'Argentina', '', ''),
(73, 'Player', 'pictures\\barcelona\\iniesta.jpg', 'Iniesta', '1985-02-05', '', NULL, 'iniesta@gmail.com', 'Spain', '', ''),
(74, 'Player', 'pictures\\barcelona\\rakitic.jpg', 'Rakitic', '1988-02-05', '', NULL, 'rakitic@gmail.com', 'Switzerland', '', ''),
(75, 'Player', 'pictures\\barcelona\\sergio.jpg', 'Sergio', '1987-02-05', '', NULL, 'sergio@gmail.com', 'Spain', '', ''),
(76, 'Player', 'pictures\\barcelona\\alba.jpg', 'Alba', '1989-02-05', '', NULL, 'alba@gmail.com', 'Spain', '', ''),
(77, 'Player', 'pictures\\barcelona\\alves.jpg', 'Dani Alves', '1986-02-05', '', NULL, 'alves@gmail.com', 'Brazil', '', ''),
(78, 'Player', 'pictures\\barcelona\\aymeric.jpg', 'Aymeric', '1988-02-05', '', NULL, 'aymeric@gmail.com', 'Spain', '', ''),
(79, 'Player', 'pictures\\barcelona\\pique.jpg', 'Pique', '1991-02-05', '', NULL, 'pique@gmail.com', 'Spain', '', ''),
(80, 'Player', 'pictures\\barcelona\\bravo.jpg', 'Bravo', '1991-02-05', '', NULL, 'bravo@gmail.com', 'Viluco', '', ''),
(81, 'Player', 'pictures\\manu\\martial.jpg', 'Martial', '1995-02-05', '', NULL, 'martial@gmail.com', 'France', '', ''),
(82, 'Player', 'pictures\\manu\\cavani.jpg', 'cavani', '1987-02-05', '', NULL, 'cavani@gmail.com', 'Uruguay', '', ''),
(83, 'Player', 'pictures\\manu\\depay.jpg', 'Depay', '1987-02-05', '', NULL, 'depay@gmail.com', 'Argentina', '', ''),
(84, 'Player', 'pictures\\manu\\herrera.jpg', 'Herrera', '1985-02-05', '', NULL, 'herrera@gmail.com', 'Spain', '', ''),
(85, 'Player', 'pictures\\manu\\pjanic.jpg', 'Pjanic', '1988-02-05', '', NULL, 'pjanic@gmail.com', 'Switzerland', '', ''),
(86, 'Player', 'pictures\\manu\\reus.jpg', 'Reus', '1987-02-05', '', NULL, 'reus@gmail.com', 'Spain', '', ''),
(87, 'Player', 'pictures\\manu\\mata.jpg', 'Juan Mata', '1989-02-05', '', NULL, 'mata@gmail.com', 'Spain', '', ''),
(88, 'Player', 'pictures\\manu\\blind.jpg', 'Blind', '1986-02-05', '', NULL, 'blind@gmail.com', 'Brazil', '', ''),
(89, 'Player', 'pictures\\manu\\hummels.jpg', 'Hummels', '1988-02-05', '', NULL, 'hummels@gmail.com', 'Germany', '', ''),
(90, 'Player', 'pictures\\manu\\darmian.jpg', 'Darmian', '1991-02-05', '', NULL, 'darmian@gmail.com', 'Uruguay', '', ''),
(91, 'Player', 'pictures\\manu\\gea.jpg', 'De gea', '1991-02-05', '', NULL, 'degea@gmail.com', 'Spain', '', ''),
(103, 'Player', 'pictures\\bayern munich\\muller.jpg', 'Muller', '1995-02-05', '', NULL, 'muller@gmail.com', 'Germany', '', ''),
(104, 'Player', 'pictures\\bayern munich\\costa.jpg', 'Costa', '1987-02-05', '', NULL, 'costa@gmail.com', 'Costa Rica', '', ''),
(105, 'Player', 'pictures\\bayern munich\\robben.jpg', 'Robben', '1987-02-05', '', NULL, 'robben@gmail.com', 'Netharland', '', ''),
(106, 'Player', 'pictures\\bayern munich\\thiago.jpg', 'Thiago', '1985-02-05', '', NULL, 'thiago@gmail.com', 'United Kingdom', '', ''),
(107, 'Player', 'pictures\\bayern munich\\sanches.jpg', 'Sanches', '1988-02-05', '', NULL, 'sanches@gmail.com', 'Argentina', '', ''),
(108, 'Player', 'pictures\\bayern munich\\vidal.jpg', 'Vidal', '1987-02-05', '', NULL, 'vidal@gmail.com', 'Chile', '', ''),
(109, 'Player', 'pictures\\bayern munich\\ribery.jpg', 'Ribery', '1989-02-05', '', NULL, 'Ribery@gmail.com', 'Netharland', '', ''),
(110, 'Player', 'pictures\\bayern munich\\lahm.jpg', 'Lahm', '1986-02-05', '', NULL, 'lahm@gmail.com', 'Germany', '', ''),
(111, 'Player', 'pictures\\bayern munich\\hummels.jpg', 'Mats Hummels', '1988-02-05', '', NULL, 'matshummels@gmail.com', 'Germany', '', ''),
(112, 'Player', 'pictures\\bayern munich\\boateng.jpg', 'Boateng', '1991-02-05', '', NULL, 'boateng@gmail.com', 'Uruguay', '', ''),
(113, 'Player', 'pictures\\bayern munich\\neuer.jpg', 'Neuer', '1991-02-05', '', NULL, 'neuer@gmail.com', 'Germany', '', ''),
(114, 'Player', 'pictures\\chelsea\\lukaku.jpg', 'Lukaku', '1995-02-05', '', NULL, 'lukaku@gmail.com', 'Germany', '', ''),
(115, 'Player', 'pictures\\chelsea\\costa.jpg', 'Costa', '1987-02-05', '', NULL, 'costa@gmail.com', 'France', '', ''),
(116, 'Player', 'pictures\\chelsea\\fabregas.jpg', 'Fabregas', '1987-02-05', '', NULL, 'fabregas@gmail.com', 'Netharland', '', ''),
(117, 'Player', 'pictures\\chelsea\\hazard.jpg', 'Hazard', '1985-02-05', '', NULL, 'thiago@gmail.com', 'Belgium', '', ''),
(118, 'Player', 'pictures\\chelsea\\willian.jpg', 'Willian', '1988-02-05', '', NULL, 'willian@gmail.com', 'Argentina', '', ''),
(119, 'Player', 'pictures\\chelsea\\luiz.jpg', 'David Luiz', '1987-02-05', '', NULL, 'luiz@gmail.com', 'Brazil', '', ''),
(120, 'Player', 'pictures\\chelsea\\matic.jpg', 'Matic', '1989-02-05', '', NULL, 'matic@gmail.com', 'Spain', '', ''),
(121, 'Player', 'pictures\\chelsea\\cahill.jpg', 'Cahill', '1986-02-05', '', NULL, 'cahill@gmail.com', 'Brazil', '', ''),
(122, 'Player', 'pictures\\chelsea\\terry.jpg', 'John Terry', '1988-02-05', '', NULL, 'terry@gmail.com', 'Germany', '', ''),
(123, 'Player', 'pictures\\chelsea\\zouma.jpg', 'Zouma', '1991-02-05', '', NULL, 'zouma@gmail.com', 'Uruguay', '', ''),
(124, 'Player', 'pictures\\chelsea\\courtois.jpg', 'Courtois', '1991-02-05', '', NULL, 'courtois@gmail.com', 'Germany', '', ''),
(125, 'Owner', '', 'owner4', '1970-05-21', 'uiu', 'Dhaka', 'owner4@gmail.com', 'Bangladesh', 'owner4', '1234'),
(126, 'Owner', '', 'owner5', '1970-05-21', 'uiu', 'Dhaka', 'owner5@gmail.com', 'Bangladesh', 'owner5', '1234'),
(127, 'Manager', '', 'zahid', '2004-02-22', 'UIU', 'Dhaka', 'zahid@gmail.com', 'Bangladesh', 'zahid', '1234'),
(128, 'Manager', '', 'test', '2001-01-01', 'test', 'test', 'test@gmail.com', 'Afghanistan', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `player_id` int(5) NOT NULL,
  `club_id` char(5) DEFAULT NULL,
  `position` varchar(5) NOT NULL,
  `speed` int(2) NOT NULL,
  `passing` int(2) NOT NULL,
  `control` int(2) NOT NULL,
  `power` int(2) NOT NULL,
  `stamina` int(2) NOT NULL,
  `strength` int(2) NOT NULL,
  `jersey_no` int(3) NOT NULL,
  `squad_status` varchar(20) NOT NULL,
  `contract` date DEFAULT NULL,
  `salary` int(5) DEFAULT NULL,
  `transfer_price` int(10) NOT NULL,
  `max_bidding_price` int(10) NOT NULL,
  `transfer_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`player_id`, `club_id`, `position`, `speed`, `passing`, `control`, `power`, `stamina`, `strength`, `jersey_no`, `squad_status`, `contract`, `salary`, `transfer_price`, `max_bidding_price`, `transfer_status`) VALUES
(58, '00002', 'LWF', 90, 98, 92, 91, 93, 97, 0, 'reserved', '2017-04-17', 100000, 100000000, 100000000, 'available'),
(59, '00000', 'ST', 90, 98, 92, 91, 93, 97, 0, 'Running', '2017-04-17', 60000, 5000000, 5000000, 'unavailable'),
(61, '00001', 'CAM', 90, 98, 92, 91, 93, 97, 0, 'Running', '2017-04-17', 100000, 20, 20, 'unavailable'),
(62, '00000', 'RWF', 90, 98, 92, 91, 93, 97, 9, 'Substitute', '2017-04-17', 100000, 200000, 200000, 'available'),
(63, '00000', 'CM', 90, 98, 92, 91, 93, 97, 11, 'running', '2017-04-17', 100000, 8000000, 8000000, 'available'),
(64, '00000', 'CM', 90, 98, 92, 91, 93, 97, 6, 'running', '2017-04-17', 100000, 6000000, 6000000, 'available'),
(65, '00000', 'LB', 90, 98, 92, 91, 93, 97, 5, 'running', '2017-04-17', 100000, 900000, 900000, 'available'),
(66, '00000', 'LCB', 90, 98, 92, 91, 93, 97, 3, 'running', '2017-04-17', 100000, 4000000, 4000000, 'unavailable'),
(67, '00001', 'RCB', 90, 98, 92, 91, 93, 97, 0, 'Running', '2017-04-17', 100000, 2200000, 2200000, 'available'),
(68, '00000', 'RB', 90, 98, 92, 91, 93, 97, 4, 'running', '2017-04-17', 100000, 500000, 500000, 'available'),
(69, '00000', 'GK', 90, 98, 92, 91, 93, 97, 1, 'running', '2017-04-17', 100000, 7000000, 7000000, 'available'),
(70, '00001', 'ST', 90, 98, 92, 91, 93, 97, 0, 'Running', '2017-04-17', 100000, 2147483647, 2147483647, 'available'),
(71, '00001', 'ST', 90, 98, 92, 91, 93, 97, 10, 'running', '2017-04-17', 100000, 4000000, 4000000, 'available'),
(72, '00001', 'CAM', 90, 98, 92, 91, 93, 97, 8, 'running', '2017-04-17', 100000, 5000000, 5000000, 'available'),
(73, '00001', 'RWF', 90, 98, 92, 91, 93, 97, 9, 'running', '2017-04-17', 100000, 8000000, 8000000, 'available'),
(74, '00001', 'CM', 90, 98, 92, 91, 93, 97, 11, 'running', '2017-04-17', 100000, 10000000, 10000000, 'unavailable'),
(75, '00001', 'CM', 90, 98, 92, 91, 93, 97, 6, 'running', '2017-04-17', 100000, 1000000, 1000000, 'available'),
(76, '00001', 'LB', 90, 98, 92, 91, 93, 97, 5, 'running', '2017-04-17', 100000, 2000000, 2000000, 'available'),
(77, '00001', 'LCB', 90, 98, 92, 91, 93, 97, 3, 'running', '2017-04-17', 100000, 3000000, 3000000, 'available'),
(78, '00001', 'RCB', 90, 98, 92, 91, 93, 97, 2, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(79, '00001', 'RB', 90, 98, 92, 91, 93, 97, 4, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(80, '00001', 'GK', 90, 98, 92, 91, 93, 97, 1, 'running', '2017-04-17', 100000, 4000000, 4000000, 'available'),
(81, '00002', 'ST', 90, 98, 92, 91, 93, 97, 7, 'running', '2017-04-17', 100000, 6000000, 6000000, 'available'),
(82, '00002', 'ST', 90, 98, 92, 91, 93, 97, 0, 'reserved', '2017-04-17', 100000, 90000000, 90000000, 'available'),
(83, '00002', 'CAM', 90, 98, 92, 91, 93, 97, 8, 'running', '2017-04-17', 100000, 5000000, 5000000, 'available'),
(84, '00002', 'RWF', 90, 98, 92, 91, 93, 97, 9, 'running', '2017-04-17', 100000, 9000000, 9000000, 'available'),
(85, '00002', 'CM', 90, 98, 92, 91, 93, 97, 11, 'running', '2017-04-17', 100000, 6100000, 6100000, 'available'),
(86, '00002', 'CM', 90, 98, 92, 91, 93, 97, 6, 'running', '2017-04-17', 100000, 7000000, 7000000, 'available'),
(87, '00002', 'LB', 90, 98, 92, 91, 93, 97, 5, 'running', '2017-04-17', 100000, 60000000, 60000000, 'available'),
(88, '00002', 'LCB', 90, 98, 92, 91, 93, 97, 3, 'running', '2017-04-17', 100000, 8000000, 8000000, 'available'),
(89, '00002', 'RCB', 90, 98, 92, 91, 93, 97, 2, 'running', '2017-04-17', 100000, 25000000, 25000000, 'available'),
(90, '00002', 'RB', 90, 98, 92, 91, 93, 97, 4, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(91, '00002', 'GK', 90, 98, 92, 91, 93, 97, 1, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(103, '00003', 'ST', 90, 98, 92, 91, 93, 97, 7, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(104, '00003', 'ST', 90, 98, 92, 91, 93, 97, 10, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(105, '00003', 'CAM', 90, 98, 92, 91, 93, 97, 8, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(106, '00003', 'RWF', 90, 98, 92, 91, 93, 97, 9, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(107, '00003', 'CM', 90, 98, 92, 91, 93, 97, 11, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(108, '00003', 'CM', 90, 98, 92, 91, 93, 97, 6, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(109, '00003', 'RWF', 90, 98, 92, 91, 93, 97, 5, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(110, '00003', 'LCB', 90, 98, 92, 91, 93, 97, 3, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(111, '00003', 'RCB', 90, 98, 92, 91, 93, 97, 2, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(112, '00003', 'RB', 90, 98, 92, 91, 93, 97, 4, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(113, '00003', 'GK', 90, 98, 92, 91, 93, 97, 1, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(114, '00004', 'ST', 90, 98, 92, 91, 93, 97, 0, 'reserved', '2017-04-17', 100000, 100000, 100000, 'unavailable'),
(115, '00004', 'CF', 90, 98, 92, 91, 93, 97, 10, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(116, '00004', 'CAM', 90, 98, 92, 91, 93, 97, 8, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(117, '00004', 'RWF', 90, 98, 92, 91, 93, 97, 9, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(118, '00004', 'CM', 90, 98, 92, 91, 93, 97, 11, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(119, '00004', 'CM', 90, 98, 92, 91, 93, 97, 6, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(120, '00004', 'LB', 90, 98, 92, 91, 93, 97, 5, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(121, '00004', 'LCB', 90, 98, 92, 91, 93, 97, 3, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(122, '00004', 'RCB', 90, 98, 92, 91, 93, 97, 2, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(123, '00004', 'RB', 90, 98, 92, 91, 93, 97, 4, 'running', '2017-04-17', 100000, 5000000, 0, 'unavailable'),
(124, '00004', 'GK', 90, 98, 92, 91, 93, 97, 1, 'running', '2017-04-17', 100000, 1000000, 1000000, 'unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `player_history`
--

CREATE TABLE `player_history` (
  `player_id` int(5) NOT NULL,
  `club_id` char(5) NOT NULL,
  `joining_date` date DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `transfer_price` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player_history`
--

INSERT INTO `player_history` (`player_id`, `club_id`, `joining_date`, `leave_date`, `transfer_price`) VALUES
(114, '00000', '2017-04-21', '2017-04-21', 5000000),
(114, '00004', '2017-04-21', NULL, 100000),
(58, '00004', '2017-04-21', '2017-04-21', 500000),
(58, '00002', '2017-04-21', '2017-04-25', 200000),
(59, '00001', '2017-04-24', '2017-04-24', 1500000),
(59, '00000', '2017-04-24', NULL, 2500000),
(61, '00001', '2017-04-24', NULL, 7000000),
(58, '00000', '2017-04-25', '2017-04-25', 100000),
(58, '00002', '2017-04-25', NULL, 300000);

-- --------------------------------------------------------

--
-- Table structure for table `scout`
--

CREATE TABLE `scout` (
  `scout_id` int(5) NOT NULL,
  `club_id` char(5) DEFAULT NULL,
  `contract` date DEFAULT NULL,
  `salary` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `player_id` int(5) NOT NULL,
  `buyer_club_id` char(5) NOT NULL,
  `transfer_price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`player_id`, `buyer_club_id`, `transfer_price`) VALUES
(62, '00001', 200000),
(67, '00000', 2200000),
(69, '00001', 7000000),
(70, '00000', 3000000),
(71, '00000', 4000000),
(72, '00000', 5000000),
(76, '00000', 2000000),
(81, '00001', 6000000),
(84, '00001', 9000000),
(86, '00000', 7000000),
(87, '00000', 60000000),
(89, '00000', 25000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`club_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `name_2` (`name`),
  ADD UNIQUE KEY `name_3` (`name`);

--
-- Indexes for table `club_request`
--
ALTER TABLE `club_request`
  ADD PRIMARY KEY (`id`,`club_id`),
  ADD KEY `id` (`id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `manager_history`
--
ALTER TABLE `manager_history`
  ADD KEY `manager_id` (`manager_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`player_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `player_history`
--
ALTER TABLE `player_history`
  ADD KEY `player_id` (`player_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `scout`
--
ALTER TABLE `scout`
  ADD PRIMARY KEY (`scout_id`),
  ADD KEY `club_id` (`club_id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`player_id`,`buyer_club_id`),
  ADD KEY `club_id` (`buyer_club_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `club_request`
--
ALTER TABLE `club_request`
  ADD CONSTRAINT `club_request_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`),
  ADD CONSTRAINT `club_request_ibfk_3` FOREIGN KEY (`id`) REFERENCES `person` (`id`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `manager_history`
--
ALTER TABLE `manager_history`
  ADD CONSTRAINT `manager_history_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`),
  ADD CONSTRAINT `manager_history_ibfk_3` FOREIGN KEY (`manager_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `owner`
--
ALTER TABLE `owner`
  ADD CONSTRAINT `owner_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `owner_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`);

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `player_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`),
  ADD CONSTRAINT `player_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `person` (`id`);

--
-- Constraints for table `player_history`
--
ALTER TABLE `player_history`
  ADD CONSTRAINT `player_history_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`);

--
-- Constraints for table `scout`
--
ALTER TABLE `scout`
  ADD CONSTRAINT `scout_ibfk_1` FOREIGN KEY (`scout_id`) REFERENCES `person` (`id`),
  ADD CONSTRAINT `scout_ibfk_2` FOREIGN KEY (`club_id`) REFERENCES `club` (`club_id`);

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `transfer_ibfk_2` FOREIGN KEY (`buyer_club_id`) REFERENCES `club` (`club_id`),
  ADD CONSTRAINT `transfer_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `person` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
