<?php
defined('BASEPATH') or exit('No direct script access allowed');

class subscription extends CI_Controller
{
    private $namespace    = 'pages/admin/subscription/subscription_';
    private $route        = 'admin/subscription';
    private $pagetitle    = 'Subscription';
    private $extend_view  = 'layouts/admin';
    private $table_id     = 'kt_subscriptions_table';

    public function __construct()
    {
        parent::__construct();

        if (!getUserLogin()) redirect('admin/auth/login');

        $this->load->model('M_admin_subscription');
    }

    public function index()
    {
        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = $this->pagetitle;
        $data['subheaders']             = ['Subscription' => base_url($this->route . '.index')];
        $data['route']                  = $this->route;
        $data['table_id']               = $this->table_id;

        $this->template->load($this->namespace . 'index', $data);
    }

    public function paginate()
    {
        try {
            $search                     = $this->input->post('search', TRUE)['value'];
            $offset                     = $this->input->post('start', TRUE);
            $limit                      = $this->input->post('length', TRUE);
            $draw                       = $this->input->post('draw', TRUE);
            $sort_field_id              = $this->input->post('order[0][column]', TRUE);
            $sort_field                 = $this->input->post("columns[$sort_field_id][data]");
            $sort_dir                   = $this->input->post('order[0][dir]', TRUE);

            $items                      = $this->M_admin_subscription->doGetSubscriptionData($search, $sort_field, $sort_dir, $offset, $limit);

            $datarow['draw']            = (int) $draw;
            $datarow['recordsTotal']    = $this->M_admin_subscription->doCountSubscriptionData();
            $datarow['recordsFiltered'] = $this->M_admin_subscription->doCountSubscriptionData($search);
            $datarow['data']            = $items;
        } catch (Throwable $th) {
            $datarow['draw']            = 0;
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
        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = 'Add ' . $this->pagetitle;
        $data['subheaders']             = ['Subscription' => base_url($this->route . '.index'), 'Create' => basename($this->route . '/create')];
        $data['route']                  = $this->route;

        $this->template->load($this->namespace . 'create', $data);
    }

    public function store()
    {
        try {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors());
            }

            $subscription               = array(
                'name'                      => $this->input->post('name', TRUE),
                'description'               => $this->input->post('description', TRUE),
                'price'                     => $this->input->post('price', TRUE),
                'items'                     => $this->input->post('items')
            );

            $this->M_admin_subscription->doInsertSubscriptionData($subscription);

            $datarow['status']  = 200;
            $datarow['msg']     = 'success';
        } catch (Throwable $th) {

            $datarow['status']  = $th->getCode();
            $datarow['msg']     = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($datarow));
        }
    }

    public function edit($id = null)
    {
        if (!$id) show_404();

        $data['extend_view']            = $this->extend_view;
        $data['pagetitle']              = 'Edit ' . $this->pagetitle;
        $data['subheaders']             = ['Subscription' => base_url($this->route . '.index'), 'Edit' => basename($this->route . '/edit/' . $id)];
        $data['route']                  = $this->route;
        $data['id']                     = $id;

        $data['record']                 = $this->M_admin_subscription->doGetFirstSubscriptionData($id);
        if (!$data['record']) show_404();

        $this->template->load($this->namespace . 'edit', $data);
    }

    public function update($id = null)
    {
        if (!$id) show_404();

        try {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors());
            }

            $subscription                 = array(
                'name'                      => $this->input->post('name', TRUE),
                'description'               => $this->input->post('description', TRUE),
                'price'                     => $this->input->post('price', TRUE),
                'items'                     => $this->input->post('items')
            );

            $this->M_admin_subscription->doUpdateSubscriptionData($id, $subscription);

            $datarow['status']  = 200;
            $datarow['msg']     = 'success';
        } catch (Throwable $th) {

            $datarow['status']  = $th->getCode();
            $datarow['msg']     = $th->getMessage();
        } finally {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($datarow));
        }
    }

    public function delete($id = null)
    {
        if (!$id) show_404();

        $this->M_admin_subscription->doDeleteSubscriptionData($id);

        $this->session->set_flashdata('success', 'Data successfully deleted');
        redirect($this->route);
    }
}
