<?php defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
    private $namespace    = 'pages/admin/icons/category/category_';
    private $route        = 'admin/icons/category';
    private $pagetitle    = 'Icon Category';
    private $extend_view  = 'layouts/admin';
    private $table_id     = 'kt_icon_categorys_table';
    private $permission   = 'icon_category:';

    public function __construct()
    {
        parent::__construct();

        if (!getUserLogin()) redirect('admin/auth/login');

        $this->load->model('M_admin_icon_category');
    }

    public function index()
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = $this->pagetitle;
        $data['subheaders']             = ['Icon Category' => base_url($this->route . '.index')];
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

            $items                      = $this->M_admin_icon_category->doGetIconCategoryData($search, $sort_field, $sort_dir, $offset, $limit);

            $datarow['draw']            = (int) $draw;
            $datarow['recordsTotal']    = $this->M_admin_icon_category->doCountIconCategoryData();
            $datarow['recordsFiltered'] = $this->M_admin_icon_category->doCountIconCategoryData($search);
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

    private function do_upload()
    {
        $file_name                      = str_replace(' ', '_', $_FILES['file']['name']);
        $config['upload_path']          = './public/uploads/icon_categories/';
        //$config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = '2000';
        $file_name                      = rand(00, 99) . '_' . date('YmdHis') . '_' . $file_name;
        $config['file_name']            = $file_name; //new file name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            return '/public/uploads/icon_categories/' . $this->upload->data()['file_name'];
        }

        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
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

            $category                   = array(
                'name'                          => $this->input->post('name', TRUE),
                'description'                   => $this->input->post('description', TRUE),
                'created_at'                    => date('Y-m-d H:i:s')
            );

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $category['image']      = $this->do_upload();
            }

            $this->M_admin_icon_category->doInsertIconCategoryData($category);

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

        $data['record']                 = $this->M_admin_icon_category->doGetFirstIconCategoryData($id);
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

            $record                     = $this->M_admin_icon_category->doGetFirstIconCategoryData($id);
            if (!$record) redirect('/client/errors/error_404');

            $icon_style                 = array(
                'name'                          => $this->input->post('name', TRUE),
                'description'                   => $this->input->post('description', TRUE),
                'updated_at'                    => date('Y-m-d H:i:s')
            );

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $icon_style['image'] = $this->do_upload();

                if ($record->image) {
                    $full_path = FCPATH . $record->image;
                    if (file_exists($full_path)) @unlink($full_path);
                }
            }

            $this->M_admin_icon_category->doUpdateIconCategoryData($id, $icon_style);

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

        $category                       = $this->M_admin_icon_category->doGetFirstIconCategoryData($id);
        if (!$category) redirect('/client/errors/error_404');

        if ($category->image) {
            $full_path = FCPATH . $category->image;
            if (file_exists($full_path)) @unlink($full_path);
        }

        $this->M_admin_icon_category->doDeleteIconCategoryData($id);

        $this->session->set_flashdata('success', 'Data successfully deleted');
        redirect($this->route);
    }
}
