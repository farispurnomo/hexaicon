<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_client_subscription extends CI_Model
{
    public function doGetClientById($id)
    {
        $client             = $this->db
            ->select('mst_clients.*, mst_subscription_plans.name AS subscription_name')
            ->from('mst_clients')
            ->join('mst_subscription_plans', 'mst_subscription_plans.id=mst_clients.subscription_plan_id')
            ->where('mst_clients.id', $id)
            ->get()
            ->row();

        if ($client) {
            $path               = ($client->image ? $client->image : '/public/images/no_image.png');
            $client->url_image  = base_url($path);
        }

        return $client;
    }

    public function doGetDetailSubscription($id)
    {
        $subscription = $this->db
            ->from('mst_subscription_plans')
            ->where('id', $id)
            ->get()
            ->row();
        return $subscription;
    }

    public function doUpdateSubscriptionClient($id, $params)
    {
        $this->db->where('id', $id)
            ->update('mst_clients', $params);

        return $this->db->affected_rows();
    }

    public function doInsertLogSubscription($params)
    {
        $log    = array();
        $this->db->insert('log_subscriptions', $params);
        return $this->db->affected_rows();
    }

    public function getSubscriptions()
    {
        $subscriptions  = $this->db->from('mst_subscription_plans')
            ->order_by('total_price')
            ->get()
            ->result();

        foreach ($subscriptions as &$subscription) {
            $subscription->items = $this->db->from('mst_subscription_plan_items')
                ->where('subscription_plan_id', $subscription->id)
                ->get()
                ->result();
        }

        return $subscriptions;
    }
}
