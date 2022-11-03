<?php
class HEXAICONS_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$login = $this->session->userdata('login');
		if (!$login) {
			redirect('/');
		}
	}
}
