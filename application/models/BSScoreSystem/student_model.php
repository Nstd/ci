<?php

class Student_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	protected $tablename = 't_user_info';

	function getScoreInfo($stu_id)
	{

		$sql="SELECT distinct(d.department_name),m.major_name,u.name as teacher_name,s.subject,s.score FROM `t_student_info` s 
		inner join `t_major_info` m on s.major_id = m.major_id
		inner join `t_department_info` d on d.department_id = s.department_id
		inner join `t_user_info` u on s.teacher_id = u.username where stu_id =".$stu_id;
		$query = $this->db->query($sql);
		if($query->num_rows() >= 1)
		{
			$row = $query->row_array();;
			return $row;
		}
		else
		{
			return array();
		}
	}
}
?>