<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
        $this->load->model("M_auth","mdb");
		header('Content-Type: application/json');
	}
    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function login()
    {
        $post = $this->input->post();
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $feedback = ['status' => 201, "msg" => validation_errors('<li>', '</li>')];
        } else {
            $get_email = $this->mdb->get_email($post['email']);
            if ($get_email['count'] > 0) {
                if (password_verify($post['password'], $get_email['data']->password)) {
                    $session = [
                        'login'=>true,
                        "role_id"=>$get_email['data']->role_id,
                        "avatar"=>$get_email['data']->avatar
                    ];
                    $this->session->set_userdata($session);
                    $feedback = ['status' => 200, "msg" => "Successful Login"];
                }else {
                    $feedback = ['status' => 201, "msg" => "Wrong email and password"];
                } 
            } else {
                $feedback = ['status' => 201, "msg" => "Email not found"];
            }
            
        }
        echo json_encode($feedback);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        
        redirect(base_url().'admin/dashboard');
        // $feedback = ['status' => 200, "msg" => "Successful Logout"];

    }
    public function register()
    {
        $post = $this->input->post();
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('kon_password', 'Confirmation Password', 'required');
        $this->form_validation->set_rules('telpon', ' Phone', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        if ($this->form_validation->run() == false) {
            $feedback = ['status' => 201, "msg" => validation_errors('<li>', '</li>')];
        } else {
            $check_email = $this->mdb->check_email();
            if ($check_email > 0) {
                $feedback = ['status' => 201, "msg" => "Email is already"];
            }else {
                if ($post['password'] == $post['kon_password']) {
                    $insert = $this->mdb->insert($post);
                    if ($insert) {
                        $feedback = ['status' => '200', "msg" => "Successful User Registration"];
                    } else {
                        $feedback = ['status' => 201, "msg" => "Failed User Registration"];
                    }
                    
                } else {
                    $feedback = ['status' => 201, "msg" => "passwords are not the same"];
                }
                
            }
        }
        echo json_encode($feedback);
    }
}
