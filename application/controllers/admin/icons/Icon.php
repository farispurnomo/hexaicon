<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class Icon extends CI_Controller
{
    private $namespace    = 'pages/admin/icons/icon/icon_';
    private $route        = 'admin/icons/icon';
    private $pagetitle    = 'Icon';
    private $extend_view  = 'layouts/admin';
    private $table_id     = 'kt_icons_table';
    private $permission   = 'icon:';

    public function __construct()
    {
        parent::__construct();

        if (!getUserLogin()) redirect('admin/auth/login');

        $this->load->model('M_admin_icon');
    }

    public function index()
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = $this->pagetitle;
        $data['subheaders']             = ['Icon' => base_url($this->route . '.index')];
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

            $items                      = $this->M_admin_icon->doGetIconData($search, $sort_field, $sort_dir, $offset, $limit);

            $datarow['draw']            = (int) $draw;
            $datarow['recordsTotal']    = $this->M_admin_icon->doCountIconData();
            $datarow['recordsFiltered'] = $this->M_admin_icon->doCountIconData($search);
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
        $data['subheaders']             = ['Icon' => base_url($this->route . '.index'), 'Create' => base_url($this->route . '/create')];
        $data['route']                  = $this->route;
        $data['categories']             = $this->M_admin_icon->doGetCategories();
        $data['styles']                 = $this->M_admin_icon->doGetStylesData();
        $data['sets']                   = $this->M_admin_icon->doGetSetsData();
        $data['subscriptions']          = $this->M_admin_icon->doGetSubscriptions();

        $this->template->load($this->namespace . 'create', $data);
    }

    private function do_upload()
    {
        $file_name                      = str_replace(' ', '_', $_FILES['file']['name']);
        $config['upload_path']          = './public/uploads/icons/';
        $config['allowed_types']        = 'svg';
        $config['max_size']             = '2000';
        $file_name                      = rand(00, 99) . '_' . date('YmdHis') . '_' . $file_name;
        $config['file_name']            = $file_name; //new file name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            return '/public/uploads/icons/' . $this->upload->data()['file_name'];
        }

        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect($_SERVER['HTTP_REFERER'], 'refresh');
    }

    public function store()
    {
        if (!isHaveAbility($this->permission . 'create')) show_404();

        try {
            $this->form_validation->set_rules('name', 'Name', 'required');

            if (empty($_FILES['file']['name'])) {
                $this->form_validation->set_rules('file', 'Image', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors(), 405);
            }

            $icon                       = array(
                'name'                          => $this->input->post('name', TRUE),
                'number_of_downloads'           => 0,
                'created_at'                    => date('Y-m-d H:i:s')
            );

            $set_id                     = $this->input->post('set_id', TRUE);
            $style_id                   = $this->input->post('style_id', TRUE);
            $category_id                = $this->input->post('category_id', TRUE);

            if ($set_id != '') {
                $set                    = $this->M_admin_icon->doGetSetById($set_id);
                if (!$set) throw new Exception('Icon Set is not valid');

                $icon['set_id']         = $set_id;
            }

            if ($style_id != '') {
                $style                  = $this->M_admin_icon->doGetStyleById($style_id);
                if (!$style) throw new Exception('Icon Style is not valid');

                $icon['style_id']       = $style_id;
            }

            if ($style_id != '') {
                $category                   = $this->M_admin_icon->doGetCategoryById($category_id);
                if (!$category) throw new Exception('Icon Category is not valid');

                $icon['category_id']    = $category_id;
            }

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $icon['image']                 = $this->do_upload();
            }

            $this->db->trans_start();
            $icon_id                    = $this->M_admin_icon->doInsertIconData($icon);

            $subscriptions              = array();
            $subscription_ids           = $this->input->post('subscriptions');
            foreach ($subscription_ids as $subscription_id) {
                $subscriptions[]        = array(
                    'subscription_plan_id'  => $subscription_id,
                    'icon_id'               => $icon_id
                );
            }
            if (!empty($subscriptions)) {
                $this->M_admin_icon->doInsertIconSubscription($subscriptions);
            }

            $formats                        = array('svg', 'png');
            foreach ($formats as $format) {

                $record                     = array(
                    'icon_id'                   => $icon_id,
                    'name'                      => $format
                );

                $format_id                  = $this->M_admin_icon->doInsertIconFormat($record);

                $records                    = [];
                $format_subscriptions       = $this->input->post("{$format}[]");
                foreach ($format_subscriptions as $format_subscription) {
                    $records[]              = array(
                        'icon_format_id'            => $format_id,
                        'subscription_plan_id'      => $format_subscription
                    );
                }

                if (!empty($records)) {
                    $this->M_admin_icon->doInsertIconFormatSubscription($records);
                }
            }
            $this->db->trans_complete();

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
        $data['subheaders']             = ['Index' => base_url($this->route . '.index')];
        $data['route']                  = $this->route;

        $data['categories']             = $this->M_admin_icon->doGetCategories();
        $data['styles']                 = $this->M_admin_icon->doGetStylesData();
        $data['sets']                   = $this->M_admin_icon->doGetSetsData();
        $data['subscriptions']          = $this->M_admin_icon->doGetSubscriptions();
        $data['record']                 = $this->M_admin_icon->doGetFirstIconData($id);
        if (!$data['record']) show_404();

        $this->template->load($this->namespace . 'edit', $data);
    }

    public function update($id = null)
    {
        if (!isHaveAbility($this->permission . 'read')) show_404();

        if (!$id) show_404();

        try {
            $this->form_validation->set_rules('name', 'Name', 'required');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors(), 405);
            }

            $record            = $this->M_admin_icon->doGetFirstIconData($id);
            if (!$record) redirect('/client/errors/error_404');

            $icon                        = array(
                'name'                          => $this->input->post('name', TRUE),
                'updated_at'                    => date('Y-m-d H:i:s')
            );

            $set_id                     = $this->input->post('set_id', TRUE);
            $style_id                   = $this->input->post('style_id', TRUE);
            $category_id                = $this->input->post('category_id', TRUE);

            if ($set_id != '') {
                $set                    = $this->M_admin_icon->doGetSetById($set_id);
                if (!$set) throw new Exception('Icon Set is not valid');

                $icon['set_id']         = $set_id;
            }

            if ($style_id != '') {
                $style                  = $this->M_admin_icon->doGetStyleById($style_id);
                if (!$style) throw new Exception('Icon Style is not valid');

                $icon['style_id']       = $style_id;
            }

            if ($style_id != '') {
                $category                   = $this->M_admin_icon->doGetCategoryById($category_id);
                if (!$category) throw new Exception('Icon Category is not valid');

                $icon['category_id']    = $category_id;
            }

            if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
                $icon['image']           = $this->do_upload();

                if ($record->image) {
                    $full_path          = FCPATH . $record->image;
                    if (file_exists($full_path)) @unlink($full_path);
                }
            }

            $this->db->trans_start();
            $this->M_admin_icon->doUpdateIconData($id, $icon);

            $this->M_admin_icon->doDeleteIconSubscription($id);
            $subscriptions              = array();
            $subscription_ids           = $this->input->post('subscriptions');
            if (!empty($subscription_ids)) {
                foreach ($subscription_ids as $subscription_id) {
                    $subscriptions[]        = array(
                        'subscription_plan_id'  => $subscription_id,
                        'icon_id'               => $id
                    );
                }
            }
            if (!empty($subscriptions)) {
                $this->M_admin_icon->doInsertIconSubscription($subscriptions);
            }

            $this->M_admin_icon->doDeleteIconFormat($id);

            $formats                        = array('svg', 'png');
            foreach ($formats as $format) {

                $record                     = array(
                    'icon_id'                   => $id,
                    'name'                      => $format
                );

                $format_id                  = $this->M_admin_icon->doInsertIconFormat($record);

                $records                    = [];
                $format_subscriptions       = $this->input->post("{$format}[]");
                foreach ($format_subscriptions as $format_subscription) {
                    $records[]              = array(
                        'icon_format_id'            => $format_id,
                        'subscription_plan_id'      => $format_subscription
                    );
                }

                if (!empty($records)) {
                    $this->M_admin_icon->doInsertIconFormatSubscription($records);
                }
            }
            $this->db->trans_complete();

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

        $client            = $this->M_admin_icon->doGetFirstIconData($id);
        if (!$client) redirect('/client/errors/error_404');

        if ($client->image) {
            $full_path = FCPATH . $client->image;
            if (file_exists($full_path)) @unlink($full_path);
        }

        $this->M_admin_icon->doDeleteIconData($id);

        $this->session->set_flashdata('success', 'Data successfully deleted');
        redirect($this->route);
    }
}
