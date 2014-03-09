<?php

class  Assignment_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	protected $tablename = 't_teacher_info';

	function getDepInfo()
	{
		$sql="select distinct(department_id),department_name from t_department_info";
		$query = $this->db->query($sql);
		if($query->num_rows() >= 1)
		{
			$result=$query->result('array');
			return $result;
		}
		else
		{
			return array();
		}
	}

	function getMajorInfo($Did)
	{
		$sql="select m.* from t_major_info m left join t_department_info d on m.major_id = d.major_id where d.department_id = ".$Did;
		$query = $this->db->query($sql);
		if($query->num_rows() >= 1)
		{
			$result=$query->result('array');
			return $result;
		}
		else
		{
			return array();
		}
	}

	function getInstructorInfo($Mid)
	{
		$sql="SELECT t.staff_id , u.name FROM `t_teacher_info` t left join `t_user_info` u on  t.staff_id = u.username WHERE major_id = ".$Mid;
		$query = $this->db->query($sql);
		if($query->num_rows() >= 1)
		{
			$result=$query->result('array');
			return $result;
		}
		else
		{
			return array();
		}
	}

	function updateInstructorInfo($mid,$staff_id)
	{
		$sql='update t_teacher_info set is_major_head = 1 where staff_id = '.$staff_id.' and major_id ='.$mid;
		$query = $this->db->query($sql);

		if($query)
		{
			return "1";
		}
		else
		{
			return "0";
		}
	}

	function getResultInfo($start,$pagesize)
	{
		$sql="SELECT @rownum := @rownum +1 AS rownum, d.department_name, m.major_name, t.staff_id,u.name 
		FROM (SELECT @rownum :=0)r,  
		`t_teacher_info` t LEFT JOIN  `t_user_info` u ON t.staff_id = u.username
		LEFT JOIN  `t_major_info` m ON t.major_id = m.major_id
		LEFT JOIN  `t_department_info` d ON m.major_id = d.major_id
		WHERE t.is_major_head =1 order by t.major_id limit ".$start.",".$pagesize;
		$query = $this->db->query($sql);
		if($query->num_rows() >= 1)
		{
			$result=$query->result('array');
			return $result;
		}
		else
		{
			return array();
		}
	}

	function countNum()
	{
		$query = $this->db->query('SELECT * FROM '.$this->tablename.' where is_major_head =1');
		return $query->num_rows();
	}

	function update_info($staff_id)
	{
		$data['is_major_head']=0;
		return $this->db->update('t_teacher_info',$data,array('staff_id' => $staff_id)); 
	}
}
?>