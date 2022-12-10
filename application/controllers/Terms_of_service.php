<?php defined('BASEPATH') or exit('No direct script access allowed');

class Terms_of_service extends CI_Controller
{
    protected $namespace    = 'pages/client/terms_of_service/terms_of_service_';
    protected $extend_view  = 'layouts/client';

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }
}
