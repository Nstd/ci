# Host: localhost  (Version: 5.6.14)
# Date: 2014-02-18 22:41:56
# Generator: MySQL-Front 5.3  (Build 4.89)

/*!40101 SET NAMES utf8 */;

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
# Data for table "t_student_info"
#

