<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
		<title><?php echo $title; ?></title>
		<?php echo $cssjscontent; ?>
	</head>
	<body>
		<?php echo $aheader; ?>
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">毕设管理
				<div class='pull-right'>
					<button type="button" class="btn btn-default btn-sm " id="add_bs">添加</button>
				</div>
			</div>
			<div class="panel-body">
				<p>管理员对指导老师进行分配</p>
			</div
			<!-- Table -->
			<table class="table">
				<thead>
					<tr>
						<th>序号</th>
						<th>系名</th>
						<th>专业名</th>
						<th>指导老师</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody id="tablebody"></tbody>
			</table>
		</div>
		<ul class="pagination"></ul>
		<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">毕设分配</h4>
			</div> 
			<div class="modal-body" id="myModal">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="facultyName" class="col-sm-2 control-label">系名</label>
					<div class="col-sm-6">
							<select class="form-control" id="facultyName">
							</select>
					</div>
				</div>
				<div class="form-group">
					<label for="majorName" class="col-sm-2 control-label">专业名</label>
					<div class="col-sm-6">
							<select class="form-control" id="majorName">
							</select>
					</div>
				</div>
				<div class="form-group">
					<label for="instructorName" class="col-sm-2 control-label">指导老师</label>
					<div class="col-sm-6">
							<select class="form-control" id="instructorName">
							</select>
					</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			<button type="button" class="btn btn-primary" id="bs-submit">保存</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
	get_result();

	var dep_info= new Array();

	function show_selection(info)
	{
		$('#facultyName').html(info);
		$('#majorName').html('<option value="0">请选择专业名</option>');
		$('#instructorName').html('<option value="0">请选择指导老师</option>');
		$('#myModal').modal('show');
	}

	$("#add_bs").click(function(){
		if(dep_info.length == 0)
		{
			$.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/assignment/a_get_department',
            type: "POST",
            dataType: 'json',
            global: false,
            success: function(data) {
            	dep_info = data;
            	show_selection(dep_info);
            }
          });
		}
		else
		{
			show_selection(dep_info);
		}
    });

    //获得专业信息
    $("#facultyName").change(function(){
    	var faculty = $("#facultyName").val();
    	if(faculty!=0)
    	{
    		$.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/assignment/a_get_major',
            type: "POST",
            data: {'faculty':faculty},
            dataType: 'json',
            global: false,
            success: function(data) {
            	$('#majorName').html(data);
            }
          });
    	}
    	else
    	{
    		alert("请选择系！")
    	}
    })


    //获得对应指导老师信息
    $("#majorName").change(function(){
    	var major = $("#majorName").val();
    	if(major!=0)
    	{
    		$.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/assignment/a_get_instructor',
            type: "POST",
            data: {'major':major},
            dataType: 'json',
            global: false,
            success: function(data) {
            	$('#instructorName').html(data);
            }
          });
    	}
    	else
    	{
    		alert("请选择专业！")
    	}
    })

    $("#bs-submit").click(function(){
    	var asg_info = {"major": $("#majorName").val(),"staff_id":$('#instructorName').val()};
    	$.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/assignment/a_set_instructor',
            type: "POST",
            data: asg_info,
            dataType: 'json',
            global: false,
            success: function(data) {
            	if(data)
            	{
            		$('#myModal').modal('hide');
            		get_result();
            	}
            	else
            	{
            		alert("添加失败请重试！")
            	}
            }
          });
    });
});

function get_result(page)
{
  $.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/assignment/a_result_list',
            type: "POST",
            dataType: 'json',
            data: {'page':page},
            global: false,
            success: function(data) {
             $('.table tbody').html(data.info); 
             $('.pagination').html(data.paging);
            }
          });
}

function del_info(staff_id)
{ 
  $.ajax({
    url: '<?php echo "$site_url/$site_name" ?>/assignment/a_del_info',
    type: "POST",
    global: false,
    dataType : 'json',
    data: {'staff_id':staff_id},
    success: function(data) {
    	if(data)
    	{
    		get_result();
    	}
    	else
    	{
    		alert("删除失败请重试！")
    	}	
    }
  });
}
</script>