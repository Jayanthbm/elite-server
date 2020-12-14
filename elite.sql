-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2020 at 08:13 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elite`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`) VALUES
(1, 'Saloon', 'sal'),
(2, 'Hotel', 'hot'),
(3, 'Book Shop', 'bs'),
(4, 'Footwear', 'fw'),
(5, 'Electronics', 'el'),
(6, 'Testing', 'tes'),
(7, 'Hello', 'hel');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `slug`) VALUES
(1, 'Basavangudi', 'bg'),
(2, 'Banashankari', 'bsk');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `storeId` varchar(255) NOT NULL,
  `storeName` varchar(255) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdBy` int(11) NOT NULL,
  `lastLoginTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isLoggedin` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `locationId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `storeId`, `storeName`, `createdOn`, `createdBy`, `lastLoginTime`, `isLoggedin`, `isActive`, `password`, `categoryId`, `locationId`) VALUES
(1, 'test', 'Test Store', '2020-11-26 14:29:13', 1, '0000-00-00 00:00:00', 0, 1, '$2y$10$NPOp78PiM6v.zUXTscadPu7r42qkrcONDrg.VFlzw6C8ZfTOcvZ.m', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `store_activity_log`
--

CREATE TABLE `store_activity_log` (
  `id` int(11) NOT NULL,
  `storeId` int(11) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdOn` timestamp NULL DEFAULT NULL,
  `lastLoginTime` timestamp NULL DEFAULT NULL,
  `isLoggedin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `email`, `name`, `password`, `createdOn`, `lastLoginTime`, `isLoggedin`) VALUES
(1, 'admin@admin.com', 'admin', '$2y$10$x6/peZLOVJJiJ9oZ271OcutmdiUj6yTu5QovkYB3eKCfSjBbK56T2', '2020-09-14 14:14:28', '2020-11-26 13:40:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `videoId` int(11) NOT NULL,
  `videoName` varchar(255) DEFAULT NULL,
  `videoSize` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `isPublished` tinyint(1) NOT NULL,
  `uploadBy` int(11) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `publishBy` int(11) NOT NULL,
  `publishDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `unPublishBy` int(11) DEFAULT NULL,
  `unPublishDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `totalPlays` bigint(20) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `locationId` int(11) DEFAULT NULL,
  `isGlobal` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `video_activity_log`
--

CREATE TABLE `video_activity_log` (
  `id` int(11) NOT NULL,
  `storeId` int(11) NOT NULL,
  `VideoId` int(11) NOT NULL,
  `playedOn` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `video_disbaled_store`
--

CREATE TABLE `video_disbaled_store` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `storeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `StoreID_StoreName` (`storeId`,`storeName`),
  ADD KEY `store_ createdBy` (`createdBy`),
  ADD KEY `store_category` (`categoryId`),
  ADD KEY `store_location` (`locationId`);

--
-- Indexes for table `store_activity_log`
--
ALTER TABLE `store_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `storeActivity_ storeId` (`storeId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`videoId`),
  ADD KEY `video_uploadBy` (`uploadBy`),
  ADD KEY `video_ publishBy` (`publishBy`),
  ADD KEY `video_ unPublishBy` (`unPublishBy`),
  ADD KEY `video_category` (`categoryId`),
  ADD KEY `video_location` (`locationId`);

--
-- Indexes for table `video_activity_log`
--
ALTER TABLE `video_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `videoActivity_storeId` (`storeId`),
  ADD KEY `videoActivity_VideoId` (`VideoId`);

--
-- Indexes for table `video_disbaled_store`
--
ALTER TABLE `video_disbaled_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `VideoDisabled_videoId` (`videoId`),
  ADD KEY `VideoDisabled_storeId` (`storeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_activity_log`
--
ALTER TABLE `store_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `videoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_activity_log`
--
ALTER TABLE `video_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_disbaled_store`
--
ALTER TABLE `video_disbaled_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `store_ createdBy` FOREIGN KEY (`createdBy`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `store_category` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `store_location` FOREIGN KEY (`locationId`) REFERENCES `location` (`id`);

--
-- Constraints for table `store_activity_log`
--
ALTER TABLE `store_activity_log`
  ADD CONSTRAINT `storeActivity_ storeId` FOREIGN KEY (`storeId`) REFERENCES `stores` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `video_ publishBy` FOREIGN KEY (`publishBy`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `video_ unPublishBy` FOREIGN KEY (`unPublishBy`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `video_category` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `video_location` FOREIGN KEY (`locationId`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `video_uploadBy` FOREIGN KEY (`uploadBy`) REFERENCES `users` (`userId`);

--
-- Constraints for table `video_activity_log`
--
ALTER TABLE `video_activity_log`
  ADD CONSTRAINT `videoActivity_VideoId` FOREIGN KEY (`VideoId`) REFERENCES `videos` (`videoId`),
  ADD CONSTRAINT `videoActivity_storeId` FOREIGN KEY (`storeId`) REFERENCES `stores` (`id`);

--
-- Constraints for table `video_disbaled_store`
--
ALTER TABLE `video_disbaled_store`
  ADD CONSTRAINT `VideoDisabled_storeId` FOREIGN KEY (`storeId`) REFERENCES `stores` (`id`),
  ADD CONSTRAINT `VideoDisabled_videoId` FOREIGN KEY (`videoId`) REFERENCES `videos` (`videoId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
