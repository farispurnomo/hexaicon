<?php defined('BASEPATH') or exit('No direct script access allowed');

class Contact_us extends CI_Controller
{
    protected $namespace    = 'pages/client/contact_us/contact_us_';
    protected $route        = 'contact_us';
    protected $extend_view  = 'layouts/client';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_contact_us');
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['route']          = $this->route;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function store()
    {
        $post = $this->input->post();
        $this->M_contact_us->store($post);

        $this->session->set_flashdata('success', 'Data Successfully Sended');
        return redirect(base_url($this->route));
    }
}
