-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 12, 2014 at 08:16 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `qldredsdb`
--
CREATE DATABASE `qldredsdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `qldredsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `passwordSalt` varchar(128) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `passwordSalt`) VALUES
(1, 'superTest', 'd4741702748ce0a178ec9e7091781a6cfcae9f234b4221d82a9ea71c416c194a3c47a63ef11b8401e7dcda2538a625f49effebf355ad4c4645d8d90501e9594d', '398399db470978eea191e9c42f8fd295dbcf49f67e220a4443f244f7c6a9d9f780f8dce6ec5949ab3e6424d0e250e80f05d2488bddfebd5eca8c066327b431dc');

-- --------------------------------------------------------

--
-- Table structure for table `users_loggedin`
--

CREATE TABLE IF NOT EXISTS `users_loggedin` (
  `userID` int(11) NOT NULL,
  `cookieHash` text NOT NULL,
  `login_timestamp` datetime NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
