
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/bootstrap-theme.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/jquery.spin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/sco.message.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/scojs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/iCheck/skins/square/blue.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $base_url; ?>resources/css/bootstrap-switch.min.css" type="text/css" media="screen" />

<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/sco.message.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/spin.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/jquery.spin.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/sco.tooltip.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/icheck.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/ckeditor/adapters/jquery.js"></script>

<!-- 系统实用工具 -->
<script type="text/javascript" src="<?php echo $base_url; ?>resources/js/common.js"></script>

<script type="text/javascript">
	//var change_spin_position = false;

	$(document).ready(function(){

		//var client_width = document.body.offsetWidth/2;
		//var client_height= document.body.offsetHeight/2;
		//var client_width = window.innerWidth/2;
		//var client_height= window.innerHeight/2;
		$("body").ajaxStart(function() {
			window.parent.createSpinner();
		});
		$(window).resize(function() {
			window.parent.changeSpinnerPos();
		});
		$("body").ajaxComplete(function() {
			window.parent.disableSpinner();
		});

	});
</script>