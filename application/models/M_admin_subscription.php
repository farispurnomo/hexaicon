<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_Subscription extends CI_Model
{
    private $table_clients              = 'mst_clients';
    private $table_subscription         = 'mst_subscription_plans';
    private $table_subscription_items   = 'mst_subscription_plan_items';

    public function doGetSubscriptionData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->select("
                $this->table_subscription.*,
                (
                    SELECT 
                        COUNT(*)
                    FROM 
                        $this->table_clients 
                    WHERE 
                        $this->table_clients.subscription_plan_id=$this->table_subscription.id 
                        AND (
                            $this->table_clients.subscription_ends_at >= current_timestamp() OR 
                            $this->table_clients.subscription_ends_at IS NULL
                        )
                ) AS active_users
            ")
            ->from($this->table_subscription);

        if ($search != '') {
            $this->db->like('name', $search)
                ->or_like('description', $search)
                ->or_like('total_price', $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        $subscriptions  = $this->db->get()->result();

        $total_users    = $this->db
            ->from($this->table_clients)
            ->count_all_results();

        foreach ($subscriptions as $subscription) {
            $active_user_percentage = 0;
            if ($total_users > 0) {
                $active_user_percentage = $subscription->active_users / $total_users * 100;
            }
            $subscription->active_user_percentage = round($active_user_percentage);
        }

        return $subscriptions;
    }

    public function doGetFirstSubscriptionData($id)
    {
        $subscription   = $this->db
            ->from($this->table_subscription)
            ->where('id', $id)
            ->get()
            ->row();

        if ($subscription) {
            $subscription->items    = $this->db
                ->from($this->table_subscription_items)
                ->where('subscription_plan_id', $id)
                ->get()
                ->result();
        }

        return $subscription;
    }

    public function doCountSubscriptionData($search = '')
    {
        $this->db->from($this->table_subscription);

        if ($search != '') {
            $this->db->like('name', $search)
                ->or_like('description', $search)
                ->or_like('total_price');
        }

        return $this->db->count_all_results();
    }

    public function doInsertSubscriptionData(array $data)
    {
        $this->db->insert($this->table_subscription, [
            'name'          => $data['name'],
            'description'   => $data['description'],
            'total_price'   => $data['price']
        ]);
        $subscription_id    = $this->db->insert_id();

        if (isset($data['items'])) {
            if (is_array($data['items']) && !empty($data['items'])) {
                foreach ($data['items'] as &$item) {
                    $item['subscription_plan_id']    = $subscription_id;
                }

                $this->db->insert_batch($this->table_subscription_items, $data['items']);
            }
        }
        return $this->db->affected_rows();
    }

    public function doUpdateSubscriptionData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_subscription, [
                'name'          => $data['name'],
                'description'   => $data['description'],
                'total_price'   => $data['price']
            ]);

        $this->db
            ->where('subscription_plan_id', $id)
            ->delete($this->table_subscription_items);

        if (isset($data['items'])) {
            if (is_array($data['items']) && !empty($data['items'])) {
                foreach ($data['items'] as &$item) {
                    $item['subscription_plan_id']    = $id;
                }

                $this->db->insert_batch($this->table_subscription_items, $data['items']);
            }
        }

        return $this->db->affected_rows();
    }

    public function doDeleteSubscriptionData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_subscription);

        // fallback if db doesn't support `cascade on delete`
        $this->db
            ->where('subscription_plan_id', $id)
            ->delete($this->table_subscription_items);

        return $this->db->affected_rows();
    }
}
