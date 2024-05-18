-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2022 at 04:20 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belensdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblappointments`
--

CREATE TABLE `tblappointments` (
  `AptID` int(10) NOT NULL,
  `CustID` int(10) NOT NULL,
  `AptNum` int(10) NOT NULL,
  `AptDate` date NOT NULL,
  `AptTime` varchar(7) NOT NULL,
  `Message` mediumtext NOT NULL,
  `BookDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(15) NOT NULL,
  `Remarks` tinytext NOT NULL,
  `RemarksDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblappointments`
--

INSERT INTO `tblappointments` (`AptID`, `CustID`, `AptNum`, `AptDate`, `AptTime`, `Message`, `BookDate`, `Status`, `Remarks`, `RemarksDate`) VALUES
(1, 1, 959853860, '2022-10-20', '10:00AM', 'sddf', '2022-10-07 02:07:34', 'Scheduled', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblaptremarks`
--

CREATE TABLE `tblaptremarks` (
  `remarkID` int(11) NOT NULL,
  `Remarks` mediumtext NOT NULL,
  `RemarksDate` datetime NOT NULL DEFAULT current_timestamp(),
  `AptNum` int(11) NOT NULL,
  `AptDate` date NOT NULL,
  `AptTime` varchar(7) NOT NULL,
  `AptStatus` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblaptservice`
--

CREATE TABLE `tblaptservice` (
  `AptNum` int(10) NOT NULL,
  `ServiceID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblaptservice`
--

INSERT INTO `tblaptservice` (`AptNum`, `ServiceID`) VALUES
(959853860, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers`
--

CREATE TABLE `tblcustomers` (
  `CustID` int(10) NOT NULL,
  `FirstName` varchar(200) DEFAULT NULL,
  `LastName` varchar(200) DEFAULT NULL,
  `MobileNumber` varchar(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `ProfilePic` varchar(200) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcustomers`
--

INSERT INTO `tblcustomers` (`CustID`, `FirstName`, `LastName`, `MobileNumber`, `Password`, `Email`, `Address`, `ProfilePic`, `CreationDate`) VALUES
(1, 'NOEL', 'MANALO', '13333111111', 'c4ca4238a0b923820dcc509a6f75849b', 'noellazarmanalo@gmail.com', 'DIAMOND ST', NULL, '2022-10-07 02:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `EmployeeID` int(10) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `MobileNumber` varchar(11) NOT NULL,
  `Password` varchar(120) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Address` mediumtext NOT NULL,
  `ProfilePic` varchar(200) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`EmployeeID`, `FirstName`, `LastName`, `MobileNumber`, `Password`, `Email`, `Address`, `ProfilePic`, `CreationDate`) VALUES
(1, 'Evelyn', 'Ewayan', '09126834161', 'c4ca4238a0b923820dcc509a6f75849b', 'employee@employee.com', 'GT', NULL, '2022-10-05 18:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblinventory`
--

CREATE TABLE `tblinventory` (
  `ID` int(10) NOT NULL,
  `ProductName` varchar(200) NOT NULL,
  `Quantity` int(10) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblinvoice`
--

CREATE TABLE `tblinvoice` (
  `soID` int(10) NOT NULL,
  `ServiceID` int(10) NOT NULL,
  `InvoiceID` int(10) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `PaymentID` int(11) NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  `AptNum` int(11) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Payment` decimal(10,2) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblserviceorder`
--

CREATE TABLE `tblserviceorder` (
  `soID` int(10) NOT NULL,
  `AptNum` int(10) DEFAULT NULL,
  `EmployeeID` int(10) NOT NULL,
  `InvoiceID` int(10) NOT NULL,
  `PaymentID` int(11) DEFAULT NULL,
  `PaymentStatus` varchar(15) DEFAULT NULL,
  `CustomerID` int(10) NOT NULL,
  `custType` varchar(20) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `CreationDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblservices`
--

CREATE TABLE `tblservices` (
  `ID` int(10) NOT NULL,
  `ServiceName` varchar(200) NOT NULL,
  `Cost` decimal(10,2) NOT NULL,
  `ServiceDescription` mediumtext NOT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblservices`
--

INSERT INTO `tblservices` (`ID`, `ServiceName`, `Cost`, `ServiceDescription`, `Image`, `CreationDate`) VALUES
(1, 'a', '55.00', 'fssf', NULL, '2022-10-07 02:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `tblstockin`
--

CREATE TABLE `tblstockin` (
  `sinID` int(10) NOT NULL,
  `prodID` int(10) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tblstockout`
--

CREATE TABLE `tblstockout` (
  `soutID` int(11) NOT NULL,
  `prodID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblappointments`
--
ALTER TABLE `tblappointments`
  ADD PRIMARY KEY (`AptID`);

--
-- Indexes for table `tblaptremarks`
--
ALTER TABLE `tblaptremarks`
  ADD PRIMARY KEY (`remarkID`);

--
-- Indexes for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  ADD PRIMARY KEY (`CustID`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `tblinventory`
--
ALTER TABLE `tblinventory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `tblserviceorder`
--
ALTER TABLE `tblserviceorder`
  ADD PRIMARY KEY (`soID`);

--
-- Indexes for table `tblservices`
--
ALTER TABLE `tblservices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblstockin`
--
ALTER TABLE `tblstockin`
  ADD PRIMARY KEY (`sinID`);

--
-- Indexes for table `tblstockout`
--
ALTER TABLE `tblstockout`
  ADD PRIMARY KEY (`soutID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblappointments`
--
ALTER TABLE `tblappointments`
  MODIFY `AptID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblaptremarks`
--
ALTER TABLE `tblaptremarks`
  MODIFY `remarkID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  MODIFY `CustID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `EmployeeID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblinventory`
--
ALTER TABLE `tblinventory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblserviceorder`
--
ALTER TABLE `tblserviceorder`
  MODIFY `soID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblservices`
--
ALTER TABLE `tblservices`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblstockin`
--
ALTER TABLE `tblstockin`
  MODIFY `sinID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstockout`
--
ALTER TABLE `tblstockout`
  MODIFY `soutID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
