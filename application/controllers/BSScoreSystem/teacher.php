<?php

	class Teacher extends My_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function t_score_table()
		{
			$this->load->model($this->bs->getSiteUrl('teacher_model'), 'tdb');
			$this->bs->data['students'] = $this->tdb->getTeachedStudentsInfo($this->session->userdata("username"));
			$this->bs->data['score_table'] = $this->tdb->getScoreTable($this->session->userdata("username"));
			$this->bs->data['theader'] = $this->load->view($this->bs->getSiteUrl("head-teacher"), $this->bs->data, true);
			$this->bs->data['scoretable_data'] = $this->load->view($this->bs->getToolsUrl("scoretable_data"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("tscoretable"), $this->bs->data);
		}
	}

?>