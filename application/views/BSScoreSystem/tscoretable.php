<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
		<title><?php echo $title; ?></title>
		<?php echo $cssjscontent; ?>
	</head>
	<body>
		<?php echo $theader; ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<?php echo $student_info; ?>
				</div>
				<div class="col-sm-8">
					<?php echo $scoretable_data; ?>
				</div>
			</div>
		</div>
	</body>
</html>