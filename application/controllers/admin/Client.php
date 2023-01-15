<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{
	private $namespace    = 'pages/admin/client/client_';
	private $route        = 'admin/client';
	private $pagetitle    = 'Client';
	private $extend_view  = 'layouts/admin';
	private $table_id     = 'kt_clients_table';
	private $permission   = 'client:';

	public function __construct()
	{
		parent::__construct();

		if (!getUserLogin()) redirect('admin/auth/login');

		$this->load->model('M_admin_client');
	}

	public function index()
	{
		if (!isHaveAbility($this->permission . 'read')) show_404();

		$data['extend_view']    		= $this->extend_view;
		$data['pagetitle']      		= $this->pagetitle;
		$data['subheaders']     		= ['Client' => base_url($this->route . '.index')];
		$data['route']					= $this->route;
		$data['table_id']				= $this->table_id;
		$data['permission']				= $this->permission;

		$this->template->load($this->namespace . 'index', $data);
	}

	public function paginate()
	{
		if (!isHaveAbility($this->permission . 'read')) show_404();

		try {
			$search						= $this->input->post('search', TRUE)['value'];
			$offset						= $this->input->post('start', TRUE);
			$limit						= $this->input->post('length', TRUE);
			$draw						= $this->input->post('draw', TRUE);
			$sort_field_id				= $this->input->post('order[0][column]', TRUE);
			$sort_field					= $this->input->post("columns[$sort_field_id][data]");
			$sort_dir					= $this->input->post('order[0][dir]', TRUE);

			$items						= $this->M_admin_client->doGetClientData($search, $sort_field, $sort_dir, $offset, $limit);

			$datarow['draw']			= (int) $draw;
			$datarow['recordsTotal'] 	= $this->M_admin_client->doCountClientData();
			$datarow['recordsFiltered']	= $this->M_admin_client->doCountClientData($search);
			$datarow['data']			= $items;
		} catch (Throwable $th) {
			$datarow['draw']			= 0;
			$datarow['recordsTotal'] 	= 0;
			$datarow['recordsFiltered']	= 0;
			$datarow['data']			= [];
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

		$data['extend_view']    		= $this->extend_view;
		$data['pagetitle']      		= 'Add ' . $this->pagetitle;
		$data['subheaders']     		= ['Index' => base_url($this->route . '.index')];
		$data['route']					= $this->route;
		$data['subscriptions']			= $this->M_admin_client->doGetSubscriptions();

		$this->template->load($this->namespace . 'create', $data);
	}

	private function do_upload()
	{
		$file_name 						= str_replace(' ', '_', $_FILES['file']['name']);
		$config['upload_path'] 			= './public/uploads/clients/';
		$config['allowed_types'] 		= 'gif|jpg|png|jpeg';
		$config['max_size']    			= '2000';
		$file_name 						= rand(00, 99) . '_' . date('YmdHis') . '_' . $file_name;
		$config['file_name'] 			= $file_name; //new file name

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ($this->upload->do_upload('file')) {
			return '/public/uploads/clients/' . $this->upload->data()['file_name'];
		}

		$this->session->set_flashdata('msg', $this->upload->display_errors());
		redirect($this->route, 'refresh');
	}

	public function store()
	{
		if (!isHaveAbility($this->permission . 'create')) show_404();

		try {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[mst_clients.email]');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
			$this->form_validation->set_rules('subscription_plan_id', 'Subscription', 'required');

			if ($this->form_validation->run() == FALSE) {
				throw new Exception(validation_errors(), 405);
			}

			$email						= $this->input->post('email', TRUE);

			$subscription_id 			= $this->input->post('subscription_plan_id', TRUE);
			$current_timestamp			= date('Y-m-d H:i:s');
			$subscription_ends_at		= null;
			$subscription 				= $this->M_admin_client->doGetSubscriptionById($subscription_id);

			if (!$subscription) throw new Exception('Subscription is not valid');

			if ($subscription->periode) {
				$subscription_ends_at	= date('Y-m-d H:i:s', strtotime("+ $subscription->periode years"));
			}

			$client						= array(
				'email'						=> $email,
				'password'					=> password_hash($this->input->post('password'), PASSWORD_BCRYPT),
				'name'						=> $this->input->post('name', TRUE),
				'position'					=> $this->input->post('position', TRUE),
				'account_type'				=> ACCOUNT_TYPE_EMAIL,
				'subscription_plan_id'		=> $subscription_id,
				'subscribed_at'				=> $current_timestamp,
				'subscription_ends_at'		=> $subscription_ends_at,
				'created_at'				=> date('Y-m-d H:i:s')
			);

			if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
				$client['image'] 		= $this->do_upload();
			}

			$client_id 					= $this->M_admin_client->doInsertClientData($client);

			// $history					= array(
			// 	'order_id'					=> '#0',
			// 	'client_id'					=> $client_id,
			// 	'client_email'				=> $email,
			// 	'subscription_plan_id'		=> $subscription_id,
			// 	'subscription_plan_name'	=> $subscription->name,
			// 	'subscribed_at'				=> $current_timestamp,
			// 	'subscription_ends_at'		=> $subscription_ends_at,
			// 	'subscription_total'		=> $subscription->total_price,
			// 	'status_id'					=> TRANSACTION_STATUS_SUCCESS
			// );
			// $this->M_admin_client->doInsertSubscriptionHistory($history);

			$this->session->set_flashdata('success', 'Data successfully saved');
			redirect($this->route);
		} catch (Throwable $th) {
			if ($th->getCode() != 405)
				$this->session->set_flashdata('error', $th->getMessage());

			return $this->create();
		}
	}

	public function profile($id)
	{
		if (!isHaveAbility($this->permission . 'read')) show_404();

		if (!$id) show_404();

		$data['extend_view']    		= $this->extend_view;
		$data['route']					= $this->route;
		$data['pagetitle']      		= $this->pagetitle . ' Detail';
		$data['subheaders']     		= ['client' => base_url($this->route . '.index'), 'detail' => null];
		$data['permission']				= $this->permission;

		$data['id']						= $id;
		$data['client']					= $this->M_admin_client->doGetFirstClientData($id);
		if (!$data['client']) redirect('/client/errors/error_404');

		$data['view']					= $this->load->view($this->namespace . 'profile', $data, true);
		$this->template->load($this->namespace . 'overview', $data);
	}

	public function subscription($id = null)
	{
		if (!isHaveAbility($this->permission . 'read')) show_404();

		if (!$id) show_404();

		$data['extend_view']    		= $this->extend_view;
		$data['route']					= $this->route;
		$data['pagetitle']      		= $this->pagetitle . ' History';
		$data['subheaders']     		= ['client' => base_url($this->route . '.index'), 'detail' => null];
		$data['permission']				= $this->permission;
		$data['id']						= $id;
		$data['view']					= $this->load->view($this->namespace . 'subscription', $data, true);


		$data['client']					= $this->M_admin_client->doGetFirstClientData($id);
		if (!$data['client']) redirect('/client/errors/error_404');

		$this->template->load($this->namespace . 'overview', $data);
	}

	public function subscription_paginate($id = null)
	{
		if (!isHaveAbility($this->permission . 'read')) show_404();

		if (!$id) show_404();

		try {
			$search						= $this->input->post('search[value]', TRUE);
			$offset						= $this->input->post('start', TRUE);
			$limit						= $this->input->post('length', TRUE);
			$draw						= $this->input->post('draw', TRUE);
			$sort_field_id				= $this->input->post('order[0][column]', TRUE);
			$sort_field					= $this->input->post("columns[$sort_field_id][data]");
			$sort_dir					= $this->input->post('order[0][dir]', TRUE);

			$items						= $this->M_admin_client->doGetSubscriptionHistory($id, $search, $sort_field, $sort_dir, $offset, $limit);

			$datarow['draw']			= (int) $draw;
			$datarow['recordsTotal'] 	= $this->M_admin_client->doCountSubscriptionHistory($id);
			$datarow['recordsFiltered']	= $this->M_admin_client->doCountSubscriptionHistory($id, $search);
			$datarow['data']			= $items;
		} catch (Throwable $th) {
			$datarow['draw']			= 0;
			$datarow['recordsTotal'] 	= 0;
			$datarow['recordsFiltered']	= 0;
			echo $th->getMessage();
			exit;
			$datarow['data']			= [];
		} finally {
			$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode($datarow));
		}
	}

	public function edit($id = null)
	{
		if (!isHaveAbility($this->permission . 'update')) show_404();

		if (!$id) show_404();

		$data['extend_view']    		= $this->extend_view;
		$data['pagetitle']      		= 'Edit ' . $this->pagetitle;
		$data['subheaders']     		= ['Index' => base_url($this->route . '.index')];
		$data['route']					= $this->route;

		$data['subscriptions']			= $this->M_admin_client->doGetSubscriptions();
		$data['record']					= $this->M_admin_client->doGetFirstClientData($id);
		if (!$data['record']) show_404();

		$this->template->load($this->namespace . 'edit', $data);
	}

	public function update($id = null)
	{
		if (!isHaveAbility($this->permission . 'read')) show_404();

		if (!$id) show_404();

		try {
			$password					= $this->input->post('password');

			$this->form_validation->set_rules('subscription_plan_id', 'Subscription', 'required');
			if ($password != '') {
				$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
			}

			if ($this->form_validation->run() == FALSE) {
				throw new Exception(validation_errors(), 405);
			}

			$record			= $this->M_admin_client->doGetFirstClientData($id);
			if (!$record) redirect('/client/errors/error_404');

			$client						= array(
				'name'						=> $this->input->post('name', TRUE),
				'position'					=> $this->input->post('position', TRUE),
				'account_type'				=> ACCOUNT_TYPE_EMAIL,
				'updated_at'				=> date('Y-m-d H:i:s')
			);

			$subscription_id 			= $this->input->post('subscription_plan_id', TRUE);
			$current_timestamp			= date('Y-m-d H:i:s');
			$subscription_ends_at		= null;
			$subscription 				= $this->M_admin_client->doGetSubscriptionById($subscription_id);

			if (!$subscription) throw new Exception('Subscription is not valid');

			if ($subscription->periode) {
				$subscription_ends_at	= date('Y-m-d H:i:s', strtotime("+ $subscription->periode years"));
			}

			if ($record->subscription_plan_id !== $subscription_id) {
				$client['subscription_plan_id']		= $subscription_id;
				$client['subscribed_at']			= $current_timestamp;
				$client['subscription_ends_at']		= $subscription_ends_at;

				// $history					= array(
				// 	'order_id'					=> '#0',
				// 	'client_id'					=> $id,
				// 	'client_email'				=> $record->email,
				// 	'subscription_plan_id'		=> $subscription_id,
				// 	'subscription_plan_name'	=> $subscription->name,
				// 	'subscribed_at'				=> $current_timestamp,
				// 	'subscription_ends_at'		=> $subscription_ends_at,
				// 	'subscription_total'		=> $subscription->total_price,
				// 	'status_id'					=> TRANSACTION_STATUS_SUCCESS
				// );
				// $this->M_admin_client->doInsertSubscriptionHistory($history);
			}

			if ($password != '') {
				$client['password']			= password_hash($password, PASSWORD_BCRYPT);
			}

			if (!empty($_FILES['file']) && $_FILES['file']['size'] > 0) {
				$client['image'] = $this->do_upload();

				if ($record->image) {
					$full_path = FCPATH . $record->image;
					if (file_exists($full_path)) @unlink($full_path);
				}
			}

			$this->M_admin_client->doUpdateClientData($id, $client);

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

		$client			= $this->M_admin_client->doGetFirstClientData($id);
		if (!$client) redirect('/client/errors/error_404');

		if ($client->image) {
			$full_path = FCPATH . $client->image;
			if (file_exists($full_path)) @unlink($full_path);
		}

		$this->M_admin_client->doDeleteClientData($id);

		$this->session->set_flashdata('success', 'Data successfully deleted');
		redirect($this->route);
	}
}
