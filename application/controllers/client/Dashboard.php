<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    protected $namespace    = 'pages/client/dashboard/dashboard_';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_client_dashboard');
    }

    public function index()
    {
        $id                         = $this->session->userdata('id') ?? 1;

        $data['extend_view']        = $this->extend_view;
        $data['user']               = $this->M_client_dashboard->doGetClientById($id);

        // if (!$data['user']) show_404();

        $data['favorite_icon_sets'] = $this->M_client_dashboard->doGetFavoriteIconSets($id);
        $data['favorite_icons']     = $this->M_client_dashboard->doGetFavoriteIcons($id);

        $this->template->load($this->namespace . 'index', $data);
    }
}
