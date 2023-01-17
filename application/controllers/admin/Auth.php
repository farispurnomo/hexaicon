<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $namespace    = 'pages/admin/auth/auth_';
    private $extend_view  = 'layouts/admin_auth';
    private $route        = 'admin/auth/';

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin_auth');

        $this->user = getUserLogin();
    }

    public function login()
    {
        if ($this->user) {
            redirect('admin/dashboard');
        }

        $data['extend_view']        = $this->extend_view;
        $data['pagetitle']          = 'Login';

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
                'is_user'     => TRUE,
                'user_id'     => $login_data->id,
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

    private function do_upload()
    {
        $file_name                      = str_replace(' ', '_', $_FILES['file']['name']);
        $config['upload_path']          = './public/uploads/users/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = '2000';
        $file_name                      = rand(00, 99) . '_' . date('YmdHis') . '_' . $file_name;
        $config['file_name']            = $file_name; //new file name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            return '/public/uploads/users/' . $this->upload->data()['file_name'];
        }

        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function profile()
    {
        if (!$this->user) show_404();

        $data['extend_view']            = 'layouts/admin';
        $data['pagetitle']              = 'Profile';
        $data['subheaders']             = ['Profile' => base_url($this->route . '.index')];
        $data['route']                  = $this->route;
        $data['record']                 = $this->M_admin_auth->doGetFirstUserData($this->user->id);

        $this->template->load('pages/admin/users/user/user_profile', $data);
    }

    public function profile_update()
    {
        if (!$this->user) show_404();

        try {
            $password                   = $this->input->post('password');

            if ($password != '') {
                $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

                if ($this->form_validation->run() == FALSE) {
                    throw new Exception(validation_errors(), 405);
                }
            }


            $record            = $this->M_admin_auth->doGetFirstUserData($this->user->id);
            if (!$record) redirect('/client/errors/error_404');

            $user                        = array(
                'name'                          => $this->input->post('name', TRUE),
                'phone'                         => $this->input->post('phone', TRUE),
                'updated_at'                    => date('Y-m-d H:i:s')
            );

            if ($password != '') {
                $user['password']            = password_hash($password, PASSWORD_BCRYPT);
            }

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $user['avatar'] = $this->do_upload();

                if ($record->avatar) {
                    $full_path = FCPATH . $record->avatar;
                    if (file_exists($full_path)) @unlink($full_path);
                }
            }

            $this->M_admin_auth->doUpdateUserData($this->user->id, $user);

            $this->session->set_flashdata('success', 'Profile successfully updated');
        } catch (Throwable $th) {
            if ($th->getCode() != 405)
                $this->session->set_flashdata('error', $th->getMessage());
        } finally {
            redirect($this->route . 'profile');
        }
    }
}
