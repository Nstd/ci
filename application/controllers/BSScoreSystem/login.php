<?php

	class Login extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			//这是一行注释
			$this->load->view($this->bs->getSiteUrl("login"), $this->bs->data);
		}

		public function showLogin()
		{
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
						$this->session->set_userdata("username", $username);
						echo $this->bs->getJsonString(1, "success", $this->bs->site_url . "/" . $this->bs->site_name . "/home");
						break;
					case Login_model::USER_NOT_EXIST:
						echo $this->bs->getJsonString(0, "用户不存在!");
						break;
					case Login_model::PASSWORD_NOT_FIT:
						echo $this->bs->getJsonString(0, "密码错误!");
						break;
					default:
						echo $this->bs->getJsonString(0, "未知错误!");
				}
			}
		}

		public function logout()
		{
			$this->session->unset_userdata("username");
			$this->load->view($this->bs->getSiteUrl("login"), $this->bs->data);
		}
	}
?>