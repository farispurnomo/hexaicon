<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $namespace    = 'pages/client/auth/auth_';
    private $extend_view  = 'layouts/client_auth';
    private $route        = 'client/auth/';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_client_auth');
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
                throw new Exception(validation_errors('<div>', '</div>'));
            }

            $email          = $this->input->post('email', TRUE);
            $password       = $this->input->post('password', TRUE);
            $login_data     = $this->M_client_auth->doGetLoginData($email, $password);
            if (!$login_data) throw new Exception('These credentials do not match our records.');

            $userdata       = array(
                'is_client'     => TRUE,
                'client_id'     => $login_data->id,
            );
            $this->session->set_userdata($userdata);

            redirect('client/dashboard');
        } catch (Throwable $th) {
            $this->session->set_flashdata('error', $th->getMessage());
            redirect($this->route . 'login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect($this->route . 'login');
    }

    public function register()
    {
        $data['extend_view']        = $this->extend_view;
        $data['pagetitle']          = 'Register';
        $data['header_button']      = array(
            'text'  => 'Login',
            'href'  => base_url($this->route . 'login')
        );

        $this->template->load($this->namespace . 'register', $data);
    }

    public function register_act()
    {
        try {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[mst_clients.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');

            $this->form_validation->set_message('is_unique', 'The %s is already taken');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors('<div class="small">', '</div>'));
            }

            $current_timestamp      = date('Y-m-d h:i:s');

            $email                  = $this->input->post('email', TRUE);
            $password               = $this->input->post('password', TRUE);

            $subscribed_at          = null;
            $subscription_plan_id   = null;

            $def_subscription_plan  = $this->M_client_auth->doGetDefaultSubscriptionPlan();
            if (isset($def_subscription_plan)) {
                $subscription_plan_id = $def_subscription_plan->id;
                $subscribed_at        = $current_timestamp;
            }

            $client                 = array(
                'email'                 => $email,
                'subscription_plan_id'  => $subscription_plan_id,
                'subscribed_at'         => $subscribed_at,
                'password'              => password_hash($password, PASSWORD_DEFAULT),
                'created_at'            => $current_timestamp
            );

            $this->session->set_flashdata('success', 'Account registered.');
            $this->M_client_auth->doInsertClientData($client);

            redirect($this->route . 'login');
        } catch (Throwable $th) {
            $this->session->set_flashdata('error', $th->getMessage());
            // redirect($this->route . 'register');
            return $this->register();
        }
    }

    public function forget()
    {
    }

    public function reset_password()
    {
    }
}
