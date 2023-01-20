<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_icon_search extends CI_Model
{
    public function doGetStyles()
    {
        return $this->db
            ->select('
                *,
                (SELECT COUNT(*) FROM mst_icons WHERE mst_icons.style_id=mst_icon_styles.id) AS total_icons
            ')
            ->from('mst_icon_styles')
            ->order_by('name')
            ->limit(10)
            ->get()
            ->result();
    }

    public function doGetSets()
    {
        return $this->db
            ->select('
                *,
                (SELECT COUNT(*) FROM mst_icons WHERE mst_icons.set_id=mst_icon_sets.id) AS total_icons
            ')
            ->from('mst_icon_sets')
            ->order_by('name')
            ->limit(10)
            ->get()
            ->result();
    }

    public function doGetCategories()
    {
        return $this->db
            ->select('
                *,
                (SELECT COUNT(*) FROM mst_icons WHERE mst_icons.category_id=mst_icon_categories.id) AS total_icons
            ')
            ->from('mst_icon_categories')
            ->order_by('name')
            ->limit(10)
            ->get()
            ->result();
    }

    public function doGetSubscriptions()
    {
        return $this->db
            ->select('
                *,
                (SELECT COUNT(*) FROM mst_icon_subscriptions WHERE mst_icon_subscriptions.subscription_plan_id=mst_subscription_plans.id) AS total_icons
            ')
            ->from('mst_subscription_plans')
            ->order_by('name')
            ->limit(10)
            ->get()
            ->result();
    }

    private function doGenerateQueryIconPaginate($data)
    {
        $this->db->from('mst_icons');

        if (isset($data->subscription_ids) && !empty($data->subscription_ids)) {
            $in = implode(',', $data->subscription_ids);
            $this->db->where('EXISTS (SELECT icon_id FROM mst_icon_subscriptions WHERE mst_icon_subscriptions.icon_id = mst_icons.id AND subscription_plan_id IN (' . $in . '))', NULL, FALSE);
            // $this->db->where_in('subscription_id', $data->subscription_ids);
        }

        if (isset($data->category_ids) && !empty($data->category_ids)) {
            $this->db->where_in('category_id', $data->category_ids);
        }

        if (isset($data->set_ids) && !empty($data->set_ids)) {
            $this->db->where_in('set_id', $data->set_ids);
        }

        if (isset($data->style_ids) && !empty($data->style_ids)) {
            $this->db->where_in('style_id', $data->style_ids);
        }

        if (isset($data->queries) && !empty($data->queries)) {
            $this->db->group_start();
            foreach ($data->queries as $like) {
                $this->db->or_like('name', $like);
            }
            $this->db->group_end();
        }

        $this->db->order_by('name');
    }

    public function doGetIconPaginate($data, $page = 1, $item_per_page = 20)
    {
        // $total_data     = $this->db->from('mst_icons')->count_all_results();
        $this->doGenerateQueryIconPaginate($data);
        $total_data = $this->db->count_all_results();

        $total_page     = ceil($total_data / $item_per_page);
        $offset         = ($page - 1) * $item_per_page;


        $this->doGenerateQueryIconPaginate($data);
        $this->db->limit($item_per_page, $offset);

        $items          = $this->db->get()->result();

        $last_query     = $this->db->last_query();

        $items          = array_map(function ($icon) use ($data) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

            $subscription       = $this->db
                ->from('mst_icon_subscriptions')
                ->where('icon_id', $icon->id)
                ->where('subscription_plan_id', $data->subscription_id)
                ->get()
                ->row();

            $icon->is_unlock    = ($subscription ? true : false);
            $icon->guest_access = ($icon->guest_access == '1' ? true : false);

            return $icon;
        }, $items);

        return array(
            'items'         => $items,
            'current_page'  => $page,
            'last_page'     => $total_page,
            'total_data'    => $total_data,
            'last_query'    => $last_query
        );
    }
}
