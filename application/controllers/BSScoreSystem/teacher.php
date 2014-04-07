<?php

	class Teacher extends My_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model($this->bs->getSiteUrl('teacher_model'), 'tdb');
		}

		/**
		 * 初始化评分表
		 * @param  [type] $stu_id [学号]
		 * @return [type]         
		 */
		function t_init_score_table($stu_id)
		{
			$stu_file = $this->_get_stu_project($stu_id);
			$this->bs->data['stu_file_exist'] = !empty($stu_file['project']);
			$teacher_id = $this->session->userdata("username");
			$this->bs->data['student_id'] = $stu_id;
			$this->bs->data['students'] = $this->tdb->getTeachedStudentsInfo($teacher_id);
			$this->bs->data['score_table'] = $this->tdb->getEmptyScoreTable($stu_id);
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
			$stu_file = $this->_get_stu_project($stu_id);
			$this->bs->data['stu_file_exist'] = !empty($stu_file['project']);
			$teacher_id = $this->session->userdata("username");
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


		/**
		 * 教师评分
		 * @param  [type] $stu_id [学号]
		 * @return [type]         
		 */
		function t_score($stu_id)
		{
			//print_r($this->input->post("score"));
			$score = $this->input->post("score");
			$teacher_id = $this->session->userdata("username");
			$this->tdb->scoreStudent($teacher_id, $stu_id, $score);

			Teacher::t_init_score_table($stu_id);
		}

		/**
		 * 生成评分表
		 * @return [type] 
		 */
		function t_gen_score_table()
		{
			$teacher_id = $this->session->userdata("username");
			$this->bs->data['students'] = $this->tdb->getTeachedStudentsInfo($teacher_id);
			$this->bs->data['theader'] = $this->load->view($this->bs->getSiteUrl("head-teacher"), $this->bs->data, true);
			$this->bs->data['is_item_exist'] = $this->_is_score_table_exist();
			$this->bs->data['scoretable'] = $this->load->view($this->bs->getToolsUrl("scoretable_genter"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("tgenscoretable"), $this->bs->data);
		}

		/**
		 * 检测评分表是否存在
		 * @return boolean [description]
		 */
		function _is_score_table_exist()
		{
			$major_id = $this->session->userdata("major_id");
			$is_item_exist = $this->tdb->isScoreTableItemExist($major_id);
			return $is_item_exist;
		}

		function t_add_score_item()
		{
			try {

				$score_item_data = $this->input->post("data");

				$teacher_id = $this->session->userdata("username");
				$major_id = $this->session->userdata("major_id");

				if($this->_is_score_table_exist())
				{
					die("exist");
				}

				$first_level_data  = array();
				$second_level_data = array();

				foreach($score_item_data as $key => $value)
				{
					array_push($first_level_data, $score_item_data[$key][0]);
				}

				//插入一级指标并获取其ID
				$first_level_ids = $this->tdb->insertFirstLevelItemAndGetResult($major_id, $first_level_data);

				//预处理二级指标
				foreach($score_item_data as $key1 => $level_1)
				{
					$content = $level_1[0][0];
					$ratio   = $level_1[0][1];
					$pid     = -1;
					foreach($first_level_ids as $id => $row)
					{
						if($content == $row['item_content'] && $ratio == $row['ratio'])
						{
							$pid = $row['item_id'];
							break;
						}
					}

					foreach($level_1 as $key2 => $level_2)
					{
						if($key2 == 0) continue;
						$tmp_level = array(
							"parent_item_id" => $pid,
							"item_content" => $level_2[0],
							"major_id" => $major_id,
							"item_level" => 2,
							"ratio" => $level_2[1]
							);
						array_push($second_level_data, $tmp_level);
					}
				}

				//插入二级指标
				$query = $this->tdb->insertSecondLevelItem($second_level_data);

				echo "success";
			}
			catch (Exception $e) 
			{
				echo "error";
			}
		}

		/**
		 * 下载论文
		 * @param  [type] $stu_id [学号]
		 * @return [type]         [description]
		 */
		function t_download_project($stu_id)
		{
			//echo $stu_id;
			$this->load->helper("download");
			//$this->load->model($this->bs->getSiteUrl('student_model'), 'sdb');
			//$data = $this->sdb->get_project_file($stu_id);
			$data = $this->_get_stu_project($stu_id);
			if(!empty($data))
			{
				print_r($data);
				$file_path = file_get_contents($data['project']);
				$file_type = end(explode(".", $data['project']));
				$file_name = $data['subject'] . "." . $file_type;
				force_download($file_name, $file_path);
			}
			else
			{
				echo "file_not_exist";
			}
		}

		function _get_stu_project($stu_id)
		{
			$this->load->model($this->bs->getSiteUrl('student_model'), 'sdb');
			$data = $this->sdb->get_project_file($stu_id);
			return $data;
		}

	}

?>