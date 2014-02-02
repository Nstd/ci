<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
		<title><?php echo $title; ?></title>
		<?php echo $cssjscontent; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#submit").click(function(){
					var param = {"username": $("#username").val(), "password": $("#password").val()};
					$.ajax({
						url: '<?php echo "$site_url/$site_name" ?>/login/login_valid',
						data: param,
						type: "POST",
						global: false,
						success: function(data) {
							var jsondata = eval("(" + data + ")");
							if(jsondata.success == 1) {
								location.href = jsondata.data;
							} else {
								$.scojs_message(jsondata.msg, $.scojs_message.TYPE_ERROR);
							}
						}
					});
				});
				$("#username").keypress(function(e){
					if(e.which == 13) $("#password").focus();
				});
				$("#password").keypress(function(e){
					if(e.which == 13) $("#submit").click();
				});
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="span12" style="margin:0 auto;float:none;margin-top:200px">
					<table style="width:100%;text-align:center;">
						<tr>
							<td>
								<h1 style="font-family:幼圆;font-weight:900"><font size="20px" color="#306fa5">本科毕业设计质量评价系统</font></h1>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="span12" style="margin:0 auto;float:none;margin-top:20px;width:200px">
					<form class="form-signin" role="form" id="sub_form">
						<!-- <div class="form-group"> -->
						<div class="input-group">
							<sapn class="input-group-addon"><span class="glyphicon glyphicon-user"></span></sapn> 
							<input id="username" name="username" type="text" class="form-control" placeholder="用户名" required autofocus/>
						</div>
						<br/>
						<div class="input-group">
							<sapn class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></sapn> 
							<input id="password" name="password" type="password" class="form-control" placeholder="密码" required/>
						</div>
						<!-- </div> -->
						<br/>
						<button id="submit" class="btn btn-primary btn-block" type="button">登 陆</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
