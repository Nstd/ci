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

	function getScoreTable($teacher_id)
	{
		$query = $this->db->query(
			"select * " .
			"from t_teacher_info t_tc inner join t_score_item_info t_si on t_tc.major_id=t_si.major_id " .
			"where staff_id='" . $teacher_id . "'"
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
}