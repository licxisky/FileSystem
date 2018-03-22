/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : filesystem

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-22 22:02:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for extension
-- ----------------------------
DROP TABLE IF EXISTS `extension`;
CREATE TABLE `extension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension_string` varchar(50) NOT NULL,
  `extension_desc` varchar(255) DEFAULT NULL,
  `extension_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of extension
-- ----------------------------
INSERT INTO `extension` VALUES ('1', 'pdf', 'pdf', '17');
INSERT INTO `extension` VALUES ('2', 'doc', 'doc', '11');
INSERT INTO `extension` VALUES ('3', 'zip', 'zip', '3');
INSERT INTO `extension` VALUES ('4', 'docx', 'docx', '11');
INSERT INTO `extension` VALUES ('5', 'pptx', 'pptx', '13');
INSERT INTO `extension` VALUES ('6', 'ppt', 'ppt', '13');
INSERT INTO `extension` VALUES ('7', 'jpg', 'jpg', '4');
INSERT INTO `extension` VALUES ('8', 'cpp', 'cpp', '14');
INSERT INTO `extension` VALUES ('9', 'xls', 'xls', '12');
INSERT INTO `extension` VALUES ('10', 'xlsx', 'xlsx', '12');
INSERT INTO `extension` VALUES ('11', 'sql', 'sql', '18');
INSERT INTO `extension` VALUES ('12', 'mp4', 'mp4', '6');
INSERT INTO `extension` VALUES ('13', 'png', 'png', '4');
INSERT INTO `extension` VALUES ('14', 'txt', 'txt', '2');
INSERT INTO `extension` VALUES ('15', 'mp3', 'mp3', '5');
INSERT INTO `extension` VALUES ('16', 'crt', 'crt', '1');
INSERT INTO `extension` VALUES ('17', 'key', 'key', '1');
INSERT INTO `extension` VALUES ('18', 'mdl', 'mdl', '14');
INSERT INTO `extension` VALUES ('19', 'md~', 'md~', '14');
INSERT INTO `extension` VALUES ('20', 'rar', 'rar', '3');
INSERT INTO `extension` VALUES ('21', 'mobi', 'mobi', '1');

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_hash` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_extension_id` int(11) NOT NULL,
  `file_remark` varchar(255) DEFAULT NULL,
  `file_share_hash` varchar(255) DEFAULT NULL,
  `file_upload_time` datetime DEFAULT NULL,
  `file_update_time` datetime DEFAULT NULL,
  `file_delete_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file
-- ----------------------------

-- ----------------------------
-- Table structure for type
-- ----------------------------
DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of type
-- ----------------------------
INSERT INTO `type` VALUES ('1', '未知文件');
INSERT INTO `type` VALUES ('2', '文本文件');
INSERT INTO `type` VALUES ('3', '压缩文件');
INSERT INTO `type` VALUES ('4', '图形文件');
INSERT INTO `type` VALUES ('5', '音频文件');
INSERT INTO `type` VALUES ('6', '视频文件');
INSERT INTO `type` VALUES ('7', '系统文件');
INSERT INTO `type` VALUES ('8', '安装包文件');
INSERT INTO `type` VALUES ('9', '网页文件');
INSERT INTO `type` VALUES ('10', '临时文件');
INSERT INTO `type` VALUES ('11', 'word文档');
INSERT INTO `type` VALUES ('12', 'excel文档');
INSERT INTO `type` VALUES ('13', 'ppt文档');
INSERT INTO `type` VALUES ('14', '语言文件');
INSERT INTO `type` VALUES ('15', '备份文件');
INSERT INTO `type` VALUES ('16', '批处理文件');
INSERT INTO `type` VALUES ('17', 'pdf文档');
INSERT INTO `type` VALUES ('18', '数据库文件');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'lichaoxi', '$2y$10$.fgMMDVpaUo7NeHItLDUr.G4OUH3a9/mJUx3mP5nQIaKw7gPrAQya', '2992368059@qq.com', '2017-06-15 08:11:02');
