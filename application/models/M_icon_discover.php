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

            $style->icons = array_map(function ($icon) {
                $icon->url_image = base_url() . $icon->image;
                return $icon;
            }, $icons);
        }
        return $styles;
    }

    public function doGetTrandingIcons()
    {
        $icons = $this->db
            ->from('mst_icons')
            ->order_by('number_of_downloads')
            ->limit(20)
            ->get()
            ->result();

        $icons = array_map(function ($icon) {
            $icon->url_image = base_url() . $icon->image;
            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetLatestIcons()
    {
        $icons = $this->db
            ->from('mst_icons')
            ->order_by('created_at')
            ->limit(20)
            ->get()
            ->result();

        $icons = array_map(function ($icon) {
            $icon->url_image = base_url() . $icon->image;
            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetPopularIcons()
    {
        // $icons = $this->db
        //     ->from('');
        $icons = [];
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

        $icons = array_map(function ($icon) {
            $icon->url_image = base_url() . $icon->image;
            return $icon;
        }, $icons);
        return $icons;
    }
}
