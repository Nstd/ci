<?php

	class Home extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
		}

		function t_index()
		{
			$this->bs->data['theader'] = $this->load->view($this->bs->getSiteUrl("head-teacher"), $this->bs->data, true);
			$this->load->view($this->bs->getSiteUrl("thome"), $this->bs->data);
		}

		function a_index()
		{

		}
	}

?>