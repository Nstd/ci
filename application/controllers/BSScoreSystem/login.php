<?php

	class Login extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$this->load->view($this->bs->getSiteUrl("login"), $this->bs->data);
		}

		public function showLogin()
		{
			//这是注释
			$this->load->view($this->bs->getSiteUrl("fakeindex"), $this->bs->data);
		}

		public function login_valid()
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'username', 'trim|required|max_length[20]|alpha_dash|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|max_length[20]|alpha_dash|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
				echo $this->getJsonString(0, "非法输入!");
			}
			else
			{
				$this->load->model($this->bs->getSiteUrl('login_model'), 'logindb');

				$username = $this->input->post("username");
				$password = $this->input->post("password");
				$verify_state = $this->logindb->verify_user($username, $password);

				switch($verify_state)
				{
					case Login_model::SUCCESS:
						$user_info = $this->logindb->getUserInfo($username);
						$this->session->set_userdata("username", 		$user_info['username']);
						$this->session->set_userdata("usertype", 		$user_info['type']);
						$this->session->set_userdata("name",     		$user_info['name']);
						$this->session->set_userdata("major_id",    	$user_info['major_id']);
						$this->session->set_userdata("is_major_head",	$user_info['attr']);
						$site_index = "";
						switch ($user_info['type'])
						{
							case Bs::USER_ADMIN   : $site_index = "a_index"; break;
							case Bs::USER_STUDENT : $site_index = "s_index/-1"; break;
							case BS::USER_TEACHER : $site_index = "t_index"; break;
						}
						echo $this->bs->getJsonString(1, "success", $this->bs->site_url . "/" . $this->bs->site_name . "/home/" . $site_index);
						break;
					case Login_model::USER_NOT_EXIST:
						echo $this->bs->getJsonString(0, "用户不存在!");
						break;
					case Login_model::PASSWORD_NOT_FIT:
						echo $this->bs->getJsonString(0, "密码错误!");
						break;
					case Login_model::CAN_LOGIN:
						echo $this->bs->getJsonString(0, "您的账号被锁定，请联系管理员!");
						break;
					default:
						echo $this->bs->getJsonString(0, "未知错误!");
				}
			}
		}

		public function logout()
		{
			$this->session->unset_userdata("username");
			$this->session->unset_userdata("type");
			$this->session->unset_userdata("name");
			$this->session->unset_userdata("is_major_head");
			$this->session->unset_userdata("major_id");
			$this->load->view($this->bs->getSiteUrl("login"), $this->bs->data);
		}

		public function change_password_index()
		{	
			$this->bs->data['HTTP_REFERER'] = $_SERVER['HTTP_REFERER'];
			$this->load->view($this->bs->getSiteUrl("password"), $this->bs->data);
		}

		public function new_password()
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('old_password', 'old_password', 'trim|required|max_length[20]|alpha_dash|xss_clean');
			$this->form_validation->set_rules('new_password', 'new_password', 'trim|required|max_length[20]|alpha_dash|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
				echo 0;
			}
			else
			{
				$this->load->model($this->bs->getSiteUrl('login_model'), 'logindb');

				$username=$this->session->userdata("username");
				$old_password = $this->input->post("old_password");
				$new_password = $this->input->post("new_password");
				$result=$this->logindb->change_password($username, $old_password,$new_password);
				echo $result;
			}
		}
	}
?>