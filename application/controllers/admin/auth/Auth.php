<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("M_auth", "mdb");
        // header('Content-Type: application/json');
    }
    public function index()
    {
        $data['link'] = 'login';
        $data['content'] = 'layouts/login';
        $this->load->view('layouts/auth', $data);
    }

    public function login()
    {
        $post = $this->input->post();
        $data['content'] = 'layouts/login';
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('login', 'Email and Password Required');
            redirect(base_url('admin/auth/auth'));
        } else {
            $get_email = $this->mdb->get_email($post['email']);
            if ($get_email['count'] > 0) {
                if (password_verify($post['password'], $get_email['data']->password)) {
                    $session = [
                        'login' => true,
                        "role_id" => $get_email['data']->role_id,
                        "avatar" => $get_email['data']->avatar
                    ];
                    $this->session->set_userdata($session);
                    redirect(base_url('admin/dashboard'));
                } else {
                    $this->session->set_flashdata('login', 'Email and Password Not Found');
                    redirect(base_url('admin/auth/auth'));
                    // $this->load->view('layouts/auth',$data);
                }
            } else {
                $this->session->set_flashdata('login', 'Email Not Found');
                redirect(base_url('admin/auth/auth'));
                // $this->load->view('layouts/auth',$data);
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'admin/dashboard');
    }
    public function index_register()
    {
        $data['link'] = 'register';
        $data['content'] = 'layouts/register';
        $this->load->view('layouts/auth', $data);
    }
    public function register()
    {
        $post = $this->input->post();
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('ulpassword', 'Confirmation Password', 'required');
        // $this->form_validation->set_rules('telpon', ' Phone', 'required');
        // $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == false) {
            $feedback = ['status' => 201, "msg" => validation_errors('<li>', '</li>')];
        } else {
            $check_email = $this->mdb->check_email();
            if ($check_email > 0) {
                $this->session->set_flashdata('register', 'E-mail Already');
                redirect(base_url('admin/auth/auth/index_register'));
            } else {
                if ($post['password'] == $post['ulpassword']) {
                    $insert = $this->mdb->insert($post);
                    if ($insert) {
                        $this->session->set_flashdata('success', 'Successful Registration');
                        redirect(base_url('admin/auth/auth'));
                    } else {
                        $this->session->set_flashdata('register', 'Failed User Registration');
                        redirect(base_url('admin/auth/auth/index_register'));
                    }
                } else {
                    $this->session->set_flashdata('register', 'Passwords are not the same');
                    redirect(base_url('admin/auth/auth/index_register'));
                }
            }
        }
    }
    public function index_forget()
    {
        $data['link'] = 'register';
        $data['content'] = 'layouts/forget';
        $this->load->view('layouts/auth', $data);
    }
    public function index_reset()
    {
        $data['link'] = 'register';
        $data['content'] = 'layouts/reset';
        $this->load->view('layouts/auth', $data);
    }
    public function check_email()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('login', 'Email Required');
        } else {
            $post = $this->input->post();
            $get_email = $this->mdb->get_email($post['email']);
            if ($get_email['count'] > 0) {
                redirect(base_url('admin/auth/auth/index_reset'));
            } else {
                $this->session->set_flashdata('forget', 'Email Not Found');
                redirect(base_url('admin/auth/auth'));
                // $this->load->view('layouts/auth',$data);
            }
        }
    }
}
