<?php

class Student_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	protected $tablename = 't_user_info';

	function getScoreInfo($stu_id)
	{

		$sql="SELECT distinct(d.department_name),m.major_name,u.name as teacher_name,s.subject,s.score FROM `t_student_info` s 
		inner join `t_major_info` m on s.major_id = m.major_id
		inner join `t_department_info` d on d.department_id = s.department_id
		inner join `t_user_info` u on s.teacher_id = u.username where stu_id =".$stu_id;
		$query = $this->db->query($sql);
		if($query->num_rows() >= 1)
		{
			$row = $query->row_array();

			//检测是否已评分完毕
			if(empty($row['score']))
			{
				$num = $this->_is_finished_score($stu_id);
				if($num !== FALSE)
				{
					//评分完毕，计算结果
					$score_result = $this->_socre_student($stu_id, $num);
					$is_ok = $this->_set_final_score($stu_id, $score_result);

					if($is_ok)
					{
						$row['score'] = $score_result;
					}
				}
			}

			return $row;
		}
		else
		{
			return array();
		}
	}

	function _set_final_score($stu_id, $value)
	{
		$query = $this->db->query(
			"update `t_student_info` set score='$value' where stu_id='$stu_id'"
			);

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * 检测学生是否已被评分，并返回评分老师的个数
	 * @param  [type]  $stu_id [description]
	 * @return boolean         [description]
	 */
	function _is_finished_score($stu_id)
	{
		$query = $this->db->query(
			"select count(1) as num from `t_score_value_info` where stu_id='$stu_id' group by stu_id, staff_id"
			);

		if($query->num_rows() >= 2)
		{
			$result = $query->result("array");
			$len = count($result[0]);
			foreach($result as $key => $value)
			{
				//为当前学生评分的老师，打分项个数应该是相同的
				if(count($result[$key]) != $len)
				{
					return FALSE;
				}
			}

			return $len;
		}
		else
		{
			return FALSE;
		}
	}

	//为学生进行模糊计算
	function _socre_student($stu_id, $num)
	{
		$query = $this->db->query(
			"select si.item_id , si.parent_item_id as pid, si.item_level, si.ratio, sv.value 
			from t_score_item_info si inner join t_score_value_info sv on si.item_id=sv.item_id 
			where stu_id='$stu_id' order by parent_item_id,item_id asc"
			);

		if($query->num_rows() > 0)
		{
			$data = $query->result("array");

			$first_ratio  = array();
			$second_ratio = array();

			$pre = -1;

			$score = array();

			//存放矩阵下标的数组
			$index = array();
			$index_num = 0;
			$index[0] = array();
			$index[0][0] = 0;

			//初始化矩阵数据
			foreach($data as $key => $value)
			{
				if($value['item_level'] == 1)
				{
					//初始化一级指标数据
					$first_ratio[$value['item_id']] = $value['ratio'];

					//初始化一级指标的下标
					if($index[0][0] == 0 || $index[0][$index[0][0]] != $value['item_id'])
					{
						$index[0][0]++;
						$index[0][$index[0][0]] = $value['item_id'];
					}
				}
				else
				{
					$pid = $value['pid'];
					//初始化二级指标的数据
					if(empty($second_ratio[$pid]))
					{
						$second_ratio[$pid] = array();
					}
					$second_ratio[$pid][$value['item_id']] = $value['ratio'];

					if($value['item_id'] != $pre)
					{
						$pre = $value['item_id'];

						$score[$pid][$pre] = array(0, 0, 0, 0, 0);
					}
					//$score[$pid][$pre][$value['item_id']] = array(0, 0, 0, 0, 0);
					$score[$pid][$pre][$value['value']-1]++;

					//初始化二级指标的下标
					if(empty($index[$pid]))
					{
						$index[$pid] = array();
						$index[$pid][0] = 0;
					}

					if($index[$pid][0] == 0 || $index[$pid][$index[$pid][0]] != $value['item_id'])
					{
						$index[$pid][0]++;
						$index[$pid][$index[$pid][0]] = $value['item_id'];
					}
				}
			}


			//模糊计算
			//先计算二级指标
			$second_item_result = array();
			foreach($index as $key => $row)
			{
				if($key != 0)
				{
					$second_item_result[$key] = array(0, 0, 0, 0, 0);

					for($i = 0; $i < 5; $i++)
					{
						for($j = 1; $j <= $row[0]; $j++)
						{
							$second_item_result[$key][$i] += $second_ratio[$key][$row[$j]] * $score[$key][$row[$j]][$i];
						}

						$second_item_result[$key][$i] /= $num;
					}
				}
			}

/*			echo "<pre>";
			echo "stu_id=$stu_id<br/>";
		//	echo "data=";
		//	print_r($data);
			echo "index=";
			print_r($index);
			echo "<br/>first_ratio=";
			print_r($first_ratio);
			echo "<br/>second_ratio=";
			print_r($second_ratio);
			echo "<br/>score=";
			print_r($score);
			echo "<br/>second_result=";
			print_r($second_item_result);
			echo "<br/>final=";
			print_r($final_result);
			echo "</pre>";*/


			//计算二级指标
			$final_result = array(0, 0, 0, 0, 0);
			$max_value = -1;
			$max_id = -1;
			for($i = 0; $i < 5; $i++)
			{
				for($j = 1; $j <= $index[0][0]; $j++)
				{
					//echo "  " . $first_ratio[$index[0][$j]] . "*" . $second_item_result[$index[0][$j]][$i];
					$final_result[$i] = $first_ratio[$index[0][$j]] * $second_item_result[$index[0][$j]][$i];
				}
				//echo "<br/>";
				if($final_result[$i] >= $max_value)
				{
					$max_value = $final_result[$i];
					$max_id = $i;
				}
			}


			$result_name = array("不及格", "及格", "中等", "良好", "优秀");
			//$result_name = array("0", "1", "2", "3", "4");

			return $result_name[$max_id];
		}
		else
		{
			return FALSE;
		}
	}
}
?>