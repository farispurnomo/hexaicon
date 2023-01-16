<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_user extends CI_Model
{
    private $table_users         = 'core_users';
    private $table_roles         = 'core_roles';

    public function doGetUserData(string $search, $sort_field = 'name', $sort_dir = 'ASC', int $offset = 0, int $limit = 16)
    {
        $this->db
            ->select("
                $this->table_users.*,
                $this->table_roles.name AS role_name
            ")
            ->from($this->table_users)
            ->join($this->table_roles, "$this->table_roles.id=$this->table_users.role_id");

        if ($search != '') {
            $this->db->like("$this->table_users.email", $search)
                ->or_like("$this->table_users.name", $search)
                ->or_like("$this->table_users.phone", $search);
        }

        $this->db->order_by($sort_field, $sort_dir);
        $this->db->limit($limit, $offset);

        $users      = $this->db->get()->result();
        $users      = array_map(function ($user) {
            $path               = ($user->avatar ? $user->avatar : '/public/src/media/avatars/blank.png');
            $user->url_image    = base_url($path);

            return $user;
        }, $users);

        return $users;
    }

    public function doGetFirstUserData($id)
    {
        $user                   = $this->db
            ->from($this->table_users)
            ->where('id', $id)
            ->get()
            ->row();

        if ($user) {
            $path               = ($user->avatar ? $user->avatar : '/public/src/media/avatars/blank.png');
            $user->url_image    = base_url($path);

            return $user;
        }

        return $user;
    }

    public function doCountUserData($search = '')
    {
        $this->db->from($this->table_users);

        if ($search != '') {
            $this->db->like("$this->table_users.email", $search)
                ->or_like("$this->table_users.name", $search)
                ->or_like("$this->table_users.phone", $search);
        }

        return $this->db->count_all_results();
    }

    public function doInsertUserData(array $data)
    {
        $this->db->insert($this->table_users, $data);

        return $this->db->affected_rows();
    }

    public function doUpdateUserData($id, array $data)
    {
        $this->db
            ->where('id', $id)
            ->update($this->table_users, $data);

        return $this->db->affected_rows();
    }

    public function doDeleteUserData($id)
    {
        $this->db
            ->where('id', $id)
            ->delete($this->table_users);

        return $this->db->affected_rows();
    }

    public function doGetRoles()
    {
        return $this->db
            ->from($this->table_roles)
            ->order_by('name')
            ->get()
            ->result();
    }

    public function doGetRoleById($id)
    {
        return $this->db
            ->from($this->table_roles)
            ->where('id', $id)
            ->get()
            ->row();
    }
}
