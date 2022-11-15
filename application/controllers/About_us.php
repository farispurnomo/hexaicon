<?php defined('BASEPATH') or exit('No direct script access allowed');

class About_us extends CI_Controller
{
    protected $namespace    = 'pages/client/about_us/about_us_';
    protected $extend_view  = 'layouts/client';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }
}
