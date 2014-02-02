<table class="table table-striped table-bordered table-hover" id='<?php echo $name_id;?>' name='<?php echo $name_id;?>'>
<?php
//输出表格标题
if(null != $table_head && "" != $table_head)
{
	if(is_array($table_head))
	{
		echo "<thead><tr>";
		for($h_id=0, $h_num=count($table_head); $h_id < $h_num; $h_id++)
		{
			echo "<th style=\"text-align:center\">" . $table_head[$h_id] . "</th>";
		}
		echo "</tr></thead>";
	}
	else
	{
		echo $table_head;
	}
}

//输出表格内容
if(null != $table_data && "" != $table_data)
{
	if(is_array($table_data))
	{
		if(null != $table_head_title)
		{
			if(is_array($table_head_title))
			{
				//按指定列名输出列
				if(null != $table_col_css && is_array($table_col_css))
				{
					//输出样式
					foreach($table_data as $rows)
					{
						echo "<tr>";
						for($c_id=0, $c_num=count($table_head_title); $c_id < $c_num; $c_id++)
						{
							echo "<td style=\"" . $table_col_css[$c_id] . "\">" . $rows[$table_head_title[$c_id]] . "</td>";
						}
						echo "</tr>";
				}
				}
				else
				{
					foreach($table_data as $rows)
					{
						echo "<tr>";
						for($c_id=0, $c_num=count($table_head_title); $c_id < $c_num; $c_id++)
						{
							echo "<td>" . $rows[$table_head_title[$c_id]] . "</td>";
						}
						echo "</tr>";
					}
				}

			}
			else
			{
				//直接输出所有列
				for($r_id=0, $r_num=count($table_data); $r_id < $r_num; $r_id++)
				{
					echo "<tr>" . $table_data[$r_id] . "</tr>";
				}
			}
		}
	}
	else
	{
		echo $table_data;
	}
}
else
{
	echo "<tr style='text-align:center'><td colspan='" . count($table_head_title) . "'><font color='red'><strong>&lt;未找到数据!&gt;</strong></font></td></tr>";
}

?>
</table>