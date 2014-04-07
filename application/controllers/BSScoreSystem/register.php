<?php

	class Register extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			$this->load->view($this->bs->getSiteUrl("register"), $this->bs->data);
		}

	
		public function register_valid()
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'username', 'trim|required|max_length[20]|alpha_dash|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|max_length[20]|alpha_dash|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
				echo $this->getJsonString(0, "注册信息有误!");
			}
			else
			{			
				$username = $this->input->post("username");
				$password = $this->input->post("password");		
				$this->load->model($this->bs->getSiteUrl('login_model'), 'logindb');	
				$flag = $this->logindb->register($username, $password);
				echo $flag;	
			}
		}

	}
?>