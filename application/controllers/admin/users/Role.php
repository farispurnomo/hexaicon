<?php defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    private $namespace    = 'pages/admin/users/role/role_';
    private $route        = 'admin/users/role';
    private $pagetitle    = 'Role';
    private $extend_view  = 'layouts/admin';
    private $table_id     = 'kt_roles_table';
    private $permission   = 'role:';

    public function __construct()
    {
        parent::__construct();

        if (!getUserLogin()) redirect('admin/auth/login');

        $this->load->model('M_admin_role');
    }

    public function index()
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = $this->pagetitle;
        $data['subheaders']             = ['Role' => base_url($this->route . '.index')];
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

            $items                      = $this->M_admin_role->doGetRoleData($search, $sort_field, $sort_dir, $offset, $limit);

            $datarow['draw']            = (int) $draw;
            $datarow['recordsTotal']    = $this->M_admin_role->doCountRoleData();
            $datarow['recordsFiltered'] = $this->M_admin_role->doCountRoleData($search);
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
        $data['subheaders']             = ['Role' => base_url($this->route . '.index'), 'Create' => base_url($this->route . '/create')];
        $data['route']                  = $this->route;

        $this->template->load($this->namespace . 'create', $data);
    }

    public function store()
    {
        if (!isHaveAbility($this->permission . 'create')) show_404();

        try {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors(), 405);
            }

            $role                        = array(
                'name'                          => $this->input->post('name', TRUE),
                'description'                   => $this->input->post('description', TRUE),
                'created_at'                    => date('Y-m-d H:i:s')
            );

            $this->M_admin_role->doInsertRoleData($role);

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
        $data['subheaders']             = ['Role' => base_url($this->route . '.index'), 'Edit' => basename($this->route . '/edit/' . $id)];
        $data['route']                  = $this->route;

        $data['record']                 = $this->M_admin_role->doGetFirstRoleData($id);
        if (!$data['record']) show_404();

        $this->template->load($this->namespace . 'edit', $data);
    }

    public function update($id = null)
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        if (!$id) show_404();

        try {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors(), 405);
            }

            $record            = $this->M_admin_role->doGetFirstRoleData($id);
            if (!$record) redirect('/client/errors/error_404');

            $role                        = array(
                'name'                          => $this->input->post('name', TRUE),
                'description'                   => $this->input->post('description', TRUE),
                'updated_at'                    => date('Y-m-d H:i:s')
            );

            $this->M_admin_role->doUpdateRoleData($id, $role);

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

        $this->M_admin_role->doDeleteRoleData($id);

        $this->session->set_flashdata('success', 'Data successfully deleted');
        redirect($this->route);
    }

    public function permission($id = null)
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        if (!$id) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['subheaders']             = ['Role' => base_url($this->route . '.index'), 'Permission' => basename($this->route . '/permission/' . $id)];
        $data['route']                  = $this->route;

        $data['record']                 = $this->M_admin_role->doGetFirstRoleData($id);
        if (!$data['record']) show_404();

        $data['pagetitle']              = $this->pagetitle . ' ' . $data['record']->name . ' Permissions';

        $data['menus']                  = $this->M_admin_role->doGetTreeviewMenu($id);

        $this->template->load($this->namespace . 'permission', $data);
    }

    public function permission_store($id = null)
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        if (!$id) show_404();

        $privileges                     = $this->input->post('privileges');
        $this->M_admin_role->doUpdatePermissionRole($id, $privileges);

        $this->session->set_flashdata('success', 'Permission successfully updated');
        redirect($this->route);
    }
}
