# Host: localhost  (Version: 5.6.14)
# Date: 2014-02-24 00:41:39
# Generator: MySQL-Front 5.3  (Build 4.89)

/*!40101 SET NAMES utf8 */;

#
# Data for table "t_department_info"
#

INSERT INTO `t_department_info` (`department_id`,`department_name`,`major_id`) VALUES (1,'系1',1);

#
# Data for table "t_major_info"
#

INSERT INTO `t_major_info` (`major_id`,`major_name`) VALUES (1,'专业1');

#
# Data for table "t_score_item_info"
#

INSERT INTO `t_score_item_info` (`item_id`,`parent_item_id`,`item_content`,`major_id`,`item_level`,`ratio`) VALUES (1,0,'一级指标1',1,1,5.00),(2,1,'二级指标1.1',1,2,5.00),(3,1,'二级指标1.2',1,2,3.00),(4,0,'一级指标2',1,1,2.00),(5,4,'二级指标2.1',1,2,3.00),(6,6,'一级指标3',1,1,10.00);

#
# Data for table "t_score_value_info"
#

INSERT INTO `t_score_value_info` (`id`,`stu_id`,`staff_id`,`item_id`,`value`) VALUES (1,'1000','2000',1,0),(2,'1000','2000',2,4),(3,'1000','2000',3,3),(4,'1000','2000',4,0),(5,'1000','2000',5,3),(6,'1000','2000',6,2);

#
# Data for table "t_student_info"
#

INSERT INTO `t_student_info` (`stu_id`,`major_id`,`department_id`,`subject`,`score`,`teacher_id`,`respondent_teacher_id`) VALUES ('1000',1,1,'这是毕设课题',NULL,'2000','2002'),('1001',1,1,'这是毕设课题2这个课题十分的长，长的有点受不了了',NULL,'2002','2000');

#
# Data for table "t_teacher_info"
#

INSERT INTO `t_teacher_info` (`staff_id`,`major_id`,`is_major_head`) VALUES ('2000',1,1),('2001',1,0);

#
# Data for table "t_user_info"
#

INSERT INTO `t_user_info` (`username`,`password`,`name`,`type`,`canlogin`) VALUES ('1000','1000','学生1',1,1),('1001','1001','学生2',1,1),('2000','2000','老师1',2,1),('20001','2001','老师2',2,1),('admin','admin','admin',0,1);
