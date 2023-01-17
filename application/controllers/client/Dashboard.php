<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    private $namespace    = 'pages/client/dashboard/dashboard_';
    private $extend_view  = 'layouts/client';

    private $client;

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
        $subscription_id            = @$this->client->subscription_plan_id;

        $data['extend_view']        = $this->extend_view;
        $data['favorite_icon_sets'] = $this->M_client_dashboard->doGetFavoriteIconSets($this->client->id);
        $data['favorite_icons']     = $this->M_client_dashboard->doGetFavoriteIcons($this->client->id, $subscription_id);

        $this->template->load($this->namespace . 'index', $data);
    }
}
