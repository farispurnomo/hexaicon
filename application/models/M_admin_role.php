<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_role extends CI_Model
{
    private $table_roles        = 'core_roles';
    private $table_menus        = 'core_menus';
    private $table_abilities    = 'core_menu_abilities';
    private $table_privileges   = 'core_privileges';

    public function doGetRoleData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->from($this->table_roles);

        if ($search != '') {
            $this->db->like("$this->table_roles.name", $search)
                ->or_like("$this->table_roles.description", $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        return $this->db->get()->result();
    }

    public function doGetFirstRoleData($id)
    {
        return $this->db
            ->from($this->table_roles)
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function doCountRoleData($search = '')
    {
        $this->db->from($this->table_roles);

        if ($search != '') {
            $this->db->like("$this->table_roles.name", $search)
                ->or_like("$this->table_roles.description", $search);
        }

        return $this->db->count_all_results();
    }

    public function doInsertRoleData(array $data)
    {
        $this->db->insert($this->table_roles, $data);

        return $this->db->affected_rows();
    }

    public function doUpdateRoleData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_roles, $data);

        return $this->db->affected_rows();
    }

    public function doDeleteRoleData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_roles);

        return $this->db->affected_rows();
    }

    public function doGetTreeviewMenu($role_id)
    {
        $find_child     = function ($parent_id) use (&$find_child, $role_id) {
            $menus          = $this->db->from($this->table_menus)
                ->where('parent_id', $parent_id)
                ->order_by('order')
                ->get()
                ->result();

            foreach ($menus as &$menu) {
                $menu->child                = $find_child($menu->id);

                $abilities                  = $this->db
                    ->from($this->table_abilities)
                    ->where('menu_id', $menu->id)
                    ->get()
                    ->result();

                foreach ($abilities as $ability) {
                    $is_granted             = $this->db->from($this->table_privileges)
                        ->where('role_id', $role_id)
                        ->where('ability_id', $ability->id)
                        ->get()
                        ->row();

                    $ability->is_granted    = ($is_granted ? true : false);
                }

                $menu->abilities            = $abilities;
            }
            return $menus;
        };

        $menus          = $this->db->from($this->table_menus)
            ->where('parent_id IS NULL', NULL, FALSE)
            ->order_by('order')
            ->get()
            ->result();

        foreach ($menus as &$menu) {
            $menu->child = $find_child($menu->id);

            $abilities    = $this->db
                ->from($this->table_abilities)
                ->where('menu_id', $menu->id)
                ->get()
                ->result();

            foreach ($abilities as $ability) {
                $is_granted = $this->db->from($this->table_privileges)
                    ->where('role_id', $role_id)
                    ->where('ability_id', $ability->id)
                    ->get()
                    ->row();

                $ability->is_granted = ($is_granted ? true : false);
            }

            $menu->abilities    = $abilities;
        }

        return $menus;
    }

    public function doUpdatePermissionRole($role_id, $ability_ids)
    {
        $this->db->where('role_id', $role_id)
            ->delete($this->table_privileges);

        $permissions     = [];
        foreach ($ability_ids as $ability_id) {
            $permissions[]  = array(
                'role_id'       => $role_id,
                'ability_id'    => $ability_id,
                'created_at'    => date('Y-m-d H:i:s'),
                'created_at'    => date('Y-m-d H:i:s')
            );
        }

        if (!empty($permissions)) {
            $this->db->insert_batch($this->table_privileges, $permissions);
        }

        return $this->db->affected_rows();
    }
}
