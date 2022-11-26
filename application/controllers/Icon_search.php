<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_search extends CI_Controller
{
    protected $namespace    = 'pages/client/icon_search/icon_search_';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('M_icon_search');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }
}
