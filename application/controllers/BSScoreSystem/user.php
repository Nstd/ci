<?php

	class User extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function a_user_list()
		{
			$page = $this->input->post('page')?$this->input->post('page'):1;
			$pagesize=5;
			$start=($page-1)*$pagesize;

			$this->load->model($this->bs->getSiteUrl('user_model'), 'userdb');
			$total_page = ceil($this->userdb->countNum() / $pagesize);
			$paging='<li><a href="#">&laquo;</a></li>';
			for ($i=1; $i <= $total_page; $i++)
			{ 
				$paging.='<li '.($page==$i? "class=\"active\"": "").'><a href="javascript:user_management('.$i.');">'.$i.'</a></li>';
			}
			$paging.='<li><a href="#">&raquo;</a></li>';

			$result = $this->userdb->getAllUserInfo($start,$pagesize);
			$info='';
			foreach ($result as $key => $val) 
			{
				switch ($val['type'])
						{
							case Bs::USER_ADMIN   : $val['type'] = "管理员"; break;
							case Bs::USER_STUDENT : $val['type'] = "学生"; break;
							case BS::USER_TEACHER : $val['type'] = "老师"; break;
						}
				$info.='<tr>
						<td>'.$val['rownum'].'</td>
						<td>'.$val['username'].'</td>
						<td>'.$val['name'].'</td>
						<td>'.$val['type'].'</td>
						<td>'.($val['canlogin']?"可以登陆":"不可以登陆").'</td>
						<td><button type="button" class="btn btn-default" onclick="get_userinfo('."'".$val['username']."'".')">修改</button></td>
					</tr>';
			}
			$data=array('info'=>$info,'paging'=>$paging);
			echo json_encode($data);
		}

		function a_load_info()
		{  
			$username = $this->input->post('username');
			$this->load->model($this->bs->getSiteUrl('user_model'), 'userdb');
			$result = $this->userdb->load_info($username);
			$data=json_encode($result);
			echo $data;
		}

		function a_update_user()
		{
			$username= $this->input->post('username');
			$data['type'] = $this->input->post('usertype');
			$data['canlogin'] = $this->input->post('canlogin');
			$this->load->model($this->bs->getSiteUrl('user_model'), 'userdb');
			$result = $this->userdb->update_userinfo($data,$username);
			echo json_encode($result);
		}
	}
?>