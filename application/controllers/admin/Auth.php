<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $namespace    = 'pages/admin/auth/auth_';
    private $extend_view  = 'layouts/admin_auth';
    private $route        = 'admin/auth/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin_auth');
    }

    public function login()
    {
        if (getClientLogin()) {
            redirect('client/dashboard');
        }

        $data['extend_view']        = $this->extend_view;
        $data['pagetitle']          = 'Login';
        $data['header_button']      = array(
            'text'  => 'Register',
            'href'  => base_url('client/auth/register')
        );

        $this->template->load($this->namespace . 'login', $data);
    }

    public function login_act()
    {
        try {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors('<div><small>', '</small></div>', 504));
            }

            $email          = $this->input->post('email', TRUE);
            $password       = $this->input->post('password', TRUE);
            $login_data     = $this->M_admin_auth->doGetLoginData($email, $password);
            if (!$login_data) throw new Exception('These credentials do not match our records.', 401);

            $userdata       = array(
                'is_client'     => TRUE,
                'client_id'     => $login_data->id,
            );
            $this->session->set_userdata($userdata);

            $datarow['status']  = 200;
            $datarow['msg']     = 'success';
            // redirect('client/dashboard');
        } catch (Throwable $th) {
            // $this->session->set_flashdata('error', $th->getMessage());
            // redirect($this->route . 'login');

            $datarow['status']  = $th->getCode();
            $datarow['msg']     = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($datarow));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect($this->route . 'login');
    }
}