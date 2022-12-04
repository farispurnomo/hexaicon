<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_icon_discover extends CI_Model
{
    public function doGetCategories()
    {
        $categories = $this->db
            ->from('mst_icon_categories')
            ->order_by('created_at', 'desc')
            ->limit(4)
            ->get()
            ->result();

        $categories = array_map(function ($category) {
            $category->url_image = base_url() . $category->image;
            return $category;
        }, $categories);

        return $categories;
    }

    public function doGetIconStyles()
    {
        $styles = $this->db
            ->from('mst_icon_styles')
            ->order_by('name')
            ->limit(4)
            ->get()
            ->result();

        foreach ($styles as $style) {
            $icons = $this->db
                ->from('mst_icons')
                ->where('style_id', $style->id)
                ->order_by('created_at')
                ->limit(9)
                ->get()
                ->result();

            $style->icons = $icons;
        }
        return $styles;
    }

    public function doGetFreeIcons()
    {
        $subscription_free_id = '1';
        $icons = $this->db
            ->from('mst_icons')
            ->where("exists(SELECT * FROM mst_icon_subscriptions WHERE mst_icon_subscriptions.icon_id=mst_icons.id AND subscription_plan_id='$subscription_free_id')", NULL, false)
            ->order_by('created_at', 'desc')
            ->get()
            ->result();

        return $icons;
    }

    public function doGetLatestIcons()
    {
        $icons = $this->db
            ->from('mst_icons')
            ->order_by('created_at', 'desc')
            ->limit(20)
            ->get()
            ->result();

        return $icons;
    }

    public function doGetPopularIcons()
    {
        $icons = $this->db
            ->from('mst_icons')
            ->order_by('number_of_downloads', 'desc')
            ->limit(20)
            ->get()
            ->result();

        return $icons;
    }

    public function doGetIconByKeyword($keyword)
    {
        $icons = $this->db->from('mst_icons')
            ->like('name', $keyword)
            ->order_by('name')
            ->group_by('name')
            ->limit(7)
            ->get()
            ->result();

        return $icons;
    }

    public function doGetIconSets()
    {
        $sets = $this->db
            ->from('mst_icon_sets')
            ->order_by('created_at', 'desc')
            ->limit(4)
            ->get()
            ->result();

        foreach ($sets as &$set) {
            $set->icons = $this->db->from('mst_icons')
                ->where('set_id', $set->id)
                ->limit(20)
                ->get()
                ->result();
        }

        return $sets;
    }
}
