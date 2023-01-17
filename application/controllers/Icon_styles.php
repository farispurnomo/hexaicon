<?php defined('BASEPATH') or exit('No direct script access allowed');

class Icon_styles extends CI_Controller
{
    private $namespace    = 'pages/client/icon_styles/icon_styles_';
    private $extend_view  = 'layouts/client';
    private $route        = 'icon_styles';

    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client       = getClientLogin();
        $this->load->model('M_icon_style');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;

        $this->template->load($this->namespace . 'index', $data);
    }
}
