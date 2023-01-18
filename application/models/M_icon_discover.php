<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_icon_discover extends CI_Model
{
    public function doGetCategories()
    {
        $categories             = $this->db
            ->from('mst_icon_categories')
            ->order_by('created_at', 'desc')
            ->limit(4)
            ->get()
            ->result();

        $categories             = array_map(function ($category) {
            $path                   = ($category->image ? $category->image : 'public/images/no_image.png');
            $category->url_image    = base_url($path);

            return $category;
        }, $categories);

        return $categories;
    }

    public function doGetIconStyles()
    {
        $styles                 = $this->db
            ->from('mst_icon_styles')
            ->order_by('name')
            ->limit(4)
            ->get()
            ->result();

        foreach ($styles as $style) {
            $icons              = $this->db
                ->from('mst_icons')
                ->where('style_id', $style->id)
                ->order_by('created_at')
                ->limit(9)
                ->get()
                ->result();

            $icons              = array_map(function ($icon) {
                $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
                $icon->url_image    = base_url($path);

                return $icon;
            }, $icons);

            $style->icons = $icons;
        }
        return $styles;
    }

    public function doGetFreeIcons()
    {
        $subscription_free_id   = '1';

        $icons = $this->db
            ->from('mst_icons')
            ->where("exists(SELECT * FROM mst_icon_subscriptions WHERE mst_icon_subscriptions.icon_id=mst_icons.id AND subscription_plan_id='$subscription_free_id')", NULL, false)
            ->order_by('created_at', 'desc')
            ->get()
            ->result();

        $icons                  = array_map(function ($icon) {
            $path                   = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image        = base_url($path);

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetLatestIcons($subscription_id = null)
    {
        $icons                  = $this->db
            ->from('mst_icons')
            ->order_by('created_at', 'desc')
            ->limit(20)
            ->get()
            ->result();

        $icons = array_map(function ($icon) use ($subscription_id) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

            $subscription       = $this->db
                ->from('mst_icon_subscriptions')
                ->where('icon_id', $icon->id)
                ->where('subscription_plan_id', $subscription_id)
                ->get()
                ->row();

            $icon->is_unlock    = ($subscription ? true : false);
            $icon->guest_access = ($icon->guest_access == '1' ? true : false);

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetPopularIcons($subscription_id = null)
    {
        $icons                  = $this->db
            ->from('mst_icons')
            ->order_by('number_of_downloads', 'desc')
            ->limit(20)
            ->get()
            ->result();

        $icons = array_map(function ($icon) use ($subscription_id) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

            $subscription       = $this->db
                ->from('mst_icon_subscriptions')
                ->where('icon_id', $icon->id)
                ->where('subscription_plan_id', $subscription_id)
                ->get()
                ->row();

            $icon->is_unlock    = ($subscription ? true : false);
            $icon->guest_access = ($icon->guest_access == '1' ? true : false);

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetIconByKeyword($keyword)
    {
        $icons                  = $this->db->from('mst_icons')
            ->like('name', $keyword)
            ->order_by('name')
            ->group_by('name')
            ->limit(7)
            ->get()
            ->result();

        $icons = array_map(function ($icon) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetIconSets()
    {
        $sets                   = $this->db
            ->from('mst_icon_sets')
            ->order_by('created_at', 'desc')
            ->limit(4)
            ->get()
            ->result();

        foreach ($sets as &$set) {
            $icons              = $this->db->from('mst_icons')
                ->where('set_id', $set->id)
                ->limit(20)
                ->get()
                ->result();

            $icons              = array_map(function ($icon) {
                $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
                $icon->url_image    = base_url($path);

                return $icon;
            }, $icons);

            $set->icons = $icons;
        }

        return $sets;
    }

    public function doGetDetailIcon($icon_id, $subscription_id = null)
    {
        $icon                       = $this->db
            ->from('mst_icons')
            ->where('id', $icon_id)
            ->get()
            ->row();

        if ($icon) {
            $path                       = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image            = base_url($path);

            $subscription               = $this->db
                ->from('mst_icon_subscriptions')
                ->where('icon_id', $icon->id)
                ->where('subscription_plan_id', $subscription_id)
                ->get()
                ->row();

            $icon->is_unlock            = ($subscription ? true : false);
            $icon->guest_access         = ($icon->guest_access == '1' ? true : false);

            $icon->minimum_subscription = $this->db
                ->select('mst_subscription_plans.*')
                ->from('mst_icon_subscriptions')
                ->join('mst_subscription_plans', 'mst_subscription_plans.id=mst_icon_subscriptions.subscription_plan_id')
                ->where('mst_icon_subscriptions.icon_id', $icon->id)
                ->order_by('mst_subscription_plans.total_price', 'asc')
                ->get()
                ->row();
        }

        return $icon;
    }

    public function doGetMoreCategories($page, $item_per_page = 12)
    {
        $total_data     = $this->db->from('mst_icon_categories')->get()->num_rows();
        $total_page     = ceil($total_data / $item_per_page);

        $is_done        = $page >= $total_page;

        $offset         = ($page - 1) * $item_per_page;

        $categories     = $this->db
            ->from('mst_icon_categories')
            ->order_by('name')
            ->limit($item_per_page)
            ->offset($offset)
            ->get()
            ->result();

        foreach ($categories as &$category) {
            $path                   = ($category->image ? $category->image : 'public/images/no_image.png');
            $category->url_image    = base_url($path);
        }

        return array(
            'categories' => $categories,
            'is_done'    => $is_done,
        );
    }
}
