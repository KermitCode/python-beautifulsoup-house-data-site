/*
Navicat MySQL Data Transfer

Source Server         : 阿里Mysql
Source Server Version : 50537
Source Host           : 114.215.80.214:3306
Source Database       : 04007CN

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2020-09-09 19:03:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qd_area
-- ----------------------------
DROP TABLE IF EXISTS `qd_area`;
CREATE TABLE `qd_area` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `area` varchar(255) NOT NULL DEFAULT '' COMMENT '青岛市区名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='青岛市区表';

-- ----------------------------
-- Records of qd_area
-- ----------------------------
INSERT INTO `qd_area` VALUES ('1', '市南区');
INSERT INTO `qd_area` VALUES ('2', '市北区（原）');
INSERT INTO `qd_area` VALUES ('3', '四方区（原）');
INSERT INTO `qd_area` VALUES ('4', '李沧区');
INSERT INTO `qd_area` VALUES ('5', '崂山区');
INSERT INTO `qd_area` VALUES ('6', '黄岛区（原）');
INSERT INTO `qd_area` VALUES ('7', '胶南市（原）');
INSERT INTO `qd_area` VALUES ('8', '城阳区');
INSERT INTO `qd_area` VALUES ('9', '高新区');
INSERT INTO `qd_area` VALUES ('10', '即墨市');
INSERT INTO `qd_area` VALUES ('11', '胶州市');
INSERT INTO `qd_area` VALUES ('12', '莱西市');
INSERT INTO `qd_area` VALUES ('13', '平度市');
INSERT INTO `qd_area` VALUES ('14', '前湾保税港区');
INSERT INTO `qd_area` VALUES ('15', '全市');
