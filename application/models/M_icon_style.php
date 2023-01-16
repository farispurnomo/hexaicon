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

        $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
        $icon->url_image    = base_url($path);

        if (!$icon) return;

        $icon->resolutions = $this->db
            ->select("
                *,
                EXISTS(
                    SELECT 
                        *
                    FROM
                        mst_icon_resolution_subscriptions
                    WHERE
                        mst_icon_resolution_subscriptions.icon_resolution_id = mst_icon_resolutions.id
                        AND mst_icon_resolution_subscriptions.subscription_plan_id = \"$subscription_id\"
                ) AS is_unlock
            ")
            ->from('mst_icon_resolutions')
            ->where('icon_id', $icon->id)
            ->order_by('size')
            ->get()
            ->result();

        foreach ($icon->resolutions as &$resolution) {
            $resolution->is_unlock = boolval($resolution->is_unlock);

            $formats = $this->db
                ->select("
                    *, EXISTS(
                        SELECT 
                            *
                        FROM
                            mst_icon_format_subscriptions
                        WHERE
                            mst_icon_format_subscriptions.icon_format_id = mst_icon_formats.id
                            AND mst_icon_format_subscriptions.subscription_plan_id = \"$subscription_id\"
                    ) AS is_unlock
                ")
                ->from('mst_icon_formats')
                ->where('icon_resolution_id', $resolution->id)
                ->get()
                ->result();

            $resolution->formats = array_map(function ($format) {
                $format->is_unlock = boolval($format->is_unlock);

                return $format;
            }, $formats);
        }

        return $icon;
    }

    public function doGetIconLikeId($id)
    {
        $icon = $this->db
            ->from('mst_icons')
            ->where('id', $id)
            ->get()
            ->row();

        if (!$icon) return;

        $icons = $this->db->from('mst_icons')
            ->like('name', $icon->name)
            // ->or_where('category_id', $icon->category_id)
            ->limit(12)
            ->order_by('name')
            ->get()
            ->result();

        $icons              = array_map(function ($icon) {
            $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
            $icon->url_image    = base_url($path);

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetMoreCategoryWithIcons($page = 1, $item_per_page = 4)
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

            $icons              = array_map(function ($icon) {
                $path               = ($icon->image ? $icon->image : 'public/images/no_image.png');
                $icon->url_image    = base_url($path);

                return $icon;
            }, $icons);

            $category->icons    = $icons;
        }

        return array(
            'categories' => $categories,
            'is_done'    => $is_done
        );
    }

    public function doGetFormatIconById($id)
    {
        return $this->db
            ->select('mst_icon_formats.*, mst_icon_resolutions.icon_id')
            ->from('mst_icon_formats')
            ->join('mst_icon_resolutions', 'mst_icon_resolutions.id=icon_resolution_id')
            ->where('mst_icon_formats.id', $id)
            ->get()
            ->row();
    }

    public function updateDownloadIcon($id)
    {
        $this->db->where('id', $id);
        $this->db->set('number_of_downloads', 'number_of_downloads+1', false);
        $this->db->update('mst_icons');
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

    public function doGetIconById($id)
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

            return $icon;
        }
    }
}
