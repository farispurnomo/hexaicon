<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_admin_auth extends CI_Model
{
    private $table_users        = 'core_users';
    private $table_roles        = 'core_roles';

    public function doGetUserByEmail($email)
    {
        return $this->db
            ->select("$this->table_users.*, $this->table_roles.name AS role_name")
            ->from($this->table_users)
            ->join($this->table_roles, "$this->table_roles.id=$this->table_users.role_id")
            ->where('email', $email)
            ->get()
            ->row();
    }

    public function doGetLoginData($email, $password)
    {
        $user = $this->doGetUserByEmail($email);

        if (!$user) return;

        if (password_verify($password, $user->password)) {
            return $user;
        }
    }
}
