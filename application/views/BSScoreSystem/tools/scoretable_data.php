<?php
	echo "<table class='table table-bordered table-hover'>";
	
	if(isset($score_table) && count($score_table) == 0)
	{
		echo "<tr><td style='text-align:center;text-color:red;'><strong>评分表不存在!</strong></td></tr>";
	}
	else
	{

		foreach($score_table as $level_one)
		{
			if($level_one['parent_item_id'] == 0)
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
					$item_id = $level_one['item_id'];
					echo "<tr><td colspan='2'>" . $level_one['item_content'] . "</td><td style='text-align:center' width='30%'><input type='radio' name='sorce_".$item_id ."'/>优&nbsp;&nbsp;<input type='radio' name='sorce_".$item_id ."'/>良&nbsp;&nbsp;<input type='radio' name='sorce_".$item_id ."'/>中&nbsp;&nbsp;<input type='radio' name='sorce_".$item_id ."'/>及格&nbsp;&nbsp;<input type='radio' name='sorce_".$item_id ."'/>差</td></tr>";
				}
				else if($num == 1)
				{
					echo "<tr><td>" . $level_one['item_content'] . "</td><td>" . $item_rows[0]['item_content'] . "</td><td style='text-align:center' width='30%'><input type='radio'/>优&nbsp;&nbsp;<input type='radio'/>良&nbsp;&nbsp;<input type='radio'/>中&nbsp;&nbsp;<input type='radio'/>及格&nbsp;&nbsp;<input type='radio'/>差</td></tr>";
				}
				else 
				{
					echo "<tr><td rowspan='" . ($num+1) . "'>" . $level_one['item_content'] . "</td></tr>";
					foreach($item_rows as $row)
					{
						echo "<tr><td>" . $row['item_content'] . "</td><td style='text-color:red;text-align:center' width='30%'><input type='radio'/>优&nbsp;&nbsp;<input type='radio'/>良&nbsp;&nbsp;<input type='radio'/>中&nbsp;&nbsp;<input type='radio'/>及格&nbsp;&nbsp;<input type='radio'/>差</td></tr>";
					}
				}
			}
		}
	}

	echo "</table>";
?>