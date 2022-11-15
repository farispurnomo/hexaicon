<?php defined('BASEPATH') or exit('No direct script access allowed');

class Privacy_policy extends CI_Controller
{
    protected $namespace    = 'pages/client/privacy_policy/privacy_policy_';
    protected $pagetitle    = 'Dashboard';
    protected $extend_view  = 'layouts/client';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }
}
