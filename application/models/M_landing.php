<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_landing extends CI_Model
{
    public function getSubscriptions()
    {
        // $max_user    = $this->db
        //     ->select('id')
        //     ->select_max('active_users')
        //     ->from('mst_subscription_plans')
        //     ->get()
        //     ->row();

        // $most_expensive = $this->db
        //     ->select_max('id', 'total_price')
        //     ->from('mst_subscription_plans')
        //     ->get()
        //     ->result();

        // echo '<pre>';
        // print_r($most_expensive);
        // exit;

        $subscriptions  = $this->db->from('mst_subscription_plans')
            ->order_by('total_price')
            ->get()
            ->result();

        foreach ($subscriptions as &$subscription) {
            $subscription->is_popular      = false;
            $subscription->is_expensive    = false;
            $subscription->items = $this->db->from('mst_subscription_plan_items')
                ->where('subscription_plan_id', $subscription->id)
                ->get()
                ->result();
        }

        return $subscriptions;
    }
}
