-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 04:08 PM
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
-- Database: `hotel_transelvinia`
--

-- --------------------------------------------------------

--
-- Table structure for table `cardpayment`
--

CREATE TABLE `cardpayment` (
  `PaymentID` int(11) NOT NULL,
  `CardNumber` varchar(20) NOT NULL,
  `ExpDate` date NOT NULL,
  `HolderName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cardpayment`
--

INSERT INTO `cardpayment` (`PaymentID`, `CardNumber`, `ExpDate`, `HolderName`) VALUES
(1, '4111111111111111', '2027-12-31', 'Ahmed Ali'),
(3, '4222222222222222', '2026-11-30', 'Omar Khaled');

-- --------------------------------------------------------

--
-- Table structure for table `corporatecustomer`
--

CREATE TABLE `corporatecustomer` (
  `customer_id` int(11) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `TaxNumber` varchar(50) DEFAULT NULL,
  `ContactPerson` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corporatecustomer`
--

INSERT INTO `corporatecustomer` (`customer_id`, `CompanyName`, `TaxNumber`, `ContactPerson`) VALUES
(2, 'Tech Solutions LLC', 'TX112233', 'Mona Hassan');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `F_Name` varchar(50) NOT NULL,
  `L_Name` varchar(50) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `F_Name`, `L_Name`, `phone`, `Email`, `Nationality`) VALUES
(1, 'Ahmed', 'Ali', '01012345678', 'ahmed.ali@example.com', 'Egypt'),
(2, 'Mona', 'Hassan', '01123456789', 'mona.hassan@example.com', 'Egypt'),
(3, 'Omar', 'Khaled', '01234567890', 'omar.khaled@example.com', 'Egypt'),
(4, 'Sara', 'Tarek', '01598765432', 'sara.tarek@example.com', 'Egypt');

-- --------------------------------------------------------

--
-- Table structure for table `individualcustomer`
--

CREATE TABLE `individualcustomer` (
  `customer_id` int(11) NOT NULL,
  `PassportNumber` varchar(50) DEFAULT NULL,
  `NationalID` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `individualcustomer`
--

INSERT INTO `individualcustomer` (`customer_id`, `PassportNumber`, `NationalID`) VALUES
(1, 'P1234567', 'NID1001'),
(3, 'P7894561', 'NID1003');

-- --------------------------------------------------------

--
-- Table structure for table `onlinepayment`
--

CREATE TABLE `onlinepayment` (
  `PaymentID` int(11) NOT NULL,
  `TransactionID` varchar(100) NOT NULL,
  `ServiceName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `onlinepayment`
--

INSERT INTO `onlinepayment` (`PaymentID`, `TransactionID`, `ServiceName`) VALUES
(2, 'TXN987654321', 'PayPal'),
(4, 'TXN555666777', 'VodafoneCash');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `ReservationID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `ReservationID`, `Amount`, `PaymentDate`, `PaymentMethod`) VALUES
(1, 1, 1000.00, '2025-12-01', 'Card'),
(2, 2, 700.00, '2025-12-02', 'Online'),
(3, 3, 1200.00, '2025-12-03', 'Card'),
(4, 4, 500.00, '2025-12-04', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ReservationID` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `ReservationDate` date NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ReservationID`, `customer_id`, `CheckInDate`, `CheckOutDate`, `ReservationDate`, `Status`) VALUES
(1, 1, '2025-12-20', '2025-12-25', '2025-12-01', 'Confirmed'),
(2, 2, '2025-12-21', '2025-12-23', '2025-12-02', 'Pending'),
(3, 3, '2025-12-22', '2025-12-26', '2025-12-03', 'Confirmed'),
(4, 4, '2025-12-24', '2025-12-28', '2025-12-04', 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `reservationroom`
--

CREATE TABLE `reservationroom` (
  `ResRoomID` int(11) NOT NULL,
  `ReservationID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservationroom`
--

INSERT INTO `reservationroom` (`ResRoomID`, `ReservationID`, `RoomID`) VALUES
(1, 1, 1),
(2, 1, 2),
(4, 3, 3),
(3, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RoomID` int(11) NOT NULL,
  `ROOM_NO` varchar(20) NOT NULL,
  `ROOM_TYPE` text DEFAULT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `Status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`RoomID`, `ROOM_NO`, `ROOM_TYPE`, `PRICE`, `Status`) VALUES
(1, '101', 'Single', 200.00, 'Available'),
(2, '102', 'Double', 350.00, 'Available'),
(3, '103', 'Suite', 600.00, 'Occupied'),
(4, '104', 'Single', 200.00, 'Available'),
(5, '111', 'Single', 200.00, 'Available'),
(6, '112', 'Double', 350.00, 'Available'),
(7, '113', 'Suite', 600.00, 'Occupied'),
(8, '114', 'Single', 200.00, 'Available'),
(9, '105', 'Double', 350.00, 'Available'),
(10, '106', 'Suite', 620.00, 'Available'),
(11, '107', 'Single', 210.00, 'Occupied'),
(12, '108', 'Double', 360.00, 'Available'),
(13, '109', 'Suite', 650.00, 'Available'),
(14, '110', 'Single', 205.00, 'Available'),
(15, '201', 'Single', 220.00, 'Available'),
(16, '202', 'Double', 370.00, 'Occupied'),
(17, '203', 'Suite', 700.00, 'Available'),
(18, '204', 'Single', 215.00, 'Available'),
(19, '205', 'Double', 355.00, 'Available'),
(20, '206', 'Suite', 720.00, 'Available'),
(21, '207', 'Single', 225.00, 'Occupied'),
(22, '208', 'Double', 340.00, 'Available'),
(23, '209', 'Suite', 750.00, 'Available'),
(24, '210', 'Single', 230.00, 'Available'),
(25, '12', 'single', 65656.77, 'confirmed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cardpayment`
--
ALTER TABLE `cardpayment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `corporatecustomer`
--
ALTER TABLE `corporatecustomer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `TaxNumber` (`TaxNumber`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `Phone` (`phone`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `individualcustomer`
--
ALTER TABLE `individualcustomer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `PassportNumber` (`PassportNumber`),
  ADD UNIQUE KEY `NationalID` (`NationalID`);

--
-- Indexes for table `onlinepayment`
--
ALTER TABLE `onlinepayment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD UNIQUE KEY `TransactionID` (`TransactionID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `ReservationID` (`ReservationID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ReservationID`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `reservationroom`
--
ALTER TABLE `reservationroom`
  ADD PRIMARY KEY (`ResRoomID`),
  ADD UNIQUE KEY `unique_room_per_reservation` (`RoomID`,`ReservationID`),
  ADD KEY `ReservationID` (`ReservationID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`RoomID`),
  ADD UNIQUE KEY `ROOM_NO` (`ROOM_NO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ReservationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservationroom`
--
ALTER TABLE `reservationroom`
  MODIFY `ResRoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cardpayment`
--
ALTER TABLE `cardpayment`
  ADD CONSTRAINT `cardpayment_ibfk_1` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`) ON DELETE CASCADE;

--
-- Constraints for table `corporatecustomer`
--
ALTER TABLE `corporatecustomer`
  ADD CONSTRAINT `corporatecustomer_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `individualcustomer`
--
ALTER TABLE `individualcustomer`
  ADD CONSTRAINT `individualcustomer_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `onlinepayment`
--
ALTER TABLE `onlinepayment`
  ADD CONSTRAINT `onlinepayment_ibfk_1` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`ReservationID`) REFERENCES `reservation` (`ReservationID`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `reservationroom`
--
ALTER TABLE `reservationroom`
  ADD CONSTRAINT `reservationroom_ibfk_1` FOREIGN KEY (`ReservationID`) REFERENCES `reservation` (`ReservationID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservationroom_ibfk_2` FOREIGN KEY (`RoomID`) REFERENCES `room` (`RoomID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
