# Host: localhost  (Version: 5.6.14)
# Date: 2014-02-24 00:29:38
# Generator: MySQL-Front 5.3  (Build 4.89)

/*!40101 SET NAMES utf8 */;

DROP DATABASE IF EXISTS `bs_score_db`;

CREATE DATABASE IF NOT EXISTS `bs_score_db`

#
# Structure for table "t_department_info"
#

DROP TABLE IF EXISTS `t_department_info`;
CREATE TABLE `t_department_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `department_id` int(11) NOT NULL COMMENT '系ID',
  `department_name` varchar(255) DEFAULT NULL COMMENT '系名',
  `major_id` int(11) DEFAULT NULL COMMENT '所属专业ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系信息';

#
# Structure for table "t_major_info"
#

DROP TABLE IF EXISTS `t_major_info`;
CREATE TABLE `t_major_info` (
  `major_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '专业ID',
  `major_name` varchar(255) DEFAULT NULL COMMENT '专业名称',
  PRIMARY KEY (`major_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='专业信息';

#
# Structure for table "t_score_item_info"
#

DROP TABLE IF EXISTS `t_score_item_info`;
CREATE TABLE `t_score_item_info` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评分项ID',
  `parent_item_id` int(11) DEFAULT '0',
  `item_content` varchar(255) DEFAULT NULL COMMENT '评分项内容',
  `major_id` int(11) DEFAULT '0' COMMENT '所属专业ID',
  `item_level` int(2) DEFAULT '0' COMMENT '评分项级别：1.一级，2.二级',
  `ratio` decimal(10,2) DEFAULT '0.00' COMMENT '评分项所占比例',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='评分项信息';

#
# Structure for table "t_score_value_info"
#

DROP TABLE IF EXISTS `t_score_value_info`;
CREATE TABLE `t_score_value_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `stu_id` varchar(20) DEFAULT NULL COMMENT '学号',
  `staff_id` varchar(20) DEFAULT NULL COMMENT '教师ID',
  `item_id` int(11) DEFAULT NULL COMMENT '评分项ID',
  `value` decimal(10,2) DEFAULT NULL COMMENT '分值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评分详情';

#
# Structure for table "t_student_info"
#

DROP TABLE IF EXISTS `t_student_info`;
CREATE TABLE `t_student_info` (
  `stu_id` varchar(20) NOT NULL DEFAULT '' COMMENT '学号',
  `major_id` int(11) DEFAULT '0' COMMENT '专业ID',
  `department_id` int(11) DEFAULT '0' COMMENT '系',
  `subject` varchar(255) DEFAULT NULL COMMENT '毕设题目',
  `score` varchar(20) DEFAULT NULL COMMENT '毕设成绩',
  `teacher_id` varchar(20) DEFAULT NULL COMMENT '指导老师ID',
  `respondent_teacher_id` varchar(20) DEFAULT NULL COMMENT '答辩组老师ID',
  PRIMARY KEY (`stu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生信息';

#
# Structure for table "t_teacher_info"
#

DROP TABLE IF EXISTS `t_teacher_info`;
CREATE TABLE `t_teacher_info` (
  `staff_id` varchar(20) NOT NULL DEFAULT '' COMMENT '教职工ID',
  `major_id` int(11) DEFAULT '0' COMMENT '所属专业ID',
  `is_major_head` int(2) DEFAULT '0' COMMENT '是否毕设指导组长：0.不是，1.是',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教师信息';

#
# Structure for table "t_user_info"
#

DROP TABLE IF EXISTS `t_user_info`;
CREATE TABLE `t_user_info` (
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '账号（学号、职工号、admin）',
  `password` varchar(20) DEFAULT NULL COMMENT '密码',
  `name` varchar(20) DEFAULT NULL,
  `type` int(2) DEFAULT NULL COMMENT '用户类型：0.管理员、1.学生、2.老师',
  `canlogin` int(2) NOT NULL DEFAULT '1' COMMENT '用户是否可登录：0.不能登录，1.可以登录',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息';
