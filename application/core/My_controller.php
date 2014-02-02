<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->hr->checkUserLogin() == FALSE) 
		{
			redirect($this->hr->getSiteUrl("login/showLogin"));
		}
	}
}
// END MY_Controller Class

/* End of file MY_Controller.php */