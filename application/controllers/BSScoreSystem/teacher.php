<?php

	class Teacher extends My_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		/**
		 * 初始化评分表
		 * @param  [type] $stu_id [学号]
		 * @return [type]         
		 */
		function t_init_score_table($stu_id)
		{
			$teacher_id = $this->session->userdata("username");
			$this->load->model($this->bs->getSiteUrl('teacher_model'), 'tdb');
			$this->bs->data['student_id'] = $stu_id;
			$this->bs->data['students'] = $this->tdb->getTeachedStudentsInfo($teacher_id);
			$this->bs->data['score_table'] = $this->tdb->getEmptyScoreTable($teacher_id);
			$this->bs->data['can_score'] = TRUE;
			$this->bs->data['is_scored'] = $this->tdb->isScored($teacher_id, $stu_id);
			$this->bs->data['student_data'] = $this->tdb->getStudentInfoByStudentId($stu_id);
			$this->bs->data['student_info'] = $this->load->view($this->bs->getSiteUrl("student_info"), $this->bs->data, true);
			$this->bs->data['theader'] = $this->load->view($this->bs->getSiteUrl("head-teacher"), $this->bs->data, true);
			$this->bs->data['scoretable_data'] = $this->load->view($this->bs->getToolsUrl("scoretable_data"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("tscoretable"), $this->bs->data);
		}

		/**
		 * 获取打分结果
		 * @param  [type] $stu_id [学号]
		 * @return [type]         
		 */
		function t_get_score_table_and_value($stu_id)
		{
			$teacher_id = $this->session->userdata("username");
			$this->load->model($this->bs->getSiteUrl('teacher_model'), 'tdb');
			$this->bs->data['students'] = $this->tdb->getTeachedStudentsInfo($teacher_id);
			$this->bs->data['score_table'] = $this->tdb->getScoreTableAndValueByStudent($teacher_id, $stu_id);
			$this->bs->data['can_score'] = FALSE;
			$this->bs->data['is_scored'] = $this->tdb->isScored($teacher_id, $stu_id);
			$this->bs->data['student_data'] = $this->tdb->getStudentInfoByStudentId($stu_id);
			$this->bs->data['student_info'] = $this->load->view($this->bs->getSiteUrl("student_info"), $this->bs->data, true);
			$this->bs->data['theader'] = $this->load->view($this->bs->getSiteUrl("head-teacher"), $this->bs->data, true);
			$this->bs->data['scoretable_data'] = $this->load->view($this->bs->getToolsUrl("scoretable_data"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("tscoretable"), $this->bs->data);
		}


		function t_score($stu_id)
		{
			//print_r($this->input->post("score"));
			$score = $this->input->post("score");
			$teacher_id = $this->session->userdata("username");
			$this->load->model($this->bs->getSiteUrl('teacher_model'), 'tdb');
			$this->tdb->scoreStudent($teacher_id, $stu_id, $score);
		}
	}

?>