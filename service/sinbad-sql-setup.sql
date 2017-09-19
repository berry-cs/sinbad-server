-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2017 at 04:50 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sinbad`
--
CREATE DATABASE IF NOT EXISTS `sinbad` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sinbad`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `setup` (
  `id` int(11) NOT NULL DEFAULT '1' COMMENT 'should only be 1 row ever in this table',
  `operational` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

TRUNCATE TABLE `setup`;

INSERT INTO `setup` (`id`, `operational`) VALUES
(1, 1);

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `envs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `os` varchar(128) NOT NULL,
  `lang` varchar(128) NOT NULL,
  `version` varchar(32) NOT NULL,
  `hash` char(32) NOT NULL DEFAULT 'md5(concat(lang,os,version))',
  PRIMARY KEY (`id`),
  KEY `os` (`os`,`lang`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


CREATE TABLE IF NOT EXISTS `installs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'auto-filled with timestamp record is created',
  `first_use_ts` int(11) NOT NULL COMMENT 'unix timestamp',
  `env` int(11) NOT NULL COMMENT 'foreign key to envs table',
  PRIMARY KEY (`id`),
  KEY `first_use_ts` (`first_use_ts`),
  KEY `ts` (`ts`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;


CREATE TABLE IF NOT EXISTS `usage_fetches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `env_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `field_paths` varchar(2048) DEFAULT NULL COMMENT 'comma-separated list',
  `base_path` varchar(256) NOT NULL,
  `select_option` varchar(64) DEFAULT NULL COMMENT 'null,"random", or an int',
  `got_data` tinyint(1) NOT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`,`hash`),
  KEY `env_id` (`env_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;


CREATE TABLE IF NOT EXISTS `usage_loads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `env_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `data_options` varchar(512) DEFAULT NULL,
  `status` varchar(128) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `hash` char(32) NOT NULL COMMENT 'md5(concat(env_id, src_id, data_options, status))',
  PRIMARY KEY (`id`),
  KEY `env_id` (`env_id`,`source_id`,`status`,`hash`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;


CREATE TABLE IF NOT EXISTS `usage_samples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `env_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL COMMENT 'foreign key to usage_sources',
  `sample_amt` int(11) NOT NULL,
  `sample_seed` int(11) DEFAULT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source_id` (`source_id`),
  KEY `hash` (`hash`),
  KEY `env_id` (`env_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `usage_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_url` varchar(1024) NOT NULL,
  `data_format` varchar(10) NOT NULL,
  `file_entry` varchar(256) DEFAULT NULL,
  `hash` char(32) NOT NULL COMMENT 'md5(concat(''$full_url'',''$format'', ''$file_entry''))',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;


CREATE TABLE IF NOT EXISTS `usage_timestamps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL COMMENT 'load,fetch,sample,...',
  `usage_id` int(11) NOT NULL COMMENT 'foreign key',
  `timestamp` int(11) NOT NULL COMMENT 'unix timestamp',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
