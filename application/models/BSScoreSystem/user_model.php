<?php

class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getAllUserInfo()
	{
		//return $this->user_info;
		$query = $this->db->query("select @rownum:=@rownum+1 AS rownum,t_user_info.* from (SELECT @rownum:=0) r,t_user_info");
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
}

?>