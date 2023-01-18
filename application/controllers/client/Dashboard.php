<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    private $namespace    = 'pages/client/dashboard/dashboard_';
    private $extend_view  = 'layouts/client';
    private $route        = 'client/dashboard';

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
        $data['route']              = $this->route;
        $data['favorite_icon_sets'] = $this->M_client_dashboard->doGetFavoriteIconSets($this->client->id, 1, 8)['sets'];
        $data['favorite_icons']     = $this->M_client_dashboard->doGetFavoriteIcons($this->client->id, $subscription_id)['icons'];

        $this->template->load($this->namespace . 'index', $data);
    }

    public function favorite_icon()
    {
        $data['extend_view']        = $this->extend_view;
        $data['route']              = $this->route;
        $data['client']             = $this->client;

        $this->template->load($this->namespace . 'favorite_icon', $data);
    }

    public function favorite_icon_paginate()
    {
        try {
            $page = $this->input->get('page', true);
            $subscription_id        = @$this->client->subscription_plan_id;

            $datarow['status']      = 200;
            $datarow['msg']         = 'sukses';
            $datarow['data']        = $this->M_client_dashboard->doGetFavoriteIcons($this->client->id, $subscription_id, $page);
        } catch (Throwable $th) {
            $datarow['status']      = $th->getCode();
            $datarow['msg']         = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }

    public function favorite_icon_set()
    {
        $data['extend_view']        = $this->extend_view;
        $data['route']              = $this->route;
        $data['client']             = $this->client;

        $this->template->load($this->namespace . 'favorite_icon_set', $data);
    }

    public function favorite_icon_set_paginate()
    {
        try {
            $page = $this->input->get('page', true);

            $datarow['status']      = 200;
            $datarow['msg']         = 'sukses';
            $datarow['data']        = $this->M_client_dashboard->doGetFavoriteIconSets($this->client->id, $page);
        } catch (Throwable $th) {
            $datarow['status']      = $th->getCode();
            $datarow['msg']         = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($datarow));
        }
    }
}
