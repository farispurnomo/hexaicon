<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $namespace    = 'pages/admin/users/user/user_';
    private $route        = 'admin/users/user';
    private $pagetitle    = 'User';
    private $extend_view  = 'layouts/admin';
    private $table_id     = 'kt_users_table';
    private $permission   = 'user:';

    public function __construct()
    {
        parent::__construct();

        if (!getUserLogin()) redirect('admin/auth/login');

        $this->load->model('M_admin_user');
    }

    public function index()
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = $this->pagetitle;
        $data['subheaders']             = ['User' => base_url($this->route . '.index')];
        $data['route']                  = $this->route;
        $data['table_id']               = $this->table_id;
        $data['permission']             = $this->permission;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function paginate()
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        try {
            $search                     = $this->input->post('search', TRUE)['value'];
            $offset                     = $this->input->post('start', TRUE);
            $limit                      = $this->input->post('length', TRUE);
            $draw                       = $this->input->post('draw', TRUE);
            $sort_field_id              = $this->input->post('order[0][column]', TRUE);
            $sort_field                 = $this->input->post("columns[$sort_field_id][data]");
            $sort_dir                   = $this->input->post('order[0][dir]', TRUE);

            $items                      = $this->M_admin_user->doGetUserData($search, $sort_field, $sort_dir, $offset, $limit);

            $datarow['draw']            = (int) $draw;
            $datarow['recordsTotal']    = $this->M_admin_user->doCountUserData();
            $datarow['recordsFiltered'] = $this->M_admin_user->doCountUserData($search);
            $datarow['data']            = $items;
        } catch (Throwable $th) {
            $datarow['errors']          = $th->getMessage();
            $datarow['draw']            = 1;
            $datarow['recordsTotal']    = 0;
            $datarow['recordsFiltered'] = 0;
            $datarow['data']            = [];
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($datarow));
        }
    }

    public function create()
    {
        if (!isHaveAbility($this->permission . 'create')) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = 'Add ' . $this->pagetitle;
        $data['subheaders']             = ['User' => base_url($this->route . '.index'), 'Create' => base_url($this->route . '/create')];
        $data['route']                  = $this->route;
        $data['roles']                  = $this->M_admin_user->doGetRoles();

        $this->template->load($this->namespace . 'create', $data);
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

    public function store()
    {
        if (!isHaveAbility($this->permission . 'create')) show_404();

        try {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[core_users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('role_id', 'Role', 'required');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors(), 405);
            }

            $email                      = $this->input->post('email', TRUE);

            $role_id                    = $this->input->post('role_id', TRUE);
            $role                       = $this->M_admin_user->doGetRoleById($role_id);
            if (!$role) throw new Exception('Role is not valid');

            $user                        = array(
                'email'                         => $email,
                'password'                      => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'name'                          => $this->input->post('name', TRUE),
                'phone'                         => $this->input->post('phone', TRUE),
                'role_id'                       => $this->input->post('role_id'),
                'created_at'                    => date('Y-m-d H:i:s')
            );

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $user['avatar']                 = $this->do_upload();
            }

            $this->M_admin_user->doInsertUserData($user);

            $this->session->set_flashdata('success', 'Data successfully saved');
            redirect($this->route);
        } catch (Throwable $th) {
            if ($th->getCode() != 405)
                $this->session->set_flashdata('error', $th->getMessage());

            return $this->create();
        }
    }

    public function edit($id = null)
    {
        if (!isHaveAbility($this->permission . 'update')) show_404();

        if (!$id) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = 'Edit ' . $this->pagetitle;
        $data['subheaders']             = ['User' => base_url($this->route . '.index'), 'Edit' => basename($this->route . '/edit/' . $id)];
        $data['route']                  = $this->route;

        $data['roles']                  = $this->M_admin_user->doGetRoles();
        $data['record']                 = $this->M_admin_user->doGetFirstUserData($id);
        if (!$data['record']) show_404();

        $this->template->load($this->namespace . 'edit', $data);
    }

    public function update($id = null)
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        if (!$id) show_404();

        try {
            $password                   = $this->input->post('password');

            $this->form_validation->set_rules('role_id', 'Role', 'required');
            if ($password != '') {
                $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            }

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors(), 405);
            }

            $record            = $this->M_admin_user->doGetFirstUserData($id);
            if (!$record) redirect('/client/errors/error_404');

            $user                        = array(
                'name'                          => $this->input->post('name', TRUE),
                'phone'                         => $this->input->post('phone', TRUE),
                'role_id'                       => $this->input->post('role_id'),
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

            $this->M_admin_user->doUpdateUserData($id, $user);

            $this->session->set_flashdata('success', 'Data successfully updated');
            redirect($this->route);
        } catch (Throwable $th) {

            if ($th->getCode() != 405)
                $this->session->set_flashdata('error', $th->getMessage());

            return $this->edit($id);
        }
    }

    public function delete($id = null)
    {
        if (!isHaveAbility($this->permission . 'delete')) show_404();

        if (!$id) show_404();

        $client            = $this->M_admin_user->doGetFirstUserData($id);
        if (!$client) redirect('/client/errors/error_404');

        if ($client->avatar) {
            $full_path = FCPATH . $client->avatar;
            if (file_exists($full_path)) @unlink($full_path);
        }

        $this->M_admin_user->doDeleteUserData($id);

        $this->session->set_flashdata('success', 'Data successfully deleted');
        redirect($this->route);
    }
}
