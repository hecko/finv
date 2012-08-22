-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 22, 2012 at 11:43 AM
-- Server version: 5.0.95
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `finv`
--

-- --------------------------------------------------------

--
-- Table structure for table `firms`
--

CREATE TABLE IF NOT EXISTS `firms` (
  `id` int(11) NOT NULL auto_increment,
  `description` text NOT NULL,
  `vat_payer` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL auto_increment,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `issued` date NOT NULL,
  `lang` varchar(3) NOT NULL,
  `hash` varchar(256) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL auto_increment,
  `invoice_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

