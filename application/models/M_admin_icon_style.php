<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_icon_style extends CI_Model
{
    private $table_icon_style         = 'mst_icon_styles';

    public function doGetIconStyleData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->from($this->table_icon_style);

        if ($search != '') {
            $this->db->like("$this->table_icon_style.name", $search)
                ->or_like("$this->table_icon_style.description", $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function doGetFirstIconStyleData($id)
    {
        return $this->db
            ->from($this->table_icon_style)
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function doCountIconStyleData($search = '')
    {
        $this->db->from($this->table_icon_style);

        if ($search != '') {
            $this->db->like("$this->table_icon_style.name", $search)
                ->or_like("$this->table_icon_style.description", $search);
        }

        return $this->db->count_all_results();
    }

    public function doInsertIconStyleData(array $data)
    {
        $this->db->insert($this->table_icon_style, $data);

        return $this->db->affected_rows();
    }

    public function doUpdateIconStyleData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_icon_style, $data);

        return $this->db->affected_rows();
    }

    public function doDeleteIconStyleData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_icon_style);

        return $this->db->affected_rows();
    }
}
