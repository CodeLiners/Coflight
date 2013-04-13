/*
Navicat MySQL Data Transfer

Source Server         : Server
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : coflight

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2013-04-13 23:37:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `edit_time` bigint(20) NOT NULL,
  `edit_by` varchar(255) NOT NULL DEFAULT 'System',
  `access_count` bigint(20) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'start', '0', 'System', '0', 'LALALALALALAL', 'LOL');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `permissions` enum('user','writer','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
