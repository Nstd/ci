<?php

	class User extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function a_user_list()
		{
			return("12234");
			$this->load->model($this->bs->getSiteUrl('user_model'), 'userdb');
			$result = $this->userdb->getAllUserInfo();
			var_dump($result);exit;
		}
	}
?>