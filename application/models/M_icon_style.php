<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_icon_style extends CI_Model
{
    public function doGetCategoriesWithIcons($offset = 0)
    {
        $categories             = $this->db
            ->from('mst_icon_categories')
            ->offset($offset)
            ->limit(4)
            ->get()
            ->result();

        $categories = array_map(function ($category) {
            // $path                   = ($category->image ? $category->image : 'public/images/no_image.png');
            // $category->url_image    = base_url($path);

            $icons              = $this->db
                ->from('mst_icons')
                ->where('category_id', $category->id)
                ->get()
                ->result();

            $icons              = array_map(function ($icon) {
                $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
                $icon->url_image    = base_url($path);

                return $icon;
            }, $icons);

            $category->icons = $icons;
            return $category;
        }, $categories);

        return $categories;
    }

    public function doGetDetaiIcon($id, $subscription_id)
    {
        $icon = $this->db
            ->from('mst_icons')
            ->where('id', $id)
            ->get()
            ->row();

        if ($icon) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);
            return $icon;
        }
    }

    public function doGetIconLikeId($id, $subscription_id)
    {
        $icon = $this->db
            ->from('mst_icons')
            ->where('id', $id)
            ->get()
            ->row();

        if (!$icon) return;

        $icons = $this->db->from('mst_icons')
            ->where('id <>', $id)
            // ->like('name', $icon->name)
            ->where('category_id', $icon->category_id)
            // ->or_where('category_id', $icon->category_id)
            ->limit(12)
            ->order_by('name')
            ->get()
            ->result();

        $icons              = array_map(function ($icon) use ($subscription_id) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

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

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetMoreCategoryWithIcons($subscription_id, $page = 1, $item_per_page = 4)
    {
        $total_data     = $this->db->from('mst_icon_categories')->get()->num_rows();
        $total_page     = ceil($total_data / $item_per_page);

        $is_done        = $page >= $total_page;

        $offset         = ($page - 1) * $item_per_page;

        $categories     = $this->db
            ->from('mst_icon_categories')
            ->limit($item_per_page)
            ->offset($offset)
            ->get()
            ->result();

        foreach ($categories as &$category) {
            // $path                   = ($category->image ? $category->image : 'public/images/no_image.png');
            // $category->url_image    = base_url($path);

            $icons              = $this->db
                ->from('mst_icons')
                ->where('category_id', $category->id)
                ->get()
                ->result();

            $icons              = array_map(function ($icon) use ($subscription_id) {
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

                return $icon;
            }, $icons);

            $category->icons    = $icons;
        }

        return array(
            'categories' => $categories,
            'is_done'    => $is_done
        );
    }

    public function updateDownloadIcon($id)
    {
        $this->db->where('id', $id);
        $this->db->set('number_of_downloads', 'number_of_downloads+1', false);
        $this->db->update('mst_icons');

        $total = 0;
        $log = $this->db->from('log_downloads')
            ->where('DATE(date)', date('Y-m-d'))
            ->get()
            ->row();

        if ($log) {
            $total = $log->total;
        }

        $this->db->where('DATE(date)', date('Y-m-d'))
            ->update('log_downloads', [
                'total'         => $total,
                'updated_at'    => date('Y-m-d H:i:s')
            ]);

        return $this->db->affected_rows();
    }

    public function doToggleFavorite($icon_id, $client_id)
    {
        $exist = $this->doCheckIsFavorite($icon_id, $client_id);
        if ($exist) {
            $this->db->where('icon_id', $icon_id);
            $this->db->where('client_id', $client_id);

            $this->db->delete('log_favorite_icons');
        } else {
            $this->db->insert('log_favorite_icons', [
                'icon_id'   => $icon_id,
                'client_id' => $client_id,
            ]);
        }

        return $this->db->affected_rows();
    }

    public function doCheckIsFavorite($icon_id, $client_id)
    {
        return $this->db
            ->from('log_favorite_icons')
            ->where('icon_id', $icon_id)
            ->where('client_id', $client_id)
            ->get()
            ->num_rows() > 0;
    }

    public function doGetIconById($id, $subscription_id)
    {
        $icon = $this->db
            ->from('mst_icons')
            ->where('id', $id)
            ->get()
            ->row();

        if ($icon) {
            if ($icon->image) {
                $icon->vector = file_get_contents(base_url($icon->image));
            }

            $formats = $this->db
                ->from('mst_icon_formats')
                ->where('icon_id', $icon->id)
                ->get()
                ->result();

            foreach ($formats as &$format) {
                $subscription = $this->db
                    ->from('mst_icon_format_subscriptions')
                    ->where('icon_format_id', $format->id)
                    ->where('subscription_plan_id', $subscription_id)
                    ->get()
                    ->row();

                $format->is_unlock            = ($subscription ? true : false);
            }

            $icon->formats = $formats;

            return $icon;
        }
    }
}
