<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->bs->checkUserLogin() == FALSE) 
		{
			redirect($this->bs->getSiteUrl("login/showLogin"));
		} else {
			$pos = strpos($_SERVER['PHP_SELF'], $this->bs->site_name);
			$url_sig = substr($_SERVER['PHP_SELF'], $pos + strlen($this->bs->site_name) + 1);
			$url_sig_array = explode("/", $url_sig);
			if(count($url_sig_array) >= 2)
			{
				$method = $url_sig_array[1];
				$usertype = $this->session->userdata("usertype");
				if(	!(	(strpos($method, "a_") === 0 && $usertype == Bs::USER_ADMIN) ||
						(strpos($method, "s_") === 0 && $usertype == Bs::USER_STUDENT) ||
						(strpos($method, "t_") === 0 && $usertype == Bs::USER_TEACHER) ||
						!preg_match("/^[ast]_/", $method)
						)
					)
				{
					die("you does't have the authority!");
				}
				
				
			}
		}
	}
}
// END MY_Controller Class

/* End of file MY_Controller.php */