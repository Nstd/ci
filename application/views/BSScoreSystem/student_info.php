<div class="panel panel-default">
	<div class="panel-heading">学生信息</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label class="col-sm-5 control-label">姓名</label>
				<div class="col-sm-7">
					<?php echo trim($student_data['name']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">学号</label>
				<div class="col-sm-7">
					<?php echo trim($student_data['stu_id']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label">毕设课题</label>
				<div class="col-sm-7">
					<?php echo trim($student_data['subject']); ?>
				</div>
			</div>
		</form>
	</div>
</div>