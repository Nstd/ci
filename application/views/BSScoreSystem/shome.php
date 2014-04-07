<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
		<title><?php echo $title; ?></title>
		<?php echo $cssjscontent; ?>
		<script type="text/javascript">
			$(document).ready(function(){
				var type = <?php echo $s_msg; ?>;
				if(type == 1) {
					$.scojs_message("上传成功", $.scojs_message.TYPE_OK);
				} else if(type == 0){
					$.scojs_message("上传失败", $.scojs_message.TYPE_ERROR);
				}
			});
		</script>
	</head>
	<body>
		<?php echo $aheader; ?>
	<div class="panel panel-default">
	<div class="panel-heading">学生信息</div>
	<div class="panel-body">
		<form class="form-horizontal"  enctype="multipart/form-data" role="form" method="post"
				action="<?php echo $this->bs->site_url."/".$this->bs->getSiteUrl('home/s_upload_project');?>">
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
			<div class="form-group">
				<label class="col-sm-5 control-label">上传论文：</label>
				<div class="col-sm-7">
					<input <?php if(!empty($student["score"])) echo "disabled"; ?> type="file" style="width: 200px" class="form-control" name="project" id="project" />
					<br/>
					<input <?php if(!empty($student["score"])) echo "disabled"; ?> type="submit" style="width: 100px" class="form-control btn btn-primary" name="submit" value="提交" />
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>