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

		function s_index($msg)
		{
			$this->bs->data["s_msg"] = $msg;
			$this->bs->data['aheader'] = $this->load->view($this->bs->getSiteUrl("head-student"), $this->bs->data, true);
			$this->load->model($this->bs->getSiteUrl('student_model'),'student');	
			$this->bs->data['student']=$this->student->getScoreInfo( $this->session->userdata("username"));
			$this->load->view($this->bs->getSiteUrl("shome"), $this->bs->data);
		}

		function a_assignment()
		{
			$this->bs->data['aheader'] = $this->load->view($this->bs->getSiteUrl("head-admin"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("assignment"), $this->bs->data);
		}

		function a_major()
		{
			$this->bs->data['aheader'] = $this->load->view($this->bs->getSiteUrl("head-admin"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("major"), $this->bs->data);
		}

		function s_upload_project()
		{
			$config['upload_path'] = getcwd() . "/upload_files/";
			$config['allowed_types'] = "pdf|doc|docx|rar|zip|7z";
			$config['max_size'] = "83886080";
			$config['file_name'] = $this->session->userdata("username") . "_" . time();
			$this->load->library("upload", $config);

			if(!$this->upload->do_upload("project"))
			{
				//echo $this->upload->display_errors();
				$this->s_index("0");
			}
			else
			{
				$file_data = $this->upload->data();
				//print_r($file_data);
				$this->load->model($this->bs->getSiteUrl('student_model'),'student');
				$this->student->set_project_file($this->session->userdata("username"), $file_data["full_path"]);
				$this->s_index("1");
			}
			
		}
	}

?>