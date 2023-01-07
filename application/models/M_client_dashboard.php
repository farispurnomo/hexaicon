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

        foreach ($sets as $set) {
            $set->icons = $this->db
                ->from('mst_icons')
                ->where('set_id', $set->id)
                ->limit(9)
                ->get()
                ->result();
        }

        return $sets;
    }

    public function doGetFavoriteIcons($id)
    {
        $icons = $this->db
            ->select('mst_icons.*')
            ->from('log_favorite_icons')
            ->join('mst_icons', 'mst_icons.id=log_favorite_icons.icon_id')
            ->where('log_favorite_icons.client_id', $id)
            ->get()
            ->result();

        return $icons;
    }
}
