-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 04:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(10) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `FirstName`, `LastName`, `Email`, `Phone`, `Address`) VALUES
(1, 'erica', 'silvosa', 'ericasilvosa123@gmail.com', '12345', 'singapore'),
(3, 'Kineth', 'Pestaño', 'Kineth123@yahoo.com', '12345', 'Lizada'),
(6, 'Abdul pogi', 'Magaluyan', 'abdulmagaluyan@gmail.com', '8823812', 'Purok 18'),
(7, 'ritche', 'laganson', 'ritchepogi123@gmail.com', '111222333', 'toril, davao city'),
(8, 'jb', 'rulona', 'jbrulona@gmail.com', '77723331', 'inawayan'),
(9, 'juan', 'dela cruz', 'juandelacruz@gmail.com', '8888445', 'toril davao city'),
(10, 'john', 'doe', 'johndoe@gmail.com', '9929392', 'toril'),
(11, 'ASDWW', 'SMITH', 'ASDWWSMITH@GMAIL.COM', '9929392', 'TORIL');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `InventoryID` int(10) NOT NULL,
  `ProductID` int(10) NOT NULL,
  `Unit` varchar(55) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ReOrderLevel` int(11) NOT NULL,
  `WarehouseID` int(11) DEFAULT NULL,
  `Status` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`InventoryID`, `ProductID`, `Unit`, `Quantity`, `ReOrderLevel`, `WarehouseID`, `Status`) VALUES
(11, 7, 'pcs', 0, 10, 3, 'out of stock'),
(12, 8, 'pcs', 3, 10, 3, 'low-stock'),
(13, 11, 'box', 17, 10, 3, 'in-stock'),
(14, 18, 'box', 10, 10, 3, 'low-stock'),
(15, 20, 'pcs', 107, 10, 3, 'in-stock'),
(16, 21, 'pcs', 55, 10, 3, 'in-stock'),
(17, 22, 'pcs', 0, 10, 3, 'out of stock'),
(18, 23, 'box', 20, 10, 3, 'low-stock'),
(19, 24, 'box', 5, 10, 3, 'low-stock'),
(20, 18, 'pcs', 10, 10, 3, 'low-stock'),
(21, 7, 'pcs', 0, 10, 3, 'out of stock'),
(22, 25, 'pcs', 60, 10, 3, 'in-stock');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetail_ID` int(10) NOT NULL,
  `OrderID` int(10) NOT NULL,
  `ProductID` int(10) NOT NULL,
  `PriceSold` double NOT NULL,
  `Quantity` int(11) NOT NULL,
  `SubTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetail_ID`, `OrderID`, `ProductID`, `PriceSold`, `Quantity`, `SubTotal`) VALUES
(20, 51, 7, 7500, 1, 7500),
(21, 51, 8, 4500, 5, 22500),
(22, 52, 7, 7500, 5, 37500),
(23, 53, 7, 7500, 5, 37500),
(24, 54, 7, 7500, 5, 37500),
(25, 55, 7, 7500, 5, 37500),
(26, 56, 7, 7500, 5, 37500),
(27, 57, 7, 7500, 5, 37500),
(28, 62, 7, 7500, 50, 375000),
(29, 63, 7, 7500, 5, 37500),
(30, 63, 8, 4500, 5, 22500),
(31, 64, 7, 7500, 3, 22500),
(32, 64, 8, 4500, 1, 4500),
(33, 65, 7, 7500, 1, 7500),
(34, 66, 7, 7500, 5, 37500),
(35, 66, 8, 4500, 6, 27000),
(36, 67, 18, 500, 10, 5000),
(37, 68, 20, 350, 3, 1050),
(38, 68, 7, 7500, 10, 75000),
(39, 69, 21, 123, 5, 615),
(40, 69, 7, 7500, 1, 7500),
(41, 70, 22, 2000, 10, 20000),
(42, 71, 17, 1502, 5, 28000),
(43, 72, 18, 500, 7, 3500),
(44, 73, 22, 2000, 30, 60000),
(45, 74, 7, 7500, 5, 37500),
(46, 75, 7, 7500, 25, 187500),
(47, 76, 25, 850, 5, 4250);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(10) NOT NULL,
  `CustomerID` int(10) NOT NULL,
  `UserID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` double NOT NULL,
  `Status` varchar(55) NOT NULL,
  `Remarks` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `CustomerID`, `UserID`, `OrderDate`, `TotalQuantity`, `TotalAmount`, `Status`, `Remarks`) VALUES
