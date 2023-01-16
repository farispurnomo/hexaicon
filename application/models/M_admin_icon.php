<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_icon extends CI_Model
{
    private $table_icons            = 'mst_icons';
    private $table_icon_styles      = 'mst_icon_styles';
    private $table_icon_categories  = 'mst_icon_categories';
    private $table_icon_sets        = 'mst_icon_sets';

    public function doGetIconData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->select("
                $this->table_icons.*,
                $this->table_icon_styles.name AS style_name,
                $this->table_icon_categories.name AS category_name,
                $this->table_icon_sets.name AS set_name
            ")
            ->from($this->table_icons)
            ->join($this->table_icon_styles,     "$this->table_icon_styles.id=$this->table_icons.style_id",         'LEFT')
            ->join($this->table_icon_categories, "$this->table_icon_categories.id=$this->table_icons.category_id",  'LEFT')
            ->join($this->table_icon_sets,       "$this->table_icon_sets.id=$this->table_icons.set_id",             'LEFT');

        if ($search != '') {
            $this->db->like("$this->table_icons.name",          $search)
                ->or_like("$this->table_icon_styles.name",      $search)
                ->or_like("$this->table_icon_categories.name",  $search)
                ->or_like("$this->table_icon_sets.name",        $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        $icons      = $this->db->get()->result();
        $icons      = array_map(function ($icon) {
            $path               = ($icon->image ? $icon->image : '/public/images/no_image.png');
            $icon->url_image    = base_url($path);

            return $icon;
        }, $icons);

        return $icons;
    }

    public function doGetFirstIconData($id)
    {
        $icon                   = $this->db
            ->from($this->table_icons)
            ->where('id', $id)
            ->get()
            ->row();

        if ($icon) {
            $path               = ($icon->image ? $icon->image : '/public/images/no_image.png');
            $icon->url_image    = base_url($path);

            return $icon;
        }

        return $icon;
    }

    public function doCountIconData($search = '')
    {
        $this->db
            ->from($this->table_icons)
            ->join($this->table_icon_styles,     "$this->table_icon_styles.id=$this->table_icons.style_id",         'LEFT')
            ->join($this->table_icon_categories, "$this->table_icon_categories.id=$this->table_icons.category_id",  'LEFT')
            ->join($this->table_icon_sets,       "$this->table_icon_sets.id=$this->table_icons.set_id",             'LEFT');

        if ($search != '') {
            $this->db->like("$this->table_icons.name",          $search)
                ->or_like("$this->table_icon_styles.name",      $search)
                ->or_like("$this->table_icon_categories.name",  $search)
                ->or_like("$this->table_icon_sets.name",        $search);
        }

        return $this->db->count_all_results();
    }

    public function doInsertIconData(array $data)
    {
        $this->db->insert($this->table_icons, $data);

        return $this->db->affected_rows();
    }

    public function doUpdateIconData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_icons, $data);

        return $this->db->affected_rows();
    }

    public function doDeleteIconData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_icons);

        return $this->db->affected_rows();
    }

    public function doGetCategories()
    {
        return $this->db
            ->from($this->table_icon_categories)
            ->order_by('name')
            ->get()
            ->result();
    }

    public function doGetStylesData()
    {
        return $this->db
            ->from($this->table_icon_styles)
            ->order_by('name')
            ->get()
            ->result();
    }

    public function doGetSetsData()
    {
        return $this->db
            ->from($this->table_icon_sets)
            ->order_by('name')
            ->get()
            ->result();
    }
}
