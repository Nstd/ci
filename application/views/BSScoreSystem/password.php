<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta name="renderer" content="webkit" />
<title><?php echo $title; ?></title>
<?php echo $cssjscontent; ?>

<link href="<?php echo  base_url(); ?>resources/css/common.css?>" rel="stylesheet" type="text/css" />
<link href="<?php echo  base_url(); ?>resources/css/register.css" rel="stylesheet" type="text/css" />

</head><body>
<div class="aw-register-bg">
	<div class="aw-register-head">
		<h1 style="font-family:幼圆;font-weight:900"><font size="20px" color="#306fa5">本科毕业设计质量评价系统</font></h1>
		<p class="aw-register-head-title" id="header_action">
			<i class="icon-add-alt"></i>
		</p>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#header_action').append('修改密码');
		$("#pwd_change").click(function(){
			var pwd_info = {"old_password": $("#old_password").val(), "new_password": $("#new_password").val()};
			$.ajax({
				url: '<?php echo "$site_url/$site_name" ?>/login/new_password',
				data: pwd_info,
				type: "POST",
				global: false,
				success: function(data) {
					if(data == 0)
					{
						$('#error_data').html('输入信息有误');
					}
					if(data == 2)
					{
						$('#error_data').html('旧密码输入错误');
					}
					if(data == 1)
					{
						alert("修改密码成功！")
						location.href = "<?php echo $HTTP_REFERER; ?>";
					}

					$('.error').removeClass("hide"); 
				}
			});
		});
	})
</script>

<div class="aw-register-box">
	<form class="aw-register-form" id="profile_form" >
		<ul>
			<li class="error alert-danger hide error_message">
				<p><i class="icon-remove"></i><em id="error_data"></em></p>
			</li>
			<li>
				<input class="form-control" name="old_password" id="old_password" type="password" placeholder="旧密码" />
			</li>
			<li>
				<input class="form-control" name="new_password" id="new_password" type="password" placeholder="新密码" />
			</li>
			<li class="clearfix">
				<button class="pull-right btn btn-large btn-success" id="pwd_change" type="button">改密</button>
			</li>
		</ul>
	</form>
</div>
</body>
</html>