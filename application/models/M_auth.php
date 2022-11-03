<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class M_auth extends CI_Model
{
    private $table = "core_users";
	public function check_email($email = '')
    {
        $this->db->where('email',$this->db->escape_str($email));
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function insert($post = [])
    {
        $this->db->set("name",$this->db->escape_str($post['name']));
        $this->db->set("email",$this->db->escape_str($post['email']));
        $this->db->set("password",password_hash($post['password'],PASSWORD_DEFAULT));
        $this->db->set("role_id",$post['role']);
        $this->db->set("avatar",$post['avatar']);
        $this->db->set("telp",$post['telpon']);
        $this->db->insert($this->table);
        return $this->db->affected_rows();
    }
    public function get_email($email = '')
    {
        $this->db->where('email',$this->db->escape_str($email));
        $query = $this->db->get($this->table);
        return ["count"=>$query->num_rows(),"Data"=>$query->row()] ;
    }
}
