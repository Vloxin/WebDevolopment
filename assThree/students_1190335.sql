-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 03:18 PM
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
-- Database: `students`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `department` varchar(50) NOT NULL,
  `avarage` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `gender`, `dob`, `department`, `avarage`, `address`, `city`, `country`, `telephone`, `email`, `image`) VALUES
(123485, 'Kooky', 'female', '2023-12-31', 'Dog', 100, 'bestest dog', 'Rammalah', 'Palestine', '059-1111112', 'dogo@gmail.com', '123485.jpg'),
(987654, 'Sawsan', 'female', '2001-08-10', 'History', 87, 'Terah', 'Ramallah', 'Palestine', '059-1234566', 'sawas@hotmail.com', '987654.jpg'),
(1185364, 'Fareed', 'male', '2024-01-08', 'Engineering', 69, 'betoonya', 'rammalah', 'Palestine', '059-4315241', 'kk@gmail.com', '1185364.jpg'),
(1190335, 'Fadi Tarazi ', 'male', '2024-02-03', 'ComputerSince', 66, 'masyoon', 'Ramallah', 'Palestine', '059-1234562', 'tarazifadi2001@gmail.com', '1190335.jpg'),
(5169565, 'Nerd', 'male', '2024-01-16', 'Math', 99, 'School', 'Ramallah', 'Palestine', '059-1415926', 'PhoneIsNumbersOfPi@gmail.com', '5169565.jpg'),
(6541651, 'Ahmad', 'male', '2017-01-10', 'Medicen', 99, 'sateh marhaba', 'Rammalah', 'Palestine', '059-6516511', 'hamada@gmail.com', '6541651.jpg'),
(8798711, 'Fareda', 'female', '2002-09-10', 'ComputerSince', 88, 'Terah', 'Ramallah', 'Palestine', '059-9988774', 'Fareda@gmail.com', '8798711.jpg'),
(9874654, 'PigBoy', 'male', '2023-10-10', 'Food', 50, 'pizzahut', 'Rammalah', 'Palestine', '059-6541651', 'bigboy@gmail.com', '9874654.jpg'),
(51651541, 'FlapJack', 'male', '2023-03-20', 'Sailor', 99, 'Misadvanture', 'Stormalong', 'England', '059-6541695', 'cartoon@gmail.com', '51651541.jpg'),
(51651651, 'SpongeBob', 'male', '2014-01-13', 'Sea', 44, 'ka3 alhamoor', 'Ka3 alhammor', 'Sesaw', '059-6516555', 'cartoon1@gmail.com', '51651651.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
