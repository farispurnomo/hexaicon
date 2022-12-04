<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    protected $namespace    = 'pages/client/profile/profile_';
    protected $extend_view  = 'layouts/client';
    protected $route        = 'client/profile';

    protected $client_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_client_profile');

        $this->client_id = $this->session->userdata('id') ?? 1;
    }

    public function index()
    {
        $data['extend_view']    = $this->extend_view;
        $data['route']          = $this->route;

        $data['user']           = $this->M_client_profile->doGetClientById($this->client_id);

        if (!$data['user']) show_404();

        $this->template->load($this->namespace . 'index', $data);
    }

    private function do_upload()
    {
        $file_name = str_replace(' ', '_', $_FILES['file']['name']);
        $config['upload_path'] = './public/uploads/clients/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']    = '2000';
        $file_name = rand(00, 99) . '_' . date('YmdHis') . '_' . $file_name;
        $config['file_name'] = $file_name; //new file name


        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $file_path = '/public/uploads/clients/' . $this->upload->data()['file_name'];
            return $file_path;
        }

        $this->session->set_flashdata('msg', $this->upload->display_errors());
        redirect($this->route, 'refresh');
    }

    public function update()
    {
        try {
            if ($this->input->method(true) != 'POST') throw new Exception();

            $params                 = array();
            $params['name']         = $this->input->post('name', true);
            $params['position']     = $this->input->post('position', true);

            if ($password = $this->input->post('password')) {
                $params['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $params['image'] = $this->do_upload();
            }

            $this->M_client_profile->doUpdateClientById($this->client_id, $params);
            $this->session->set_flashdata('success', 'Data successfully saved');
        } catch (Throwable $th) {
        } finally {
            redirect($this->route);
        }
    }
}
