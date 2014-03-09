<div class='panel panel-default'>
	<div class='panel-heading'>评分表<div id='remainScore' class='pull-right'></div></div>
	<table class='table table-bordered table-hover'>
	<?php
		if($is_item_exist)
		 {
		 	echo "<tr><td style='text-align:center'><font color='red'>&lt;评分表已存在&gt;</font></td></tr>";
		 }
		 else
		 {
		 	echo <<<HTML
		<tr class='row-1-title'>
			<td class='myheadcol' rowspan='3' style='padding:0px 0px 0px 0px;vertical-align:middle;'>
				<div class='input-group' style='height:100%'>
					<input type='text' class='first-name form-control' style='width:80%;height:72px' placeholder='一级指标'>
					<input type='text' class='first-ratio form-control' style='width:20%;height:72px' placeholder='权重'>
					<span class='remove-row input-group-addon'>
						<span class='glyphicon glyphicon-remove'></span>
					</span>
				</div>
			</td>
		</tr>
		<tr class='row-1-1'>
			<td style='padding:0px 0px 0px 0px;vertical-align:middle;'>
				<div class='input-group' style='width:100%;'>
					<input type='text' class='second-name form-control' style='width:80%;' placeholder='二级指标'>
					<input type='text' class='second-ratio form-control' style='width:20%;' placeholder='权重'>
					<span style='height:auto;' class='remove-col input-group-addon'>
						<span class='glyphicon glyphicon-remove'></span>
					</span>
				</div>
			</td>
		</tr>
		<tr class='row-1-add'><td style='text-align:center;' class='add2-1'><span class='glyphicon glyphicon-plus-sign'></span></td></tr>
		<tr><td colspan='3' style='text-align:center;' class='add1'><span class='glyphicon glyphicon-plus-sign'></td></tr>

HTML;
		}
	?>
	</table>
	<div class='panel-footer' style='height:41px;'>
		<div class='pull-right' style='margin-top:-7px;margin-right:-10px;'>
			<?php
				if( ! $is_item_exist)
				{
					echo <<<HTML
					<button id='savebtn' type='text' onclick='return submitScoreItem();' class='btn btn-primary'>&nbsp;&nbsp;保存&nbsp;&nbsp;</button>
HTML;
				}
			?>
		</div>
	</div>
</div>