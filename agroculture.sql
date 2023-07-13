-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 07:52 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agroculture`
--

-- --------------------------------------------------------

--


-- Table structure for table `buyer`
CREATE TABLE `buyer` (
  `bid` int(100) NOT NULL AUTO_INCREMENT,
  `bname` varchar(100) NOT NULL,
  `busername` varchar(100) NOT NULL,
  `bpassword` varchar(100) NOT NULL,
  `bhash` varchar(100) NOT NULL,
  `bemail` varchar(100) NOT NULL,
  `bmobile` varchar(100) NOT NULL,
  `baddress` text NOT NULL,
  `bactive` int(100) NOT NULL DEFAULT '0',
  `fid` int(255) NOT NULL,
  PRIMARY KEY (`bid`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `farmer`
CREATE TABLE `farmer` (
  `fid` int(255) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `fusername` varchar(255) NOT NULL,
  `fpassword` varchar(255) NOT NULL,
  `fhash` varchar(255) NOT NULL,
  `femail` varchar(255) NOT NULL,
  `fmobile` varchar(255) NOT NULL,
  `faddress` text NOT NULL,
  `factive` int(255) NOT NULL DEFAULT '0',
  `frating` int(11) NOT NULL DEFAULT '0',
  `picExt` varchar(255) NOT NULL DEFAULT 'png',
  `picStatus` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `fproduct`
CREATE TABLE `fproduct` (
  `fid` int(255) NOT NULL,
  `pid` int(255) NOT NULL AUTO_INCREMENT,
  `product` varchar(255) NOT NULL,
  `pcat` varchar(255) NOT NULL,
  `pinfo` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `pimage` varchar(255) NOT NULL DEFAULT 'blank.png',
  `picStatus` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  FOREIGN KEY (`bid`) REFERENCES `farmer` (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `likedata`
CREATE TABLE `likedata` (
  `blogId` int(10) NOT NULL,
  `blogUserId` int(10) NOT NULL,
  FOREIGN KEY (`blogId`) REFERENCES `blogdata` (`blogId`),
  FOREIGN KEY (`blogUserId`) REFERENCES `buyer` (`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `mycart`
CREATE TABLE `mycart` (
  `bid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  FOREIGN KEY (`bid`) REFERENCES `buyer` (`bid`),
  FOREIGN KEY (`pid`) REFERENCES `fproduct` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `review`
CREATE TABLE `review` (
  `pid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rating` int(10) NOT NULL,
  `comment` text NOT NULL,
  FOREIGN KEY (`pid`) REFERENCES `fproduct` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table structure for table `transaction`
CREATE TABLE `transaction` (
  `tid` int(10) NOT NULL AUTO_INCREMENT,
  `bid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `addr` varchar(255) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Adding the foreign key relation between `buyer` and `farmer` tables
ALTER TABLE `buyer`
  ADD CONSTRAINT `fk_buyer_farmer` FOREIGN KEY (`bid`) REFERENCES `farmer` (`fid`);

-- Adding the foreign key relation between `likedata` and `blogdata` tables
ALTER TABLE `likedata`
  ADD CONSTRAINT `fk_likedata_blogdata` FOREIGN KEY (`blogId`) REFERENCES `blogdata` (`blogId`);

-- Adding the foreign key relation between `likedata` and `buyer` tables
ALTER TABLE `likedata`
  ADD CONSTRAINT `fk_likedata_buyer` FOREIGN KEY (`blogUserId`) REFERENCES `buyer` (`bid`);


ALTER TABLE `buyer` AUTO_INCREMENT = 1;
