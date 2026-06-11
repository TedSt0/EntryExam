-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 01:33 PM
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
-- Database: `registration_entryexams`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `Candidates_ID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Major_ID` int(11) NOT NULL,
  `Exam_ID` int(11) NOT NULL,
  `PaymentMethod` enum('Visa','Mastercard','Bank_Transfer','Cash') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`Candidates_ID`, `FirstName`, `LastName`, `Email`, `Major_ID`, `Exam_ID`, `PaymentMethod`) VALUES
(3, 'Margarita', 'Martini', 'uwu_maggie@mail.ru', 4, 4, 'Bank_Transfer'),
(4, 'A', 'A', 'A@a.a', 2, 2, 'Visa'),
(5, 'b', 'n', 'bn@a.com', 2, 2, 'Bank_Transfer'),
(6, 'Konstantin', 'Belev', 'fhgdjs@mail.com', 3, 3, 'Mastercard'),
(7, 'l', 'l', 'l@l.cm', 2, 2, 'Visa'),
(8, 'afs', 'gfd', 'gdf@fsa.v', 3, 3, 'Visa'),
(9, 'adas', 'dass', 'asd@gb.vd', 3, 7, 'Bank_Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `entryexam`
--

CREATE TABLE `entryexam` (
  `Exam_ID` int(11) NOT NULL,
  `Major_ID` int(11) NOT NULL,
  `ExamName` varchar(255) NOT NULL,
  `ExamDate` date NOT NULL,
  `ExamTime` time NOT NULL,
  `ExamRoom` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `entryexam`
--

INSERT INTO `entryexam` (`Exam_ID`, `Major_ID`, `ExamName`, `ExamDate`, `ExamTime`, `ExamRoom`) VALUES
(1, 1, 'Advanced Mathematics and Problem Solving', '2026-06-15', '10:00:00', 113),
(2, 2, 'Mathematics and Computer Science Admissions Test (MAT)', '2026-06-19', '14:00:00', 431),
(3, 3, 'National Law Admissions Test (LNAT)', '2026-05-16', '11:04:00', 221),
(4, 4, 'SAT Subject Test in Mathematics', '2026-05-19', '12:00:00', 216),
(6, 1, 'Analytical and Algorithmic Thinking Test', '2026-07-08', '12:00:00', 121),
(7, 3, 'History and Civil Education', '2026-06-30', '13:00:00', 444),
(8, 5, 'Behavioral Sciences Aptitude Test', '2026-06-22', '10:00:00', 227);

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `Major_ID` int(11) NOT NULL,
  `Major` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`Major_ID`, `Major`) VALUES
(2, 'Computer Science'),
(3, 'Law'),
(4, 'Marketing'),
(5, 'Psychology'),
(1, 'Software Engineer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Admin_ID` int(11) NOT NULL,
  `Username` varchar(16) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Admin_ID`, `Username`, `Password`) VALUES
(2, 'Admin', '$2y$10$mdiHjfbx.nI6SYt4CNJZQOri5cJ0AjYI.7nIiBgSmOoCzgeRxKUDq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`Candidates_ID`),
  ADD KEY `Major_ID_FK_Constraint` (`Major_ID`),
  ADD KEY `Exam_ID_FK_Constraint` (`Exam_ID`);

--
-- Indexes for table `entryexam`
--
ALTER TABLE `entryexam`
  ADD PRIMARY KEY (`Exam_ID`),
  ADD UNIQUE KEY `unique_room` (`ExamDate`,`ExamRoom`),
  ADD KEY `MajorIdIndex` (`Major_ID`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`Major_ID`),
  ADD UNIQUE KEY `MajorIndex` (`Major`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD UNIQUE KEY `UniqueUsernameIndex` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `Candidates_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `entryexam`
--
ALTER TABLE `entryexam`
  MODIFY `Exam_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `Major_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `Exam_ID_FK_Constraint` FOREIGN KEY (`Exam_ID`) REFERENCES `entryexam` (`Exam_ID`),
  ADD CONSTRAINT `Major_ID_FK_Constraint` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`);

--
-- Constraints for table `entryexam`
--
ALTER TABLE `entryexam`
  ADD CONSTRAINT `MajorFKConstraint` FOREIGN KEY (`Major_ID`) REFERENCES `major` (`Major_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