(51, 1, 7, '2024-12-09', 6, 30000, 'Pending', ''),
(52, 3, 7, '2024-12-09', 5, 37500, 'Pending', ''),
(53, 3, 7, '2024-12-09', 5, 37500, 'Pending', ''),
(54, 3, 7, '2024-12-09', 5, 37500, 'Pending', ''),
(55, 7, 7, '2024-12-09', 5, 37500, 'Pending', ''),
(56, 7, 7, '2024-12-09', 5, 37500, 'Pending', ''),
(57, 7, 7, '2024-12-09', 5, 37500, 'Pending', ''),
(62, 3, 5, '2024-12-09', 50, 375000, 'Pending', ''),
(63, 9, 5, '2024-12-10', 10, 60000, 'Pending', ''),
(64, 1, 5, '2024-12-10', 4, 27000, 'Pending', ''),
(65, 1, 5, '2024-12-10', 1, 7500, 'Pending', ''),
(66, 8, 5, '2024-12-10', 11, 64500, 'Pending', ''),
(67, 10, 5, '2024-12-10', 10, 5000, 'Pending', ''),
(68, 9, 5, '2024-12-10', 13, 76050, 'Pending', ''),
(69, 3, 5, '2024-12-10', 6, 8115, 'Cancelled', 'Order Cancelled'),
(70, 6, 5, '2024-12-10', 10, 20000, 'Cancelled', 'Order Cancelled'),
(71, 6, 5, '2024-12-10', 5, 28000, 'Pending', ''),
(72, 6, 5, '2024-12-10', 7, 3500, 'Pending', ''),
(73, 6, 5, '2024-12-10', 30, 60000, 'Pending', ''),
(74, 1, 5, '2024-12-10', 5, 37500, 'Cancelled', 'Order Cancelled'),
(75, 1, 5, '2024-12-12', 25, 187500, 'Pending', ''),
(76, 7, 5, '2024-12-13', 5, 4250, 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(10) NOT NULL,
  `Barcode` varchar(50) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `UnitPrice` double NOT NULL,
  `SupplierID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Barcode`, `Name`, `Description`, `UnitPrice`, `SupplierID`) VALUES
(7, 'PROD0001', 'Ryzen 5 3400G', '4cores 8threads 3.90ghz speed APU', 7500, 2),
(8, 'PROD0002', 'B450 Biostar Motherboard', 'DDR4 2slots  M.2 Slot', 4500, 2),
(9, 'PROD0003', 'Ripjaws Ram', '16gb DDR4 3200mhz', 3200, 1),
(10, 'PROD0004', 'INPLAY 450w PSU', '80+ bronze 450watts Power supply ', 1500, 1),
(11, 'PROD0005', 'Ramsta M.2 SSD', 'M.2 SSD 128gb', 1000, 1),
(12, 'PROD0006', 'LED LG Monitor 75hz', 'LG Monitor 75hz, 21 inches LED', 4950, 1),
(13, 'PROD0007', 'INPLAY Tempered Glass Casing', 'Tempered Glass Casing', 1150, 1),
(14, 'PROD0007', 'Fantech X9 Thor Gaming mouse', '2m clicks. LED light', 650, 1),
(16, '7788823', 'prodtest', 'proddesctest', 5500, 1),
(17, '2138238', 'testname', 'testdescription', 1502, 1),
(18, '888999', 'testprod1update', 'testdescription', 500, 2),
(19, '777331', 'testprod12', 'testdescription123', 350, 2),
(20, '9998881', 'testprod123', 'descriptiontest', 350, 1),
(21, 'PROD2313', 'TEST', 'TESTDESC', 123, 1),
(22, 'PROD2314', 'JACK', 'testdescription', 2000, 1),
(23, '2138238', 'RYZEN 5300', 'testdescription', 5600, 1),
(24, '777330', 'INTEL i9 14800', 'testdescription', 5600, 6),
(25, '111222333', 'product2024', 'descriptiontest', 850, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `Name`, `Address`, `Phone`) VALUES
(1, 'ABC COMPANY', 'TORIL', '87898'),
(2, 'XYZ COMPANY', 'TORIL', '321'),
(3, 'TEST test', 'TORIL test', 'test'),
(5, 'suppliertest1 spiderman', 'New York, Brooklyn', '82893284'),
(6, 'MCDO', 'TORIL', '9929393');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `reset_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `reset_token`) VALUES
(5, 'admin', '$2y$10$X8gNeZEvV6lsxZZR87G5yuIdB0cP1qLdQk.mskoEoxBFDPFYHe3ma', 'ritche2000@gmail.com', 'dec06cbd6dce4f06013c46e6ab3f52d9'),
(6, 'ritche', '$2y$10$hFDsCB.UH9j.5489ie2QFuN8YqHOLvAMkOF84qHrUiSjROfQtYVFW', 'celega8565@avzong.com', 'c28e5d4a0a0f869cfe8810c4e9e959ec'),
(7, 'superadmin', '$2y$10$LV3kio/T359f.doVzPQO5u6a.mwPKV30L0768Xkujk3rw/RxpglF6', 'superadmin@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `WarehouseID` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`WarehouseID`, `Name`, `Location`) VALUES
(3, 'SmartStock', 'Toril, Davao City');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`InventoryID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `WarehouseID` (`WarehouseID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetail_ID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`WarehouseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `InventoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetail_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `WarehouseID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`),
  ADD CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`WarehouseID`) REFERENCES `warehouse` (`WarehouseID`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
