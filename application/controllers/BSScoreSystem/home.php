<?php

	class Home extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function t_index()
		{
			$this->load->view($this->bs->getSiteUrl("thome"), $this->bs->data);
		}

		function a_index()
		{
			
		}
	}

?>