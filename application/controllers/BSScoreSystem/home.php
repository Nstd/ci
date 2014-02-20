<?php

	class Home extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function t_index()
		{
			$this->load->model($this->bs->getSiteUrl('teacher_model'), 'tdb');
			$this->bs->data['students'] = $this->tdb->getTeachedStudentsInfo($this->session->userdata("username"));
			$this->bs->data['theader'] = $this->load->view($this->bs->getSiteUrl("head-teacher"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("thome"), $this->bs->data);
		}

		function a_index()
		{
			$this->bs->data['aheader'] = $this->load->view($this->bs->getSiteUrl("head-admin"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("ahome"), $this->bs->data);
		}
	}

?>