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
			<div class="panel-heading">用户管理</div>
			<div class="panel-body">
				<p>管理员可对所有用户进行权限管理</p>
			</div
			<!-- Table -->
			<table class="table">
				<thead>
					<tr>
						<th>序号</th>
						<th>用户账号</th>
						<th>用户名</th>
						<th>用户类型</th>
						<th>是否可以登陆</th>
						<th>操作</th>
					</tr>
				</thead>
			<tbody id="tablebody"></tbody>
		</table>
	</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">权限管理</h4>
			</div> 
			<div class="modal-body" id="myModal">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputUsername" class="col-sm-2 control-label">用户账号</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="inputUsername"  disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputName" class="col-sm-2 control-label">用户名</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="inputName" disabled>
						</div>
					</div>
					<div class="form-group">
						<label  class="col-sm-2 control-label">用户类型</label>
						<div class="col-sm-6">
							<select class="form-control" id="usertype">
								<option value="0">管理员</option>
								<option value="2">老师</option>
								<option value="1">学生</option>
							</select>
						</div>
					</div>
						<div class="form-group">
						<label class="col-sm-2 control-label">登陆权限</label>
						<div class="col-sm-6">
							<div class="radio-inline">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios1" value="0" checked>
									无
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="1">
									有
								</label>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id="info-submit">保存</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<ul class="pagination" >
</ul>
<script type="text/javascript">
$(document).ready(function(){
  user_management();

  $("#info-submit").click(function(){
    var user_info = {"username": $("#inputUsername").val(), "usertype": $("#usertype").val(),"canlogin":$('input:radio[name="optionsRadios"]:checked').val()};
    $.ajax({
      url: '<?php echo "$site_url/$site_name" ?>/user/a_update_user',
      data: user_info,
      type: "POST",
      dataType: 'json',
      global: false,
      success: function(data) 
      { 
        if(!data)
        {
          alert("修改失败");
        }
        $('#myModal').modal('hide');
        user_management();
      }
    });
  });
});

function user_management(page)
{
  $.ajax({
            url: '<?php echo "$site_url/$site_name" ?>/user/a_user_list',
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

function get_userinfo(username)
{ 
  $.ajax({
    url: '<?php echo "$site_url/$site_name" ?>/user/a_load_info',
    type: "POST",
    global: false,
    dataType : 'json',
    data: {'username':username},
    success: function(data) {
      $("#inputUsername").val(data.username);
      $("#inputName").val(data.name);
      $("#usertype").val(data.type);
      $("input[name=optionsRadios]:eq(" + data.canlogin + ")").attr("checked",'checked'); 
      $('#myModal').modal('show');
    }
  });
}
</script>
</body>
</html>