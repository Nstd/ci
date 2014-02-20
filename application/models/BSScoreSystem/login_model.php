<?php

class Login_model extends CI_Model
{

	const SUCCESS          = 0;
	const USER_NOT_EXIST   = 1;
	const PASSWORD_NOT_FIT = 2;

	/** 用户信息 **/
	public $user_info      = NULL;

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 验证用户密码
	 * @param  string $username [用户名]
	 * @param  string $password [密码]
	 * @return [int]            [验证结果]
	 */
	function verify_user($username="", $password="")
	{
		$this->user_info = NULL;
		//$this->load->database();
		$query = $this->db->query("select * from t_user_info where username='$username'");

		if($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if($row['password'] == $password)
			{
				$this->user_info = $row;
				return Login_model::SUCCESS;
			}
			else
			{
				return Login_model::PASSWORD_NOT_FIT;
			}
		}
		else
		{
			return Login_model::USER_NOT_EXIST;
		}
	}

	function getUserInfo($username)
	{
		//return $this->user_info;
		$query = $this->db->query("select * from t_user_info us left join t_teacher_info tc on us.username=tc.staff_id left join t_student_info st on us.username=st.stu_id where username='$username'");
		if($query->num_rows() == 1)
		{
			$result=$query->result('array');
			return $result[0];
		}
		else
		{
			return NULL;
		}
	}
}

?>