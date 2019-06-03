-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Sep 15, 2017 at 09:24 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `doctor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
`admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
`app_id` int(11) NOT NULL,
  `appdef_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `token_no` int(11) NOT NULL,
  `date` date NOT NULL,
  `prescription` longtext,
  `card_no` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_definition`
--

CREATE TABLE `appointment_definition` (
`appdef_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `patient_limit` int(11) NOT NULL,
  `note` longtext,
  `fees` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `pv_id` longtext,
  `videoId` longtext
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `card_no` varchar(255) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
`id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `s_type` varchar(10) NOT NULL,
  `message` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
`commission_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `commission` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
`doctor_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `specialized` varchar(255) NOT NULL,
  `hospital` varchar(255) DEFAULT NULL,
  `mobile` varchar(30) NOT NULL,
  `address_lane_1` varchar(255) NOT NULL,
  `address_lane_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pin` int(11) NOT NULL,
  `country` varchar(40) NOT NULL,
  `about` longtext NOT NULL,
  `password` longtext NOT NULL,
  `document` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'default.png',
  `jdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` int(5) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` longtext,
  `video_id` longtext
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
`id` int(11) NOT NULL,
  `url` longtext NOT NULL,
  `doctor_id` varchar(255) DEFAULT NULL,
  `patient_id` longtext
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
`employee_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `address_lane_1` varchar(255) NOT NULL,
  `address_lane_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pin` int(11) NOT NULL,
  `country` varchar(40) NOT NULL,
  `password` longtext NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'default.png',
  `jdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1008 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
`patient_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `sex` varchar(10) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address_lane_1` varchar(255) NOT NULL,
  `address_lane_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `pin` int(10) NOT NULL,
  `medical_history` longtext,
  `medical_doc` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'default.png',
  `password` varchar(255) NOT NULL,
  `code` int(8) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `video_id` longtext
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
`specialization_id` int(11) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
 ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `appointment_definition`
--
ALTER TABLE `appointment_definition`
 ADD PRIMARY KEY (`appdef_id`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
 ADD PRIMARY KEY (`card_no`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
 ADD PRIMARY KEY (`commission_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
 ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
 ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
 ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
 ADD PRIMARY KEY (`specialization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `appointment_definition`
--
ALTER TABLE `appointment_definition`
MODIFY `appdef_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
MODIFY `commission_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1008;
--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
MODIFY `specialization_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
