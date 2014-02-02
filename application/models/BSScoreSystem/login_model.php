<?php

class Login_model extends CI_Model
{

	const SUCCESS          = 0;
	const USER_NOT_EXIST   = 1;
	const PASSWORD_NOT_FIT = 2;

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
		$this->load->database();
		$query = $this->db->query("select user_name, user_pwd, user_type from t_user_info where user_name='$username'");

		if($query->num_rows() == 1)
		{
			$row = $query->row_array();
			if($row['user_pwd'] == $password)
			{
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
}

?>