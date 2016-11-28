-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 21, 2016 at 02:38 PM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kayako`
--

-- --------------------------------------------------------

--
-- Table structure for table `statusboard`
--

CREATE TABLE `statusboard` (
  `indexnumber` int(11) NOT NULL,
  `type` text NOT NULL,
  `value1` text NOT NULL,
  `value2` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `swapplogdata`
--

CREATE TABLE `swapplogdata` (
  `applogdataid` int(11) NOT NULL,
  `applogid` int(11) NOT NULL DEFAULT '0',
  `logdata` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swapplogs`
--

CREATE TABLE `swapplogs` (
  `applogid` int(11) NOT NULL,
  `appname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `logtype` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swattachmentchunks`
--

CREATE TABLE `swattachmentchunks` (
  `chunkid` int(11) NOT NULL,
  `attachmentid` int(11) NOT NULL DEFAULT '0',
  `contents` mediumblob NOT NULL,
  `notbase64` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swattachments`
--

CREATE TABLE `swattachments` (
  `attachmentid` int(11) NOT NULL,
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `linktypeid` int(11) NOT NULL DEFAULT '0',
  `downloaditemid` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filesize` int(11) NOT NULL DEFAULT '0',
  `filetype` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `attachmenttype` smallint(6) NOT NULL DEFAULT '0',
  `storefilename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contentid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swautoclosecriteria`
--

CREATE TABLE `swautoclosecriteria` (
  `autoclosecriteriaid` int(11) NOT NULL,
  `autocloseruleid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ruleop` smallint(6) NOT NULL DEFAULT '0',
  `rulematch` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rulematchtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swautocloserules`
--

CREATE TABLE `swautocloserules` (
  `autocloseruleid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `targetticketstatusid` int(11) NOT NULL DEFAULT '0',
  `inactivitythreshold` double NOT NULL DEFAULT '0',
  `closurethreshold` double NOT NULL DEFAULT '0',
  `sendpendingnotification` int(11) NOT NULL DEFAULT '0',
  `sendfinalnotification` int(11) NOT NULL DEFAULT '0',
  `suppresssurveyemail` int(11) NOT NULL DEFAULT '0',
  `isenabled` int(11) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swbayescategories`
--

CREATE TABLE `swbayescategories` (
  `bayescategoryid` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `probability` decimal(10,0) NOT NULL DEFAULT '0',
  `wordcount` bigint(20) NOT NULL DEFAULT '0',
  `categoryweight` smallint(6) NOT NULL DEFAULT '0',
  `ismaster` smallint(6) NOT NULL DEFAULT '0',
  `categorytype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swbayeswords`
--

CREATE TABLE `swbayeswords` (
  `bayeswordid` int(11) NOT NULL,
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swbayeswordsfreqs`
--

CREATE TABLE `swbayeswordsfreqs` (
  `bayeswordid` int(11) NOT NULL DEFAULT '0',
  `bayescategoryid` int(11) NOT NULL DEFAULT '0',
  `wordcount` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swbreaklines`
--

CREATE TABLE `swbreaklines` (
  `breaklineid` int(11) NOT NULL,
  `breakline` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `isregexp` smallint(6) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcatchallrules`
--

CREATE TABLE `swcatchallrules` (
  `catchallruleid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ruleexpr` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `emailqueueid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcommentdata`
--

CREATE TABLE `swcommentdata` (
  `commentdataid` int(11) NOT NULL,
  `commentid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcomments`
--

CREATE TABLE `swcomments` (
  `commentid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `creatortype` smallint(6) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `commenttype` smallint(6) NOT NULL DEFAULT '0',
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `parentcommentid` int(11) NOT NULL DEFAULT '0',
  `commentstatus` smallint(6) NOT NULL DEFAULT '0',
  `useragent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `referrer` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parenturl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcron`
--

CREATE TABLE `swcron` (
  `cronid` int(11) NOT NULL,
  `nextrun` int(11) NOT NULL DEFAULT '0',
  `lastrun` int(11) NOT NULL DEFAULT '0',
  `chour` int(11) NOT NULL DEFAULT '0',
  `cminute` int(11) NOT NULL DEFAULT '0',
  `cday` int(11) NOT NULL DEFAULT '0',
  `app` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `controller` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `autorun` smallint(6) NOT NULL DEFAULT '0',
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcronlogs`
--

CREATE TABLE `swcronlogs` (
  `cronlogid` int(11) NOT NULL,
  `cronid` int(11) NOT NULL DEFAULT '0',
  `crontitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfielddeplinks`
--

CREATE TABLE `swcustomfielddeplinks` (
  `customfielddeplinkid` int(11) NOT NULL,
  `customfieldgroupid` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfieldgrouppermissions`
--

CREATE TABLE `swcustomfieldgrouppermissions` (
  `customfieldgrouppermissionsid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `customfieldgroupid` int(11) NOT NULL DEFAULT '0',
  `cfgrouptype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `accessmask` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfieldgroups`
--

CREATE TABLE `swcustomfieldgroups` (
  `customfieldgroupid` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `grouptype` smallint(6) NOT NULL DEFAULT '0',
  `visibilitytype` smallint(6) NOT NULL DEFAULT '1',
  `displayorder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfieldlinks`
--

CREATE TABLE `swcustomfieldlinks` (
  `customfieldlinkid` int(11) NOT NULL,
  `grouptype` smallint(6) NOT NULL DEFAULT '0',
  `linktypeid` int(11) NOT NULL DEFAULT '0',
  `customfieldgroupid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfieldoptionlinks`
--

CREATE TABLE `swcustomfieldoptionlinks` (
  `customfieldoptionlinkid` int(11) NOT NULL,
  `customfieldid` int(11) NOT NULL DEFAULT '0',
  `customfieldoptionid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfieldoptions`
--

CREATE TABLE `swcustomfieldoptions` (
  `customfieldoptionid` int(11) NOT NULL,
  `customfieldid` int(11) NOT NULL DEFAULT '0',
  `optionvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `isselected` smallint(6) NOT NULL DEFAULT '0',
  `parentcustomfieldoptionid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfields`
--

CREATE TABLE `swcustomfields` (
  `customfieldid` int(11) NOT NULL,
  `customfieldgroupid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fieldtype` smallint(6) NOT NULL DEFAULT '0',
  `fieldname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `defaultvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isrequired` smallint(6) NOT NULL DEFAULT '0',
  `usereditable` smallint(6) NOT NULL DEFAULT '0',
  `staffeditable` smallint(6) NOT NULL DEFAULT '0',
  `regexpvalidate` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `encryptindb` smallint(6) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swcustomfieldvalues`
--

CREATE TABLE `swcustomfieldvalues` (
  `customfieldvalueid` int(11) NOT NULL,
  `customfieldid` int(11) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `fieldvalue` text COLLATE utf8_unicode_ci,
  `isserialized` smallint(6) NOT NULL DEFAULT '0',
  `isencrypted` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `uniquehash` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastupdated` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swdbwb_staffselect`
--

CREATE TABLE `swdbwb_staffselect` (
  `dbwb_staffselectid` int(11) NOT NULL,
  `dbwb_staffid` int(11) NOT NULL DEFAULT '0',
  `dbwb_staffselected` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swdepartments`
--

CREATE TABLE `swdepartments` (
  `departmentid` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `departmenttype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `departmentapp` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'tickets',
  `isdefault` smallint(6) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `parentdepartmentid` int(11) NOT NULL DEFAULT '0',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `enabletimer` int(1) NOT NULL DEFAULT '0',
  `ideltime` int(11) NOT NULL DEFAULT '0',
  `surrender` int(1) NOT NULL DEFAULT '0',
  `showtimer` int(1) NOT NULL DEFAULT '0',
  `showpausetime` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swemailqueues`
--

CREATE TABLE `swemailqueues` (
  `emailqueueid` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'tickets',
  `fetchtype` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pipe',
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `port` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userpassword` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customfromname` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customfromemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tickettypeid` int(11) NOT NULL DEFAULT '0',
  `priorityid` int(11) NOT NULL DEFAULT '0',
  `ticketstatusid` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `prefix` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ticketautoresponder` smallint(6) NOT NULL DEFAULT '0',
  `replyautoresponder` smallint(6) NOT NULL DEFAULT '0',
  `registrationrequired` smallint(6) NOT NULL DEFAULT '0',
  `tgroupid` int(11) NOT NULL DEFAULT '0',
  `forcequeue` smallint(6) NOT NULL DEFAULT '1',
  `leavecopyonserver` smallint(6) NOT NULL DEFAULT '0',
  `usequeuesmtp` smallint(6) NOT NULL DEFAULT '0',
  `smtptype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isenabled` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swerrorlogs`
--

CREATE TABLE `swerrorlogs` (
  `errorlogid` int(11) NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `errordetails` text COLLATE utf8_unicode_ci,
  `userdata` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swescalationnotifications`
--

CREATE TABLE `swescalationnotifications` (
  `escalationnotificationid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `escalationruleid` int(11) NOT NULL DEFAULT '0',
  `notificationtype` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notificationcontents` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swescalationpaths`
--

CREATE TABLE `swescalationpaths` (
  `escalationpathid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `slaplantitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `escalationruleid` int(11) NOT NULL DEFAULT '0',
  `escalationruletitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ownerstaffid` int(11) NOT NULL DEFAULT '0',
  `ownerstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `departmenttitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ticketstatusid` int(11) NOT NULL DEFAULT '0',
  `ticketstatustitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `priorityid` int(11) NOT NULL DEFAULT '0',
  `prioritytitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tickettypeid` int(11) NOT NULL DEFAULT '0',
  `tickettypetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flagtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swescalationrules`
--

CREATE TABLE `swescalationrules` (
  `escalationruleid` int(11) NOT NULL,
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `priorityid` int(11) NOT NULL DEFAULT '0',
  `ticketstatusid` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ruletype` smallint(6) NOT NULL DEFAULT '0',
  `flagtype` smallint(6) NOT NULL DEFAULT '0',
  `newslaplanid` int(11) NOT NULL DEFAULT '0',
  `addtags` longtext COLLATE utf8_unicode_ci,
  `removetags` longtext COLLATE utf8_unicode_ci,
  `tickettypeid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swfiles`
--

CREATE TABLE `swfiles` (
  `fileid` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `originalfilename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `filehash` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `expiry` int(11) NOT NULL DEFAULT '0',
  `subdirectory` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcities`
--

CREATE TABLE `swgeoipcities` (
  `blockid` int(11) NOT NULL DEFAULT '0',
  `country` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `region` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `postalcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `latitude` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `longitude` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `metrocode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `areacode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks1`
--

CREATE TABLE `swgeoipcityblocks1` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks2`
--

CREATE TABLE `swgeoipcityblocks2` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks3`
--

CREATE TABLE `swgeoipcityblocks3` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks4`
--

CREATE TABLE `swgeoipcityblocks4` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks5`
--

CREATE TABLE `swgeoipcityblocks5` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks6`
--

CREATE TABLE `swgeoipcityblocks6` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks7`
--

CREATE TABLE `swgeoipcityblocks7` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks8`
--

CREATE TABLE `swgeoipcityblocks8` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks9`
--

CREATE TABLE `swgeoipcityblocks9` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipcityblocks10`
--

CREATE TABLE `swgeoipcityblocks10` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `blockid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp1`
--

CREATE TABLE `swgeoipisp1` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp2`
--

CREATE TABLE `swgeoipisp2` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp3`
--

CREATE TABLE `swgeoipisp3` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp4`
--

CREATE TABLE `swgeoipisp4` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp5`
--

CREATE TABLE `swgeoipisp5` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp6`
--

CREATE TABLE `swgeoipisp6` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp7`
--

CREATE TABLE `swgeoipisp7` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp8`
--

CREATE TABLE `swgeoipisp8` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp9`
--

CREATE TABLE `swgeoipisp9` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipisp10`
--

CREATE TABLE `swgeoipisp10` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `isp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed1`
--

CREATE TABLE `swgeoipnetspeed1` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed2`
--

CREATE TABLE `swgeoipnetspeed2` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed3`
--

CREATE TABLE `swgeoipnetspeed3` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed4`
--

CREATE TABLE `swgeoipnetspeed4` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed5`
--

CREATE TABLE `swgeoipnetspeed5` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed6`
--

CREATE TABLE `swgeoipnetspeed6` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed7`
--

CREATE TABLE `swgeoipnetspeed7` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed8`
--

CREATE TABLE `swgeoipnetspeed8` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed9`
--

CREATE TABLE `swgeoipnetspeed9` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoipnetspeed10`
--

CREATE TABLE `swgeoipnetspeed10` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `netspeed` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization1`
--

CREATE TABLE `swgeoiporganization1` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization2`
--

CREATE TABLE `swgeoiporganization2` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization3`
--

CREATE TABLE `swgeoiporganization3` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization4`
--

CREATE TABLE `swgeoiporganization4` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization5`
--

CREATE TABLE `swgeoiporganization5` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization6`
--

CREATE TABLE `swgeoiporganization6` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization7`
--

CREATE TABLE `swgeoiporganization7` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization8`
--

CREATE TABLE `swgeoiporganization8` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization9`
--

CREATE TABLE `swgeoiporganization9` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgeoiporganization10`
--

CREATE TABLE `swgeoiporganization10` (
  `ipfrom` bigint(20) NOT NULL DEFAULT '0',
  `ipto` bigint(20) NOT NULL DEFAULT '0',
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swgroupassigns`
--

CREATE TABLE `swgroupassigns` (
  `groupassignid` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `staffgroupid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swimportlogs`
--

CREATE TABLE `swimportlogs` (
  `importlogid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `logtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swimportregistry`
--

CREATE TABLE `swimportregistry` (
  `importregistryid` int(11) NOT NULL,
  `section` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `data` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nocache` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swjabberqueue`
--

CREATE TABLE `swjabberqueue` (
  `jabberqueueid` int(11) NOT NULL,
  `messagetype` smallint(6) NOT NULL DEFAULT '0',
  `dispatchname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dispatchtype` smallint(6) NOT NULL DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci,
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swjobqueuemessagelogs`
--

CREATE TABLE `swjobqueuemessagelogs` (
  `jobqueuemessagelogid` int(11) NOT NULL,
  `jobqueuemessageid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `messagestatus` smallint(6) NOT NULL DEFAULT '0',
  `statusstage` smallint(6) NOT NULL DEFAULT '0',
  `updatecontents` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swjobqueuemessagepackets`
--

CREATE TABLE `swjobqueuemessagepackets` (
  `jobqueuemessagepacketid` int(11) NOT NULL,
  `queuename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `receipthandle` text COLLATE utf8_unicode_ci,
  `messagebody` longtext COLLATE utf8_unicode_ci NOT NULL,
  `verifyhash` smallint(6) NOT NULL DEFAULT '0',
  `controllerparentclass` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swjobqueuemessages`
--

CREATE TABLE `swjobqueuemessages` (
  `jobqueuemessageid` int(11) NOT NULL,
  `messageuuid` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `serverid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastupdate` int(11) NOT NULL DEFAULT '0',
  `messagestatus` smallint(6) NOT NULL DEFAULT '0',
  `statusstage` smallint(6) NOT NULL DEFAULT '0',
  `executionpath` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contents` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swkbarticledata`
--

CREATE TABLE `swkbarticledata` (
  `kbarticledataid` int(11) NOT NULL,
  `kbarticleid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci,
  `contentstext` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swkbarticlelinks`
--

CREATE TABLE `swkbarticlelinks` (
  `kbarticlelinkid` int(11) NOT NULL,
  `kbarticleid` int(11) NOT NULL DEFAULT '0',
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `linktypeid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swkbarticles`
--

CREATE TABLE `swkbarticles` (
  `kbarticleid` int(11) NOT NULL,
  `creator` smallint(6) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isedited` smallint(6) NOT NULL DEFAULT '0',
  `editeddateline` int(11) NOT NULL DEFAULT '0',
  `editedstaffid` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `isfeatured` smallint(6) NOT NULL DEFAULT '0',
  `allowcomments` smallint(6) NOT NULL DEFAULT '0',
  `totalcomments` int(11) NOT NULL DEFAULT '0',
  `hasattachments` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `articlestatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `articlerating` double NOT NULL DEFAULT '0',
  `ratinghits` int(11) NOT NULL DEFAULT '0',
  `ratingcount` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swkbarticlesubscribers`
--

CREATE TABLE `swkbarticlesubscribers` (
  `kbarticlesubscriberid` int(11) NOT NULL,
  `kbarticleid` int(11) NOT NULL DEFAULT '0',
  `creator` smallint(6) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swkbcategories`
--

CREATE TABLE `swkbcategories` (
  `kbcategoryid` int(11) NOT NULL,
  `parentkbcategoryid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `totalarticles` int(11) NOT NULL DEFAULT '0',
  `categorytype` smallint(6) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `articlesortorder` smallint(6) NOT NULL DEFAULT '0',
  `allowcomments` smallint(6) NOT NULL DEFAULT '0',
  `allowrating` smallint(6) NOT NULL DEFAULT '0',
  `ispublished` smallint(6) NOT NULL DEFAULT '0',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `staffvisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `isimporteddownloadcategory` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swlanguagephrases`
--

CREATE TABLE `swlanguagephrases` (
  `phraseid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL DEFAULT '0',
  `section` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sectioncode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `appname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contents` text COLLATE utf8_unicode_ci,
  `contentsdefault` text COLLATE utf8_unicode_ci,
  `ismaster` smallint(6) NOT NULL DEFAULT '1',
  `revertrequired` smallint(6) NOT NULL DEFAULT '0',
  `modified` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'notmodified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swlanguages`
--

CREATE TABLE `swlanguages` (
  `languageid` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `languagecode` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `charset` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `textdirection` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ltr',
  `ismaster` smallint(6) NOT NULL DEFAULT '0',
  `isdefault` smallint(6) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `isenabled` smallint(6) NOT NULL DEFAULT '1',
  `flagicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swmacrocategories`
--

CREATE TABLE `swmacrocategories` (
  `macrocategoryid` int(11) NOT NULL,
  `parentcategoryid` int(11) NOT NULL DEFAULT '0',
  `categorytype` smallint(6) NOT NULL DEFAULT '0',
  `restrictstaffgroupid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swmacroreplies`
--

CREATE TABLE `swmacroreplies` (
  `macroreplyid` int(11) NOT NULL,
  `macrocategoryid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `totalhits` int(11) NOT NULL DEFAULT '0',
  `lastusage` int(11) NOT NULL DEFAULT '0',
  `departmentid` double NOT NULL DEFAULT '-1',
  `ownerstaffid` double NOT NULL DEFAULT '-1',
  `tickettypeid` double NOT NULL DEFAULT '-1',
  `ticketstatusid` double NOT NULL DEFAULT '-1',
  `priorityid` double NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swmacroreplydata`
--

CREATE TABLE `swmacroreplydata` (
  `macroreplydataid` int(11) NOT NULL,
  `macroreplyid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci,
  `tagcontents` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swmailqueuedata`
--

CREATE TABLE `swmailqueuedata` (
  `mailqueuedataid` int(11) NOT NULL,
  `toemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fromemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fromname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `datatext` longtext COLLATE utf8_unicode_ci,
  `datahtml` longtext COLLATE utf8_unicode_ci,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ishtml` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnewscategories`
--

CREATE TABLE `swnewscategories` (
  `newscategoryid` int(11) NOT NULL,
  `categorytitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `newsitemcount` int(11) NOT NULL DEFAULT '0',
  `visibilitytype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastupdate` int(11) NOT NULL DEFAULT '0',
  `titlehash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnewscategorylinks`
--

CREATE TABLE `swnewscategorylinks` (
  `newscategorylinkid` int(11) NOT NULL,
  `newsitemid` int(11) NOT NULL DEFAULT '0',
  `newscategoryid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnewsitemdata`
--

CREATE TABLE `swnewsitemdata` (
  `newsitemdataid` int(11) NOT NULL,
  `newsitemid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnewsitems`
--

CREATE TABLE `swnewsitems` (
  `newsitemid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `newstype` smallint(6) NOT NULL DEFAULT '0',
  `newsstatus` smallint(6) NOT NULL DEFAULT '0',
  `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `emailsubject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8_unicode_ci,
  `descriptionhash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subjecthash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contentshash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `expiry` int(11) NOT NULL DEFAULT '0',
  `issynced` smallint(6) NOT NULL DEFAULT '0',
  `syncguidhash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `syncdateline` int(11) NOT NULL DEFAULT '0',
  `edited` smallint(6) NOT NULL DEFAULT '0',
  `editedstaffid` int(11) NOT NULL DEFAULT '0',
  `editeddateline` int(11) NOT NULL DEFAULT '0',
  `totalcomments` int(11) NOT NULL DEFAULT '0',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `staffvisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `allowcomments` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnewssubscriberhash`
--

CREATE TABLE `swnewssubscriberhash` (
  `newssubscriberhashid` int(11) NOT NULL,
  `newssubscriberid` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnewssubscribers`
--

CREATE TABLE `swnewssubscribers` (
  `newssubscriberid` int(11) NOT NULL,
  `tgroupid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `isvalidated` smallint(6) NOT NULL DEFAULT '0',
  `usergroupid` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnotificationactions`
--

CREATE TABLE `swnotificationactions` (
  `notificationactionid` int(11) NOT NULL,
  `notificationruleid` int(11) NOT NULL DEFAULT '0',
  `actiontype` smallint(6) NOT NULL DEFAULT '0',
  `contents` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnotificationcriteria`
--

CREATE TABLE `swnotificationcriteria` (
  `notificationcriteriaid` int(11) NOT NULL,
  `notificationruleid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ruleop` smallint(6) NOT NULL DEFAULT '0',
  `rulematch` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rulematchtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnotificationpool`
--

CREATE TABLE `swnotificationpool` (
  `notificationpoolid` int(11) NOT NULL,
  `notificationruleid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `contents` text COLLATE utf8_unicode_ci,
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swnotificationrules`
--

CREATE TABLE `swnotificationrules` (
  `notificationruleid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ruletype` smallint(6) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `emailprefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isenabled` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swonsitesessions`
--

CREATE TABLE `swonsitesessions` (
  `onsitesessionid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `sessioncode` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sessionhash` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `chatsessionid` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `chatobjectid` int(11) NOT NULL DEFAULT '0',
  `configid` smallint(6) NOT NULL DEFAULT '0',
  `peerjid` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `localjid` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserbans`
--

CREATE TABLE `swparserbans` (
  `parserbanid` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserlogdata`
--

CREATE TABLE `swparserlogdata` (
  `parserlogdataid` int(11) NOT NULL,
  `parserlogid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserlogs`
--

CREATE TABLE `swparserlogs` (
  `parserlogid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `emailqueueid` int(11) NOT NULL DEFAULT '0',
  `logtype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'failure',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fromemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `toemail` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `size` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `parsetimetaken` double NOT NULL DEFAULT '0',
  `responsetype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ticket',
  `ticketpostid` int(11) NOT NULL DEFAULT '0',
  `ticketmaskid` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `messageid` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserloopblocks`
--

CREATE TABLE `swparserloopblocks` (
  `parserloopblockid` int(11) NOT NULL,
  `restoretime` int(11) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserloophits`
--

CREATE TABLE `swparserloophits` (
  `parserloophitid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `emailaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserlooprules`
--

CREATE TABLE `swparserlooprules` (
  `parserloopruleid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `length` int(11) NOT NULL DEFAULT '0',
  `maxhits` int(11) NOT NULL DEFAULT '0',
  `restoreafter` int(11) NOT NULL DEFAULT '0',
  `ismaster` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserruleactions`
--

CREATE TABLE `swparserruleactions` (
  `parserruleactionid` int(11) NOT NULL,
  `parserruleid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `typedata` longtext COLLATE utf8_unicode_ci,
  `typechar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserrulecriteria`
--

CREATE TABLE `swparserrulecriteria` (
  `parserrulecriteriaid` int(11) NOT NULL,
  `parserruleid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ruleop` smallint(6) NOT NULL DEFAULT '0',
  `rulematch` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rulematchtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swparserrules`
--

CREATE TABLE `swparserrules` (
  `parserruleid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0',
  `ruletype` smallint(6) NOT NULL DEFAULT '0',
  `matchtype` smallint(6) NOT NULL DEFAULT '0',
  `stopprocessing` smallint(6) NOT NULL DEFAULT '0',
  `isenabled` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swqueuesignatures`
--

CREATE TABLE `swqueuesignatures` (
  `queuesignatureid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `emailqueueid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swratingresults`
--

CREATE TABLE `swratingresults` (
  `ratingresultid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `ratingid` int(11) NOT NULL DEFAULT '0',
  `ratingresult` double NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `creatortype` smallint(6) NOT NULL DEFAULT '0',
  `isedited` smallint(6) NOT NULL DEFAULT '0',
  `editorid` int(11) NOT NULL DEFAULT '0',
  `editortype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swratings`
--

CREATE TABLE `swratings` (
  `ratingid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `ratingscale` smallint(6) NOT NULL DEFAULT '0',
  `ratingvisibility` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'private',
  `ratingtype` smallint(6) NOT NULL DEFAULT '0',
  `staffvisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `iseditable` smallint(6) NOT NULL DEFAULT '0',
  `isclientonly` smallint(6) NOT NULL DEFAULT '0',
  `ratingtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swregistry`
--

CREATE TABLE `swregistry` (
  `vkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `data` longtext COLLATE utf8_unicode_ci,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `isvolatile` smallint(6) NOT NULL DEFAULT '0',
  `datasize` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swreportcategories`
--

CREATE TABLE `swreportcategories` (
  `reportcategoryid` int(11) NOT NULL,
  `visibilitytype` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swreporthistory`
--

CREATE TABLE `swreporthistory` (
  `reporthistoryid` int(11) NOT NULL,
  `reportid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `creatorstaffid` int(11) NOT NULL DEFAULT '0',
  `creatorstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `kql` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swreports`
--

CREATE TABLE `swreports` (
  `reportid` int(11) NOT NULL,
  `reportcategoryid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `basetablename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `basetablenametext` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `creatorstaffid` int(11) NOT NULL DEFAULT '0',
  `creatorstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `visibilitytype` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `updatedateline` int(11) NOT NULL DEFAULT '0',
  `updatestaffid` int(11) NOT NULL DEFAULT '0',
  `updatestaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `executedateline` int(11) NOT NULL DEFAULT '0',
  `executestaffid` int(11) NOT NULL DEFAULT '0',
  `executestaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `executetimetaken` int(11) NOT NULL DEFAULT '0',
  `chartsenabled` smallint(6) NOT NULL DEFAULT '1',
  `kql` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swreportschedules`
--

CREATE TABLE `swreportschedules` (
  `scheduleid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `reportid` int(11) NOT NULL DEFAULT '0',
  `isexecuted` smallint(6) NOT NULL DEFAULT '0',
  `lastrun` int(11) DEFAULT '0',
  `nextrun` int(11) NOT NULL DEFAULT '0',
  `cday` int(11) DEFAULT '0',
  `format` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Excel',
  `recurrencetype` smallint(6) NOT NULL DEFAULT '0',
  `ccemails` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swreportusagelogs`
--

CREATE TABLE `swreportusagelogs` (
  `reportusagelogid` int(11) NOT NULL,
  `reportid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timetaken` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsearchindex`
--

CREATE TABLE `swsearchindex` (
  `objid` int(11) NOT NULL,
  `subobjid` int(11) DEFAULT '0',
  `type` smallint(6) DEFAULT NULL,
  `ft` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsearchstoredata`
--

CREATE TABLE `swsearchstoredata` (
  `searchstoredataid` int(11) NOT NULL,
  `searchstoreid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `dataid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsearchstores`
--

CREATE TABLE `swsearchstores` (
  `searchstoreid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `sessionid` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastupdate` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `storetype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsessions`
--

CREATE TABLE `swsessions` (
  `sessionid` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `lastactivity` int(11) NOT NULL DEFAULT '0',
  `lastactivitycustom` int(11) NOT NULL DEFAULT '0',
  `useragent` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isloggedin` smallint(6) NOT NULL DEFAULT '0',
  `sessiontype` int(11) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `sessionhits` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `phonestatus` smallint(6) NOT NULL DEFAULT '0',
  `captcha` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gridcolor` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `visitorgroupid` smallint(6) NOT NULL DEFAULT '0',
  `departmentid` smallint(6) NOT NULL DEFAULT '0',
  `proactiveresult` smallint(6) NOT NULL DEFAULT '0',
  `ticketviewid` smallint(6) NOT NULL DEFAULT '0',
  `iswinapp` smallint(6) NOT NULL DEFAULT '0',
  `csrfhash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `languagecode` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsettings`
--

CREATE TABLE `swsettings` (
  `settingid` int(11) NOT NULL,
  `section` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `vkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `data` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsettingsfields`
--

CREATE TABLE `swsettingsfields` (
  `sfieldid` int(11) NOT NULL,
  `sgroupid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `customvalue` longtext COLLATE utf8_unicode_ci,
  `iscustom` smallint(6) NOT NULL DEFAULT '0',
  `settingtype` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `app` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsettingsgroups`
--

CREATE TABLE `swsettingsgroups` (
  `sgroupid` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `app` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `ishidden` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swsignatures`
--

CREATE TABLE `swsignatures` (
  `signatureid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `signature` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swslaholidaylinks`
--

CREATE TABLE `swslaholidaylinks` (
  `slaholidaylinkid` int(11) NOT NULL,
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `slaholidayid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swslaholidays`
--

CREATE TABLE `swslaholidays` (
  `slaholidayid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `holidayday` smallint(6) NOT NULL DEFAULT '0',
  `holidaymonth` smallint(6) NOT NULL DEFAULT '0',
  `holidaydate` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `flagicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iscustom` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swslaplans`
--

CREATE TABLE `swslaplans` (
  `slaplanid` int(11) NOT NULL,
  `slascheduleid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `overduehrs` double NOT NULL DEFAULT '0',
  `resolutionduehrs` double NOT NULL DEFAULT '0',
  `isenabled` smallint(6) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0',
  `ruletype` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swslarulecriteria`
--

CREATE TABLE `swslarulecriteria` (
  `slarulecriteriaid` int(11) NOT NULL,
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ruleop` smallint(6) NOT NULL DEFAULT '0',
  `rulematch` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rulematchtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swslaschedules`
--

CREATE TABLE `swslaschedules` (
  `slascheduleid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sunday_open` smallint(6) NOT NULL DEFAULT '0',
  `monday_open` smallint(6) NOT NULL DEFAULT '0',
  `tuesday_open` smallint(6) NOT NULL DEFAULT '0',
  `wednesday_open` smallint(6) NOT NULL DEFAULT '0',
  `thursday_open` smallint(6) NOT NULL DEFAULT '0',
  `friday_open` smallint(6) NOT NULL DEFAULT '0',
  `saturday_open` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swslascheduletable`
--

CREATE TABLE `swslascheduletable` (
  `slascheduletableid` int(11) NOT NULL,
  `slascheduleid` int(11) NOT NULL DEFAULT '0',
  `sladay` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `opentimeline` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00:00',
  `closetimeline` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaff`
--

CREATE TABLE `swstaff` (
  `staffid` int(11) NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffpassword` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `islegacypassword` smallint(6) NOT NULL DEFAULT '0',
  `designation` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `greeting` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffgroupid` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobilenumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `statusmessage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastprofileupdate` int(11) NOT NULL DEFAULT '0',
  `lastvisit` int(11) NOT NULL DEFAULT '0',
  `lastvisit2` int(11) NOT NULL DEFAULT '0',
  `lastactivity` int(11) NOT NULL DEFAULT '0',
  `enabledst` smallint(6) NOT NULL DEFAULT '0',
  `startofweek` int(11) NOT NULL DEFAULT '1',
  `pmunread` int(11) NOT NULL DEFAULT '0',
  `groupassigns` smallint(6) NOT NULL DEFAULT '1',
  `enablepmalerts` smallint(6) NOT NULL DEFAULT '1',
  `enablepmjsalerts` smallint(6) NOT NULL DEFAULT '1',
  `ticketviewid` int(11) NOT NULL DEFAULT '0',
  `isenabled` smallint(6) NOT NULL DEFAULT '1',
  `passwordupdatetimeline` int(11) NOT NULL DEFAULT '0',
  `iprestriction` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timezonephp` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffactivitylog`
--

CREATE TABLE `swstaffactivitylog` (
  `staffactivitylogid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `forwardedipaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `useragent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actiontype` smallint(6) NOT NULL DEFAULT '0',
  `sectiontype` smallint(6) NOT NULL DEFAULT '0',
  `interfacetype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffassigns`
--

CREATE TABLE `swstaffassigns` (
  `staffassignid` int(11) NOT NULL,
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffgroup`
--

CREATE TABLE `swstaffgroup` (
  `staffgroupid` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isadmin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffgrouplinks`
--

CREATE TABLE `swstaffgrouplinks` (
  `staffgrouplinkid` int(11) NOT NULL,
  `toassignid` int(11) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `staffgroupid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffgroupsettings`
--

CREATE TABLE `swstaffgroupsettings` (
  `sgroupsettingid` int(11) NOT NULL,
  `staffgroupid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffloginlog`
--

CREATE TABLE `swstaffloginlog` (
  `staffloginlogid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `logindateline` int(11) NOT NULL DEFAULT '0',
  `activitydateline` int(11) NOT NULL DEFAULT '0',
  `logoutdateline` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffusername` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `forwardedipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `useragent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sessionid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `logouttype` smallint(6) NOT NULL DEFAULT '0',
  `loginresult` smallint(6) NOT NULL DEFAULT '0',
  `interfacetype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffprofileimages`
--

CREATE TABLE `swstaffprofileimages` (
  `staffprofileimageid` int(11) NOT NULL,
  `type` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `imagedata` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffproperties`
--

CREATE TABLE `swstaffproperties` (
  `staffpropertyid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `updatedateline` int(11) NOT NULL DEFAULT '0',
  `keyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `keyvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swstaffsettings`
--

CREATE TABLE `swstaffsettings` (
  `staffsettingid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtaglinks`
--

CREATE TABLE `swtaglinks` (
  `taglinkid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `tagid` int(11) NOT NULL DEFAULT '0',
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `linkid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtags`
--

CREATE TABLE `swtags` (
  `tagid` int(11) NOT NULL,
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `tagname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `linkcount` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtemplatecategories`
--

CREATE TABLE `swtemplatecategories` (
  `tcategoryid` int(11) NOT NULL,
  `tgroupid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `app` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtemplatedata`
--

CREATE TABLE `swtemplatedata` (
  `templatedataid` int(11) NOT NULL,
  `templateid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci,
  `contentsdefault` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtemplategroups`
--

CREATE TABLE `swtemplategroups` (
  `tgroupid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL DEFAULT '0',
  `isenabled` smallint(6) NOT NULL DEFAULT '0',
  `guestusergroupid` int(11) NOT NULL DEFAULT '0',
  `regusergroupid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(155) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `companyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ismaster` smallint(6) NOT NULL DEFAULT '0',
  `enablepassword` smallint(6) NOT NULL DEFAULT '0',
  `groupusername` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `grouppassword` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `restrictgroups` smallint(6) NOT NULL DEFAULT '0',
  `isdefault` smallint(6) NOT NULL DEFAULT '0',
  `useloginshare` smallint(6) NOT NULL DEFAULT '0',
  `loginapi_appid` smallint(6) NOT NULL DEFAULT '0',
  `ticketstatusid` int(11) NOT NULL DEFAULT '0',
  `priorityid` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `tickettypeid` int(11) NOT NULL DEFAULT '0',
  `departmentid_livechat` int(11) NOT NULL DEFAULT '0',
  `tickets_prompttype` smallint(6) NOT NULL DEFAULT '0',
  `tickets_promptpriority` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtemplatehistory`
--

CREATE TABLE `swtemplatehistory` (
  `templatehistoryid` int(11) NOT NULL,
  `templateid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `changelognotes` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `templatelength` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `templateversion` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1.00.00',
  `contents` longtext COLLATE utf8_unicode_ci,
  `contentshash` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtemplates`
--

CREATE TABLE `swtemplates` (
  `templateid` int(11) NOT NULL,
  `tgroupid` int(11) NOT NULL DEFAULT '0',
  `tcategoryid` int(11) NOT NULL DEFAULT '0',
  `templateversion` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1.00.00',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `templatelength` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `modified` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'notmodified',
  `contentshash` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iscustom` smallint(6) NOT NULL DEFAULT '0',
  `contentsdefaulthash` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketauditlogs`
--

CREATE TABLE `swticketauditlogs` (
  `ticketauditlogid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `ticketpostid` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `departmenttitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `creatortype` smallint(6) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `creatorfullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actiontype` smallint(6) NOT NULL DEFAULT '0',
  `actionmsg` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `valuetype` int(11) NOT NULL DEFAULT '0',
  `oldvalueid` int(11) NOT NULL DEFAULT '0',
  `oldvaluestring` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `newvalueid` int(11) NOT NULL DEFAULT '0',
  `newvaluestring` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actionhash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketdrafts`
--

CREATE TABLE `swticketdrafts` (
  `ticketdraftid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isedited` smallint(6) NOT NULL DEFAULT '0',
  `editedstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `editedbystaffid` int(11) NOT NULL DEFAULT '0',
  `editeddateline` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketemails`
--

CREATE TABLE `swticketemails` (
  `ticketemailid` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `issearchable` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketfiletypes`
--

CREATE TABLE `swticketfiletypes` (
  `ticketfiletypeid` int(11) NOT NULL,
  `extension` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `maxsize` int(11) NOT NULL DEFAULT '0',
  `acceptsupportcenter` smallint(6) NOT NULL DEFAULT '0',
  `acceptmailparser` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketfilterfields`
--

CREATE TABLE `swticketfilterfields` (
  `ticketfilterfieldid` int(11) NOT NULL,
  `ticketfilterid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `fieldtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fieldoper` int(11) NOT NULL DEFAULT '0',
  `fieldvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketfilters`
--

CREATE TABLE `swticketfilters` (
  `ticketfilterid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastactivity` int(11) NOT NULL DEFAULT '0',
  `filtertype` smallint(6) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `restrictstaffgroupid` int(11) NOT NULL DEFAULT '0',
  `criteriaoptions` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketfollowups`
--

CREATE TABLE `swticketfollowups` (
  `ticketfollowupid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `executiondateline` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dochangeproperties` smallint(6) NOT NULL DEFAULT '0',
  `ownerstaffid` double NOT NULL DEFAULT '0',
  `departmentid` double NOT NULL DEFAULT '0',
  `ticketstatusid` double NOT NULL DEFAULT '0',
  `tickettypeid` double NOT NULL DEFAULT '0',
  `priorityid` double NOT NULL DEFAULT '0',
  `dochangeduedateline` smallint(6) NOT NULL DEFAULT '0',
  `duedateline` int(11) NOT NULL DEFAULT '0',
  `resolutionduedateline` int(11) NOT NULL DEFAULT '0',
  `timeworked` int(11) NOT NULL DEFAULT '0',
  `timebillable` int(11) NOT NULL DEFAULT '0',
  `donote` smallint(6) NOT NULL DEFAULT '0',
  `notetype` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `notecolor` smallint(6) NOT NULL DEFAULT '0',
  `ticketnotes` longtext COLLATE utf8_unicode_ci,
  `doreply` smallint(6) NOT NULL DEFAULT '0',
  `replycontents` longtext COLLATE utf8_unicode_ci,
  `doforward` smallint(6) NOT NULL DEFAULT '0',
  `forwardemailto` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `forwardcontents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketlinkchains`
--

CREATE TABLE `swticketlinkchains` (
  `ticketlinkchainid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `ticketlinktypeid` int(11) NOT NULL DEFAULT '0',
  `chainhash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketlinkedtables`
--

CREATE TABLE `swticketlinkedtables` (
  `ticketlinkedtableid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `linktypeid` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketlinktypes`
--

CREATE TABLE `swticketlinktypes` (
  `ticketlinktypeid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `linktypetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketlocks`
--

CREATE TABLE `swticketlocks` (
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketmergelog`
--

CREATE TABLE `swticketmergelog` (
  `ticketmergelogid` int(11) NOT NULL,
  `oldticketid` int(11) NOT NULL DEFAULT '0',
  `oldticketmaskid` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketmessageids`
--

CREATE TABLE `swticketmessageids` (
  `ticketmessageid` int(11) NOT NULL,
  `messageid` varchar(17) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `ticketpostid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketnotes`
--

CREATE TABLE `swticketnotes` (
  `ticketnoteid` int(11) NOT NULL,
  `linktypeid` int(11) NOT NULL DEFAULT '0',
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `forstaffid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `isedited` smallint(6) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `editedstaffid` int(11) NOT NULL DEFAULT '0',
  `editedstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `editedtimeline` int(11) NOT NULL DEFAULT '0',
  `notecolor` int(11) NOT NULL DEFAULT '0',
  `note` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketpostlocks`
--

CREATE TABLE `swticketpostlocks` (
  `ticketpostlockid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `contents` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketposts`
--

CREATE TABLE `swticketposts` (
  `ticketpostid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `emailto` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `hasattachments` smallint(6) NOT NULL DEFAULT '0',
  `edited` smallint(6) NOT NULL DEFAULT '0',
  `editedbystaffid` int(11) NOT NULL DEFAULT '0',
  `editeddateline` int(11) NOT NULL DEFAULT '0',
  `creator` smallint(6) NOT NULL DEFAULT '0',
  `isthirdparty` smallint(6) NOT NULL DEFAULT '0',
  `ishtml` smallint(6) NOT NULL DEFAULT '0',
  `isemailed` smallint(6) NOT NULL DEFAULT '0',
  `isprivate` smallint(6) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `contents` longtext COLLATE utf8_unicode_ci,
  `contenthash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subjecthash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `issurveycomment` smallint(6) NOT NULL DEFAULT '0',
  `creationmode` smallint(6) NOT NULL DEFAULT '0',
  `responsetime` int(11) NOT NULL DEFAULT '0',
  `firstresponsetime` int(11) NOT NULL DEFAULT '0',
  `slaresponsetime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketpriorities`
--

CREATE TABLE `swticketpriorities` (
  `priorityid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `frcolorcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bgcolorcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iscustom` smallint(6) NOT NULL DEFAULT '1',
  `ismaster` smallint(6) NOT NULL DEFAULT '1',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketrecipients`
--

CREATE TABLE `swticketrecipients` (
  `ticketrecipientid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `ticketemailid` int(11) NOT NULL DEFAULT '0',
  `recipienttype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketrecurrences`
--

CREATE TABLE `swticketrecurrences` (
  `ticketrecurrenceid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `tickettype` smallint(6) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `ownerstaffid` int(11) NOT NULL DEFAULT '0',
  `tickettypeid` int(11) NOT NULL DEFAULT '0',
  `ticketstatusid` int(11) NOT NULL DEFAULT '0',
  `ticketpriorityid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `dontsendemail` smallint(6) NOT NULL DEFAULT '0',
  `dispatchautoresponder` smallint(6) NOT NULL DEFAULT '0',
  `intervaltype` smallint(6) NOT NULL DEFAULT '0',
  `intervalstep` int(11) NOT NULL DEFAULT '0',
  `daily_everyweekday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_monday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_tuesday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_wednesday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_thursday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_friday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_saturday` smallint(6) NOT NULL DEFAULT '0',
  `weekly_sunday` smallint(6) NOT NULL DEFAULT '0',
  `monthly_type` smallint(6) NOT NULL DEFAULT '0',
  `monthly_day` smallint(6) NOT NULL DEFAULT '0',
  `monthly_extdaystep` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `monthly_extday` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `yearly_type` smallint(6) NOT NULL DEFAULT '0',
  `yearly_month` smallint(6) NOT NULL DEFAULT '0',
  `yearly_monthday` smallint(6) NOT NULL DEFAULT '0',
  `yearly_extdaystep` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `yearly_extday` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `yearly_extmonth` smallint(6) NOT NULL DEFAULT '0',
  `startdateline` int(11) NOT NULL DEFAULT '0',
  `endtype` smallint(6) NOT NULL DEFAULT '0',
  `enddateline` int(11) NOT NULL DEFAULT '0',
  `endcount` int(11) NOT NULL DEFAULT '0',
  `creationcount` int(11) NOT NULL DEFAULT '0',
  `nextrecurrence` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtickets`
--

CREATE TABLE `swtickets` (
  `ticketid` int(11) NOT NULL,
  `ticketmaskid` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `departmenttitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ticketstatusid` int(11) NOT NULL DEFAULT '0',
  `ticketstatustitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `priorityid` int(11) NOT NULL DEFAULT '0',
  `prioritytitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `emailqueueid` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `ownerstaffid` int(11) NOT NULL DEFAULT '0',
  `ownerstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `assignstatus` smallint(6) NOT NULL DEFAULT '0',
  `fullname` varchar(225) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastreplier` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `replyto` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastactivity` int(11) NOT NULL DEFAULT '0',
  `laststaffreplytime` int(11) NOT NULL DEFAULT '0',
  `lastuserreplytime` int(11) NOT NULL DEFAULT '0',
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `ticketslaplanid` int(11) NOT NULL DEFAULT '0',
  `duetime` int(11) NOT NULL DEFAULT '0',
  `totalreplies` int(11) NOT NULL DEFAULT '0',
  `ipaddress` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `flagtype` smallint(6) NOT NULL DEFAULT '0',
  `hasnotes` smallint(6) NOT NULL DEFAULT '0',
  `hasattachments` smallint(6) NOT NULL DEFAULT '0',
  `isemailed` smallint(6) NOT NULL DEFAULT '0',
  `edited` smallint(6) NOT NULL DEFAULT '0',
  `editedbystaffid` int(11) NOT NULL DEFAULT '0',
  `editeddateline` int(11) NOT NULL DEFAULT '0',
  `creator` smallint(6) NOT NULL DEFAULT '0',
  `charset` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `transferencoding` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timeworked` int(11) NOT NULL DEFAULT '0',
  `timebilled` int(11) NOT NULL DEFAULT '0',
  `dateicon` int(11) NOT NULL DEFAULT '0',
  `lastpostid` int(11) NOT NULL DEFAULT '0',
  `firstpostid` int(11) NOT NULL DEFAULT '0',
  `tgroupid` int(11) NOT NULL DEFAULT '0',
  `messageid` varchar(17) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `escalationruleid` int(11) NOT NULL DEFAULT '0',
  `hasdraft` smallint(6) NOT NULL DEFAULT '0',
  `hasbilling` smallint(6) NOT NULL DEFAULT '0',
  `isphonecall` smallint(6) NOT NULL DEFAULT '0',
  `isescalated` smallint(6) NOT NULL DEFAULT '0',
  `isescalatedvolatile` smallint(6) NOT NULL DEFAULT '0',
  `phoneno` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isautoclosed` smallint(6) NOT NULL DEFAULT '0',
  `autocloseruleid` int(11) NOT NULL DEFAULT '0',
  `autoclosestatus` smallint(6) NOT NULL DEFAULT '0',
  `autoclosetimeline` int(11) NOT NULL DEFAULT '0',
  `escalatedtime` int(11) NOT NULL DEFAULT '0',
  `followupcount` int(11) NOT NULL DEFAULT '0',
  `hasfollowup` smallint(6) NOT NULL DEFAULT '0',
  `hasratings` smallint(6) NOT NULL DEFAULT '0',
  `tickethash` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `islinked` smallint(6) NOT NULL DEFAULT '0',
  `trasholddepartmentid` int(11) DEFAULT '0',
  `tickettype` smallint(6) NOT NULL DEFAULT '0',
  `tickettypeid` int(11) NOT NULL DEFAULT '0',
  `tickettypetitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `creationmode` smallint(6) NOT NULL DEFAULT '0',
  `isfirstcontactresolved` smallint(6) NOT NULL DEFAULT '0',
  `wasreopened` smallint(6) NOT NULL DEFAULT '0',
  `reopendateline` int(11) NOT NULL DEFAULT '0',
  `resolutiondateline` int(11) NOT NULL DEFAULT '0',
  `escalationlevelcount` int(11) NOT NULL DEFAULT '0',
  `resolutionseconds` int(11) NOT NULL DEFAULT '0',
  `resolutionlevel` int(11) NOT NULL DEFAULT '0',
  `repliestoresolution` int(11) NOT NULL DEFAULT '0',
  `averageresponsetime` int(11) NOT NULL DEFAULT '0',
  `averageresponsetimehits` int(11) NOT NULL DEFAULT '0',
  `firstresponsetime` int(11) NOT NULL DEFAULT '0',
  `resolutionduedateline` int(11) NOT NULL DEFAULT '0',
  `isresolved` smallint(6) NOT NULL DEFAULT '0',
  `iswatched` smallint(6) NOT NULL DEFAULT '0',
  `oldeditemailaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `linkkbarticleid` int(11) NOT NULL DEFAULT '0',
  `linkticketmacroid` int(11) NOT NULL DEFAULT '0',
  `bayescategoryid` int(11) NOT NULL DEFAULT '0',
  `recurrencefromticketid` int(11) NOT NULL DEFAULT '0',
  `averageslaresponsetime` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketstatus`
--

CREATE TABLE `swticketstatus` (
  `ticketstatusid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `iscustom` smallint(6) NOT NULL DEFAULT '1',
  `displayinmainlist` smallint(6) NOT NULL DEFAULT '0',
  `markasresolved` smallint(6) NOT NULL DEFAULT '0',
  `ismaster` smallint(6) NOT NULL DEFAULT '0',
  `statustype` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `displaycount` smallint(6) NOT NULL DEFAULT '0',
  `statuscolor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `statusbgcolor` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `resetduetime` smallint(6) NOT NULL DEFAULT '0',
  `displayicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffvisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `dispatchnotification` smallint(6) NOT NULL DEFAULT '0',
  `triggersurvey` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtickettimetracknotes`
--

CREATE TABLE `swtickettimetracknotes` (
  `tickettimetracknoteid` int(11) NOT NULL,
  `tickettimetrackid` int(11) NOT NULL DEFAULT '0',
  `notes` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtickettimetracks`
--

CREATE TABLE `swtickettimetracks` (
  `tickettimetrackid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `workdateline` int(11) NOT NULL DEFAULT '0',
  `creatorstaffid` int(11) NOT NULL DEFAULT '0',
  `creatorstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timespent` int(11) NOT NULL DEFAULT '0',
  `timebillable` int(11) NOT NULL DEFAULT '0',
  `isedited` smallint(6) NOT NULL DEFAULT '0',
  `editedstaffid` int(11) NOT NULL DEFAULT '0',
  `editedstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `editedtimeline` int(11) NOT NULL DEFAULT '0',
  `notecolor` int(11) NOT NULL DEFAULT '0',
  `workerstaffid` int(11) NOT NULL DEFAULT '0',
  `workerstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sessionhash` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swtickettypes`
--

CREATE TABLE `swtickettypes` (
  `tickettypeid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `departmentid` int(11) NOT NULL DEFAULT '0',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `ismaster` smallint(6) NOT NULL DEFAULT '0',
  `displayicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketviewfields`
--

CREATE TABLE `swticketviewfields` (
  `ticketviewfieldid` int(11) NOT NULL,
  `ticketviewid` int(11) NOT NULL DEFAULT '0',
  `fieldtype` smallint(6) NOT NULL DEFAULT '0',
  `fieldtypeid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketviewlinks`
--

CREATE TABLE `swticketviewlinks` (
  `ticketviewlinkid` int(11) NOT NULL,
  `ticketviewid` int(11) NOT NULL DEFAULT '0',
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `linktypeid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketviews`
--

CREATE TABLE `swticketviews` (
  `ticketviewid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `viewscope` smallint(6) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `viewalltickets` smallint(6) NOT NULL DEFAULT '0',
  `viewunassigned` smallint(6) NOT NULL DEFAULT '0',
  `viewassigned` smallint(6) NOT NULL DEFAULT '0',
  `sortby` smallint(6) NOT NULL DEFAULT '0',
  `sortorder` smallint(6) NOT NULL DEFAULT '0',
  `ismaster` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ticketsperpage` int(11) NOT NULL DEFAULT '0',
  `autorefresh` smallint(6) NOT NULL DEFAULT '0',
  `setasowner` smallint(6) NOT NULL DEFAULT '0',
  `defaultstatusonreply` smallint(6) NOT NULL DEFAULT '0',
  `afterreplyaction` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketwatchers`
--

CREATE TABLE `swticketwatchers` (
  `ticketwatcherid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ticketid` int(11) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketworkflowactions`
--

CREATE TABLE `swticketworkflowactions` (
  `ticketworkflowactionid` int(11) NOT NULL,
  `ticketworkflowid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `typedata` longtext COLLATE utf8_unicode_ci,
  `typechar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketworkflowcriteria`
--

CREATE TABLE `swticketworkflowcriteria` (
  `ticketworkflowcriteriaid` int(11) NOT NULL,
  `ticketworkflowid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ruleop` smallint(6) NOT NULL DEFAULT '0',
  `rulematch` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rulematchtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketworkflownotifications`
--

CREATE TABLE `swticketworkflownotifications` (
  `ticketworkflownotificationid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `ticketworkflowid` int(11) NOT NULL DEFAULT '0',
  `notificationtype` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notificationcontents` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swticketworkflows`
--

CREATE TABLE `swticketworkflows` (
  `ticketworkflowid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isenabled` smallint(6) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL DEFAULT '0',
  `ruletype` smallint(6) NOT NULL DEFAULT '0',
  `staffvisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swuseremails`
--

CREATE TABLE `swuseremails` (
  `useremailid` int(11) NOT NULL,
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `linktypeid` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isprimary` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swusergroupassigns`
--

CREATE TABLE `swusergroupassigns` (
  `usergroupassignid` int(11) NOT NULL,
  `toassignid` int(11) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '0',
  `usergroupid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swusergroups`
--

CREATE TABLE `swusergroups` (
  `usergroupid` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `grouptype` int(11) NOT NULL DEFAULT '0',
  `ismaster` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swusergroupsettings`
--

CREATE TABLE `swusergroupsettings` (
  `ugroupsettingid` int(11) NOT NULL,
  `usergroupid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swuserloginlog`
--

CREATE TABLE `swuserloginlog` (
  `userloginlogid` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `logindateline` int(11) NOT NULL DEFAULT '0',
  `activitydateline` int(11) NOT NULL DEFAULT '0',
  `logoutdateline` int(11) NOT NULL DEFAULT '0',
  `userfullname` varchar(255) NOT NULL DEFAULT '',
  `useremail` varchar(255) NOT NULL DEFAULT '',
  `ipaddress` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `forwardedipaddress` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `useragent` varchar(255) NOT NULL DEFAULT '',
  `sessionid` varchar(255) NOT NULL DEFAULT '',
  `logouttype` smallint(6) NOT NULL DEFAULT '0',
  `loginresult` smallint(6) NOT NULL DEFAULT '0',
  `interfacetype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `swusernotedata`
--

CREATE TABLE `swusernotedata` (
  `usernotedataid` int(11) NOT NULL,
  `usernoteid` int(11) NOT NULL DEFAULT '0',
  `notecontents` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swusernotes`
--

CREATE TABLE `swusernotes` (
  `usernoteid` int(11) NOT NULL,
  `linktypeid` int(11) NOT NULL DEFAULT '0',
  `linktype` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastupdated` int(11) NOT NULL DEFAULT '0',
  `isedited` smallint(6) NOT NULL DEFAULT '0',
  `staffid` int(11) NOT NULL DEFAULT '0',
  `staffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `editedstaffid` int(11) NOT NULL DEFAULT '0',
  `editedstaffname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `editedtimeline` int(11) NOT NULL DEFAULT '0',
  `notecolor` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swuserorganizations`
--

CREATE TABLE `swuserorganizations` (
  `userorganizationid` int(11) NOT NULL,
  `organizationname` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `organizationtype` smallint(6) NOT NULL DEFAULT '0',
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `postalcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastupdate` int(11) NOT NULL DEFAULT '0',
  `languageid` int(11) NOT NULL DEFAULT '0',
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `slaexpirytimeline` int(11) NOT NULL DEFAULT '0',
  `usergroupid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swuserprofileimages`
--

CREATE TABLE `swuserprofileimages` (
  `userprofileimageid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `imagedata` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swuserproperties`
--

CREATE TABLE `swuserproperties` (
  `userpropertyid` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `updatedateline` int(11) NOT NULL DEFAULT '0',
  `keyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `keyvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swusers`
--

CREATE TABLE `swusers` (
  `userid` int(11) NOT NULL,
  `usergroupid` int(11) NOT NULL DEFAULT '0',
  `userrole` smallint(6) NOT NULL DEFAULT '0',
  `userorganizationid` int(11) NOT NULL DEFAULT '0',
  `salutation` smallint(6) NOT NULL DEFAULT '0',
  `fullname` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userdesignation` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userpassword` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `islegacypassword` smallint(6) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `lastupdate` int(11) NOT NULL DEFAULT '0',
  `lastvisit` int(11) NOT NULL DEFAULT '0',
  `lastvisit2` int(11) NOT NULL DEFAULT '0',
  `lastactivity` int(11) NOT NULL DEFAULT '0',
  `lastvisitip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastvisitip2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `isenabled` smallint(6) NOT NULL DEFAULT '0',
  `languageid` int(11) NOT NULL DEFAULT '0',
  `timezonephp` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `enabledst` smallint(6) NOT NULL DEFAULT '0',
  `useremailcount` int(11) NOT NULL DEFAULT '0',
  `slaplanid` int(11) NOT NULL DEFAULT '0',
  `slaexpirytimeline` int(11) NOT NULL DEFAULT '0',
  `userexpirytimeline` int(11) NOT NULL DEFAULT '0',
  `isvalidated` int(11) NOT NULL DEFAULT '0',
  `profileprompt` smallint(6) NOT NULL DEFAULT '0',
  `hasgeoip` smallint(6) NOT NULL DEFAULT '0',
  `geoiptimezone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipisp` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoiporganization` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipnetspeed` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipcountry` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipcountrydesc` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipregion` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipcity` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoippostalcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoiplatitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoiplongitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipmetrocode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `geoipareacode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swusersettings`
--

CREATE TABLE `swusersettings` (
  `usersettingid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swuserverifyhash`
--

CREATE TABLE `swuserverifyhash` (
  `userverifyhashid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(11) NOT NULL DEFAULT '0',
  `hashtype` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `swwidgets`
--

CREATE TABLE `swwidgets` (
  `widgetid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL DEFAULT '0',
  `defaulttitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `appname` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `widgetlink` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `defaulticon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `defaultsmallicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `displayorder` int(11) NOT NULL DEFAULT '0',
  `displayinnavbar` smallint(6) NOT NULL DEFAULT '0',
  `displayinindex` smallint(6) NOT NULL DEFAULT '0',
  `ismaster` smallint(6) NOT NULL DEFAULT '0',
  `isenabled` smallint(6) NOT NULL DEFAULT '0',
  `widgetvisibility` smallint(6) NOT NULL DEFAULT '0',
  `uservisibilitycustom` smallint(6) NOT NULL DEFAULT '0',
  `widgetname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `staffid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `statusboard`
--
ALTER TABLE `statusboard`
  ADD PRIMARY KEY (`indexnumber`);

--
-- Indexes for table `swapplogdata`
--
ALTER TABLE `swapplogdata`
  ADD PRIMARY KEY (`applogdataid`),
  ADD KEY `applogdata1` (`applogid`);

--
-- Indexes for table `swapplogs`
--
ALTER TABLE `swapplogs`
  ADD PRIMARY KEY (`applogid`),
  ADD KEY `applogs1` (`appname`,`logtype`),
  ADD KEY `applogs2` (`logtype`);

--
-- Indexes for table `swattachmentchunks`
--
ALTER TABLE `swattachmentchunks`
  ADD PRIMARY KEY (`chunkid`),
  ADD KEY `attachmentchunks1` (`attachmentid`);

--
-- Indexes for table `swattachments`
--
ALTER TABLE `swattachments`
  ADD PRIMARY KEY (`attachmentid`),
  ADD KEY `attachments1` (`linktype`,`linktypeid`),
  ADD KEY `attachments2` (`attachmenttype`),
  ADD KEY `attachments3` (`downloaditemid`),
  ADD KEY `attachments4` (`ticketid`,`linktype`,`linktypeid`),
  ADD KEY `attachments5` (`linktype`,`ticketid`,`linktypeid`),
  ADD KEY `attachments6` (`linktype`,`ticketid`,`attachmentid`);

--
-- Indexes for table `swautoclosecriteria`
--
ALTER TABLE `swautoclosecriteria`
  ADD PRIMARY KEY (`autoclosecriteriaid`),
  ADD KEY `autoclosecriteria1` (`autocloseruleid`);

--
-- Indexes for table `swautocloserules`
--
ALTER TABLE `swautocloserules`
  ADD PRIMARY KEY (`autocloseruleid`),
  ADD KEY `autocloserules1` (`isenabled`,`sortorder`),
  ADD KEY `autocloserules2` (`title`);

--
-- Indexes for table `swbayescategories`
--
ALTER TABLE `swbayescategories`
  ADD PRIMARY KEY (`bayescategoryid`),
  ADD KEY `bayescategories1` (`category`);

--
-- Indexes for table `swbayeswords`
--
ALTER TABLE `swbayeswords`
  ADD PRIMARY KEY (`bayeswordid`),
  ADD UNIQUE KEY `bayeswords1` (`word`);

--
-- Indexes for table `swbayeswordsfreqs`
--
ALTER TABLE `swbayeswordsfreqs`
  ADD UNIQUE KEY `bayeswordsfreqs1` (`bayeswordid`,`bayescategoryid`);

--
-- Indexes for table `swbreaklines`
--
ALTER TABLE `swbreaklines`
  ADD PRIMARY KEY (`breaklineid`),
  ADD KEY `breaklines1` (`breakline`);

--
-- Indexes for table `swcatchallrules`
--
ALTER TABLE `swcatchallrules`
  ADD PRIMARY KEY (`catchallruleid`);

--
-- Indexes for table `swcommentdata`
--
ALTER TABLE `swcommentdata`
  ADD PRIMARY KEY (`commentdataid`),
  ADD KEY `commentdata1` (`commentid`);

--
-- Indexes for table `swcomments`
--
ALTER TABLE `swcomments`
  ADD PRIMARY KEY (`commentid`),
  ADD KEY `comments1` (`commenttype`,`commentstatus`,`typeid`),
  ADD KEY `comments2` (`parentcommentid`),
  ADD KEY `comments3` (`dateline`);

--
-- Indexes for table `swcron`
--
ALTER TABLE `swcron`
  ADD PRIMARY KEY (`cronid`);

--
-- Indexes for table `swcronlogs`
--
ALTER TABLE `swcronlogs`
  ADD PRIMARY KEY (`cronlogid`);

--
-- Indexes for table `swcustomfielddeplinks`
--
ALTER TABLE `swcustomfielddeplinks`
  ADD PRIMARY KEY (`customfielddeplinkid`),
  ADD UNIQUE KEY `customfielddeplinks1` (`customfieldgroupid`,`departmentid`);

--
-- Indexes for table `swcustomfieldgrouppermissions`
--
ALTER TABLE `swcustomfieldgrouppermissions`
  ADD PRIMARY KEY (`customfieldgrouppermissionsid`),
  ADD KEY `customfieldgrouppermissions1` (`customfieldgroupid`,`cfgrouptype`),
  ADD KEY `customfieldgrouppermissions2` (`cfgrouptype`,`typeid`);

--
-- Indexes for table `swcustomfieldgroups`
--
ALTER TABLE `swcustomfieldgroups`
  ADD PRIMARY KEY (`customfieldgroupid`),
  ADD KEY `customfieldgroups1` (`grouptype`);

--
-- Indexes for table `swcustomfieldlinks`
--
ALTER TABLE `swcustomfieldlinks`
  ADD PRIMARY KEY (`customfieldlinkid`),
  ADD KEY `customfieldlinks1` (`grouptype`,`linktypeid`,`customfieldgroupid`),
  ADD KEY `customfieldlinks2` (`customfieldgroupid`);

--
-- Indexes for table `swcustomfieldoptionlinks`
--
ALTER TABLE `swcustomfieldoptionlinks`
  ADD PRIMARY KEY (`customfieldoptionlinkid`),
  ADD KEY `customfieldoptionlinks1` (`customfieldid`),
  ADD KEY `customfieldoptionlinks2` (`customfieldoptionid`);

--
-- Indexes for table `swcustomfieldoptions`
--
ALTER TABLE `swcustomfieldoptions`
  ADD PRIMARY KEY (`customfieldoptionid`),
  ADD KEY `customfieldoptions1` (`customfieldid`),
  ADD KEY `customfieldoptions2` (`parentcustomfieldoptionid`);

--
-- Indexes for table `swcustomfields`
--
ALTER TABLE `swcustomfields`
  ADD PRIMARY KEY (`customfieldid`),
  ADD KEY `customfields1` (`customfieldgroupid`);

--
-- Indexes for table `swcustomfieldvalues`
--
ALTER TABLE `swcustomfieldvalues`
  ADD PRIMARY KEY (`customfieldvalueid`),
  ADD KEY `customfieldvalues1` (`customfieldid`,`typeid`),
  ADD KEY `customfieldvalues2` (`uniquehash`);

--
-- Indexes for table `swdbwb_staffselect`
--
ALTER TABLE `swdbwb_staffselect`
  ADD PRIMARY KEY (`dbwb_staffselectid`);

--
-- Indexes for table `swdepartments`
--
ALTER TABLE `swdepartments`
  ADD PRIMARY KEY (`departmentid`),
  ADD KEY `departments1` (`departmentapp`),
  ADD KEY `departments2` (`departmenttype`),
  ADD KEY `departments3` (`parentdepartmentid`,`departmentapp`,`departmentid`,`departmenttype`);

--
-- Indexes for table `swemailqueues`
--
ALTER TABLE `swemailqueues`
  ADD PRIMARY KEY (`emailqueueid`),
  ADD KEY `emailqueues1` (`email`),
  ADD KEY `emailqueues2` (`email`(100),`customfromname`(100),`customfromemail`(100));

--
-- Indexes for table `swerrorlogs`
--
ALTER TABLE `swerrorlogs`
  ADD PRIMARY KEY (`errorlogid`),
  ADD KEY `errorlogs1` (`type`),
  ADD KEY `errorlogs2` (`dateline`);

--
-- Indexes for table `swescalationnotifications`
--
ALTER TABLE `swescalationnotifications`
  ADD PRIMARY KEY (`escalationnotificationid`),
  ADD KEY `escalationnotifications1` (`escalationruleid`);

--
-- Indexes for table `swescalationpaths`
--
ALTER TABLE `swescalationpaths`
  ADD PRIMARY KEY (`escalationpathid`),
  ADD KEY `escalationpaths1` (`ticketid`);

--
-- Indexes for table `swescalationrules`
--
ALTER TABLE `swescalationrules`
  ADD PRIMARY KEY (`escalationruleid`),
  ADD KEY `escalationrules1` (`slaplanid`),
  ADD KEY `escalationrules2` (`title`);

--
-- Indexes for table `swfiles`
--
ALTER TABLE `swfiles`
  ADD PRIMARY KEY (`fileid`),
  ADD KEY `files1` (`dateline`,`expiry`),
  ADD KEY `files2` (`expiry`);

--
-- Indexes for table `swgeoipcities`
--
ALTER TABLE `swgeoipcities`
  ADD PRIMARY KEY (`blockid`);

--
-- Indexes for table `swgeoipcityblocks1`
--
ALTER TABLE `swgeoipcityblocks1`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks2`
--
ALTER TABLE `swgeoipcityblocks2`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks3`
--
ALTER TABLE `swgeoipcityblocks3`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks4`
--
ALTER TABLE `swgeoipcityblocks4`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks5`
--
ALTER TABLE `swgeoipcityblocks5`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks6`
--
ALTER TABLE `swgeoipcityblocks6`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks7`
--
ALTER TABLE `swgeoipcityblocks7`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks8`
--
ALTER TABLE `swgeoipcityblocks8`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks9`
--
ALTER TABLE `swgeoipcityblocks9`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipcityblocks10`
--
ALTER TABLE `swgeoipcityblocks10`
  ADD KEY `geoipcityblocks1` (`ipto`),
  ADD KEY `geoipcityblocks2` (`blockid`);

--
-- Indexes for table `swgeoipisp1`
--
ALTER TABLE `swgeoipisp1`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp2`
--
ALTER TABLE `swgeoipisp2`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp3`
--
ALTER TABLE `swgeoipisp3`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp4`
--
ALTER TABLE `swgeoipisp4`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp5`
--
ALTER TABLE `swgeoipisp5`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp6`
--
ALTER TABLE `swgeoipisp6`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp7`
--
ALTER TABLE `swgeoipisp7`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp8`
--
ALTER TABLE `swgeoipisp8`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp9`
--
ALTER TABLE `swgeoipisp9`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipisp10`
--
ALTER TABLE `swgeoipisp10`
  ADD KEY `geoipisp1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed1`
--
ALTER TABLE `swgeoipnetspeed1`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed2`
--
ALTER TABLE `swgeoipnetspeed2`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed3`
--
ALTER TABLE `swgeoipnetspeed3`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed4`
--
ALTER TABLE `swgeoipnetspeed4`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed5`
--
ALTER TABLE `swgeoipnetspeed5`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed6`
--
ALTER TABLE `swgeoipnetspeed6`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed7`
--
ALTER TABLE `swgeoipnetspeed7`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed8`
--
ALTER TABLE `swgeoipnetspeed8`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed9`
--
ALTER TABLE `swgeoipnetspeed9`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoipnetspeed10`
--
ALTER TABLE `swgeoipnetspeed10`
  ADD KEY `geoipnetspeed1` (`ipto`);

--
-- Indexes for table `swgeoiporganization1`
--
ALTER TABLE `swgeoiporganization1`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization2`
--
ALTER TABLE `swgeoiporganization2`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization3`
--
ALTER TABLE `swgeoiporganization3`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization4`
--
ALTER TABLE `swgeoiporganization4`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization5`
--
ALTER TABLE `swgeoiporganization5`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization6`
--
ALTER TABLE `swgeoiporganization6`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization7`
--
ALTER TABLE `swgeoiporganization7`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization8`
--
ALTER TABLE `swgeoiporganization8`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization9`
--
ALTER TABLE `swgeoiporganization9`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgeoiporganization10`
--
ALTER TABLE `swgeoiporganization10`
  ADD KEY `geoiporganization1` (`ipto`);

--
-- Indexes for table `swgroupassigns`
--
ALTER TABLE `swgroupassigns`
  ADD PRIMARY KEY (`groupassignid`),
  ADD UNIQUE KEY `groupassigns3` (`departmentid`,`staffgroupid`),
  ADD KEY `groupassigns1` (`staffgroupid`),
  ADD KEY `groupassigns2` (`departmentid`);

--
-- Indexes for table `swimportlogs`
--
ALTER TABLE `swimportlogs`
  ADD PRIMARY KEY (`importlogid`),
  ADD KEY `importlogs1` (`logtype`,`dateline`),
  ADD KEY `importlogs2` (`dateline`);

--
-- Indexes for table `swimportregistry`
--
ALTER TABLE `swimportregistry`
  ADD PRIMARY KEY (`importregistryid`),
  ADD KEY `importregistry1` (`section`,`vkey`),
  ADD KEY `importregistry2` (`nocache`);

--
-- Indexes for table `swjabberqueue`
--
ALTER TABLE `swjabberqueue`
  ADD PRIMARY KEY (`jabberqueueid`),
  ADD KEY `jabberqueue1` (`messagetype`);

--
-- Indexes for table `swjobqueuemessagelogs`
--
ALTER TABLE `swjobqueuemessagelogs`
  ADD PRIMARY KEY (`jobqueuemessagelogid`),
  ADD KEY `jobqueuemessagelogs1` (`jobqueuemessageid`),
  ADD KEY `jobqueuemessagelogs2` (`dateline`);

--
-- Indexes for table `swjobqueuemessagepackets`
--
ALTER TABLE `swjobqueuemessagepackets`
  ADD PRIMARY KEY (`jobqueuemessagepacketid`),
  ADD KEY `jobqueuemessagepackets1` (`queuename`),
  ADD KEY `jobqueuemessagepackets2` (`dateline`);

--
-- Indexes for table `swjobqueuemessages`
--
ALTER TABLE `swjobqueuemessages`
  ADD PRIMARY KEY (`jobqueuemessageid`),
  ADD KEY `jobqueuemessages1` (`serverid`),
  ADD KEY `jobqueuemessages2` (`messageuuid`),
  ADD KEY `jobqueuemessages3` (`lastupdate`),
  ADD KEY `jobqueuemessages4` (`dateline`);

--
-- Indexes for table `swkbarticledata`
--
ALTER TABLE `swkbarticledata`
  ADD PRIMARY KEY (`kbarticledataid`),
  ADD KEY `kbarticledata1` (`kbarticleid`);

--
-- Indexes for table `swkbarticlelinks`
--
ALTER TABLE `swkbarticlelinks`
  ADD PRIMARY KEY (`kbarticlelinkid`),
  ADD KEY `kbarticlelinks1` (`kbarticleid`),
  ADD KEY `kbarticlelinks2` (`linktype`,`linktypeid`,`kbarticleid`);

--
-- Indexes for table `swkbarticles`
--
ALTER TABLE `swkbarticles`
  ADD PRIMARY KEY (`kbarticleid`),
  ADD KEY `kbarticles1` (`creator`,`creatorid`),
  ADD KEY `kbarticles2` (`kbarticleid`,`isfeatured`),
  ADD KEY `kbarticles3` (`articlestatus`),
  ADD KEY `kbarticles4` (`subject`,`kbarticleid`);

--
-- Indexes for table `swkbarticlesubscribers`
--
ALTER TABLE `swkbarticlesubscribers`
  ADD PRIMARY KEY (`kbarticlesubscriberid`),
  ADD KEY `kbarticlesubscribers1` (`kbarticleid`);

--
-- Indexes for table `swkbcategories`
--
ALTER TABLE `swkbcategories`
  ADD PRIMARY KEY (`kbcategoryid`),
  ADD KEY `kbcategories1` (`parentkbcategoryid`),
  ADD KEY `kbcategories2` (`categorytype`,`parentkbcategoryid`,`uservisibilitycustom`,`staffvisibilitycustom`),
  ADD KEY `kbcategories3` (`uservisibilitycustom`,`categorytype`),
  ADD KEY `kbcategories4` (`title`,`kbcategoryid`);

--
-- Indexes for table `swlanguagephrases`
--
ALTER TABLE `swlanguagephrases`
  ADD PRIMARY KEY (`phraseid`),
  ADD UNIQUE KEY `languagephrases1` (`languageid`,`code`),
  ADD KEY `languagephrases2` (`modified`,`revertrequired`),
  ADD KEY `languagephrases3` (`languageid`,`modified`),
  ADD KEY `languagephrases4` (`appname`);

--
-- Indexes for table `swlanguages`
--
ALTER TABLE `swlanguages`
  ADD PRIMARY KEY (`languageid`),
  ADD KEY `languages1` (`languagecode`);

--
-- Indexes for table `swmacrocategories`
--
ALTER TABLE `swmacrocategories`
  ADD PRIMARY KEY (`macrocategoryid`),
  ADD KEY `macrocategories1` (`parentcategoryid`),
  ADD KEY `macrocategories2` (`categorytype`,`staffid`);

--
-- Indexes for table `swmacroreplies`
--
ALTER TABLE `swmacroreplies`
  ADD PRIMARY KEY (`macroreplyid`),
  ADD KEY `macroreplies1` (`macrocategoryid`),
  ADD KEY `macroreplies2` (`staffid`),
  ADD KEY `macroreplies3` (`subject`);

--
-- Indexes for table `swmacroreplydata`
--
ALTER TABLE `swmacroreplydata`
  ADD PRIMARY KEY (`macroreplydataid`),
  ADD KEY `macroreplydata1` (`macroreplyid`);

--
-- Indexes for table `swmailqueuedata`
--
ALTER TABLE `swmailqueuedata`
  ADD PRIMARY KEY (`mailqueuedataid`);

--
-- Indexes for table `swnewscategories`
--
ALTER TABLE `swnewscategories`
  ADD PRIMARY KEY (`newscategoryid`),
  ADD KEY `newscategories1` (`visibilitytype`),
  ADD KEY `newscategories2` (`titlehash`,`visibilitytype`);

--
-- Indexes for table `swnewscategorylinks`
--
ALTER TABLE `swnewscategorylinks`
  ADD PRIMARY KEY (`newscategorylinkid`),
  ADD KEY `newscategorylinks1` (`newsitemid`,`newscategoryid`),
  ADD KEY `newscategorylinks2` (`newscategoryid`,`newsitemid`);

--
-- Indexes for table `swnewsitemdata`
--
ALTER TABLE `swnewsitemdata`
  ADD PRIMARY KEY (`newsitemdataid`),
  ADD KEY `newsitemdata1` (`newsitemid`);

--
-- Indexes for table `swnewsitems`
--
ALTER TABLE `swnewsitems`
  ADD PRIMARY KEY (`newsitemid`),
  ADD KEY `newsitems1` (`newstype`,`newsstatus`,`expiry`,`uservisibilitycustom`,`newsitemid`),
  ADD KEY `newsitems2` (`issynced`,`syncguidhash`,`syncdateline`),
  ADD KEY `newsitems3` (`dateline`),
  ADD KEY `newsitems4` (`newsstatus`,`expiry`,`staffvisibilitycustom`),
  ADD KEY `newsitems5` (`expiry`,`staffvisibilitycustom`),
  ADD KEY `newsitems6` (`subject`);

--
-- Indexes for table `swnewssubscriberhash`
--
ALTER TABLE `swnewssubscriberhash`
  ADD PRIMARY KEY (`newssubscriberhashid`),
  ADD KEY `newssubscriberhash1` (`newssubscriberid`),
  ADD KEY `newssubscriberhash2` (`hash`);

--
-- Indexes for table `swnewssubscribers`
--
ALTER TABLE `swnewssubscribers`
  ADD PRIMARY KEY (`newssubscriberid`),
  ADD UNIQUE KEY `newssubscribers2` (`email`),
  ADD KEY `newssubscribers1` (`tgroupid`,`isvalidated`),
  ADD KEY `newssubscribers3` (`usergroupid`,`isvalidated`),
  ADD KEY `newssubscribers4` (`isvalidated`);

--
-- Indexes for table `swnotificationactions`
--
ALTER TABLE `swnotificationactions`
  ADD PRIMARY KEY (`notificationactionid`),
  ADD KEY `notificationactions1` (`notificationruleid`);

--
-- Indexes for table `swnotificationcriteria`
--
ALTER TABLE `swnotificationcriteria`
  ADD PRIMARY KEY (`notificationcriteriaid`),
  ADD KEY `notificationcriteria1` (`notificationruleid`);

--
-- Indexes for table `swnotificationpool`
--
ALTER TABLE `swnotificationpool`
  ADD PRIMARY KEY (`notificationpoolid`),
  ADD KEY `notificationpool1` (`staffid`,`dateline`),
  ADD KEY `notificationpool2` (`dateline`);

--
-- Indexes for table `swnotificationrules`
--
ALTER TABLE `swnotificationrules`
  ADD PRIMARY KEY (`notificationruleid`),
  ADD KEY `notificationrules1` (`ruletype`,`isenabled`),
  ADD KEY `notificationrules2` (`isenabled`);

--
-- Indexes for table `swonsitesessions`
--
ALTER TABLE `swonsitesessions`
  ADD PRIMARY KEY (`onsitesessionid`),
  ADD KEY `onsitesessions1` (`sessionhash`,`chatsessionid`,`chatobjectid`),
  ADD KEY `onsitesessions2` (`dateline`),
  ADD KEY `onsitesessions3` (`sessioncode`);

--
-- Indexes for table `swparserbans`
--
ALTER TABLE `swparserbans`
  ADD PRIMARY KEY (`parserbanid`),
  ADD UNIQUE KEY `parserbans1` (`email`);

--
-- Indexes for table `swparserlogdata`
--
ALTER TABLE `swparserlogdata`
  ADD PRIMARY KEY (`parserlogdataid`),
  ADD KEY `parserlogdata1` (`parserlogid`);

--
-- Indexes for table `swparserlogs`
--
ALTER TABLE `swparserlogs`
  ADD PRIMARY KEY (`parserlogid`),
  ADD KEY `parserlogs1` (`ticketpostid`),
  ADD KEY `parserlogs2` (`dateline`),
  ADD KEY `parserlogs3` (`emailqueueid`),
  ADD KEY `parserlogs4` (`logtype`,`dateline`);

--
-- Indexes for table `swparserloopblocks`
--
ALTER TABLE `swparserloopblocks`
  ADD PRIMARY KEY (`parserloopblockid`),
  ADD KEY `parserloopblocks1` (`address`,`restoretime`),
  ADD KEY `parserloopblocks2` (`restoretime`);

--
-- Indexes for table `swparserloophits`
--
ALTER TABLE `swparserloophits`
  ADD PRIMARY KEY (`parserloophitid`),
  ADD KEY `parserloophits1` (`dateline`),
  ADD KEY `parserloophits2` (`emailaddress`);

--
-- Indexes for table `swparserlooprules`
--
ALTER TABLE `swparserlooprules`
  ADD PRIMARY KEY (`parserloopruleid`);

--
-- Indexes for table `swparserruleactions`
--
ALTER TABLE `swparserruleactions`
  ADD PRIMARY KEY (`parserruleactionid`),
  ADD KEY `parserruleactions1` (`parserruleid`);

--
-- Indexes for table `swparserrulecriteria`
--
ALTER TABLE `swparserrulecriteria`
  ADD PRIMARY KEY (`parserrulecriteriaid`),
  ADD KEY `parserrulecriteria1` (`parserruleid`);

--
-- Indexes for table `swparserrules`
--
ALTER TABLE `swparserrules`
  ADD PRIMARY KEY (`parserruleid`),
  ADD KEY `parserrules1` (`title`);

--
-- Indexes for table `swqueuesignatures`
--
ALTER TABLE `swqueuesignatures`
  ADD PRIMARY KEY (`queuesignatureid`),
  ADD KEY `queuesignatures1` (`emailqueueid`);

--
-- Indexes for table `swratingresults`
--
ALTER TABLE `swratingresults`
  ADD PRIMARY KEY (`ratingresultid`),
  ADD KEY `ratingresults1` (`ratingid`),
  ADD KEY `ratingresults2` (`typeid`,`ratingid`);

--
-- Indexes for table `swratings`
--
ALTER TABLE `swratings`
  ADD PRIMARY KEY (`ratingid`),
  ADD KEY `ratings1` (`ratingtype`,`departmentid`),
  ADD KEY `ratings2` (`departmentid`);

--
-- Indexes for table `swregistry`
--
ALTER TABLE `swregistry`
  ADD PRIMARY KEY (`vkey`);

--
-- Indexes for table `swreportcategories`
--
ALTER TABLE `swreportcategories`
  ADD PRIMARY KEY (`reportcategoryid`),
  ADD KEY `reportcategories1` (`visibilitytype`);

--
-- Indexes for table `swreporthistory`
--
ALTER TABLE `swreporthistory`
  ADD PRIMARY KEY (`reporthistoryid`),
  ADD KEY `reporthistory1` (`reportid`);

--
-- Indexes for table `swreports`
--
ALTER TABLE `swreports`
  ADD PRIMARY KEY (`reportid`),
  ADD KEY `reports1` (`dateline`),
  ADD KEY `reports2` (`title`);

--
-- Indexes for table `swreportschedules`
--
ALTER TABLE `swreportschedules`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `reportschedules1` (`staffid`),
  ADD KEY `reportschedules2` (`reportid`);

--
-- Indexes for table `swreportusagelogs`
--
ALTER TABLE `swreportusagelogs`
  ADD PRIMARY KEY (`reportusagelogid`),
  ADD KEY `reportusagelogs1` (`reportid`),
  ADD KEY `reportusagelogs2` (`staffid`,`reportid`);

--
-- Indexes for table `swsearchindex`
--
ALTER TABLE `swsearchindex`
  ADD KEY `searchindex1` (`objid`),
  ADD KEY `searchindex2` (`type`,`objid`),
  ADD KEY `searchindex3` (`objid`,`type`),
  ADD KEY `searchindex4` (`objid`,`subobjid`,`type`);
ALTER TABLE `swsearchindex` ADD FULLTEXT KEY `fulltextsearch` (`ft`);
ALTER TABLE `swsearchindex` ADD FULLTEXT KEY `ft` (`ft`);

--
-- Indexes for table `swsearchstoredata`
--
ALTER TABLE `swsearchstoredata`
  ADD PRIMARY KEY (`searchstoredataid`),
  ADD KEY `searchstoredata1` (`searchstoreid`),
  ADD KEY `searchstoredata2` (`dateline`);

--
-- Indexes for table `swsearchstores`
--
ALTER TABLE `swsearchstores`
  ADD PRIMARY KEY (`searchstoreid`),
  ADD KEY `searchstores1` (`sessionid`),
  ADD KEY `searchstores2` (`storetype`,`staffid`),
  ADD KEY `searchstores3` (`storetype`,`userid`);

--
-- Indexes for table `swsessions`
--
ALTER TABLE `swsessions`
  ADD PRIMARY KEY (`sessionid`),
  ADD KEY `sessions1` (`sessiontype`,`lastactivity`,`status`),
  ADD KEY `sessions2` (`typeid`,`sessiontype`),
  ADD KEY `sessions3` (`sessionid`,`sessiontype`);

--
-- Indexes for table `swsettings`
--
ALTER TABLE `swsettings`
  ADD PRIMARY KEY (`settingid`),
  ADD KEY `settings1` (`section`,`vkey`);

--
-- Indexes for table `swsettingsfields`
--
ALTER TABLE `swsettingsfields`
  ADD PRIMARY KEY (`sfieldid`),
  ADD KEY `settingsfields1` (`sgroupid`);

--
-- Indexes for table `swsettingsgroups`
--
ALTER TABLE `swsettingsgroups`
  ADD PRIMARY KEY (`sgroupid`),
  ADD KEY `settingsgroups1` (`app`),
  ADD KEY `settingsgroups2` (`name`);

--
-- Indexes for table `swsignatures`
--
ALTER TABLE `swsignatures`
  ADD PRIMARY KEY (`signatureid`),
  ADD KEY `signatures1` (`staffid`);

--
-- Indexes for table `swslaholidaylinks`
--
ALTER TABLE `swslaholidaylinks`
  ADD PRIMARY KEY (`slaholidaylinkid`),
  ADD KEY `slaholidaylinks1` (`slaplanid`,`slaholidayid`),
  ADD KEY `slaholidaylinks2` (`slaholidayid`);

--
-- Indexes for table `swslaholidays`
--
ALTER TABLE `swslaholidays`
  ADD PRIMARY KEY (`slaholidayid`),
  ADD KEY `slaholidays1` (`holidayday`,`holidaymonth`),
  ADD KEY `slaholidays2` (`holidaydate`,`iscustom`);

--
-- Indexes for table `swslaplans`
--
ALTER TABLE `swslaplans`
  ADD PRIMARY KEY (`slaplanid`),
  ADD KEY `slaplans1` (`slascheduleid`),
  ADD KEY `slaplans2` (`title`);

--
-- Indexes for table `swslarulecriteria`
--
ALTER TABLE `swslarulecriteria`
  ADD PRIMARY KEY (`slarulecriteriaid`),
  ADD KEY `slarulecriteria1` (`slaplanid`);

--
-- Indexes for table `swslaschedules`
--
ALTER TABLE `swslaschedules`
  ADD PRIMARY KEY (`slascheduleid`);

--
-- Indexes for table `swslascheduletable`
--
ALTER TABLE `swslascheduletable`
  ADD PRIMARY KEY (`slascheduletableid`);

--
-- Indexes for table `swstaff`
--
ALTER TABLE `swstaff`
  ADD PRIMARY KEY (`staffid`),
  ADD KEY `staff1` (`staffgroupid`);

--
-- Indexes for table `swstaffactivitylog`
--
ALTER TABLE `swstaffactivitylog`
  ADD PRIMARY KEY (`staffactivitylogid`),
  ADD KEY `staffactivitylog1` (`interfacetype`,`dateline`),
  ADD KEY `staffactivitylog2` (`dateline`);

--
-- Indexes for table `swstaffassigns`
--
ALTER TABLE `swstaffassigns`
  ADD PRIMARY KEY (`staffassignid`),
  ADD UNIQUE KEY `staffassigns3` (`departmentid`,`staffid`),
  ADD KEY `staffassigns1` (`staffid`),
  ADD KEY `staffassigns2` (`departmentid`);

--
-- Indexes for table `swstaffgroup`
--
ALTER TABLE `swstaffgroup`
  ADD PRIMARY KEY (`staffgroupid`),
  ADD KEY `staffgroup1` (`isadmin`);

--
-- Indexes for table `swstaffgrouplinks`
--
ALTER TABLE `swstaffgrouplinks`
  ADD PRIMARY KEY (`staffgrouplinkid`),
  ADD KEY `staffgrouplinks1` (`staffgroupid`,`type`),
  ADD KEY `staffgrouplinks2` (`toassignid`,`type`,`staffgroupid`);

--
-- Indexes for table `swstaffgroupsettings`
--
ALTER TABLE `swstaffgroupsettings`
  ADD PRIMARY KEY (`sgroupsettingid`),
  ADD UNIQUE KEY `staffgroupsettings2` (`staffgroupid`,`name`),
  ADD KEY `staffgroupsettings1` (`staffgroupid`);

--
-- Indexes for table `swstaffloginlog`
--
ALTER TABLE `swstaffloginlog`
  ADD PRIMARY KEY (`staffloginlogid`),
  ADD KEY `staffloginlog1` (`staffid`,`logindateline`,`interfacetype`),
  ADD KEY `staffloginlog2` (`staffusername`,`logindateline`,`loginresult`),
  ADD KEY `staffloginlog3` (`logindateline`,`loginresult`),
  ADD KEY `staffloginlog4` (`sessionid`);

--
-- Indexes for table `swstaffprofileimages`
--
ALTER TABLE `swstaffprofileimages`
  ADD PRIMARY KEY (`staffprofileimageid`),
  ADD KEY `staffprofileimages1` (`staffid`,`type`);

--
-- Indexes for table `swstaffproperties`
--
ALTER TABLE `swstaffproperties`
  ADD PRIMARY KEY (`staffpropertyid`),
  ADD KEY `staffproperties1` (`staffid`,`keyname`);

--
-- Indexes for table `swstaffsettings`
--
ALTER TABLE `swstaffsettings`
  ADD PRIMARY KEY (`staffsettingid`),
  ADD UNIQUE KEY `staffsettings2` (`staffid`,`departmentid`,`name`),
  ADD KEY `staffsettings1` (`staffid`),
  ADD KEY `staffsettings3` (`departmentid`);

--
-- Indexes for table `swtaglinks`
--
ALTER TABLE `swtaglinks`
  ADD PRIMARY KEY (`taglinkid`),
  ADD KEY `taglinks1` (`tagid`,`linktype`),
  ADD KEY `taglinks2` (`linktype`,`linkid`);

--
-- Indexes for table `swtags`
--
ALTER TABLE `swtags`
  ADD PRIMARY KEY (`tagid`),
  ADD KEY `tags1` (`tagname`);

--
-- Indexes for table `swtemplatecategories`
--
ALTER TABLE `swtemplatecategories`
  ADD PRIMARY KEY (`tcategoryid`),
  ADD KEY `templatecategories1` (`tgroupid`);

--
-- Indexes for table `swtemplatedata`
--
ALTER TABLE `swtemplatedata`
  ADD PRIMARY KEY (`templatedataid`),
  ADD KEY `templatedata1` (`templateid`);

--
-- Indexes for table `swtemplategroups`
--
ALTER TABLE `swtemplategroups`
  ADD PRIMARY KEY (`tgroupid`);

--
-- Indexes for table `swtemplatehistory`
--
ALTER TABLE `swtemplatehistory`
  ADD PRIMARY KEY (`templatehistoryid`),
  ADD KEY `templatehistory1` (`templateid`);

--
-- Indexes for table `swtemplates`
--
ALTER TABLE `swtemplates`
  ADD PRIMARY KEY (`templateid`),
  ADD KEY `templates1` (`tgroupid`,`name`),
  ADD KEY `templates2` (`tcategoryid`);

--
-- Indexes for table `swticketauditlogs`
--
ALTER TABLE `swticketauditlogs`
  ADD PRIMARY KEY (`ticketauditlogid`),
  ADD KEY `ticketauditlogs1` (`ticketid`,`actiontype`),
  ADD KEY `ticketauditlogs2` (`dateline`,`creatortype`,`creatorid`),
  ADD KEY `ticketauditlogs3` (`actionhash`),
  ADD KEY `ticketauditlogs4` (`ticketid`,`ticketpostid`,`valuetype`),
  ADD KEY `ticketauditlogs5` (`ticketpostid`,`ticketid`,`valuetype`);

--
-- Indexes for table `swticketdrafts`
--
ALTER TABLE `swticketdrafts`
  ADD PRIMARY KEY (`ticketdraftid`),
  ADD KEY `ticketdrafts1` (`ticketid`,`staffid`);

--
-- Indexes for table `swticketemails`
--
ALTER TABLE `swticketemails`
  ADD PRIMARY KEY (`ticketemailid`),
  ADD UNIQUE KEY `ticketemails1` (`issearchable`,`email`);

--
-- Indexes for table `swticketfiletypes`
--
ALTER TABLE `swticketfiletypes`
  ADD PRIMARY KEY (`ticketfiletypeid`),
  ADD KEY `ticketfiletypes1` (`extension`);

--
-- Indexes for table `swticketfilterfields`
--
ALTER TABLE `swticketfilterfields`
  ADD PRIMARY KEY (`ticketfilterfieldid`),
  ADD KEY `ticketfilterfields1` (`ticketfilterid`);

--
-- Indexes for table `swticketfilters`
--
ALTER TABLE `swticketfilters`
  ADD PRIMARY KEY (`ticketfilterid`),
  ADD KEY `ticketfilters1` (`filtertype`,`staffid`),
  ADD KEY `ticketfilters2` (`filtertype`,`restrictstaffgroupid`),
  ADD KEY `ticketfilters3` (`staffid`),
  ADD KEY `ticketfilters4` (`title`,`ticketfilterid`);

--
-- Indexes for table `swticketfollowups`
--
ALTER TABLE `swticketfollowups`
  ADD PRIMARY KEY (`ticketfollowupid`),
  ADD KEY `ticketfollowups1` (`ticketid`),
  ADD KEY `ticketfollowups2` (`executiondateline`);

--
-- Indexes for table `swticketlinkchains`
--
ALTER TABLE `swticketlinkchains`
  ADD PRIMARY KEY (`ticketlinkchainid`),
  ADD KEY `ticketlinkchains1` (`chainhash`),
  ADD KEY `ticketlinkchains2` (`ticketid`),
  ADD KEY `ticketlinkchains3` (`ticketlinktypeid`);

--
-- Indexes for table `swticketlinkedtables`
--
ALTER TABLE `swticketlinkedtables`
  ADD PRIMARY KEY (`ticketlinkedtableid`),
  ADD KEY `ticketlinkedtables1` (`ticketid`,`linktype`),
  ADD KEY `ticketlinkedtables2` (`linktype`,`linktypeid`);

--
-- Indexes for table `swticketlinktypes`
--
ALTER TABLE `swticketlinktypes`
  ADD PRIMARY KEY (`ticketlinktypeid`);

--
-- Indexes for table `swticketlocks`
--
ALTER TABLE `swticketlocks`
  ADD UNIQUE KEY `ticketlocks1` (`ticketid`);

--
-- Indexes for table `swticketmergelog`
--
ALTER TABLE `swticketmergelog`
  ADD PRIMARY KEY (`ticketmergelogid`),
  ADD KEY `ticketmergelog1` (`oldticketid`),
  ADD KEY `ticketmergelog2` (`oldticketmaskid`),
  ADD KEY `ticketmergelog3` (`ticketid`);

--
-- Indexes for table `swticketmessageids`
--
ALTER TABLE `swticketmessageids`
  ADD PRIMARY KEY (`ticketmessageid`),
  ADD KEY `ticketmessageids1` (`messageid`,`ticketid`),
  ADD KEY `ticketmessageids2` (`dateline`),
  ADD KEY `ticketmessageids3` (`ticketid`,`messageid`);

--
-- Indexes for table `swticketnotes`
--
ALTER TABLE `swticketnotes`
  ADD PRIMARY KEY (`ticketnoteid`),
  ADD KEY `ticketnotes1` (`linktypeid`,`linktype`,`forstaffid`),
  ADD KEY `ticketnotes2` (`linktype`,`linktypeid`);

--
-- Indexes for table `swticketpostlocks`
--
ALTER TABLE `swticketpostlocks`
  ADD PRIMARY KEY (`ticketpostlockid`),
  ADD KEY `ticketpostlocks1` (`ticketid`,`staffid`),
  ADD KEY `ticketpostlocks2` (`dateline`);

--
-- Indexes for table `swticketposts`
--
ALTER TABLE `swticketposts`
  ADD PRIMARY KEY (`ticketpostid`),
  ADD KEY `ticketposts1` (`ticketid`,`staffid`),
  ADD KEY `ticketposts2` (`email`,`subjecthash`),
  ADD KEY `ticketposts3` (`creator`,`staffid`,`dateline`),
  ADD KEY `ticketposts4` (`responsetime`),
  ADD KEY `ticketposts5` (`firstresponsetime`);

--
-- Indexes for table `swticketpriorities`
--
ALTER TABLE `swticketpriorities`
  ADD PRIMARY KEY (`priorityid`),
  ADD KEY `ticketpriorities1` (`uservisibilitycustom`,`priorityid`),
  ADD KEY `ticketpriorities2` (`title`);

--
-- Indexes for table `swticketrecipients`
--
ALTER TABLE `swticketrecipients`
  ADD PRIMARY KEY (`ticketrecipientid`),
  ADD UNIQUE KEY `ticketrecipients1` (`ticketid`,`ticketemailid`);

--
-- Indexes for table `swticketrecurrences`
--
ALTER TABLE `swticketrecurrences`
  ADD PRIMARY KEY (`ticketrecurrenceid`),
  ADD KEY `ticketrecurrences1` (`nextrecurrence`,`startdateline`),
  ADD KEY `ticketrecurrences2` (`ticketid`);

--
-- Indexes for table `swtickets`
--
ALTER TABLE `swtickets`
  ADD PRIMARY KEY (`ticketid`),
  ADD KEY `ticketcount` (`departmentid`,`ticketstatusid`,`ownerstaffid`,`tickettypeid`,`lastactivity`),
  ADD KEY `tickets1` (`userid`,`email`,`replyto`,`departmentid`,`isresolved`),
  ADD KEY `tickets2` (`slaplanid`,`duetime`,`ticketstatusid`),
  ADD KEY `tickets3` (`departmentid`,`ticketstatusid`,`lastactivity`),
  ADD KEY `tickets4` (`email`),
  ADD KEY `tickets5` (`departmentid`,`ticketstatusid`,`userid`),
  ADD KEY `tickets6` (`departmentid`,`ticketstatusid`,`duetime`),
  ADD KEY `tickets7` (`dateline`),
  ADD KEY `tickets8` (`departmentid`,`ticketstatusid`,`lastuserreplytime`),
  ADD KEY `tickets9` (`duetime`,`resolutionduedateline`,`isescalatedvolatile`,`isresolved`),
  ADD KEY `tickets10` (`ticketmaskid`,`ticketid`,`departmentid`),
  ADD KEY `tickets11` (`departmentid`,`ticketstatusid`,`duetime`,`resolutionduedateline`),
  ADD KEY `tickets12` (`isresolved`,`departmentid`),
  ADD KEY `tickets13` (`ticketstatusid`,`departmentid`,`priorityid`,`tickettypeid`),
  ADD KEY `tickets14` (`isescalatedvolatile`,`isresolved`),
  ADD KEY `tickets15` (`ticketid`,`departmentid`),
  ADD KEY `tickets16` (`ticketid`,`isresolved`,`autoclosestatus`,`lastactivity`),
  ADD KEY `tickets17` (`autoclosestatus`,`autocloseruleid`,`autoclosetimeline`),
  ADD KEY `tickets18` (`lastactivity`),
  ADD KEY `tickets19` (`recurrencefromticketid`);

--
-- Indexes for table `swticketstatus`
--
ALTER TABLE `swticketstatus`
  ADD PRIMARY KEY (`ticketstatusid`),
  ADD KEY `ticketstatus1` (`title`);

--
-- Indexes for table `swtickettimetracknotes`
--
ALTER TABLE `swtickettimetracknotes`
  ADD PRIMARY KEY (`tickettimetracknoteid`),
  ADD KEY `tickettimetracknotes1` (`tickettimetrackid`);

--
-- Indexes for table `swtickettimetracks`
--
ALTER TABLE `swtickettimetracks`
  ADD PRIMARY KEY (`tickettimetrackid`),
  ADD KEY `tickettimetracks1` (`ticketid`);

--
-- Indexes for table `swtickettypes`
--
ALTER TABLE `swtickettypes`
  ADD PRIMARY KEY (`tickettypeid`),
  ADD KEY `tickettypes1` (`departmentid`),
  ADD KEY `tickettypes2` (`uservisibilitycustom`,`tickettypeid`),
  ADD KEY `tickettypes3` (`title`);

--
-- Indexes for table `swticketviewfields`
--
ALTER TABLE `swticketviewfields`
  ADD PRIMARY KEY (`ticketviewfieldid`),
  ADD KEY `ticketviewfields1` (`ticketviewid`);

--
-- Indexes for table `swticketviewlinks`
--
ALTER TABLE `swticketviewlinks`
  ADD PRIMARY KEY (`ticketviewlinkid`),
  ADD KEY `ticketviewlinks1` (`ticketviewid`);

--
-- Indexes for table `swticketviews`
--
ALTER TABLE `swticketviews`
  ADD PRIMARY KEY (`ticketviewid`),
  ADD KEY `ticketviews1` (`viewscope`,`staffid`);

--
-- Indexes for table `swticketwatchers`
--
ALTER TABLE `swticketwatchers`
  ADD PRIMARY KEY (`ticketwatcherid`),
  ADD UNIQUE KEY `ticketwatchers1` (`ticketid`,`staffid`);

--
-- Indexes for table `swticketworkflowactions`
--
ALTER TABLE `swticketworkflowactions`
  ADD PRIMARY KEY (`ticketworkflowactionid`),
  ADD KEY `ticketworkflowactions1` (`ticketworkflowid`);

--
-- Indexes for table `swticketworkflowcriteria`
--
ALTER TABLE `swticketworkflowcriteria`
  ADD PRIMARY KEY (`ticketworkflowcriteriaid`),
  ADD KEY `ticketworkflowcriteria1` (`ticketworkflowid`);

--
-- Indexes for table `swticketworkflownotifications`
--
ALTER TABLE `swticketworkflownotifications`
  ADD PRIMARY KEY (`ticketworkflownotificationid`),
  ADD KEY `ticketworkflownotifications1` (`ticketworkflowid`);

--
-- Indexes for table `swticketworkflows`
--
ALTER TABLE `swticketworkflows`
  ADD PRIMARY KEY (`ticketworkflowid`),
  ADD KEY `ticketworkflows2` (`title`);

--
-- Indexes for table `swuseremails`
--
ALTER TABLE `swuseremails`
  ADD PRIMARY KEY (`useremailid`),
  ADD KEY `useremails1` (`linktype`,`linktypeid`,`isprimary`),
  ADD KEY `useremails2` (`linktype`,`email`),
  ADD KEY `useremails3` (`email`),
  ADD KEY `useremails4` (`linktype`,`useremailid`);

--
-- Indexes for table `swusergroupassigns`
--
ALTER TABLE `swusergroupassigns`
  ADD PRIMARY KEY (`usergroupassignid`),
  ADD KEY `usergroupassigns1` (`usergroupid`,`type`),
  ADD KEY `usergroupassigns2` (`toassignid`,`type`,`usergroupid`);

--
-- Indexes for table `swusergroups`
--
ALTER TABLE `swusergroups`
  ADD PRIMARY KEY (`usergroupid`),
  ADD KEY `usergroups1` (`grouptype`),
  ADD KEY `usergroups2` (`title`,`grouptype`);

--
-- Indexes for table `swusergroupsettings`
--
ALTER TABLE `swusergroupsettings`
  ADD PRIMARY KEY (`ugroupsettingid`),
  ADD UNIQUE KEY `usergroupsettings2` (`usergroupid`,`name`),
  ADD KEY `usergroupsettings1` (`usergroupid`);

--
-- Indexes for table `swuserloginlog`
--
ALTER TABLE `swuserloginlog`
  ADD PRIMARY KEY (`userloginlogid`),
  ADD KEY `userloginlog1` (`userid`,`logindateline`,`interfacetype`),
  ADD KEY `userloginlog2` (`userfullname`,`logindateline`,`loginresult`),
  ADD KEY `userloginlog3` (`logindateline`,`loginresult`),
  ADD KEY `userloginlog4` (`sessionid`);

--
-- Indexes for table `swusernotedata`
--
ALTER TABLE `swusernotedata`
  ADD PRIMARY KEY (`usernotedataid`),
  ADD KEY `usernotedata1` (`usernoteid`);

--
-- Indexes for table `swusernotes`
--
ALTER TABLE `swusernotes`
  ADD PRIMARY KEY (`usernoteid`),
  ADD KEY `usernotes1` (`linktype`,`linktypeid`);

--
-- Indexes for table `swuserorganizations`
--
ALTER TABLE `swuserorganizations`
  ADD PRIMARY KEY (`userorganizationid`),
  ADD KEY `userorganizations1` (`organizationname`,`address`,`phone`);

--
-- Indexes for table `swuserprofileimages`
--
ALTER TABLE `swuserprofileimages`
  ADD PRIMARY KEY (`userprofileimageid`),
  ADD KEY `userprofileimages1` (`userid`);

--
-- Indexes for table `swuserproperties`
--
ALTER TABLE `swuserproperties`
  ADD PRIMARY KEY (`userpropertyid`),
  ADD KEY `userproperties1` (`userid`,`keyname`);

--
-- Indexes for table `swusers`
--
ALTER TABLE `swusers`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `users1` (`usergroupid`),
  ADD KEY `users2` (`isenabled`,`dateline`),
  ADD KEY `users3` (`userorganizationid`),
  ADD KEY `users4` (`fullname`,`phone`),
  ADD KEY `users5` (`isvalidated`,`dateline`);

--
-- Indexes for table `swusersettings`
--
ALTER TABLE `swusersettings`
  ADD PRIMARY KEY (`usersettingid`),
  ADD UNIQUE KEY `usersettings2` (`userid`,`name`),
  ADD KEY `usersettings1` (`userid`);

--
-- Indexes for table `swuserverifyhash`
--
ALTER TABLE `swuserverifyhash`
  ADD PRIMARY KEY (`userverifyhashid`),
  ADD KEY `userverifyhash1` (`hashtype`,`dateline`),
  ADD KEY `userverifyhash2` (`userid`,`hashtype`);

--
-- Indexes for table `swwidgets`
--
ALTER TABLE `swwidgets`
  ADD PRIMARY KEY (`widgetid`),
  ADD KEY `widgets1` (`appname`),
  ADD KEY `widgets2` (`isenabled`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `statusboard`
--
ALTER TABLE `statusboard`
  MODIFY `indexnumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `swapplogdata`
--
ALTER TABLE `swapplogdata`
  MODIFY `applogdataid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swapplogs`
--
ALTER TABLE `swapplogs`
  MODIFY `applogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swattachmentchunks`
--
ALTER TABLE `swattachmentchunks`
  MODIFY `chunkid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swattachments`
--
ALTER TABLE `swattachments`
  MODIFY `attachmentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26703;
--
-- AUTO_INCREMENT for table `swautoclosecriteria`
--
ALTER TABLE `swautoclosecriteria`
  MODIFY `autoclosecriteriaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `swautocloserules`
--
ALTER TABLE `swautocloserules`
  MODIFY `autocloseruleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `swbayescategories`
--
ALTER TABLE `swbayescategories`
  MODIFY `bayescategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `swbayeswords`
--
ALTER TABLE `swbayeswords`
  MODIFY `bayeswordid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swbreaklines`
--
ALTER TABLE `swbreaklines`
  MODIFY `breaklineid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `swcatchallrules`
--
ALTER TABLE `swcatchallrules`
  MODIFY `catchallruleid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swcommentdata`
--
ALTER TABLE `swcommentdata`
  MODIFY `commentdataid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swcomments`
--
ALTER TABLE `swcomments`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swcron`
--
ALTER TABLE `swcron`
  MODIFY `cronid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `swcronlogs`
--
ALTER TABLE `swcronlogs`
  MODIFY `cronlogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swcustomfielddeplinks`
--
ALTER TABLE `swcustomfielddeplinks`
  MODIFY `customfielddeplinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `swcustomfieldgrouppermissions`
--
ALTER TABLE `swcustomfieldgrouppermissions`
  MODIFY `customfieldgrouppermissionsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;
--
-- AUTO_INCREMENT for table `swcustomfieldgroups`
--
ALTER TABLE `swcustomfieldgroups`
  MODIFY `customfieldgroupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `swcustomfieldlinks`
--
ALTER TABLE `swcustomfieldlinks`
  MODIFY `customfieldlinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6206;
--
-- AUTO_INCREMENT for table `swcustomfieldoptionlinks`
--
ALTER TABLE `swcustomfieldoptionlinks`
  MODIFY `customfieldoptionlinkid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swcustomfieldoptions`
--
ALTER TABLE `swcustomfieldoptions`
  MODIFY `customfieldoptionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `swcustomfields`
--
ALTER TABLE `swcustomfields`
  MODIFY `customfieldid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `swcustomfieldvalues`
--
ALTER TABLE `swcustomfieldvalues`
  MODIFY `customfieldvalueid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27097;
--
-- AUTO_INCREMENT for table `swdbwb_staffselect`
--
ALTER TABLE `swdbwb_staffselect`
  MODIFY `dbwb_staffselectid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `swdepartments`
--
ALTER TABLE `swdepartments`
  MODIFY `departmentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `swemailqueues`
--
ALTER TABLE `swemailqueues`
  MODIFY `emailqueueid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `swerrorlogs`
--
ALTER TABLE `swerrorlogs`
  MODIFY `errorlogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=785;
--
-- AUTO_INCREMENT for table `swescalationnotifications`
--
ALTER TABLE `swescalationnotifications`
  MODIFY `escalationnotificationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swescalationpaths`
--
ALTER TABLE `swescalationpaths`
  MODIFY `escalationpathid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;
--
-- AUTO_INCREMENT for table `swescalationrules`
--
ALTER TABLE `swescalationrules`
  MODIFY `escalationruleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swfiles`
--
ALTER TABLE `swfiles`
  MODIFY `fileid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `swgroupassigns`
--
ALTER TABLE `swgroupassigns`
  MODIFY `groupassignid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;
--
-- AUTO_INCREMENT for table `swimportlogs`
--
ALTER TABLE `swimportlogs`
  MODIFY `importlogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swimportregistry`
--
ALTER TABLE `swimportregistry`
  MODIFY `importregistryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swjabberqueue`
--
ALTER TABLE `swjabberqueue`
  MODIFY `jabberqueueid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swjobqueuemessagelogs`
--
ALTER TABLE `swjobqueuemessagelogs`
  MODIFY `jobqueuemessagelogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swjobqueuemessagepackets`
--
ALTER TABLE `swjobqueuemessagepackets`
  MODIFY `jobqueuemessagepacketid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swjobqueuemessages`
--
ALTER TABLE `swjobqueuemessages`
  MODIFY `jobqueuemessageid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swkbarticledata`
--
ALTER TABLE `swkbarticledata`
  MODIFY `kbarticledataid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=670;
--
-- AUTO_INCREMENT for table `swkbarticlelinks`
--
ALTER TABLE `swkbarticlelinks`
  MODIFY `kbarticlelinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4778;
--
-- AUTO_INCREMENT for table `swkbarticles`
--
ALTER TABLE `swkbarticles`
  MODIFY `kbarticleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=670;
--
-- AUTO_INCREMENT for table `swkbarticlesubscribers`
--
ALTER TABLE `swkbarticlesubscribers`
  MODIFY `kbarticlesubscriberid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swkbcategories`
--
ALTER TABLE `swkbcategories`
  MODIFY `kbcategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `swlanguagephrases`
--
ALTER TABLE `swlanguagephrases`
  MODIFY `phraseid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4017;
--
-- AUTO_INCREMENT for table `swlanguages`
--
ALTER TABLE `swlanguages`
  MODIFY `languageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `swmacrocategories`
--
ALTER TABLE `swmacrocategories`
  MODIFY `macrocategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `swmacroreplies`
--
ALTER TABLE `swmacroreplies`
  MODIFY `macroreplyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `swmacroreplydata`
--
ALTER TABLE `swmacroreplydata`
  MODIFY `macroreplydataid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `swmailqueuedata`
--
ALTER TABLE `swmailqueuedata`
  MODIFY `mailqueuedataid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swnewscategories`
--
ALTER TABLE `swnewscategories`
  MODIFY `newscategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `swnewscategorylinks`
--
ALTER TABLE `swnewscategorylinks`
  MODIFY `newscategorylinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `swnewsitemdata`
--
ALTER TABLE `swnewsitemdata`
  MODIFY `newsitemdataid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `swnewsitems`
--
ALTER TABLE `swnewsitems`
  MODIFY `newsitemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `swnewssubscriberhash`
--
ALTER TABLE `swnewssubscriberhash`
  MODIFY `newssubscriberhashid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `swnewssubscribers`
--
ALTER TABLE `swnewssubscribers`
  MODIFY `newssubscriberid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `swnotificationactions`
--
ALTER TABLE `swnotificationactions`
  MODIFY `notificationactionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
--
-- AUTO_INCREMENT for table `swnotificationcriteria`
--
ALTER TABLE `swnotificationcriteria`
  MODIFY `notificationcriteriaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT for table `swnotificationpool`
--
ALTER TABLE `swnotificationpool`
  MODIFY `notificationpoolid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swnotificationrules`
--
ALTER TABLE `swnotificationrules`
  MODIFY `notificationruleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `swonsitesessions`
--
ALTER TABLE `swonsitesessions`
  MODIFY `onsitesessionid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swparserbans`
--
ALTER TABLE `swparserbans`
  MODIFY `parserbanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `swparserlogdata`
--
ALTER TABLE `swparserlogdata`
  MODIFY `parserlogdataid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swparserlogs`
--
ALTER TABLE `swparserlogs`
  MODIFY `parserlogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swparserloopblocks`
--
ALTER TABLE `swparserloopblocks`
  MODIFY `parserloopblockid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swparserloophits`
--
ALTER TABLE `swparserloophits`
  MODIFY `parserloophitid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23929;
--
-- AUTO_INCREMENT for table `swparserlooprules`
--
ALTER TABLE `swparserlooprules`
  MODIFY `parserloopruleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swparserruleactions`
--
ALTER TABLE `swparserruleactions`
  MODIFY `parserruleactionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `swparserrulecriteria`
--
ALTER TABLE `swparserrulecriteria`
  MODIFY `parserrulecriteriaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `swparserrules`
--
ALTER TABLE `swparserrules`
  MODIFY `parserruleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `swqueuesignatures`
--
ALTER TABLE `swqueuesignatures`
  MODIFY `queuesignatureid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `swratingresults`
--
ALTER TABLE `swratingresults`
  MODIFY `ratingresultid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1931;
--
-- AUTO_INCREMENT for table `swratings`
--
ALTER TABLE `swratings`
  MODIFY `ratingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `swreportcategories`
--
ALTER TABLE `swreportcategories`
  MODIFY `reportcategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `swreporthistory`
--
ALTER TABLE `swreporthistory`
  MODIFY `reporthistoryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swreports`
--
ALTER TABLE `swreports`
  MODIFY `reportid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;
--
-- AUTO_INCREMENT for table `swreportschedules`
--
ALTER TABLE `swreportschedules`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `swreportusagelogs`
--
ALTER TABLE `swreportusagelogs`
  MODIFY `reportusagelogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swsearchstoredata`
--
ALTER TABLE `swsearchstoredata`
  MODIFY `searchstoredataid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swsearchstores`
--
ALTER TABLE `swsearchstores`
  MODIFY `searchstoreid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swsettings`
--
ALTER TABLE `swsettings`
  MODIFY `settingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=348;
--
-- AUTO_INCREMENT for table `swsettingsfields`
--
ALTER TABLE `swsettingsfields`
  MODIFY `sfieldid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4322;
--
-- AUTO_INCREMENT for table `swsettingsgroups`
--
ALTER TABLE `swsettingsgroups`
  MODIFY `sgroupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;
--
-- AUTO_INCREMENT for table `swsignatures`
--
ALTER TABLE `swsignatures`
  MODIFY `signatureid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `swslaholidaylinks`
--
ALTER TABLE `swslaholidaylinks`
  MODIFY `slaholidaylinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `swslaholidays`
--
ALTER TABLE `swslaholidays`
  MODIFY `slaholidayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `swslaplans`
--
ALTER TABLE `swslaplans`
  MODIFY `slaplanid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `swslarulecriteria`
--
ALTER TABLE `swslarulecriteria`
  MODIFY `slarulecriteriaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT for table `swslaschedules`
--
ALTER TABLE `swslaschedules`
  MODIFY `slascheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `swslascheduletable`
--
ALTER TABLE `swslascheduletable`
  MODIFY `slascheduletableid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `swstaff`
--
ALTER TABLE `swstaff`
  MODIFY `staffid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `swstaffactivitylog`
--
ALTER TABLE `swstaffactivitylog`
  MODIFY `staffactivitylogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15472;
--
-- AUTO_INCREMENT for table `swstaffassigns`
--
ALTER TABLE `swstaffassigns`
  MODIFY `staffassignid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=415;
--
-- AUTO_INCREMENT for table `swstaffgroup`
--
ALTER TABLE `swstaffgroup`
  MODIFY `staffgroupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `swstaffgrouplinks`
--
ALTER TABLE `swstaffgrouplinks`
  MODIFY `staffgrouplinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `swstaffgroupsettings`
--
ALTER TABLE `swstaffgroupsettings`
  MODIFY `sgroupsettingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4636;
--
-- AUTO_INCREMENT for table `swstaffloginlog`
--
ALTER TABLE `swstaffloginlog`
  MODIFY `staffloginlogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31428;
--
-- AUTO_INCREMENT for table `swstaffprofileimages`
--
ALTER TABLE `swstaffprofileimages`
  MODIFY `staffprofileimageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `swstaffproperties`
--
ALTER TABLE `swstaffproperties`
  MODIFY `staffpropertyid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swstaffsettings`
--
ALTER TABLE `swstaffsettings`
  MODIFY `staffsettingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6461;
--
-- AUTO_INCREMENT for table `swtaglinks`
--
ALTER TABLE `swtaglinks`
  MODIFY `taglinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4827;
--
-- AUTO_INCREMENT for table `swtags`
--
ALTER TABLE `swtags`
  MODIFY `tagid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
--
-- AUTO_INCREMENT for table `swtemplatecategories`
--
ALTER TABLE `swtemplatecategories`
  MODIFY `tcategoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `swtemplatedata`
--
ALTER TABLE `swtemplatedata`
  MODIFY `templatedataid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;
--
-- AUTO_INCREMENT for table `swtemplategroups`
--
ALTER TABLE `swtemplategroups`
  MODIFY `tgroupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swtemplatehistory`
--
ALTER TABLE `swtemplatehistory`
  MODIFY `templatehistoryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swtemplates`
--
ALTER TABLE `swtemplates`
  MODIFY `templateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;
--
-- AUTO_INCREMENT for table `swticketauditlogs`
--
ALTER TABLE `swticketauditlogs`
  MODIFY `ticketauditlogid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swticketdrafts`
--
ALTER TABLE `swticketdrafts`
  MODIFY `ticketdraftid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `swticketemails`
--
ALTER TABLE `swticketemails`
  MODIFY `ticketemailid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6812;
--
-- AUTO_INCREMENT for table `swticketfiletypes`
--
ALTER TABLE `swticketfiletypes`
  MODIFY `ticketfiletypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `swticketfilterfields`
--
ALTER TABLE `swticketfilterfields`
  MODIFY `ticketfilterfieldid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `swticketfilters`
--
ALTER TABLE `swticketfilters`
  MODIFY `ticketfilterid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `swticketfollowups`
--
ALTER TABLE `swticketfollowups`
  MODIFY `ticketfollowupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `swticketlinkchains`
--
ALTER TABLE `swticketlinkchains`
  MODIFY `ticketlinkchainid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `swticketlinkedtables`
--
ALTER TABLE `swticketlinkedtables`
  MODIFY `ticketlinkedtableid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91840;
--
-- AUTO_INCREMENT for table `swticketlinktypes`
--
ALTER TABLE `swticketlinktypes`
  MODIFY `ticketlinktypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `swticketmergelog`
--
ALTER TABLE `swticketmergelog`
  MODIFY `ticketmergelogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=556;
--
-- AUTO_INCREMENT for table `swticketmessageids`
--
ALTER TABLE `swticketmessageids`
  MODIFY `ticketmessageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62911;
--
-- AUTO_INCREMENT for table `swticketnotes`
--
ALTER TABLE `swticketnotes`
  MODIFY `ticketnoteid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `swticketpostlocks`
--
ALTER TABLE `swticketpostlocks`
  MODIFY `ticketpostlockid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9556;
--
-- AUTO_INCREMENT for table `swticketposts`
--
ALTER TABLE `swticketposts`
  MODIFY `ticketpostid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62946;
--
-- AUTO_INCREMENT for table `swticketpriorities`
--
ALTER TABLE `swticketpriorities`
  MODIFY `priorityid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `swticketrecipients`
--
ALTER TABLE `swticketrecipients`
  MODIFY `ticketrecipientid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42611;
--
-- AUTO_INCREMENT for table `swticketrecurrences`
--
ALTER TABLE `swticketrecurrences`
  MODIFY `ticketrecurrenceid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swtickets`
--
ALTER TABLE `swtickets`
  MODIFY `ticketid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7343;
--
-- AUTO_INCREMENT for table `swticketstatus`
--
ALTER TABLE `swticketstatus`
  MODIFY `ticketstatusid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `swtickettimetracknotes`
--
ALTER TABLE `swtickettimetracknotes`
  MODIFY `tickettimetracknoteid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56509;
--
-- AUTO_INCREMENT for table `swtickettimetracks`
--
ALTER TABLE `swtickettimetracks`
  MODIFY `tickettimetrackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56509;
--
-- AUTO_INCREMENT for table `swtickettypes`
--
ALTER TABLE `swtickettypes`
  MODIFY `tickettypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `swticketviewfields`
--
ALTER TABLE `swticketviewfields`
  MODIFY `ticketviewfieldid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2316;
--
-- AUTO_INCREMENT for table `swticketviewlinks`
--
ALTER TABLE `swticketviewlinks`
  MODIFY `ticketviewlinkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `swticketviews`
--
ALTER TABLE `swticketviews`
  MODIFY `ticketviewid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `swticketwatchers`
--
ALTER TABLE `swticketwatchers`
  MODIFY `ticketwatcherid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `swticketworkflowactions`
--
ALTER TABLE `swticketworkflowactions`
  MODIFY `ticketworkflowactionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `swticketworkflowcriteria`
--
ALTER TABLE `swticketworkflowcriteria`
  MODIFY `ticketworkflowcriteriaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `swticketworkflownotifications`
--
ALTER TABLE `swticketworkflownotifications`
  MODIFY `ticketworkflownotificationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `swticketworkflows`
--
ALTER TABLE `swticketworkflows`
  MODIFY `ticketworkflowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `swuseremails`
--
ALTER TABLE `swuseremails`
  MODIFY `useremailid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2083;
--
-- AUTO_INCREMENT for table `swusergroupassigns`
--
ALTER TABLE `swusergroupassigns`
  MODIFY `usergroupassignid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `swusergroups`
--
ALTER TABLE `swusergroups`
  MODIFY `usergroupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `swusergroupsettings`
--
ALTER TABLE `swusergroupsettings`
  MODIFY `ugroupsettingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `swuserloginlog`
--
ALTER TABLE `swuserloginlog`
  MODIFY `userloginlogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1761;
--
-- AUTO_INCREMENT for table `swusernotedata`
--
ALTER TABLE `swusernotedata`
  MODIFY `usernotedataid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `swusernotes`
--
ALTER TABLE `swusernotes`
  MODIFY `usernoteid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `swuserorganizations`
--
ALTER TABLE `swuserorganizations`
  MODIFY `userorganizationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;
--
-- AUTO_INCREMENT for table `swuserprofileimages`
--
ALTER TABLE `swuserprofileimages`
  MODIFY `userprofileimageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `swuserproperties`
--
ALTER TABLE `swuserproperties`
  MODIFY `userpropertyid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `swusers`
--
ALTER TABLE `swusers`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1020;
--
-- AUTO_INCREMENT for table `swusersettings`
--
ALTER TABLE `swusersettings`
  MODIFY `usersettingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;
--
-- AUTO_INCREMENT for table `swwidgets`
--
ALTER TABLE `swwidgets`
  MODIFY `widgetid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
