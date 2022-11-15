<?php defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    protected $namespace    = 'pages/client/landing/landing_';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_landing');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['subscriptions']  = $this->M_landing->getSubscriptions();

        $this->template->load($this->namespace . 'index', $data);
    }
}
