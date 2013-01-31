-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.blueunit.info
-- Generation Time: Jan 07, 2013 at 11:27 PM
-- Server version: 5.1.39
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pettie`
--

-- --------------------------------------------------------

--
-- Table structure for table `AccountInfo`
--

CREATE TABLE IF NOT EXISTS `AccountInfo` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Pic` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images/avator.png',
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `status` set('Actived','Disactived','Pendding') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pendding',
  `privilege` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Member Infos' AUTO_INCREMENT=49 ;

--
-- Dumping data for table `AccountInfo`
--

INSERT INTO `AccountInfo` (`id`, `username`, `password`, `Pic`, `email`, `status`, `privilege`) VALUES
(14, 'lanyitin', 'd739964cf9c5508fd9699af0c9f4347d', 'images/avator/14.png', 'lanyitin800830@gmail.com', 'Actived', 65),
(15, 'debbie', '7865a80ca9bfe60bb732eff98ea1830d', 'images/avator/15.png', 's20153s20153@yahoo.com.tw', 'Actived', 1),
(17, 'jiun7892', 'bf060ffc6e9765b5e1b48043dbdce4c1', 'images/avator.png', 'lanyitin800830@gmail.com', 'Actived', 1),
(20, 'banana', 'ace80c81488b993d94ffed25aaa4ca8d', 'images/avator/20.png', 'ws6617@hotmail.com', 'Actived', 1),
(21, 'wanchi', '47516f00f92c30a87e0d7a437ecd6982', 'images/avator/21.png', 'a8012613@hotmail.com', 'Actived', 1),
(22, 'Alex', 'f45acf455bd6f0139004f2a8571d4c44', 'images/avator.png', 'god_741963789@hotmail.com', 'Actived', 1),
(27, 'test', '098f6bcd4621d373cade4e832627b4f6', 'images/avator.png', 'test@test.test', 'Actived', 1),
(28, 'shawn', 'a3cceba83235dc95f750108d22c14731', 'images/avator/28.png', 'whwck@hotmail.com', 'Actived', 1),
(30, 'ws6617', 'ace80c81488b993d94ffed25aaa4ca8d', 'images/avator.png', 'ws6617@hotmail.com', 'Actived', 1),
(31, 'tina3284', '6456e37b9d5b8955e9114ee39ca0268d', 'images/avator/31.png', 'tina3284@hotmail.com', 'Actived', 1),
(32, 'Hayley', 'e93e295c4d9a59e9b22602b3852b771f', 'images/avator.png', 'yoyo83117@yahoo.com.tw', 'Actived', 1),
(33, 'Jenny', '1bb18d0285528be82aef4e6b63af0ef5', 'images/avator.png', 'jenny11338@yahoo.com.tw', 'Actived', 1),
(34, 'test123', '098f6bcd4621d373cade4e832627b4f6', 'images/avator.png', 'lanyitin800830@gmail.com', 'Actived', 1),
(35, 'Pascal', 'd3002df677bc5070b8368170e820c077', 'images/avator.png', 'smart00735@yahoo.com', 'Pendding', 1),
(36, 'ring123', '202cb962ac59075b964b07152d234b70', 'images/avator.png', 'punk9525@yahoo.com.tw', 'Actived', 1),
(37, 'test321', '098f6bcd4621d373cade4e832627b4f6', 'images/avator.png', 'test@gmail.com', 'Pendding', 1),
(38, 'test4321', '098f6bcd4621d373cade4e832627b4f6', 'images/avator.png', 'test@gmail.com', 'Pendding', 1),
(39, '66176617', 'e10adc3949ba59abbe56e057f20f883e', 'images/avator.png', 'ws6617@yahoo.com.tw', 'Pendding', 1),
(40, 'an002211', '9546b630fcaead628051b9de706becf2', 'images/avator.png', 'an002211@yahoo.com.tw', 'Actived', 1),
(42, 'tryagain', 'e10adc3949ba59abbe56e057f20f883e', 'images/avator.png', 'trydownload@sina.com', 'Actived', 1),
(43, 'banana6617', 'ace80c81488b993d94ffed25aaa4ca8d', 'images/avator.png', 'ws6617@hotmail.com', 'Pendding', 1),
(44, 'nbasp26', '24c0383cde606e5cce1c40267b0fe851', 'images/avator.png', 'nbasp26@yahoo.com.tw', 'Actived', 1),
(45, 'riiiin', 'b60a16c478997441acdbb1a50a87e4dc', 'images/avator.png', 'judy20132002@yahoo.com.tw', 'Actived', 1),
(46, 'naruto8253', 'f9db76a930aaad382d7d8de384d9572c', 'images/avator.png', 'naruto8253@yahoo.com.tw', 'Actived', 1),
(47, '498850162', '96e79218965eb72c92a549dd5a330112', 'images/avator.png', 'k7860710970@hotmail.com', 'Pendding', 1),
(48, '12345678', '25d55ad283aa400af464c76d713c07ad', 'images/avator.png', 'k7860710970@hotmail.com', 'Pendding', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ERROR_MSG`
--

CREATE TABLE IF NOT EXISTS `ERROR_MSG` (
  `CODE` varchar(40) NOT NULL,
  `MSG` varchar(40) NOT NULL,
  PRIMARY KEY (`CODE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ERROR_MSG`
--

INSERT INTO `ERROR_MSG` (`CODE`, `MSG`) VALUES
('NOT_LOGIN', '請先登入'),
('CAN_NOT_FIND_USERNAME', '找不到使用者帳號'),
('EMAIL_EXISTS', '此Email已使用'),
('WRONG_PASSWORD', '密碼錯誤'),
('WRONG_EMAIL_FORMAT', 'Email格式錯誤'),
('WRONG_PASSWROD_FORMAT', '密碼格式錯誤'),
('WRONG_USERNAME_FORMAT', '帳號格式錯誤'),
('NOT_ENOUGH_PRIVILEGE', '權限不足');

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(5) NOT NULL,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mid` (`mid`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `Group`
--

INSERT INTO `Group` (`id`, `mid`, `name`) VALUES
(27, 14, 'Circle1'),
(31, 14, '中文測試'),
(52, 15, 'pettie'),
(19, 20, ''),
(46, 20, '122'),
(47, 20, 'afa'),
(48, 20, 'shrs'),
(38, 21, 'Pettie'),
(54, 21, 'TKU'),
(56, 22, '123'),
(55, 22, '@@'),
(58, 27, '&atilde;'),
(57, 27, '5555'),
(34, 28, 'tku');

-- --------------------------------------------------------

--
-- Table structure for table `IN_GROUP`
--

CREATE TABLE IF NOT EXISTS `IN_GROUP` (
  `mid` int(5) NOT NULL,
  `gid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mid`,`gid`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `IN_GROUP`
--

INSERT INTO `IN_GROUP` (`mid`, `gid`) VALUES
(14, 19),
(15, 19),
(17, 19),
(15, 27),
(20, 27),
(21, 27),
(15, 31),
(17, 31),
(20, 31),
(21, 31),
(22, 31),
(27, 31),
(14, 38),
(15, 38),
(20, 38),
(22, 38),
(14, 46),
(15, 46),
(17, 46),
(21, 46),
(22, 46),
(27, 46),
(14, 47),
(17, 47),
(21, 47),
(27, 47),
(14, 52),
(20, 52),
(22, 52),
(20, 54),
(22, 54),
(31, 54),
(40, 54),
(32, 55),
(33, 55),
(15, 56),
(21, 56);

-- --------------------------------------------------------

--
-- Table structure for table `LIKE_POST`
--

CREATE TABLE IF NOT EXISTS `LIKE_POST` (
  `mid` int(5) NOT NULL,
  `pid` int(10) NOT NULL,
  PRIMARY KEY (`mid`,`pid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LIKE_POST`
--

INSERT INTO `LIKE_POST` (`mid`, `pid`) VALUES
(20, 0),
(14, 47),
(15, 47),
(20, 47),
(14, 55),
(15, 55),
(15, 84),
(20, 84),
(14, 85),
(15, 85),
(14, 91),
(14, 95),
(14, 109),
(14, 120),
(20, 120),
(14, 122),
(15, 123),
(15, 152),
(15, 218),
(15, 224),
(20, 230),
(20, 231),
(20, 232),
(20, 235),
(31, 235),
(14, 236),
(14, 237),
(20, 237),
(15, 240),
(20, 240),
(22, 240),
(20, 253),
(21, 259),
(15, 260),
(21, 307),
(22, 307),
(31, 307),
(28, 309),
(28, 310),
(28, 311),
(28, 312),
(28, 313),
(28, 314),
(28, 315),
(28, 316),
(28, 317),
(22, 318),
(22, 322),
(15, 382),
(15, 384),
(20, 388),
(31, 391),
(20, 406),
(20, 407),
(20, 408),
(20, 436),
(20, 447),
(20, 448),
(20, 454),
(20, 465),
(15, 467),
(22, 467),
(21, 471),
(15, 474),
(20, 474),
(21, 479),
(15, 499);

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE IF NOT EXISTS `Notifications` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `[id` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `Notifications`
--

INSERT INTO `Notifications` (`id`, `mid`, `pid`) VALUES
(11, 31, 475),
(12, 31, 477),
(13, 31, 478),
(14, 31, 479),
(15, 40, 480),
(16, 31, 482),
(18, 31, 485),
(20, 31, 492),
(21, 45, 494),
(22, 45, 495),
(23, 45, 499),
(24, 45, 500);

-- --------------------------------------------------------

--
-- Table structure for table `PetInfo`
--

CREATE TABLE IF NOT EXISTS `PetInfo` (
  `UserID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Birthday` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Gender` tinyint(1) NOT NULL,
  `father` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Designer',
  `mother` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Designer',
  `Spouse` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '無',
  `Birthplace` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '寵物星球',
  `Introduction` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`PetID`),
  UNIQUE KEY `UserId_UNIQUE` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=132 ;

--
-- Dumping data for table `PetInfo`
--

INSERT INTO `PetInfo` (`UserID`, `PetID`, `Name`, `Birthday`, `Gender`, `father`, `mother`, `Spouse`, `Birthplace`, `Introduction`) VALUES
(22, 80, '別殺我我滿等了', '2012-11-27 06:37:05', 1, '我阿懷疑阿', '從缺唷目前', '無', '寵物星球??', '信我得永生'),
(31, 86, '哈利', '2012-11-29 00:26:25', 1, '哈哈', '呵呵', '無', '寵物星球', ' 可愛的小狗'),
(33, 90, 'Momo', '2012-12-08 08:16:11', 1, 'Designer', 'Designer', '無', '寵物星球', '可愛的小狗'),
(36, 92, 'tea', '2012-12-25 08:46:01', 2, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(40, 93, 'cute', '2012-12-26 01:06:54', 2, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(44, 98, 'Apple', '2013-01-01 00:20:52', 2, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(45, 100, '麻糬', '2013-01-01 19:47:05', 1, '糯米一世', '紅豆泥', '徵女友', '麻糬家', '他不是狗 他是麻糬'),
(46, 102, 'Orange', '2013-01-04 10:45:57', 1, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(21, 103, '我要活下去', '2013-01-04 22:23:39', 1, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(27, 105, '小貓咪', '2013-01-05 07:38:13', 1, '公狗生小貓', '性感小貓咪', '雷曉娟', '煞母吉姆村', '咬我阿  哈哈哈  我什麼都不怕'),
(32, 106, 'Q', '2013-01-07 09:37:47', 2, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(15, 129, 'r', '2013-01-07 23:21:14', 1, 'Designer', 'Designer', '無', '寵物星球', '小狗'),
(14, 131, 'QQ', '2013-01-07 23:24:21', 1, 'Designer', 'Designer', '無', '寵物星球', '小狗');

-- --------------------------------------------------------

--
-- Table structure for table `PetStatus`
--

CREATE TABLE IF NOT EXISTS `PetStatus` (
  `idx` int(5) NOT NULL AUTO_INCREMENT,
  `PetID` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `currentExperience` int(100) NOT NULL DEFAULT '0',
  `requiredExperience` int(100) NOT NULL DEFAULT '12',
  `level` int(4) NOT NULL DEFAULT '1',
  `status` set('健康','生病','死亡','肚子餓','髒') COLLATE utf8_unicode_ci NOT NULL DEFAULT '健康',
  `health` int(10) NOT NULL DEFAULT '100',
  `satiation` int(5) NOT NULL DEFAULT '30',
  `cleanliness` int(5) NOT NULL DEFAULT '30',
  `excreta` int(2) NOT NULL DEFAULT '5',
  `needClean` int(5) NOT NULL DEFAULT '0',
  `injectionC` int(5) NOT NULL DEFAULT '3',
  `feedC` int(5) NOT NULL DEFAULT '20',
  PRIMARY KEY (`idx`),
  UNIQUE KEY `PetID` (`PetID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=135 ;

--
-- Dumping data for table `PetStatus`
--

INSERT INTO `PetStatus` (`idx`, `PetID`, `type`, `currentExperience`, `requiredExperience`, `level`, `status`, `health`, `satiation`, `cleanliness`, `excreta`, `needClean`, `injectionC`, `feedC`) VALUES
(46, 80, '狗', 0, 522, 8, '健康', 58, 22, 13, 0, 10, 3, 15),
(52, 86, '狗', 21, 26, 3, '健康', 0, 0, 0, 0, 0, 3, 20),
(56, 90, '狗', 0, 42, 4, '健康', 85, 23, 28, 10, 0, 3, 11),
(58, 92, '狗', 0, 12, 1, '', 22, 0, 13, 0, 5, 3, 20),
(59, 93, '狗', 8, 12, 1, '健康', 0, 0, 0, 0, 0, 3, 20),
(97, 98, '狗', 0, 18, 2, '健康', 0, 0, 0, 0, 0, 3, 20),
(109, 100, '狗', 0, 12, 1, '髒', 0, 0, 0, 9, 1, 3, 20),
(114, 102, '狗', 17, 42, 4, '髒', 38, 23, 0, 10, 0, 3, 18),
(119, 103, '狗', 3, 12, 1, '健康', 0, 0, 0, 2, 1, 3, 20),
(122, 105, '狗', 8, 12, 1, '健康', 13, 8, 0, 10, 0, 3, 20),
(127, 106, '狗', 0, 12, 1, '健康', 78, 23, 24, 2, 1, 3, 20),
(132, 129, '狗', 0, 12, 1, '健康', 100, 30, 30, 5, 0, 3, 20),
(134, 131, '狗', 0, 12, 1, '健康', 100, 30, 30, 5, 0, 3, 20);

--
-- Triggers `PetStatus`
--
DROP TRIGGER IF EXISTS `LEVEL_UP`;
DELIMITER //
CREATE TRIGGER `LEVEL_UP` BEFORE UPDATE ON `PetStatus`
 FOR EACH ROW BEGIN
IF NEW.currentExperience>=NEW.requiredExperience THEN
SET NEW.level=NEW.level+1, NEW.currentExperience=0, NEW.requiredExperience=10+POW(2,(NEW.level+1));
END IF;
SET NEW.health=(NEW.satiation+NEW.cleanliness)*5/3;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

CREATE TABLE IF NOT EXISTS `Post` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mid` int(5) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `reply` int(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `refToid` (`reply`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Articles' AUTO_INCREMENT=508 ;

--
-- Dumping data for table `Post`
--

INSERT INTO `Post` (`id`, `mid`, `content`, `type`, `reply`, `time`) VALUES
(240, 20, '123sdf', '喜歡', 0, '2012-10-10 08:39:17'),
(295, 14, '旺旺', '喜歡', 240, '2012-11-19 22:16:03'),
(297, 14, '旺旺', '喜歡', 240, '2012-11-19 22:19:28'),
(300, 14, '旺旺', '喜歡', 240, '2012-11-19 22:38:33'),
(301, 14, '喵喵', '喜歡', 240, '2012-11-19 22:39:49'),
(302, 14, '聒聒', '喜歡', 240, '2012-11-19 22:42:43'),
(303, 14, '轟轟轟', '喜歡', 240, '2012-11-19 22:44:39'),
(307, 15, '我是花生: )', '喜歡', 0, '2012-11-20 04:41:34'),
(315, 28, 'test', '喜歡', 0, '2012-11-20 18:36:33'),
(317, 28, 'www.google.com', '分享', 0, '2012-11-20 18:37:39'),
(320, 22, '1\n', '說', 307, '2012-11-21 06:17:26'),
(321, 22, '12', '說', 307, '2012-11-21 06:17:32'),
(322, 22, '123', '喜歡', 307, '2012-11-26 07:10:14'),
(323, 22, '.\n', '喜歡', 322, '2012-11-26 07:10:39'),
(324, 15, 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', '喜歡', 307, '2012-11-26 07:26:47'),
(357, 22, '還是有只有我不能換圖片\nThe validation of username was failed', '喜歡', 307, '2012-11-27 07:02:53'),
(382, 15, 'BUG : 重新上傳照片後 不會立即更新照片...', '說', 0, '2012-11-28 23:40:36'),
(384, 15, '另一個小問題\n我看不到發文的全文', '說', 0, '2012-11-28 23:47:47'),
(388, 15, 'test again\n為啥事1小時前??', '喜歡', 0, '2012-11-28 23:50:10'),
(391, 31, '我要加朋友啊啊啊啊T_T', '說', 0, '2012-11-29 00:30:41'),
(392, 14, '這要想辦法讓Image element做 reload', '喜歡', 382, '2012-11-29 06:02:36'),
(396, 21, '我家NoGG快掛掉啦！！', '喜歡', 0, '2012-12-01 07:44:45'),
(399, 15, '我本來想跟你說他不會掛\n沒想到開會的時候就掛了XDDD\n', '喜歡', 396, '2012-12-03 09:20:53'),
(400, 21, '餵食之後要重新整理數值才會有變動嗎?0.0', '喜歡', 0, '2012-12-03 23:35:49'),
(401, 21, '兇手!!', '喜歡', 396, '2012-12-04 00:25:44'),
(402, 21, '是說在回覆視窗裡,最新的回覆也是在最上面?', '喜歡', 396, '2012-12-04 00:26:32'),
(403, 20, '好像是這樣唉', '喜歡', 400, '2012-12-04 02:10:33'),
(406, 22, '發文', '說', 0, '2012-12-06 00:28:10'),
(407, 20, 'se', '喜歡', 0, '2012-12-06 06:11:11'),
(408, 22, '餵食後 健康 跟飽足 會瞬間破百\n這是我電腦問題還是新bug?', '喜歡', 0, '2012-12-06 21:20:37'),
(432, 22, '換藍翊庭 爆走了\n', '喜歡', 0, '2012-12-09 00:01:12'),
(433, 14, '那是我故意發文測試的', '喜歡', 432, '2012-12-09 06:45:14'),
(435, 20, '123', '喜歡', 434, '2012-12-10 06:32:44'),
(436, 20, '8rfxjmdrtjS', '分享', 0, '2012-12-10 06:34:09'),
(438, 20, 'SghbScnzdfbn ngmzcfggmn', '喜歡', 436, '2012-12-10 06:41:08'),
(439, 20, 'SghbS', '問', 436, '2012-12-10 06:41:46'),
(440, 20, 'zdhb', '喜歡', 436, '2012-12-10 06:42:28'),
(441, 20, 'dgnhdsx', '喜歡', 436, '2012-12-10 06:42:44'),
(442, 20, '剛發聞的瞬間會有這段唉\n在時間的地方\n1355204565363\n之後才會轉換成\n2012-12-10 06:42:28', '喜歡', 436, '2012-12-10 06:43:48'),
(443, 14, '測試', '喜歡', 408, '2012-12-10 19:53:35'),
(453, 21, '加好友還是不能用呦~~~~~', '喜歡', 0, '2012-12-18 23:13:57'),
(455, 15, 'test', '喜歡', 0, '2012-12-24 04:15:35'),
(465, 31, '如茵~~~~~♥♥♥♥♥♥♥♥♥♥♥♥♥', '喜歡', 0, '2012-12-24 17:36:21'),
(467, 15, '我強烈建議要有刪好友功能!!', '喜歡', 0, '2012-12-24 17:40:33'),
(471, 15, 'QQQQQQQQQQQQQQQQ', '說', 465, '2012-12-24 18:41:55'),
(473, 14, '測試', '喜歡', 436, '2012-12-24 19:16:48'),
(474, 31, '我強烈建議要有討厭功能!!', '喜歡', 0, '2012-12-25 17:16:27'),
(475, 21, '然後把如茵的版洗爆!!((啥?', '喜歡', 474, '2012-12-26 00:06:02'),
(476, 40, 'merry christmas', '喜歡', 0, '2012-12-26 01:11:26'),
(477, 15, '想被我刪會員嗎??', '說', 474, '2012-12-26 01:33:16'),
(478, 21, '如茵幫我把&quot;tryit&quot;會員給砍了!!3Q~&gt;.0', '喜歡', 474, '2012-12-26 05:05:41'),
(479, 22, '我砍嚕', '問', 474, '2012-12-26 06:46:23'),
(480, 21, 'Merry christmas!!', '說', 476, '2012-12-26 08:24:36'),
(481, 31, '我家哈利要屎翹翹了\n', '分享', 0, '2012-12-27 00:45:33'),
(482, 21, '就讓牠屎了吧~', '說', 481, '2012-12-27 05:14:02'),
(483, 22, '發文 again', '喜歡', 0, '2012-12-29 08:22:18'),
(484, 15, 'test', '喜歡', 453, '2012-12-30 05:34:24'),
(485, 15, '你家哈利真的&quot;死&quot;翹翹了', '說', 481, '2012-12-30 23:13:45'),
(492, 21, '如茵悲劇了XDDDD', '說', 465, '2013-01-01 00:25:16'),
(493, 45, '我養了一隻麻糬!!!!!!!\n', '分享', 0, '2013-01-01 19:54:35'),
(494, 45, '希望伙食費不要太大', '說', 493, '2013-01-01 19:55:10'),
(495, 21, '我同意花生要有&quot;討厭&quot;的功能= =+', '說', 493, '2013-01-01 19:55:28'),
(496, 45, '麻糬亂便便 壞麻糬 ', '說', 0, '2013-01-01 20:05:25'),
(499, 21, '如果我們之真的有&quot;討厭&quot;的功能,阿毛絕對是最大的推手!!', '說', 496, '2013-01-03 00:12:40'),
(500, 15, '你家麻糬 快GG了\n我只好好心地幫你餵一下他XD\n阿毛養的寵物果然....', '說', 493, '2013-01-05 00:52:39'),
(501, 27, '好開心喔 養了小貓咪\n\n\n', '喜歡', 0, '2013-01-05 07:41:39'),
(502, 27, '好開心喔 養了小貓咪\n\n\n', '喜歡', 0, '2013-01-05 07:41:40'),
(503, 27, '快家我好友吧\n\n', '喜歡', 0, '2013-01-05 07:49:54'),
(504, 27, '快家我好友吧\n\n', '喜歡', 0, '2013-01-05 07:49:55'),
(505, 27, '快家我好友吧\n\n', '喜歡', 0, '2013-01-05 07:49:55'),
(506, 27, '快家我好友吧\n\n', '喜歡', 0, '2013-01-05 07:49:55'),
(507, 27, '快家我好友吧\n\n', '喜歡', 0, '2013-01-05 07:49:55');

--
-- Triggers `Post`
--
DROP TRIGGER IF EXISTS `auto_read_after_post`;
DELIMITER //
CREATE TRIGGER `auto_read_after_post` AFTER INSERT ON `Post`
 FOR EACH ROW BEGIN
    INSERT INTO `READ_POST` VALUES(NEW.mid, NEW.id);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `PRIVILEGE`
--

CREATE TABLE IF NOT EXISTS `PRIVILEGE` (
  `code` int(11) NOT NULL,
  `text` varchar(10) NOT NULL,
  UNIQUE KEY `code` (`code`,`text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PRIVILEGE`
--

INSERT INTO `PRIVILEGE` (`code`, `text`) VALUES
(1, 'GUEST'),
(2, 'MEMBER'),
(64, 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `READ_POST`
--

CREATE TABLE IF NOT EXISTS `READ_POST` (
  `mid` int(10) NOT NULL,
  `pid` int(5) NOT NULL,
  PRIMARY KEY (`mid`,`pid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `READ_POST`
--

INSERT INTO `READ_POST` (`mid`, `pid`) VALUES
(14, 240),
(20, 240),
(22, 240),
(14, 307),
(15, 307),
(20, 307),
(21, 307),
(22, 307),
(31, 307),
(28, 315),
(28, 317),
(14, 382),
(15, 382),
(20, 382),
(21, 382),
(22, 382),
(31, 382),
(14, 384),
(15, 384),
(20, 384),
(21, 384),
(22, 384),
(31, 384),
(14, 388),
(15, 388),
(20, 388),
(21, 388),
(22, 388),
(31, 388),
(14, 391),
(15, 391),
(20, 391),
(21, 391),
(22, 391),
(31, 391),
(14, 392),
(15, 396),
(20, 396),
(21, 396),
(22, 396),
(15, 399),
(15, 400),
(20, 400),
(21, 400),
(22, 400),
(21, 401),
(21, 402),
(20, 403),
(14, 406),
(20, 406),
(21, 406),
(22, 406),
(14, 407),
(20, 407),
(22, 407),
(14, 408),
(20, 408),
(21, 408),
(22, 408),
(14, 432),
(20, 432),
(21, 432),
(22, 432),
(14, 433),
(20, 435),
(14, 436),
(20, 436),
(22, 436),
(20, 438),
(20, 439),
(20, 440),
(20, 441),
(20, 442),
(14, 443),
(15, 453),
(21, 453),
(22, 453),
(14, 455),
(15, 455),
(22, 455),
(14, 465),
(15, 465),
(22, 465),
(31, 465),
(14, 467),
(15, 467),
(22, 467),
(15, 471),
(14, 473),
(31, 474),
(21, 475),
(40, 476),
(15, 477),
(21, 478),
(22, 479),
(21, 480),
(31, 481),
(21, 482),
(22, 483),
(15, 484),
(15, 485),
(21, 492),
(45, 493),
(45, 494),
(21, 495),
(45, 496),
(21, 499),
(15, 500),
(27, 501),
(27, 502),
(27, 503),
(27, 504),
(27, 505),
(27, 506),
(27, 507);

-- --------------------------------------------------------

--
-- Table structure for table `Relationship`
--

CREATE TABLE IF NOT EXISTS `Relationship` (
  `mid1` int(5) NOT NULL COMMENT 'sender',
  `mid2` int(5) NOT NULL COMMENT 'recevier',
  `status` set('Pendding','Comfirmed') NOT NULL DEFAULT 'Pendding',
  PRIMARY KEY (`mid1`,`mid2`),
  KEY `mid2` (`mid2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Relationship`
--

INSERT INTO `Relationship` (`mid1`, `mid2`, `status`) VALUES
(14, 20, 'Comfirmed'),
(14, 21, 'Comfirmed'),
(14, 31, 'Pendding'),
(15, 14, 'Comfirmed'),
(15, 20, 'Comfirmed'),
(15, 21, 'Comfirmed'),
(20, 21, 'Comfirmed'),
(20, 31, 'Comfirmed'),
(20, 35, 'Pendding'),
(22, 15, 'Comfirmed'),
(22, 21, 'Comfirmed'),
(22, 22, 'Comfirmed'),
(22, 31, 'Comfirmed'),
(22, 32, 'Comfirmed'),
(22, 33, 'Comfirmed'),
(22, 36, 'Comfirmed'),
(27, 14, 'Pendding'),
(27, 15, 'Pendding'),
(27, 30, 'Pendding'),
(27, 36, 'Pendding'),
(27, 45, 'Pendding'),
(31, 15, 'Comfirmed'),
(31, 21, 'Comfirmed'),
(31, 34, 'Pendding'),
(36, 32, 'Comfirmed'),
(36, 33, 'Comfirmed'),
(40, 21, 'Comfirmed'),
(45, 14, 'Pendding'),
(45, 15, 'Comfirmed'),
(45, 20, 'Comfirmed'),
(45, 21, 'Comfirmed'),
(45, 31, 'Pendding'),
(46, 22, 'Comfirmed'),
(46, 32, 'Pendding'),
(46, 33, 'Comfirmed'),
(46, 36, 'Pendding');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Group`
--
ALTER TABLE `Group`
  ADD CONSTRAINT `Group_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `IN_GROUP`
--
ALTER TABLE `IN_GROUP`
  ADD CONSTRAINT `IN_GROUP_ibfk_3` FOREIGN KEY (`mid`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `IN_GROUP_ibfk_4` FOREIGN KEY (`gid`) REFERENCES `Group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LIKE_POST`
--
ALTER TABLE `LIKE_POST`
  ADD CONSTRAINT `LIKE_POST_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `Notifications_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `Post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Notifications_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PetStatus`
--
ALTER TABLE `PetStatus`
  ADD CONSTRAINT `PetStatus_ibfk_1` FOREIGN KEY (`PetID`) REFERENCES `PetInfo` (`PetID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `Post_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `READ_POST`
--
ALTER TABLE `READ_POST`
  ADD CONSTRAINT `READ_POST_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `READ_POST_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `Post` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Relationship`
--
ALTER TABLE `Relationship`
  ADD CONSTRAINT `Relationship_ibfk_3` FOREIGN KEY (`mid1`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Relationship_ibfk_4` FOREIGN KEY (`mid2`) REFERENCES `AccountInfo` (`id`) ON DELETE CASCADE;
