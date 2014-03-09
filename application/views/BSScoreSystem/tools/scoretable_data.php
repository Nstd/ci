<div class="panel panel-default">
	<div class="panel-heading">评分表</div>
	<!-- <div class="panel-body"> -->
		<form action='<?php echo "$site_url/$site_name/teacher/t_score/$student_id"; ?>' method="post">
		<table class='table table-bordered table-hover'>
			<thead>
				<th style="text-align: center;">一级指标</th>
				<th style="text-align: center;">二级指标</th>
				<th style="text-align: center;">评分</th>
			</thead>
		<?php
			if(!isset($score_table) || count($score_table) == 0)
			{
				echo "<tr><td colspan='3' style='text-align:center;'><font color='red'><strong>&lt;评分表不存在!&gt;</strong></font></td></tr>";
			}
			else if($can_score == TRUE && isset($is_scored) && $is_scored == TRUE)
			{
				echo "<tr><td colspan='3' style='text-align:center;'><font color='red'><strong>&lt;已评分!&gt;</strong></font></td></tr>";
			}
			else
			{
				foreach($score_table as $level_one)
				{
					if($level_one['item_level'] == 1)
					{
						$parent_id = $level_one['item_id'];
						$item_rows = array();
						$num = 0;
						foreach($score_table as $level_two)
						{
							if($level_two['parent_item_id'] == $parent_id)
							{
								$item_rows[$num++] = $level_two;
							}
						}

						if($num == 0)
						{
							$level   = getRadioTdString(
								"score[" . $level_one['item_id'] . "]", 
								isset($level_one['value']) ? $level_one['value'] : null
								);
							echo "<tr><td colspan='2'>" . $level_one['item_content'] . "</td>$level</tr>";
						}
						else if($num == 1)
						{
							$level = getRadioTdString(
								"score[" . $item_rows[0]['item_id'] . "]", 
								isset($item_rows[0]['value']) ? $item_rows[0]['value'] : null
								);
							echo "<tr><td>" . $level_one['item_content'] . 
									"<input type='hidden' name='score[" . $level_one['item_id'] . "]' value='0'>" .
									"</td><td>" . $item_rows[0]['item_content'] . "</td>$level</tr>";
						}
						else 
						{
							echo "<tr><td valign='center' rowspan='" . ($num) . "'>" . $level_one['item_content'] . 
									"<input type='hidden' name='score[" . $level_one['item_id'] . "]' value='0'>" .
									"</td><td>" . $item_rows[0]['item_content'] . "</td>" . getRadioTdString("score[" . $item_rows[0]['item_id'] . "]", isset($item_rows[0]['value']) ? $item_rows[0]['value'] : null) . "</tr>";
						//	echo "<tr><td rowspan='" . ($num+1) . "'>" . $level_one['item_content'] . 
						//		"</td><td height='0px'></td><td height='0px'></td></tr>";
						//	echo "<tr><td rowspan='" . ($num+1) . "'>" . $level_one['item_content'] . "</td></tr>";
							
							for($i=1; $i<$num; $i++)
							{
								$level = getRadioTdString(
									"score[" . $item_rows[$i]['item_id'] . "]", 
									isset($item_rows[$i]['value']) ? $item_rows[$i]['value'] : null
									);
								echo "<tr><td>" . $item_rows[$i]['item_content'] . "</td>$level</tr>";
							}
				/*			foreach($item_rows as $row)
							{
								$level = getRadioTdString(
									"score_" . $row['item_id'], 
									isset($row['value']) ? $row['value'] : null
									);
								echo "<tr><td>" . $row['item_content'] . "</td>$level</tr>";
							}*/
						}
					}
				}
			}

			function getRadioTdString($radio_name, $level)
			{
				$level_name = array(
					1 => "不及格",
					2 => "及格",
					3 => "中",
					4 => "良",
					5 => "优"
					);

				$radio_string =  "<td style='text-align:center;' width='45%'>";
				for($i = 5; $i > 0; $i--)
				{
					$is_checked = ($level == $i ? "checked" : "");
					$radio_string .= "<div style='-moz-border-radius:5px;-webkit-border-radius:5px;border-radius: 12px;display:inline-block;border-top-style:solid;border-right-style:solid;border-bottom-style:solid;border-color:gray;border-width:1px;width:auto;'><input type='radio' name='$radio_name' " . $is_checked . " value='$i'/>" . $level_name[$i] . "&nbsp;&nbsp;</div>&nbsp;&nbsp;";
				}
				$radio_string .= "</td>";
				return $radio_string;
			}
		?>

		</table>
		<?php 
			if(isset($can_score) && $can_score === TRUE && $is_scored == FALSE)
			{
				echo "<div class='panel-footer' style='height:41px'><div class='pull-right' style='margin-top:-7px;margin-right:-10px'><input type='submit' class='btn btn-primary' value='保存' style='width:80px'></div></div>";
			}
		?>
		</form>
		<style type="text/css">
		table tr:hover td[rowspan]{
			background-color: #fff;
		}
		</style>
		<script type="text/javascript">
			$(document).ready(function(){
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '10%'
				});
			});
		</script>
	<!-- </div> -->
</div>