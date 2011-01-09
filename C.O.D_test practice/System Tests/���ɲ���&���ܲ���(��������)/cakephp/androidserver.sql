-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 01 月 08 日 17:37
-- 服务器版本: 5.1.41
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `androidserver`
--

-- --------------------------------------------------------

--
-- 表的结构 `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 92),
(2, 1, NULL, NULL, 'Pages', 2, 15),
(3, 2, NULL, NULL, 'display', 3, 4),
(4, 2, NULL, NULL, 'add', 5, 6),
(5, 2, NULL, NULL, 'edit', 7, 8),
(6, 2, NULL, NULL, 'index', 9, 10),
(7, 2, NULL, NULL, 'view', 11, 12),
(8, 2, NULL, NULL, 'delete', 13, 14),
(9, 1, NULL, NULL, 'Administrators', 16, 31),
(10, 9, NULL, NULL, 'login', 17, 18),
(11, 9, NULL, NULL, 'logout', 19, 20),
(12, 9, NULL, NULL, 'index', 21, 22),
(13, 9, NULL, NULL, 'view', 23, 24),
(14, 9, NULL, NULL, 'add', 25, 26),
(15, 9, NULL, NULL, 'edit', 27, 28),
(16, 9, NULL, NULL, 'delete', 29, 30),
(17, 1, NULL, NULL, 'Groups', 32, 43),
(18, 17, NULL, NULL, 'index', 33, 34),
(19, 17, NULL, NULL, 'view', 35, 36),
(20, 17, NULL, NULL, 'add', 37, 38),
(21, 17, NULL, NULL, 'edit', 39, 40),
(22, 17, NULL, NULL, 'delete', 41, 42),
(23, 1, NULL, NULL, 'GroupRelations', 44, 55),
(24, 23, NULL, NULL, 'index', 45, 46),
(25, 23, NULL, NULL, 'view', 47, 48),
(26, 23, NULL, NULL, 'add', 49, 50),
(27, 23, NULL, NULL, 'edit', 51, 52),
(28, 23, NULL, NULL, 'delete', 53, 54),
(29, 1, NULL, NULL, 'GroupTypes', 56, 67),
(30, 29, NULL, NULL, 'index', 57, 58),
(31, 29, NULL, NULL, 'view', 59, 60),
(32, 29, NULL, NULL, 'add', 61, 62),
(33, 29, NULL, NULL, 'edit', 63, 64),
(34, 29, NULL, NULL, 'delete', 65, 66),
(35, 1, NULL, NULL, 'News', 68, 79),
(36, 35, NULL, NULL, 'index', 69, 70),
(37, 35, NULL, NULL, 'view', 71, 72),
(38, 35, NULL, NULL, 'add', 73, 74),
(39, 35, NULL, NULL, 'edit', 75, 76),
(40, 35, NULL, NULL, 'delete', 77, 78),
(41, 1, NULL, NULL, 'Students', 80, 91),
(42, 41, NULL, NULL, 'index', 81, 82),
(43, 41, NULL, NULL, 'view', 83, 84),
(44, 41, NULL, NULL, 'add', 85, 86),
(45, 41, NULL, NULL, 'edit', 87, 88),
(46, 41, NULL, NULL, 'delete', 89, 90);

-- --------------------------------------------------------

--
-- 表的结构 `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `exist` tinyint(1) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `administrators`
--

INSERT INTO `administrators` (`id`, `name`, `password`, `exist`, `group_id`) VALUES
(1, 'root', '123456', 1, 6),
(12, 'firefox', '123456', 1, 6),
(3, 'IE', '123456', 1, 6),
(13, 'wa', '123456', 0, 6),
(14, 'google', '123456', 1, 6),
(20, 'tester', '123456', 1, 11),
(21, 'cv', '11', 0, 6);

-- --------------------------------------------------------

