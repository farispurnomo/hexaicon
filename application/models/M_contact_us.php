<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_contact_us extends CI_Model
{
    public function store($params)
    {
        $insert = array(
            'name'      => $params['name'] ?? '',
            'email'     => $params['email'] ?? '',
            'subject'   => $params['subject'] ?? '',
            'content'   => $params['content'] ?? ''
        );
        $this->db->insert('log_contact_us', $insert);
        return $this->db->affected_rows();
    }
}
