-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Nov 28, 2016 at 12:03 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `CustomerId` int(11) NOT NULL,
  `CustomerName` varchar(45) DEFAULT NULL,
  `CloudDbName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `CustomerStats`
--

CREATE TABLE `CustomerStats` (
  `CustomerStatsId` int(10) UNSIGNED NOT NULL,
  `ItemCount` int(11) DEFAULT NULL,
  `ItemSize` int(11) DEFAULT NULL,
  `TimeStamp` datetime DEFAULT NULL,
  `CustomerId` int(11) NOT NULL,
  `LinkInfoId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `LinkInfo`
--

CREATE TABLE `LinkInfo` (
  `LinkInfoId` int(11) NOT NULL,
  `LinkInfoGuid` varchar(100) DEFAULT NULL,
  `Updated` datetime DEFAULT NULL,
  `LowWaterMark` int(11) DEFAULT NULL,
  `HighWaterMark` int(11) DEFAULT NULL,
  `FreeDiskSpace` int(11) DEFAULT NULL,
  `STGPath` varchar(200) DEFAULT NULL,
  `percentUsed` int(11) DEFAULT NULL,
  `CustomerId` int(11) DEFAULT NULL,
  `LinkName` varchar(255) DEFAULT NULL,
  `FailedExported` int(11) DEFAULT NULL,
  `Failedimported` int(11) DEFAULT NULL,
  `Last7DImportedSize` int(11) DEFAULT NULL,
  `Last7DExportedSize` int(11) DEFAULT NULL,
  `Last24HExportedSize` int(11) DEFAULT NULL,
  `Last24HImportedSize` int(11) DEFAULT NULL,
  `Last7DImportedItemCount` int(11) DEFAULT NULL,
  `Last7DExportedItemCount` int(11) DEFAULT NULL,
  `Last24HImportedItemCount` int(11) DEFAULT NULL,
  `Last24HExportedItemCount` int(11) DEFAULT NULL,
  `Average24HImport` int(11) DEFAULT NULL,
  `Average24HExport` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ProductType`
--

CREATE TABLE `ProductType` (
  `ProductTypeId` int(11) NOT NULL,
  `ProductName` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Report`
--

CREATE TABLE `Report` (
  `idReport` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `reportType` int(11) NOT NULL,
  `dateFrom` datetime NOT NULL,
  `dateTo` datetime NOT NULL,
  `weekNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ReportData`
--

CREATE TABLE `ReportData` (
  `idReportData` int(10) UNSIGNED NOT NULL,
  `idReport` int(11) NOT NULL,
  `propertyName` varchar(45) DEFAULT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ReportDataForTicket`
--

CREATE TABLE `ReportDataForTicket` (
  `idReportDataForTicket` int(11) NOT NULL,
  `idReport` int(11) NOT NULL,
  `intValue1` int(11) DEFAULT NULL,
  `intValue2` int(11) DEFAULT NULL,
  `intValue3` int(11) DEFAULT NULL,
  `intValue4` int(11) DEFAULT NULL,
  `intValue5` int(11) DEFAULT NULL,
  `stringValue1` varchar(255) DEFAULT NULL,
  `stringValue2` varchar(45) DEFAULT NULL,
  `stringValue3` varchar(45) DEFAULT NULL,
  `stringValue4` varchar(45) DEFAULT NULL,
  `stringValue5` varchar(45) DEFAULT NULL,
  `stringValue6` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ReportType`
--

CREATE TABLE `ReportType` (
  `idReportType` int(11) NOT NULL,
  `ReportTypeName` varchar(45) NOT NULL,
  `Order` int(11) DEFAULT NULL,
  `ReportDescription` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uf_authorize_group`
--

CREATE TABLE `uf_authorize_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `hook` varchar(200) NOT NULL COMMENT 'A code that references a specific action or URI that the group has access to.',
  `conditions` text NOT NULL COMMENT 'The conditions under which members of this group have access to this hook.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_authorize_user`
--

CREATE TABLE `uf_authorize_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hook` varchar(200) NOT NULL COMMENT 'A code that references a specific action or URI that the user has access to.',
  `conditions` text NOT NULL COMMENT 'The conditions under which the user has access to this action.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_configuration`
--

CREATE TABLE `uf_configuration` (
  `id` int(10) UNSIGNED NOT NULL,
  `plugin` varchar(50) NOT NULL COMMENT 'The name of the plugin that manages this setting (set to ''userfrosting'' for core settings)',
  `name` varchar(150) NOT NULL COMMENT 'The name of the setting.',
  `value` longtext NOT NULL COMMENT 'The current value of the setting.',
  `description` text NOT NULL COMMENT 'A brief description of this setting.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='A configuration table, mapping global configuration options to their values.';

-- --------------------------------------------------------

--
-- Table structure for table `uf_group`
--

CREATE TABLE `uf_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Specifies whether this permission is a default setting for new accounts.',
  `can_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Specifies whether this permission can be deleted from the control panel.',
  `theme` varchar(100) NOT NULL DEFAULT 'default' COMMENT 'The theme assigned to primary users in this group.',
  `landing_page` varchar(200) NOT NULL DEFAULT 'dashboard' COMMENT 'The page to take primary members to when they first log in.',
  `new_user_title` varchar(200) NOT NULL DEFAULT 'New User' COMMENT 'The default title to assign to new primary users.',
  `icon` varchar(100) NOT NULL DEFAULT 'fa fa-user' COMMENT 'The icon representing primary users in this group.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_group_user`
--

CREATE TABLE `uf_group_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Maps users to their group(s)';

-- --------------------------------------------------------

--
-- Table structure for table `uf_user`
--

CREATE TABLE `uf_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `locale` varchar(10) NOT NULL DEFAULT 'en_US' COMMENT 'The language and locale to use for this user.',
  `primary_group_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'The id of this user''s primary group.',
  `secret_token` varchar(32) NOT NULL DEFAULT '' COMMENT 'The current one-time use token for various user activities confirmed via email.',
  `flag_verified` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Set to ''1'' if the user has verified their account via email, ''0'' otherwise.',
  `flag_enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Set to ''1'' if the user''s account is currently enabled, ''0'' otherwise.  Disabled accounts cannot be logged in to, but they retain all of their data and settings.',
  `flag_password_reset` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Set to ''1'' if the user has an outstanding password reset request, ''0'' otherwise.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_user_event`
--

CREATE TABLE `uf_user_event` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL COMMENT 'An identifier used to track the type of event.',
  `occurred_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `uf_user_rememberme`
--

CREATE TABLE `uf_user_rememberme` (
  `user_id` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `persistent_token` varchar(40) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`CustomerId`),
  ADD UNIQUE KEY `CustomerId_UNIQUE` (`CustomerId`);

--
-- Indexes for table `CustomerStats`
--
ALTER TABLE `CustomerStats`
  ADD PRIMARY KEY (`CustomerStatsId`);

--
-- Indexes for table `LinkInfo`
--
ALTER TABLE `LinkInfo`
  ADD PRIMARY KEY (`LinkInfoId`),
  ADD UNIQUE KEY `LinkInfoId_UNIQUE` (`LinkInfoId`);

--
-- Indexes for table `ProductType`
--
ALTER TABLE `ProductType`
  ADD PRIMARY KEY (`ProductTypeId`),
  ADD UNIQUE KEY `ProductTypeId_UNIQUE` (`ProductTypeId`);

--
-- Indexes for table `Report`
--
ALTER TABLE `Report`
  ADD PRIMARY KEY (`idReport`),
  ADD UNIQUE KEY `idReport_UNIQUE` (`idReport`);

--
-- Indexes for table `ReportData`
--
ALTER TABLE `ReportData`
  ADD PRIMARY KEY (`idReportData`);

--
-- Indexes for table `ReportDataForTicket`
--
ALTER TABLE `ReportDataForTicket`
  ADD PRIMARY KEY (`idReportDataForTicket`,`idReport`),
  ADD UNIQUE KEY `idReportDataForTicket_UNIQUE` (`idReportDataForTicket`),
  ADD KEY `idReportFK_idx` (`idReport`);

--
-- Indexes for table `ReportType`
--
ALTER TABLE `ReportType`
  ADD PRIMARY KEY (`idReportType`),
  ADD UNIQUE KEY `idReportType_UNIQUE` (`idReportType`);

--
-- Indexes for table `uf_authorize_group`
--
ALTER TABLE `uf_authorize_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_authorize_user`
--
ALTER TABLE `uf_authorize_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_configuration`
--
ALTER TABLE `uf_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_group`
--
ALTER TABLE `uf_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_group_user`
--
ALTER TABLE `uf_group_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_user`
--
ALTER TABLE `uf_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uf_user_event`
--
ALTER TABLE `uf_user_event`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CustomerStats`
--
ALTER TABLE `CustomerStats`
  MODIFY `CustomerStatsId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LinkInfo`
--
ALTER TABLE `LinkInfo`
  MODIFY `LinkInfoId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ProductType`
--
ALTER TABLE `ProductType`
  MODIFY `ProductTypeId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Report`
--
ALTER TABLE `Report`
  MODIFY `idReport` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReportData`
--
ALTER TABLE `ReportData`
  MODIFY `idReportData` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReportDataForTicket`
--
ALTER TABLE `ReportDataForTicket`
  MODIFY `idReportDataForTicket` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReportType`
--
ALTER TABLE `ReportType`
  MODIFY `idReportType` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_authorize_group`
--
ALTER TABLE `uf_authorize_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_authorize_user`
--
ALTER TABLE `uf_authorize_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_configuration`
--
ALTER TABLE `uf_configuration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_group`
--
ALTER TABLE `uf_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_group_user`
--
ALTER TABLE `uf_group_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_user`
--
ALTER TABLE `uf_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `uf_user_event`
--
ALTER TABLE `uf_user_event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ReportDataForTicket`
--
ALTER TABLE `ReportDataForTicket`
  ADD CONSTRAINT `idReportFK` FOREIGN KEY (`idReport`) REFERENCES `Report` (`idReport`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