--
-- 表的结构 `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- 转存表中的数据 `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'Supers', 1, 6),
(7, NULL, NULL, NULL, 'Normals', 7, 156),
(8, 7, 'Administrator', 11, 'wa', 8, 9),
(11, 7, NULL, NULL, 'IE', 10, 11),
(12, 1, NULL, NULL, 'root', 4, 5),
(6, 1, NULL, NULL, 'firefox', 2, 3),
(13, 7, 'Administrator', NULL, NULL, 12, 13),
(14, 7, 'Administrator', NULL, 'google', 14, 15),
(15, 7, 'Administrator', NULL, 'xunLei', 16, 17),
(16, 7, 'Administrator', NULL, '??°?a’???????‘??“|?—?', 18, 19),
(17, 7, 'Administrator', NULL, 'è??é?????????‘?', 20, 21),
(18, 7, 'Administrator', NULL, '??-?¤§???????‘?', 22, 23),
(19, 7, 'Administrator', 99, 'unix', 24, 25),
(20, 7, 'Administrator', 1, 'root', 26, 27),
(21, 7, 'Administrator', 20, 'tester', 28, 29),
(22, 7, 'Administrator', 99, 'unix', 30, 31),
(23, 7, 'Administrator', 1, 'root', 32, 33),
(24, 7, 'Administrator', 99, 'unix', 34, 35),
(25, 7, 'Administrator', 1, 'root', 36, 37),
(26, 7, 'Administrator', 99, 'unix', 38, 39),
(27, 7, 'Administrator', 1, 'root', 40, 41),
(28, 7, 'Administrator', 99, 'unix', 42, 43),
(29, 7, 'Administrator', 1, 'root', 44, 45),
(30, 7, 'Administrator', 99, 'unix', 46, 47),
(31, 7, 'Administrator', 1, 'root', 48, 49),
(32, 7, 'Administrator', 99, 'unix', 50, 51),
(33, 7, 'Administrator', 1, 'root', 52, 53),
(34, 7, 'Administrator', 99, 'unix', 54, 55),
(35, 7, 'Administrator', 1, 'root', 56, 57),
(36, 7, 'Administrator', 99, 'unix', 58, 59),
(37, 7, 'Administrator', 1, 'root', 60, 61),
(38, 7, 'Administrator', 21, 'unix', 62, 63),
(39, 7, 'Administrator', 1, 'root', 64, 65),
(40, 7, 'Administrator', 21, 'unix', 66, 67),
(41, 7, 'Administrator', 1, 'root', 68, 69),
(42, 7, 'Administrator', 21, 'unix', 70, 71),
(43, 7, 'Administrator', 1, 'root', 72, 73),
(44, 7, 'Administrator', 21, 'unix', 74, 75),
(45, 7, 'Administrator', 1, 'root', 76, 77),
(46, 7, 'Administrator', 21, 'unix', 78, 79),
(47, 7, 'Administrator', 1, 'root', 80, 81),
(48, 7, 'Administrator', 21, 'unix', 82, 83),
(49, 7, 'Administrator', 1, 'root', 84, 85),
(50, 7, 'Administrator', 21, 'unix', 86, 87),
(51, 7, 'Administrator', 1, 'root', 88, 89),
(52, 7, 'Administrator', 21, 'unix', 90, 91),
(53, 7, 'Administrator', 1, 'root', 92, 93),
(54, 7, 'Administrator', 21, 'unix', 94, 95),
(55, 7, 'Administrator', 1, 'root', 96, 97),
(56, 7, 'Administrator', 21, 'cv', 98, 99),
(57, 7, 'Administrator', 99, 'unix', 100, 101),
(58, 7, 'Administrator', 1, 'root', 102, 103),
(59, 7, 'Administrator', 99, 'unix', 104, 105),
(60, 7, 'Administrator', 1, 'root', 106, 107),
(61, 7, 'Administrator', 99, 'unix', 108, 109),
(62, 7, 'Administrator', 1, 'root', 110, 111),
(63, 7, 'Administrator', 99, 'unix', 112, 113),
(64, 7, 'Administrator', 1, 'root', 114, 115),
(65, 7, 'Administrator', 99, 'unix', 116, 117),
(66, 7, 'Administrator', 1, 'root', 118, 119),
(67, 7, 'Administrator', 99, 'unix', 120, 121),
(68, 7, 'Administrator', 1, 'root', 122, 123),
(69, 7, 'Administrator', 99, 'unix', 124, 125),
(70, 7, 'Administrator', 1, 'root', 126, 127),
(71, 7, 'Administrator', 99, 'unix', 128, 129),
(72, 7, 'Administrator', 1, 'root', 130, 131),
(73, 7, 'Administrator', 99, 'unix', 132, 133),
(74, 7, 'Administrator', 1, 'root', 134, 135),
(75, 7, 'Administrator', 99, 'unix', 136, 137),
(76, 7, 'Administrator', 1, 'root', 138, 139),
(77, 7, 'Administrator', 99, 'unix', 140, 141),
(78, 7, 'Administrator', 1, 'root', 142, 143),
(79, 7, 'Administrator', 99, 'unix', 144, 145),
(80, 7, 'Administrator', 1, 'root', 146, 147),
(81, 7, 'Administrator', 99, 'unix', 148, 149),
(82, 7, 'Administrator', 1, 'root', 150, 151),
(83, 7, 'Administrator', 99, 'unix', 152, 153),
(84, 7, 'Administrator', 1, 'root', 154, 155);

