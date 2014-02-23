<?php

class Teacher_model extends MY_Model
{

	const TEACHER_SCHEMA = 't_teacher_info';
	const STUDENT_SCHEMA = 't_student_info';
	const USER_SCHEMA    = 't_user_info';

	function __construct()
	{
		parent::__construct();
	}

	function getTeachedStudentsInfo($teacher_id)
	{
		$query = $this->db->query(
			"select * " .
			"from t_student_info t_st inner join t_user_info t_usr on t_st.stu_id=t_usr.username " .
			"where teacher_id='" . $teacher_id . "' or respondent_teacher_id='" . $teacher_id . "'"
			);

		if($query->num_rows() > 0)
		{
			return $query->result('array');
		}
		else
		{
			return array();
		}
	}

	function getEmptyScoreTable($teacher_id)
	{
		$query = $this->db->query(
			"select * " .
			"from t_teacher_info t_ti inner join t_score_item_info t_si on t_ti.major_id=t_si.major_id " .
			"where t_ti.staff_id='" . $teacher_id . "'"
			);

		if($query->num_rows() > 0)
		{
			return $query->result('array');
		}
		else
		{
			return array();
		}
	}

	function getScoreTableAndValueByStudent($teacher_id, $student_id)
	{
		$query = $this->db->query(
			"select * " .
			"from t_teacher_info t_ti inner join t_score_item_info t_si on t_ti.major_id=t_si.major_id " .
				" left join t_score_value_info t_sv on t_si.item_id=t_sv.item_id and t_sv.staff_id=t_ti.staff_id " .
			"where t_ti.staff_id='" . $teacher_id . "' and t_sv.stu_id='" . $student_id . "'"
			);

		if($query->num_rows() > 0)
		{
			return $query->result('array');
		}
		else
		{
			return array();
		}
	}


	function isScored($teacher_id, $student_id)
	{
		$query = $this->db->query(
			"select * " . 
			"from t_score_value_info " . 
			"where staff_id='" . $teacher_id . "' and stu_id='" . $student_id . "' limit 1"
			);
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function getStudentInfoByStudentId($stu_id)
	{
		$query = $this->db->query(
			"select * " . 
			"from t_student_info t_st inner join t_user_info t_us on t_st.stu_id=t_us.username " . 
			"where stu_id='" . $stu_id . "'"
			);

		if($query->num_rows() > 0)
		{
			return $query->result('array')[0];
		}
		else
		{
			return array();
		}
	}
}