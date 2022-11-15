<?php defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends CI_Controller
{
    protected $namespace    = 'pages/client/faq/faq_';
    protected $pagetitle    = 'Dashboard';
    protected $extend_view  = 'layouts/client';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }
}
