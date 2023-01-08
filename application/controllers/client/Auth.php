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

            $current_timestamp      = date('Y-m-d H:i:s');

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
        $data['extend_view']        = $this->extend_view;
        $data['pagetitle']          = 'Forget Password';
        $data['header_button']      = array(
            'text'  => 'Login',
            'href'  => base_url($this->route . 'login')
        );

        $this->template->load($this->namespace . 'forget', $data);
    }

    public function send_reset_password_token()
    {
        try {
            $email      = $this->input->post('email', TRUE);
            $client     = $this->M_client_auth->doGetClientByEmail($email);
            if (!$client) throw new Exception('Email not registered.');

            $token      = random_string('alnum', 60);
            $expired    = getGeneralSetting('PASSWORD_RESET_EXPIRE') ?: 60;

            $reset      = array(
                'email'         => $email,
                'token'         => $token,
                'expired_at'    => date('Y-m-d H:i:s', strtotime("+ $expired minutes")),
                'created_at'    => date('Y-m-d H:i:s')
            );
            $this->M_client_auth->doInsertPasswordReset($reset);

            $reset['expired']   = $expired . ' minutes';
            $body       = $this->load->view($this->namespace . 'forget_mail', $reset, TRUE);

            $send_email = sendEmail($email, 'Reset Password Notification', $body);
            if (!$send_email->success) {
                throw new Exception($send_email->msg);
            }

            $this->session->set_flashdata('success', 'Please check your email inbox.');
        } catch (Throwable $th) {
            $this->session->set_flashdata('error', $th->getMessage());
        } finally {
            redirect($this->route . 'forget');
        }
    }

    public function reset($token = null)
    {
        $email                      = $this->input->get('email', TRUE);

        $token_data                 = $this->M_client_auth->doGetTokenResetData($email, $token);
        if (!$token_data) {
            $this->session->set_flashdata('error', 'Invalid Token');
            redirect($this->route . 'login');
        }

        if (strtotime($token_data->expired_at) < now()) {
            $this->session->set_flashdata('error', 'Expired Token');
            redirect($this->route . 'login');
        }

        $data['extend_view']        = $this->extend_view;
        $data['pagetitle']          = 'Reset Password';
        $data['header_button']      = array(
            'text'  => 'Login',
            'href'  => base_url($this->route . 'login')
        );

        $data['token_data']         = $token_data;

        $this->template->load($this->namespace . 'forget_reset', $data);
    }

    public function reset_password_act()
    {
        try {
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|matches[password]');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors('<div class="small">', '</div>'));
            }

            $email                  = $this->input->post('_email', TRUE);
            $token                  = $this->input->post('_token', TRUE);
            $password               = $this->input->post('password');

            $token_data             = $this->M_client_auth->doGetTokenResetData($email, $token);
            if (!$token_data) {
                $this->session->set_flashdata('error', 'Invalid Token');
                redirect($this->route . 'login');
            }

            if (strtotime($token_data->expired_at) < now()) {
                $this->session->set_flashdata('error', 'Expired Token');
                redirect($this->route . 'login');
            }

            $password               = password_hash($password, PASSWORD_DEFAULT);
            $this->M_client_auth->doUpdatePasswordClientByEmail($email, $password);

            $this->session->set_flashdata('success', 'Your password has been successfully reset.');
            redirect($this->route . 'login');
        } catch (Throwable $th) {
            $this->session->set_flashdata('error', $th->getMessage());
            // redirect($this->route . 'register');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
