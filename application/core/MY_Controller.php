<?php
class Hexaicons_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$login = $this->session->userdata('login');
		if (!$login) {
			redirect('/');
		}else {
			$role = $this->session->userdata('role_id');
			$this->db->where('id',$role);
			$role_akses = $this->db->get('core_roles')->row();
			if ($role_akses->akses != 1) {
				redirect(base_url());
			}
			
		}
	}
}
