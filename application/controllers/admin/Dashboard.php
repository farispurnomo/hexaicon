<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends HEXAICONS_Controller
{
    protected $namespace    = 'pages/admin/dashboard/dashboard_';
    protected $route        = 'admin/dashboard';
    protected $pagetitle    = 'Dashboard';
    // protected $extend_view  = 'layouts/admin_1';
    protected $extend_view  = 'layouts/admin';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];

        $this->template->load($this->namespace . 'index', $data);
    }
}
