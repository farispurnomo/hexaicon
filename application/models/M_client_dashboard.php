<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_client_dashboard extends CI_Model
{
    public function doGetFavoriteIconSets($id, $page = 1, $item_per_page = 12)
    {
        $total_data     = $this->db
            ->from('log_favorite_icon_sets')
            ->where('log_favorite_icon_sets.client_id', $id)
            ->get()
            ->num_rows();

        $total_page     = ceil($total_data / $item_per_page);
        $is_done        = $page >= $total_page;
        $offset         = ($page - 1) * $item_per_page;

        $sets = $this->db
            ->select('mst_icon_sets.*')
            ->from('log_favorite_icon_sets')
            ->join('mst_icon_sets', 'mst_icon_sets.id=log_favorite_icon_sets.icon_set_id')
            ->where('log_favorite_icon_sets.client_id', $id)
            ->limit($item_per_page)
            ->offset($offset)
            ->get()
            ->result();

        foreach ($sets as &$set) {
            $icons              = $this->db
                ->from('mst_icons')
                ->where('set_id', $set->id)
                ->limit(9)
                ->get()
                ->result();

            $icons              = array_map(function ($icon) {
                $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
                $icon->url_image    = base_url($path);

                return $icon;
            }, $icons);

            $set->icons         = $icons;
        }

        return array(
            'sets'              => $sets,
            'is_done'           => $is_done,
            'total_data'        => (int) $total_data
        );
    }

    public function doGetFavoriteIcons($id, $subscription_id, $page = 1, $item_per_page = 12)
    {
        $total_data     = $this->db
            ->from('log_favorite_icons')
            ->where('log_favorite_icons.client_id', $id)
            ->get()
            ->num_rows();

        $total_page     = ceil($total_data / $item_per_page);
        $is_done        = $page >= $total_page;
        $offset         = ($page - 1) * $item_per_page;

        $icons = $this->db
            ->select('mst_icons.*')
            ->from('log_favorite_icons')
            ->join('mst_icons', 'mst_icons.id=log_favorite_icons.icon_id')
            ->where('log_favorite_icons.client_id', $id)
            ->limit($item_per_page)
            ->offset($offset)
            ->get()
            ->result();

        $icons              = array_map(function ($icon) use ($subscription_id) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

            $subscription       = $this->db
                ->from('mst_icon_subscriptions')
                ->where('icon_id', $icon->id)
                ->where('subscription_plan_id', $subscription_id)
                ->get()
                ->row();

            $icon->is_unlock    = ($subscription ? true : false);

            return $icon;
        }, $icons);

        return array(
            'icons'             => $icons,
            'is_done'           => $is_done,
            'total_data'        => (int) $total_data
        );
    }
}
