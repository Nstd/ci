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
			$result = $this->userdb->getAllUserInfo();
			$str='';
			foreach ($result as $key => $val) 
			{
				switch ($val['type'])
						{
							case Bs::USER_ADMIN   : $val['type'] = "管理员"; break;
							case Bs::USER_STUDENT : $val['type'] = "学生"; break;
							case BS::USER_TEACHER : $val['type'] = "老师"; break;
						}
				$str.='<tr>
						<td>'.$val['rownum'].'</td>
						<td>'.$val['username'].'</td>
						<td>'.$val['name'].'</td>
						<td>'.$val['type'].'</td>
						<td>'.($val['canlogin']?"可以登陆":"不可以登陆").'</td>
						<td><button type="button" class="btn btn-default" onclick="get_userinfo('."'".$val['rownum']."'".')">修改</button></td>
					</tr>';
			}
			echo $str;
		}
	}
?>