/*
Navicat MySQL Data Transfer
Target Server Type    : MYSQL
Target Server Version : 50552
File Encoding         : 65001

Date: 2016-12-06 13:06:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ln_words`
-- ----------------------------
DROP TABLE IF EXISTS `ln_words`;
CREATE TABLE `ln_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `word` varchar(50) NOT NULL COMMENT '单词',
  `desc` varchar(200) NOT NULL COMMENT '单词释义',
  `query_count` bigint(20) NOT NULL COMMENT '查询次数统计',
  `created` int(11) NOT NULL COMMENT '单词添加时间',
  PRIMARY KEY (`id`),
  KEY `word` (`word`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--