<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_client extends CI_Model
{
	private $table_clients				= 'mst_clients';
	private $table_subscriptions		= 'mst_subscription_plans';
	private $table_log_subscriptions	= 'log_subscriptions';
	private $table_status_transactions  = 'mst_status_transactions';

	public function doGetClientData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
	{
		$this->db->select("$this->table_clients.*, $this->table_subscriptions.name AS subscription_name")
			->from($this->table_clients)
			->join($this->table_subscriptions, "$this->table_subscriptions.id=$this->table_clients.subscription_plan_id");

		if ($search != '') {
			$this->db
				->group_start()
				->like("$this->table_clients.name", $search)
				->or_like("$this->table_clients.email", $search)
				->or_like("$this->table_clients.position", $search)
				->or_like("$this->table_subscriptions.name", $search)
				->group_end();
		}

		$this->db->order_by($sort_field, $sort_dir);
		$this->db->limit($limit, $offset);

		$clients 	= $this->db->get()->result();
		$clients 	= array_map(function ($client) {
			$path               			= ($client->image ? $client->image : '/public/src/media/avatars/blank.png');
			$client->url_image  			= base_url($path);

			$client->subscribed_at			= (!$client->subscribed_at) ? '' : date('Y-m-d', strtotime($client->subscribed_at));
			$client->subscription_ends_at	= (!$client->subscription_ends_at) ? '' : date('Y-m-d', strtotime($client->subscription_ends_at));

			return $client;
		}, $clients);
		return $clients;
	}

	public function doGetSubscriptions()
	{
		return $this->db
			->from($this->table_subscriptions)
			->get()
			->result();
	}

	public function doGetSubscriptionById($id)
	{
		return $this->db
			->from($this->table_subscriptions)
			->where('id', $id)
			->get()
			->row();
	}

	public function doGetFirstClientData($id)
	{
		$client = $this->db->select("$this->table_clients.*, $this->table_subscriptions.name AS subscription_name")
			->from($this->table_clients)
			->join($this->table_subscriptions, "$this->table_subscriptions.id=$this->table_clients.subscription_plan_id")
			->where("$this->table_clients.id", $id)
			->get()
			->row();

		if ($client) {
			$path               			= ($client->image ? $client->image : '/public/src/media/avatars/blank.png');
			$client->url_image  			= base_url($path);

			return $client;
		}
	}

	public function doCountClientData($search = '')
	{
		$this->db
			->from($this->table_clients)
			->join($this->table_subscriptions, "$this->table_subscriptions.id=$this->table_clients.subscription_plan_id");
		if ($search != '') {
			$this->db
				->group_start()
				->like("$this->table_clients.name", $search)
				->or_like("$this->table_clients.email", $search)
				->or_like("$this->table_clients.position", $search)
				->or_like("$this->table_subscriptions.name", $search)
				->group_end();
		}

		return $this->db->count_all_results();
	}

	public function doInsertClientData(array $data)
	{
		$this->db->insert($this->table_clients, $data);
		return $this->db->insert_id();
	}

	public function doUpdateClientData($id, array $data)
	{
		$this->db
			->where('id', $id)
			->update($this->table_clients, $data);
	}

	public function doDeleteClientData($id)
	{
		return $this->db
			->where('id', $id)
			->delete($this->table_clients);
	}

	public function doGetSubscriptionHistory($client_id, string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
	{
		$this->db
			->select("
				$this->table_log_subscriptions.*,
                $this->table_status_transactions.name AS status_name
			")
			->from($this->table_log_subscriptions)
			->join($this->table_status_transactions, "$this->table_status_transactions.id=$this->table_log_subscriptions.status_id")
			->where('client_id', $client_id);

		if ($search != '') {
			$this->db
				->like('order_id', $search)
				->or_like('subscription_plan_name', $search)
				->or_like('subscription_total', $search);
		}

		$this->db->order_by($sort_field, $sort_dir);
		$this->db->limit($limit, $offset);

		return $this->db->get()->result();
	}

	public function doCountSubscriptionHistory($client_id, $search = '')
	{
		$this->db
			->from($this->table_log_subscriptions)
			->join($this->table_status_transactions, "$this->table_status_transactions.id=$this->table_log_subscriptions.status_id")
			->where('client_id', $client_id);

		if ($search != '') {
			$this->db
				->like('order_id', $search)
				->or_like('subscription_plan_name', $search)
				->or_like('subscription_total', $search);
		}

		return $this->db->count_all_results();
	}

	public function doInsertSubscriptionHistory(array $data)
	{
		$this->db->insert($this->table_log_subscriptions, $data);
		return $this->db->affected_rows();
	}
}
