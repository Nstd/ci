<?php

class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	protected $tablename = 't_user_info';

	function getAllUserInfo($start=0,$pagesize=8)
	{
		$sql="select @rownum:=@rownum+1 AS rownum,t_user_info.* from (SELECT @rownum:=0) r,t_user_info order by type limit ".$start.",".$pagesize;
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
		$query = $this->db->query('SELECT * FROM '.$this->tablename);
		return $query->num_rows();
	}

	function load_info($username)
	{
		$query = $this->db->query("select username,name,type,canlogin from t_user_info where username = '".$username."'");
		if($query->num_rows() >= 1)
		{
			$result = $query->row_array();
			return $result;
		}
		else
		{
			return array();
		}
	}

	function update_userinfo($data,$username)
	{
		//$this->db->where('username',$username);
		return $this->db->update('t_user_info',$data,array('username' => $username)); 
	}
}

?>