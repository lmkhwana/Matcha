
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


DROP DATABASE IF EXISTS matcha;
CREATE DATABASE IF NOT EXISTS matcha;
use matcha;


DROP TABLE IF EXISTS `blocked`;
CREATE TABLE IF NOT EXISTS `blocked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blocker` int(11) NOT NULL,
  `blocked` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emitter` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `A` int(11) NOT NULL,
  `B` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emitter` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=312 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verif` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT 'Unknown',
  `age` int(11) NOT NULL DEFAULT '0',
  `gender` varchar(3) NOT NULL DEFAULT 'N/A',
  `orientation` varchar(3) NOT NULL DEFAULT 'M/F',
  `bio` varchar(255) NOT NULL DEFAULT 'No bio set yet.',
  `profile_img` varchar(255) NOT NULL DEFAULT 'img/profile.jpg',
  `i1` varchar(255) NOT NULL DEFAULT 'Example',
  `i2` varchar(255) NOT NULL DEFAULT 'Example',
  `i3` varchar(255) NOT NULL DEFAULT 'Example',
  `popscore` int(11) NOT NULL DEFAULT '0',
  `location` varchar(255) NOT NULL DEFAULT 'Unknown',
  `lati` float NOT NULL DEFAULT '0',
  `longi` float NOT NULL DEFAULT '0',
  `lastonline` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reported` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1068 DEFAULT CHARSET=utf8;
   