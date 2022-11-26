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
        $passsword = password_hash($post['password'],PASSWORD_DEFAULT);
        
        $this->db->where('name','Users');
        $role = $this->db->get('core_roles')->row()->id;
        $this->db->set("name",$this->db->escape_str($post['name']));
        $this->db->set("email",$this->db->escape_str($post['email']));
        $this->db->set("password",$passsword);
        $this->db->insert('users');
        
        $this->db->set("user_id",$this->db->insert_id());
        $this->db->set("email",$this->db->escape_str($post['email']));
        $this->db->set("password",$passsword);
        $this->db->set("role_id",$role);
        $this->db->insert($this->table);
        return $this->db->affected_rows();
    }
    public function get_email($email = '')
    {
        $this->db->where('a.email',$this->db->escape_str($email));
        $this->db->join($this->table. ' b','a.id=b.user_id');
        $this->db->from('users a');
        $this->db->select('a.email,a.password,b.role_id,b.avatar');
        $query = $this->db->get();
        return ["count"=>$query->num_rows(),"data"=>$query->row()] ;
    }
}
