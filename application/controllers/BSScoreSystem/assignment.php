<?php

	class Assignment extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		protected $tablename = 't_teacher_info';

		function a_get_department()
		{
			$this->load->model($this->bs->getSiteUrl('assignment_model'),'assignment');
			$result = $this->assignment->getDepInfo();

			$dep ='<option value="0">请选择系名</option>';
			foreach ($result as $key => $val) 
			{
				$dep.='<option value="'.$val['department_id'].'">'.$val['department_name'].'</option>';
			}

			echo json_encode($dep);
		}

		function a_get_major()
		{
			$Did = $this->input->post("faculty");

			$this->load->model($this->bs->getSiteUrl('assignment_model'),'assignment');
			$result = $this->assignment->getMajorInfo($Did);

			$major ='<option value="0">请选择专业名</option>';
			foreach ($result as $key => $val) 
			{
				$major.='<option value="'.$val['major_id'].'">'.$val['major_name'].'</option>';
			}

			echo json_encode($major);
		}


		function a_get_instructor()
		{
			$Mid = $this->input->post("major");

			$this->load->model($this->bs->getSiteUrl('assignment_model'),'assignment');
			$result = $this->assignment->getInstructorInfo($Mid);

			$instructor ='';
			foreach ($result as $key => $val) 
			{
				$instructor.='<option value="'.$val['staff_id'].'">'.$val['name'].'</option>';
			}

			echo json_encode($instructor);
		}

		function a_set_instructor()
		{
			$Mid = $this->input->post("major");
			$staff_id = $this->input->post("staff_id");

			$this->load->model($this->bs->getSiteUrl('assignment_model'),'assignment');
			$result = $this->assignment->updateInstructorInfo($Mid,$staff_id);
			
			echo json_encode($result);
		}

		function a_result_list()
		{
			$page = $this->input->post('page')?$this->input->post('page'):1;
			$pagesize=5;
			$start=($page-1)*$pagesize;

			$this->load->model($this->bs->getSiteUrl('assignment_model'),'assignment');
			$total_page = ceil($this->assignment->countNum() / $pagesize);

			$paging='<li><a href="#">&laquo;</a></li>';
			for ($i=1; $i <= $total_page; $i++)
			{ 
				$paging.='<li '.($page==$i? "class=\"active\"": "").'><a href="javascript:get_result('.$i.');">'.$i.'</a></li>';
			}
			$paging.='<li><a href="#">&raquo;</a></li>';
			//echo $paging;exit;

			$result = $this->assignment->getResultInfo($start,$pagesize);

			$info='';
			foreach ($result as $key => $val) 
			{
				$info.='<tr>
						<td>'.$val['rownum'].'</td>
						<td>'.$val['department_name'].'</td>
						<td>'.$val['major_name'].'</td>
						<td>'.$val['name'].'</td>
						<td><button type="button" class="btn btn-default" onclick="del_info('."'".$val['staff_id']."'".')">删除</button></td>
					</tr>';
			}

			$data=array('info'=>$info,'paging'=>$paging);
			echo json_encode($data);
		}

		function a_del_info()
		{
			$staff_id = $this->input->post('staff_id');
			$this->load->model($this->bs->getSiteUrl('assignment_model'),'assignment');
			$result = $this->assignment->update_info($staff_id);
			$data=json_encode($result);
			echo $data;
		}
	}
?>