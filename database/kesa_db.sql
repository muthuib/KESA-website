-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 05:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kesa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `ID` int(11) NOT NULL,
  `CERTIFICATE_NUMBER` varchar(255) NOT NULL,
  `ISSUED_DATE` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `ID` int(11) NOT NULL,
  `FIRST_NAME` varchar(255) NOT NULL,
  `LAST_NAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `STATUS` varchar(50) NOT NULL,
  `COURSE` varchar(255) DEFAULT NULL,
  `UNIVERSITY` varchar(255) DEFAULT NULL,
  `KESA_CERTIFICATE_NUMBER` varchar(255) DEFAULT NULL,
  `REASON` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  `EVENT_DATE` date NOT NULL,
  `CREATED_BY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `ID` int(11) NOT NULL,
  `COMPANY_NAME` varchar(255) NOT NULL,
  `REGISTRATION_NUMBER` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PHONE_NUMBER` varchar(20) NOT NULL,
  `PHYSICAL_ADDRESS` text NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `REASON` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `ID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `FILE_PATH` varchar(255) NOT NULL,
  `PRICE` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD_HASH` varchar(255) NOT NULL,
  `ROLE` enum('STUDENT','INSTRUCTOR','ADMIN','ALUMNI') DEFAULT 'STUDENT',
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `EMAIL`, `PASSWORD_HASH`, `ROLE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 'muthuib', 'benmuthui98@gmail.com', '$2y$10$U7YKzu6MFc7pSnqoFeZNF.crpLUYba7J1nMwH43mbvDuq91vvntwe', 'STUDENT', '2024-11-16 07:45:34', '2024-11-16 07:45:34'),
(4, 'muthui', 'muthuib220@gmail.com', '$2y$10$x9PvjN1pAgfUR4pKDWxtzuPgtgRfvQJDwZvq.YfbjeA167jjcTPL2', 'STUDENT', '2024-11-17 12:11:52', '2024-11-17 12:11:52'),
(5, 'muthuibb', 'bonfacelingwa@gmail.com', '$2y$10$NLy1rSlvpMDuG1qMn24sr.7aj1YjTvwPRrX60EVlBqf1WmQ2XHC/O', 'STUDENT', '2024-11-18 14:45:52', '2024-11-18 14:45:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CERTIFICATE_NUMBER` (`CERTIFICATE_NUMBER`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CREATED_BY` (`CREATED_BY`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `REGISTRATION_NUMBER` (`REGISTRATION_NUMBER`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`CREATED_BY`) REFERENCES `members` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
