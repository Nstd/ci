<?php

	class User extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function a_user_list()
		{
			$this->load->model($this->bs->getSiteUrl('user_model'), 'userdb');
			$result = $this->userdb->getAllUserInfo();var_dump($result);exit;
			$this->bs->data['aheader'] = $this->load->view($this->bs->getSiteUrl("head-admin"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("ahome"), $this->bs->data);
		}
	}
?>