-- --------------------------------------------------------

--
-- 表的结构 `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 7, 14, '-1', '-1', '-1', '-1'),
(2, 7, 15, '-1', '-1', '-1', '-1'),
(3, 7, 16, '-1', '-1', '-1', '-1'),
(4, 7, 9, '1', '1', '1', '1'),
(5, 1, 1, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET latin1 NOT NULL,
  `groupType_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`id`, `name`, `groupType_id`) VALUES
(6, 'ko', 2),
(11, 'testGroup', 4),
(12, 'æžçš„çš„çš„', 3),
(13, 'çš„å®˜æ–¹å¤šå›½', 2);

-- --------------------------------------------------------

--
-- 表的结构 `group_relations`
--

CREATE TABLE IF NOT EXISTS `group_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupOwner_id` int(11) NOT NULL,
  `groupOwned_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `group_relations`
--

INSERT INTO `group_relations` (`id`, `groupOwner_id`, `groupOwned_id`) VALUES
(4, 12, 11),
(5, 12, 13);

-- --------------------------------------------------------

--
-- 表的结构 `group_types`
--

CREATE TABLE IF NOT EXISTS `group_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `group_types`
--

INSERT INTO `group_types` (`id`, `name`) VALUES
(2, 'sc'),
(3, 'university'),
(4, 'testGroupType');

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `text` varchar(5120) NOT NULL,
  `date` datetime NOT NULL,
  `administrator_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `title`, `text`, `date`, `administrator_id`) VALUES
(1, 'vdf', 'dsf', '2010-12-04 05:08:00', 1),
(2, '2', '3', '2010-12-06 06:18:00', 1),
(3, 'IE1', '??IE1', '2010-12-06 08:40:00', 3),
(4, 'IE2', '??‘???IE2', '2010-12-06 08:41:00', 3),
(6, 'fg', 'gsdf', '2010-12-06 14:30:00', 1),
(7, 'aaaa', 'dgwrgrwgrhy', '2010-12-07 23:27:38', 17),
(8, 'bb', 'Our president is so handsome!!WOW!!', '2010-12-08 23:28:36', 17),
(9, 'cc', 'OMGOMGOMG!!', '2010-12-09 23:29:08', 17),
(10, 'dd', 'TMDTMDTMD!!', '2010-09-07 12:02:43', 17),
(11, 'eeee', 'WHO?', '2010-12-17 23:31:15', 18),
(12, 'ff', 'WHAT?', '2010-11-24 23:31:43', 18),
(13, 'gg', 'GGGG baby baby', '2009-12-18 23:33:14', 18),
(14, 'hh', 'so hot!!', '2010-01-12 23:33:57', 18),
(15, 'ii', 'IUIUIU', '2010-12-10 23:34:51', 19),
(16, 'jj', 'JJ or JAYJAY?', '2010-12-04 23:35:19', 19),
(17, 'kk', 'KO?OK!!', '2007-08-30 02:35:58', 19),
(18, 'll', 'Love the way you lie', '2010-12-10 05:36:37', 19),
(19, 'mm', 'a mm', '2010-06-03 23:37:06', 19),
(20, 'addclass', 'dsgsg', '2010-12-28 01:25:10', 17),
(21, 'addschool', 'asrgrfg', '2010-12-27 01:25:37', 18),
(24, 'Hello_tester', 'Hello world', '2011-01-01 21:50:57', 20),
(25, 'Hi_tester', 'Hi, world', '2011-01-01 21:51:17', 20),
(26, 'æ˜¯ç¡çš„å•å€¼', 'ç­‰ç­‰çš„', '2011-01-07 16:09:00', 3);

-- --------------------------------------------------------

--
-- 表的结构 `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `students`
--

INSERT INTO `students` (`id`, `name`, `password`, `group_id`) VALUES
(2, 'asd', '123456', 6),
(3, 'sbmx', 'sb', 6),
(4, 'Lily', '123', 9);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
