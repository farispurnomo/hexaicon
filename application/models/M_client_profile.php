<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_client_profile extends CI_Model
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

    public function doUpdateClientById($id, array $params)
    {
        $this->db->where('id', $id)->update('mst_clients', $params);
        return $this->db->affected_rows();
    }
}
