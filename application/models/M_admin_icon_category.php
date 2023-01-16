<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_icon_category extends CI_Model
{
    private $table_icon_categories         = 'mst_icon_categories';

    public function doGetIconCategoryData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->from($this->table_icon_categories);

        if ($search != '') {
            $this->db->like("$this->table_icon_categories.name", $search)
                ->or_like("$this->table_icon_categories.description", $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        $categories      = $this->db->get()->result();
        $categories      = array_map(function ($user) {
            $path               = ($user->image ? $user->image : '/public/images/no_image.png');
            $user->url_image    = base_url($path);

            return $user;
        }, $categories);

        return $categories;
    }

    public function doGetFirstIconCategoryData($id)
    {
        $category = $this->db
            ->from($this->table_icon_categories)
            ->where('id', $id)
            ->get()
            ->row();

        if ($category) {
            $path                   = ($category->image ? $category->image : '/public/images/no_image.png');
            $category->url_image    = base_url($path);

            return $category;
        }
    }

    public function doCountIconCategoryData($search = '')
    {
        $this->db->from($this->table_icon_categories);

        if ($search != '') {
            $this->db->like("$this->table_icon_categories.name", $search)
                ->or_like("$this->table_icon_categories.description", $search);
        }

        return $this->db->count_all_results();
    }

    public function doInsertIconCategoryData(array $data)
    {
        $this->db->insert($this->table_icon_categories, $data);

        return $this->db->affected_rows();
    }

    public function doUpdateIconCategoryData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_icon_categories, $data);

        return $this->db->affected_rows();
    }

    public function doDeleteIconCategoryData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_icon_categories);

        return $this->db->affected_rows();
    }
}
