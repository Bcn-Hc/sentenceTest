/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : sentenceinfo

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2019-09-05 03:46:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sentenceinfo
-- ----------------------------
DROP TABLE IF EXISTS `sentenceinfo`;
CREATE TABLE `sentenceinfo` (
  `sId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `memo` varchar(255) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `translation` varchar(255) DEFAULT NULL,
  `tips` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`sId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
