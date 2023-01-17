<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_client_dashboard extends CI_Model
{
    public function doGetFavoriteIconSets($id)
    {
        $sets = $this->db
            ->select('mst_icon_sets.*')
            ->from('log_favorite_icon_sets')
            ->join('mst_icon_sets', 'mst_icon_sets.id=log_favorite_icon_sets.icon_set_id')
            ->where('log_favorite_icon_sets.client_id', $id)
            ->limit(4)
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

        return $sets;
    }

    public function doGetFavoriteIcons($id, $subscription_id)
    {
        $icons = $this->db
            ->select('mst_icons.*')
            ->from('log_favorite_icons')
            ->join('mst_icons', 'mst_icons.id=log_favorite_icons.icon_id')
            ->where('log_favorite_icons.client_id', $id)
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

        return $icons;
    }
}
