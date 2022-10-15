<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    protected $namespace    = 'pages/client/landing/landing_';
    protected $route        = 'admin/dashboard';
    protected $pagetitle    = 'Dashboard';
    protected $extend_view  = 'layouts/client';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['title']          = $this->pagetitle;
        $data['subheaders']     = ['Index' => base_url($this->route . '.index')];

        $this->template->load($this->namespace . 'index', $data);
    }
}
