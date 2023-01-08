<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    protected $namespace    = 'pages/client/dashboard/dashboard_';
    protected $extend_view  = 'layouts/client';

    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_client_dashboard');

        $this->client = getClientLogin();
        if (!$this->client) redirect('client/auth/login');
    }

    public function index()
    {
        $data['client']             = $this->client;

        $data['extend_view']        = $this->extend_view;
        $data['favorite_icon_sets'] = $this->M_client_dashboard->doGetFavoriteIconSets($this->client->id);
        $data['favorite_icons']     = $this->M_client_dashboard->doGetFavoriteIcons($this->client->id);

        $this->template->load($this->namespace . 'index', $data);
    }
}
