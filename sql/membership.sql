-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2011 at 05:01 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `membership`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(41) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `artPriv` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `accPriv` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `stylePriv` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `adminPriv` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `lastname`, `firstname`, `artPriv`, `accPriv`, `stylePriv`, `adminPriv`) VALUES
(1, 'jerry', '0e2b0bb3a925c7001d953983f9de9823', 'liu', 'jerry', '3', '3', '3', ''),
(2, 'carl', '990ea69ca098ed35ebdc2ad232fb01c5', 'lee', 'carl', '0', '0', '3', ''),
(3, 'ivy', '990ea69ca098ed35ebdc2ad232fb01c5', 'ho', 'ivy', '3', '0', '0', '');
