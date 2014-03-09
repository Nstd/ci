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
	<div class="panel-heading">学生信息</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-sm-5 control-label">姓名：</label>
				<div class="col-sm-7">
						<label class="col-sm control-label"><?php echo $this->session->userdata("name");?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">学号：</label>
				<div class="col-sm-7">
					<label class="col-sm control-label"><?php echo $this->session->userdata("username");?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">系名：</label>
				<div class="col-sm-7">
					<label class="col-sm control-label"><?php echo $student["department_name"] ;?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">专业名：</label>
				<div class="col-sm-7">
					<label class="col-sm control-label"><?php echo $student["major_name"] ;?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">指导老师：</label>
				<div class="col-sm-7">
					<label class="col-sm control-label"><?php echo $student["teacher_name"] ;?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">毕设课题：</label>
				<div class="col-sm-7">
					<label class="col-sm control-label"><?php echo $student["subject"] ;?></label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">毕设得分：</label>
				<div class="col-sm-7">
					<label class="col-sm control-label"><?php echo empty($student["score"])?"敬请期待":$student["score"];?></label>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>