<div class="row">
	<div class="col-sm-6">
		<div  style="float:left">
		每页显示
		<select onchange="JavaScript:_Pagination_limit_change(this,'0','<?php echo $paging_class_name;?>.offset','<?php echo $paging_class_name;?>.limit',<?php echo $pageing_callback;?>);" class="form-control input-sm" style="display:inline;width:70px">
			<?php 
				$firstpageid = 1; 
				$lastpageid  = ceil($count/$limit); 

				$pagin_option=array(5, 10, 20, 30, 50);
				foreach($pagin_option as $value)
				{ 
					echo "<option value='$value' " . ($limit == $value ? "selected" : "") . ">$value</option>";
				}
			?>
		</select>
		条&nbsp;&nbsp;&nbsp;&nbsp;
		<?php  if($count != 0) { ?>
		共<?php echo $count;?>条&nbsp;第<?php echo $pageid; ?>页/共<?php echo ceil($count/$limit); ?>页&nbsp;
		<?php } ?>

		</div>
	</div>
	<div class="col-sm-6">
		<?php  if($count != 0) { ?>
		<div class="input-group input-group-sm" style="width:100px;float:right">
			<span class="input-group-btn">
					<button <?php if($pageid <= $firstpageid) echo "disabled=\"disabled\""; ?> type="button" class="btn btn-primary" onclick="JavaScript:_Pagination_NextPage('0','<?php echo $paging_class_name;?>.offset',<?php echo $pageing_callback;?>);">首页</button>
					<button <?php if($pageid <= $firstpageid) echo "disabled=\"disabled\""; ?> type="button" class="btn btn-primary" onclick="JavaScript:_Pagination_NextPage('<?php echo ($pageid-2)*$limit; ?>','<?php echo $paging_class_name;?>.offset',<?php echo $pageing_callback;?>);">上一页</button>
					<button <?php if($pageid >= $lastpageid) echo "disabled=\"disabled\""; ?> type="button" class="btn btn-primary" onclick="JavaScript:_Pagination_NextPage('<?php echo $pageid*$limit;?>','<?php echo $paging_class_name;?>.offset',<?php echo $pageing_callback;?>);">下一页</button>
					<button <?php if($pageid >= $lastpageid) echo "disabled=\"disabled\""; ?> type="button" class="btn btn-primary" onclick="JavaScript:_Pagination_NextPage('<?php echo ($lastpageid-1)*$limit; ?>','<?php echo $paging_class_name;?>.offset',<?php echo $pageing_callback;?>);">尾页</button>
			</span>
			<input type="text" id="_Pagination_jumppage" name="_Pagination_jumppage" class="form-control" placeholder="输入页码" style="width:70px">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="button" id="_Pagination_jumppage_btn" <?php if($count/$limit <= 1) echo "disabled=\"disabled\""; ?> 
					onclick="_Pagination_JumpPage(<?php echo ceil($count/$limit);?>,<?php echo $limit;?>,'<?php echo $paging_class_name;?>.offset',<?php echo $pageing_callback;?>);">GO</button>
			</span>
		</div>
		<script type="javascript/text">
			$(document).ready(function(){
				$(document).keypress(function(e){
					alert(e.which);
					if(e.which == 13) {
						$("#_Pagination_jumppage_btn").click();
						return false;
					}
				});
			});
		</script>
		<?php } ?>
	</div>
</div>