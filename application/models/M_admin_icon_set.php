<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_icon_set extends CI_Model
{
    private $table_icon_sets         = 'mst_icon_sets';

    public function doGetIconSetData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->from($this->table_icon_sets);

        if ($search != '') {
            $this->db->like("$this->table_icon_sets.name", $search)
                ->or_like("$this->table_icon_sets.description", $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function doGetFirstIconSetData($id)
    {
        return $this->db
            ->from($this->table_icon_sets)
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function doCountIconSetData($search = '')
    {
        $this->db->from($this->table_icon_sets);

        if ($search != '') {
            $this->db->like("$this->table_icon_sets.name", $search)
                ->or_like("$this->table_icon_sets.description", $search);
        }

        return $this->db->count_all_results();
    }

    public function doInsertIconSetData(array $data)
    {
        $this->db->insert($this->table_icon_sets, $data);

        return $this->db->affected_rows();
    }

    public function doUpdateIconSetData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_icon_sets, $data);

        return $this->db->affected_rows();
    }

    public function doDeleteIconSetData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_icon_sets);

        return $this->db->affected_rows();
    }
}
